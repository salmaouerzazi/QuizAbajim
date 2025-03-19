<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ForumTopic;
use App\Models\Newsletter;
use App\Models\Product;
use App\Models\ReserveMeeting;
use App\Models\Reward;
use App\Models\RewardAccounting;
use App\Models\Sale;
use App\Models\UserOccupation;
use App\Models\Webinar;
use App\User;
use App\Models\Role;
use App\Models\Follow;
use App\Models\Manuels;
use App\Models\Material;
use App\Models\Meeting;
// use App\Models\Country;
use App\Models\School;
use App\Models\HomeVideo;

// use App\Models\City;
use App\Models\Option;
use App\Models\Region;
use App\Models\SectionMat;
use App\Models\School_level;
use App\UserMatiere;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\MeetingTime;
use Session;

class UserController extends Controller
{
    public function dashboard()
    {
      
      
        return view(getTemplate() . '.panel.dashboard');
    }

   public function profile($id,Request $request)
    {
        $authUser = auth()->user();
        
        $user = User::where('id', $id)
            ->whereIn('role_name', [Role::$organization, Role::$teacher, Role::$user])
            ->with([
                'blog' => function ($query) {
                    $query->where('status', 'publish');
                    $query->withCount([
                        'comments' => function ($query) {
                            $query->where('status', 'active');
                        }
                    ]);
                },
                'products' => function ($query) {
                    $query->where('status', Product::$active);
                },
            ])
            ->first();

        if (!$user) {
            abort(404);
        }

        $userBadges = $user->getBadges();
        
        $meetings = MeetingTime::with([
            'meeting' => function ($query) use ($user) {
                $query->where('teacher_id', $user->id);
            }
        ])
	    ->whereHas('meeting', function ($query) use ($user) {
            $query->where('teacher_id', $user->id);
        })
        ->where('meet_date', '>=', date('Y-m-d')) 
        ->where(function($query) {
            $currentTime = date('h:i A');
            $query->where(function($query) use ($currentTime) {
                // $query->where('meet_date', '=', date('Y-m-d'))
                //       ->whereRaw("STR_TO_DATE(SUBSTRING_INDEX(time, '-', 1), '%h:%i%p') > STR_TO_DATE(?, '%h:%i%p')", [$currentTime]);
            })
            ->orWhere('meet_date', '>', date('Y-m-d'));
        })
        ->whereDoesntHave('reservations', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->get();

        $meetings = $this->filtersMeetingByMatiere($meetings, $request);
        $times = [];
        if (!empty($meetings->meetingTimes)) {
            $times = convertDayToNumber($meetings->meetingTimes->groupby('day_label')->toArray());
        }

        $authUserIsFollower = false;
        if (auth()->check()) {
            $authUserIsFollower = DB::table('teachers')
            ->where('users_id', auth()->id())->where('teacher_id', $user->id)->exists();
        }

        $userMetas = $user->userMetas;
        
        $materials= $user->materials()->get();
        $materials = $materials->unique('name');

        $webinars = Webinar::where('status', Webinar::$active)
            ->where('private', false)
            ->where(function ($query) use ($user) {
                $query->where('creator_id', $user->id)
                    ->orWhere('teacher_id', $user->id);
            })
            ->orderBy('updated_at', 'desc')
            ->with(['teacher' => function ($qu) {
                $qu->select('id', 'full_name', 'avatar');
            }, 'reviews', 'tickets', 'feature'])
            ->get();

        $meetingIds = Meeting::where('teacher_id', $user->id)->pluck('id');
        $appointments = ReserveMeeting::whereIn('meeting_id', $meetingIds)
            ->whereNotNull('reserved_at')
            ->where('status', '!=', ReserveMeeting::$canceled)
            ->count();

        $studentsIds = Sale::whereNull('refund_at')
            ->where('seller_id', $user->id)
            ->whereNotNull('webinar_id')
            ->pluck('buyer_id')
            ->toArray();
        $user->students_count = count(array_unique($studentsIds));

        $instructors = null;
        if ($user->isOrganization()) {
            $instructors = User::where('organ_id', $user->id)
                ->where('role_name', Role::$teacher)
                ->where('status', 'active')
                ->get();
        }
        $userMaterialQuery = UserMatiere::query();

        $teacherLevelAndMaterials = $userMaterialQuery->where('teacher_id', $user->id)->get();

        $listmatiere22 = UserMatiere::where('teacher_id', $user->id)->pluck('matiere_id');
        $listmatiere = $userMaterialQuery->where('teacher_id', $user->id)->pluck('matiere_id');

        $matiereNN = [];

        foreach ($listmatiere22 as $matiereId) {
            $matieregetnameall = Material::where('id', $matiereId)->pluck('id');
            $matiereNN[] = $matieregetnameall;
        }

        // matiereNN has array of ids so extract the names
        $matiereNames = [];

        foreach ($matiereNN as $matiereId) {
            $matiereName = Material::where('id', $matiereId)->pluck('name')->first();
            if ($matiereName && !in_array($matiereName, $matiereNames)) {
                $matiereNames[] = $matiereName;
            }
        }

        $userLevelAndMaterialIds =  $userMaterialQuery->where('teacher_id', $user->id)->pluck('level_id');
        $userLevelIds = UserMatiere::where('teacher_id', $user->id)->pluck('level_id')->unique();
        $levels = School_level::whereIn('id', $userLevelIds)->pluck('name', 'id');

         $matierePerLevels = $this->filtersByLevelAndMaterial($userMaterialQuery, $request);

        $sectionLevels = SectionMat::whereIn('level_id', $matierePerLevels)->pluck('id');

        $matieresIds = UserMatiere::where('teacher_id', $user->id)->whereIn('level_id', $userLevelAndMaterialIds)->pluck('matiere_id')->unique();
        $matiereNames = [];
        foreach ($matieresIds as $matiereId) {
            $matiereName = Material::where('id', $matiereId)->pluck('name')->first();
            if ($matiereName && !in_array($matiereName, $matiereNames)) {
                $matiereNames[] = $matiereName;
            }
        }

        $matiere1 = collect();
        foreach ($matieresIds as $matiereId) {
            $material = Material::where('id', $matiereId)->whereIn('section_id', $sectionLevels)->with(['manuels'])->get();

            $material = $material->unique('name');

            if ($material) {
                foreach ($material as $mat) {
                    $manuels = Manuels::where('material_id', $mat->id)->with('matiere.section.level')->get();
                    $mat->manuels = $manuels;
                    $matiere1->push($mat);
                }
            }
        }
        $matiere1 = $this->filterManuelsByMatiereAndLevel($request,$user->id);
        
        $levelMaterials = [];

        $userMaterialQuery = UserMatiere::query();

        $teacherLevelAndMaterials = $userMaterialQuery->where('teacher_id', $user->id)->get();

        foreach ($teacherLevelAndMaterials as $item) {
            $levelName = School_level::where('id', $item->level_id)->pluck('name')->first();
            $materialNames = Material::where('id', $item->matiere_id)->pluck('name')->first();
            if (!isset($levelMaterials[$levelName])) {
                $levelMaterials[$levelName] = [];
            }
            if (!in_array($materialNames, $levelMaterials[$levelName])) {
                $levelMaterials[$levelName][] = $materialNames;
            }
        }

        Session::put('teacher_id', $user->id);
        $materialColors = [
            'العربية' => '#FFB3BA',
            'رياضيات' => '#8EACCD',
            'الإيقاظ العلمي' => '#A0937D',
            'الفرنسية' => '#A6B37D',
            'المواد الاجتماعية' => '#F6D7A7',
            'الإنجليزية' => '#BAABDA',
        ];

        $data = [
            
            'pageTitle' => $user->full_name . ' ' . trans('public.profile'),
            'user' => $user,
            'userBadges' => $userBadges,
            'meetings' => $meetings,
            'times' => $times,
            'userRates' => $user->rates(),
            'authUserIsFollower' => $authUserIsFollower,
            'educations' => $userMetas->where('name', 'education'),
            'experiences' => $userMetas->where('name', 'experience'),
            'webinars' => $webinars,
            'appointments' => $appointments,
            'matiere1' =>$matiere1,
            'levelMaterials' =>$levelMaterials,
            'instructors' => $instructors,
            'materialColors' => $materialColors,
            'forumTopics' => $this->getUserForumTopics($user->id),
            'authUser' => $authUser,
            
        ];

        return view('web.default.user.profile', $data);
    }
    public function profilepannel($id,Request $request)
    {
        $user = User::where('id', $id)
        ->whereIn('role_name', [Role::$organization, Role::$teacher, Role::$user])
        ->with([
            'blog' => function ($query) {
                $query->where('status', 'publish');
                $query->withCount([
                    'comments' => function ($query) {
                        $query->where('status', 'active');
                    }
                ]);
            },
            'products' => function ($query) {
                $query->where('status', Product::$active);
            },
        ])
        ->first();

    if (!$user) {
        abort(404);
    }

    $userBadges = $user->getBadges();
    
    $meetings = MeetingTime::with([
        'meeting' => function ($query) use ($user) {
            $query->where('teacher_id', $user->id);
        }
    ])
    ->whereHas('meeting', function ($query) use ($user) {
        $query->where('teacher_id', $user->id);
    })
    ->where('meet_date', '>=', date('Y-m-d')) 
    ->where(function($query) {
        $currentTime = date('h:i A');
        $query->where(function($query) use ($currentTime) {
            $query->where('meet_date', '=', date('Y-m-d'))
                  ->whereRaw("STR_TO_DATE(SUBSTRING_INDEX(time, '-', 1), '%h:%i%p') > STR_TO_DATE(?, '%h:%i%p')", [$currentTime]);
        })
        ->orWhere('meet_date', '>', date('Y-m-d'));
    })
    ->whereDoesntHave('reservations', function ($query) use ($user) {
        $query->where('user_id', $user->id);
    })
    ->get();

    // Apply the filter
    $meetings = $this->filtersMeetingByMatiere($meetings, $request);

    // Return or use $filteredMeetings as needed



    $times = [];
    if (!empty($meetings->meetingTimes)) {
        $times = convertDayToNumber($meetings->meetingTimes->groupby('day_label')->toArray());
    }

    $followings = $user->following();
    $followers = $user->followers();

    $authUserIsFollower = false;
    if (auth()->check()) {
        $authUserIsFollower = $followers->where('follower', auth()->id())
            ->where('status', Follow::$accepted)
            ->first();
    }

    $userMetas = $user->userMetas;

    $webinars = Webinar::where('status', Webinar::$active)
        ->where('private', false)
        ->where(function ($query) use ($user) {
            $query->where('creator_id', $user->id)
                ->orWhere('teacher_id', $user->id);
        })
        ->orderBy('updated_at', 'desc')
        ->with(['teacher' => function ($qu) {
            $qu->select('id', 'full_name', 'avatar');
        }, 'reviews', 'tickets', 'feature'])
        ->get();

    $meetingIds = Meeting::where('teacher_id', $user->id)->pluck('id');
    $appointments = ReserveMeeting::whereIn('meeting_id', $meetingIds)
        ->whereNotNull('reserved_at')
        ->where('status', '!=', ReserveMeeting::$canceled)
        ->count();

    $studentsIds = Sale::whereNull('refund_at')
        ->where('seller_id', $user->id)
        ->whereNotNull('webinar_id')
        ->pluck('buyer_id')
        ->toArray();
    $user->students_count = count(array_unique($studentsIds));

    $instructors = null;
    if ($user->isOrganization()) {
        $instructors = User::where('organ_id', $user->id)
            ->where('role_name', Role::$teacher)
            ->where('status', 'active')
            ->get();
    }
    $userMaterialQuery = UserMatiere::query();

    $teacherLevelAndMaterials = $userMaterialQuery->where('teacher_id', $user->id)->get();

    $listmatiere22 = UserMatiere::where('teacher_id', $user->id)->pluck('matiere_id');
    $listmatiere = $userMaterialQuery->where('teacher_id', $user->id)->pluck('matiere_id');

    $matiereNN = [];

    foreach ($listmatiere22 as $matiereId) {
        $matieregetnameall = Material::where('id', $matiereId)->pluck('id');
        $matiereNN[] = $matieregetnameall;
    }

    $matiereNames = [];

    foreach ($matiereNN as $matiereId) {
        $matiereName = Material::where('id', $matiereId)->pluck('name')->first();
        if ($matiereName && !in_array($matiereName, $matiereNames)) {
            $matiereNames[] = $matiereName;
        }
    }

    $userLevelAndMaterialIds =  $userMaterialQuery->where('teacher_id', $user->id)->pluck('level_id');
    $userLevelIds = UserMatiere::where('teacher_id', $user->id)->pluck('level_id')->unique();
    $levels = School_level::whereIn('id', $userLevelIds)->pluck('name', 'id');

     $matierePerLevels = $this->filtersByLevelAndMaterial($userMaterialQuery, $request);

    $sectionLevels = SectionMat::whereIn('level_id', $matierePerLevels)->pluck('id');

    $matieresIds = UserMatiere::where('teacher_id', $user->id)->whereIn('level_id', $userLevelAndMaterialIds)->pluck('matiere_id')->unique();
    $matiereNames = [];
    foreach ($matieresIds as $matiereId) {
        $matiereName = Material::where('id', $matiereId)->pluck('name')->first();
        if ($matiereName && !in_array($matiereName, $matiereNames)) {
            $matiereNames[] = $matiereName;
        }
    }

    $matiere1 = collect();
    foreach ($matieresIds as $matiereId) {
        $material = Material::where('id', $matiereId)->whereIn('section_id', $sectionLevels)->with(['manuels'])->get();

        $material = $material->unique('name');

        if ($material) {
            foreach ($material as $mat) {
                $manuels = Manuels::where('material_id', $mat->id)->with('matiere.section.level')->get();
                $mat->manuels = $manuels;
                $matiere1->push($mat);
            }
        }
    }
    $matiere1 = $this->filterManuelsByMatiereAndLevel($request,$user->id);

    $level=School_Level::all();
    $levelMaterials = [];

    $userMaterialQuery = UserMatiere::query();

    $teacherLevelAndMaterials = $userMaterialQuery->where('teacher_id', $user->id)->get();

    foreach ($teacherLevelAndMaterials as $item) {
        $levelName = School_level::where('id', $item->level_id)->pluck('name')->first();
        
        $materialNames = Material::where('id', $item->matiere_id)->first();
        if (!isset($levelMaterials[$levelName])) {
            $levelMaterials[$levelName] = [];
        }
        if (!in_array($materialNames, $levelMaterials[$levelName])) {
            $levelMaterials[$levelName][] = $materialNames;
        }
    }
    
    $data = [
        
        'pageTitle' => $user->full_name . ' ' . trans('public.profile'),
        'user' => $user,
        'userBadges' => $userBadges,
        'times' => $times,
        'userRates' => $user->rates(),
        'userFollowers' => $followers,
        'userFollowing' => $followings,
        'authUserIsFollower' => $authUserIsFollower,
        'educations' => $userMetas->where('name', 'education'),
        'experiences' => $userMetas->where('name', 'experience'),
        'meetings' => $meetings,
        'webinars' => $webinars,
        'levelMaterials' =>$levelMaterials,
        'appointments' => $appointments,
        'instructors' => $instructors,
        'matiere1'=> $matiere1,
        'forumTopics' => $this->getUserForumTopics($user->id)
    ];

        return view('web.default.user.profile_pannel', $data);
    }

    private function getUserForumTopics($userId)
    {
        $forumTopics = null;

        if (!empty(getFeaturesSettings('forums_status')) and getFeaturesSettings('forums_status')) {
            $forumTopics = ForumTopic::where('creator_id', $userId)
                ->orderBy('pin', 'desc')
                ->orderBy('created_at', 'desc')
                ->withCount([
                    'posts'
                ])
                ->get();

            foreach ($forumTopics as $topic) {
                $topic->lastPost = $topic->posts()->orderBy('created_at', 'desc')->first();
            }
        }

        return $forumTopics;
    }

       /**
     * Filter the manuels by matiere and level
     * @param $query
     * @param $request
     * @return Collection
     */
    private function filtersByLevelAndMaterial($query, $request)
    {
        $by_level = $request->get('by_level');
        $by_matiere_name = $request->get('by_matiere');
   
        
        if (!empty($by_level) && !empty($by_matiere_name)) {
            
            $query = $query->where('level_id', $by_level)
                ->join('materials', 'materials.id', '=', 'user_matiere.matiere_id')
                ->where('materials.id', $by_matiere_name);
        } elseif (!empty($by_level)) {
            $query = $query->where('level_id', $by_level);
        } elseif (!empty($by_matiere_name)) {
            $query = $query->join('materials', 'materials.id', '=', 'user_matiere.matiere_id')
                ->where('materials.id', $by_matiere_name);
               
        }

        return $query->pluck('level_id');
    }
      /**
     * Filter the manuels by matiere and level
     * @param $query
     * @param $request
     * @return Collection
     */

     private function filterManuelsByMatiereAndLevel($request,$id)
     {
         $by_level = $request->get('by_level');
         $by_matiere_name = $request->get('by_matiere');
        
 
         $query = Manuels::select('manuels.*', 'materials.name as material_name', 'sectionsmat.level_id as section_level')
             ->join('materials', 'materials.id', '=', 'manuels.material_id')
             ->join('sectionsmat', 'sectionsmat.id', '=', 'materials.section_id')
             ->join('user_matiere', 'user_matiere.matiere_id', '=', 'materials.id')
             ->where('user_matiere.teacher_id',$id);
 
         if (!empty($by_level)) {
             $query->where('sectionsmat.level_id', $by_level);
         }
 
         if (!empty($by_matiere_name)) {
             $query->where('materials.name', $by_matiere_name);
         }
 
         $manuels = $query->with(['matiere.section.level'])->get();
 
         $materials = collect();
         foreach ($manuels as $manuel) {
             $material = $manuel->matiere;
             if ($material && !$materials->contains('id', $material->id)) {
                 $material->manuels = collect();
                 $materials->push($material);
             }
             if ($material) {
                 $material->manuels->push($manuel);
             }
         }
 
         return $materials;
     }
  
     private function filtersMeetingByMatiere($meetings, Request $request)
     {
         $by_level = $request->get('level_meeting_id'); // Getting level from request
         $by_matiere = $request->get('material_meeting_id'); // Getting material from request
         
         // Filter based on level
         if (!empty($by_level)) {
             $meetings = $meetings->filter(function ($meeting) use ($by_level) {
                 return $meeting->meeting->level_id == $by_level;
             });
         }
     
         // Filter based on material (matiere)
         if (!empty($by_matiere)) {
            
             $meetings = $meetings->filter(function ($meeting) use ($by_matiere) {
       
                 return $meeting->matiere_id == $by_matiere;
             });
         }
         return $meetings; // Return the filtered collection
     }
     
    public function followToggle($id)
    {
        $authUser = auth()->user();
        $user = User::where('id', $id)->first();

        $followStatus = false;
        $follow = Follow::where('follower', $authUser->id)
            ->where('user_id', $user->id)
            ->first();

        if (empty($follow)) {
            Follow::create([
                'follower' => $authUser->id,
                'user_id' => $user->id,
                'status' => Follow::$accepted,
            ]);

            $followStatus = true;
        } else {
            $follow->delete();
        }

        return response()->json([
            'code' => 200,
            'follow' => $followStatus
        ], 200);
    }

    public function availableTimes(Request $request, $id)
    {
        $timestamp = $request->get('timestamp');
        $dayLabel = $request->get('day_label');
        $date = $request->get('date');

        $user = User::where('id', $id)
            ->whereIn('role_name', [Role::$teacher, Role::$organization])
            ->where('status', 'active')
            ->first();

        if (!$user) {
            abort(404);
        }

        $meeting = Meeting::where('teacher_id', $user->id)
            ->with(['meetingTimes'])
            ->first();

        $resultMeetingTimes = [];

        if (!empty($meeting->meetingTimes)) {

            if (empty($dayLabel)) {
                $dayLabel = dateTimeFormat($timestamp, 'l', false, false);
            }

            $dayLabel = mb_strtolower($dayLabel);

            $meetingTimes = $meeting->meetingTimes()->where('day_label', $dayLabel)->get();

            if (!empty($meetingTimes) and count($meetingTimes)) {

                foreach ($meetingTimes as $meetingTime) {
                    $can_reserve = true;

                    $reserveMeeting = ReserveMeeting::where('meeting_time_id', $meetingTime->id)
                        ->where('day', $date)
                        ->first();

                    if ($reserveMeeting && ($reserveMeeting->locked_at || $reserveMeeting->reserved_at)) {
                        $can_reserve = false;
                    }

                    /*if ($timestamp + $secondTime < time()) {
                        $can_reserve = false;
                    }*/

                    $resultMeetingTimes[] = [
                        "id" => $meetingTime->id,
                        // "time" => $meetingTime->time,
                        "description" => $meetingTime->description,
                        "can_reserve" => $can_reserve,
                        'meeting_type' => $meetingTime->meeting_type
                    ];
                }
            }
        }

        return response()->json([
            'times' => $resultMeetingTimes
        ], 200);
    }

    /**
     * Display the instructors page.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

       public function instructors(Request $request)
    {
        $seoSettings = getSeoMetas('instructors');
        $pageTitle = !empty($seoSettings['title']) ? $seoSettings['title'] : trans('home.instructors');
        $pageDescription = !empty($seoSettings['description']) ? $seoSettings['description'] : trans('home.instructors');
        $pageRobot = getPageRobot('instructors');
        $levels = School_level::all();
        foreach ($levels as $level) {
            $level->sections = SectionMat::where('level_id', $level->id)->get();
        }
        $matieres = Material::all();
        
        $data = $this->handleInstructorsOrOrganizationsPage($request, Role::$teacher);

        $data['title'] = trans('home.instructors');
        $data['page'] = 'instructors';
        $data['pageTitle'] = $pageTitle;
        $data['pageDescription'] = $pageDescription;
        $data['pageRobot'] = $pageRobot;
        $data['levels'] = $levels;
        $data['matieres'] = $matieres;

        return view('web.default.pages.instructors', $data);
    }

       /**
     * Get materials by level id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function getMaterialsByLevel(Request $request)
    {
        $levelId = $request->input('level_id');

        if (!empty($levelId)) {
            $matieres = Material::whereHas('section', function($query) use ($levelId) {
                $query->where('level_id', $levelId);
            })->get();
            return response()->json($matieres);
        }
        return response()->json([]);
    }

    /**
     * Get instructors by level and material
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function searchInstructors(Request $request)
    {
        $levelId = $request->input('level');
        $materialId = $request->input('material');
    
        $query = User::query();
    
        if ($levelId) {
            $query->whereHas('levels', function($q) use ($levelId) {
                $q->where('level_id', $levelId);
            });
        }
    
        if ($materialId) {
            $query->whereHas('materials', function($q) use ($materialId) {
                $q->where('matiere_id', $materialId);
            });
        }
        $query->where('role_id', 4);
    
        $instructors = $query ->groupBy('users.id') // Ensure to group by 'users.id' to fix the error related to COUNT
        ->has('videos') // Only include users   that have at least one video
        ->paginate(40);
    
        $html = '';
        foreach ($instructors as $instructor) {
            $html .= view('web.default.pages.instructor_card', ['instructor' => $instructor])->render();
        }
    
        return response()->json(['html' => $html]);
    }

    public function manuels(Request $request)
    {
        $pageTitle = trans('home.manuels');
        $levels = School_level::all();
        $selectedLevel = $request->get('level', 6);
        $videos = HomeVideo::with(['manuel','teacher'])->whereHas('manuel.matiere.section', function ($query) use ($selectedLevel) {
            $query->where('level_id', $selectedLevel);
        })->take(3)->get();

 
        if ($request->ajax()) {
            return view('web.default.pages.partials.videos', compact('videos'))->render();
        }

        $pageRobot = getPageRobot('manuels');
        $seoSettings = getSeoMetas('manuels');
   
        $pageDescription = !empty($seoSettings['description']) ? $seoSettings['description'] : trans('home.home.instructors');

        $data = [
            'pageTitle' => $pageTitle,
            'page' => 'manuels',
            'title' => trans('home.manuels'),
            'pageDescription' => $pageDescription,
            'firstLevelManuels' => $this->getManuels(1),
            'secondLevelManuels' => $this->getManuels(2),
            'thirdLevelManuels' => $this->getManuels(3),
            'fourthLevelManuels' => $this->getManuels(4),
            'fifthLevelManuels' => $this->getManuels(5),
            'sixthLevelManuels' => $this->getManuels(6),
            'levels' => $levels,
            'videos' => $videos,
            'pageRobot' => $pageRobot,
            'selectedLevel' => $selectedLevel, 
        ];
        return view('web.default.pages.manuels', $data);
    }

 
    private function getManuels($level)
    {
        $manuels= Manuels::get();
        return $manuels;
    }

    public function organizations(Request $request)
    {
        $seoSettings = getSeoMetas('organizations');
        $pageTitle = !empty($seoSettings['title']) ? $seoSettings['title'] : trans('home.organizations');
        $pageDescription = !empty($seoSettings['description']) ? $seoSettings['description'] : trans('home.organizations');
        $pageRobot = getPageRobot('organizations');

        $data = $this->handleInstructorsOrOrganizationsPage($request, Role::$organization);

        $data['title'] = trans('home.organizations');
        $data['page'] = 'organizations';
        $data['pageTitle'] = $pageTitle;
        $data['pageDescription'] = $pageDescription;
        $data['pageRobot'] = $pageRobot;

        return view('web.default.pages.instructors', $data);
    }

    private function getTopFollowersUsers($query, $role)
    {
        $query->leftJoin('follows', function ($join) {
            $join->on('users.id', '=', 'follows.user_id');
        })
            ->select('users.*', DB::raw('count(follows.follower) as counts'))
            ->groupBy('follows.user_id')
            ->orderBy('counts', 'desc');

        return $query;
    }

     public function handleInstructorsOrOrganizationsPage(Request $request, $role)
    {
        $query = User::where('role_name', $role)
            ->where('users.status', 'active')
            ->where(function ($query) {
                $query->where('users.ban', false)
                    ->orWhere(function ($query) {
                        $query->whereNotNull('users.ban_end_at')
                            ->orWhere('users.ban_end_at', '<', time());
                    });
            })
            ->with(['meeting' => function ($query) {
                $query->with('meetingTimes');
                $query->withCount('meetingTimes');
                
            }]) ;// Order by videos_count
     
            $listmatiere = UserMatiere::pluck('matiere_id');

            $matiereNames = [];
         
            
            foreach ($listmatiere as $matiereId) {
                $matiereName = Material::where('id', $matiereId)->pluck('name')->first();
                if ($matiereName && !in_array($matiereName, $matiereNames)) {
                    $matiereNames[] = $matiereName;
                }
            }
        $instructors = $this->filterInstructors($request, deepClone($query), $role, true)  ->withCount('videos') // Generate videos_count
        ->orderBy('videos_count', 'desc')->paginate(9);
        if ($request->ajax()) {
            $html = null;

            foreach ($instructors as $instructor) {
                $html .= '<div class="col-12 col-lg-4">';
                $html .= (string)view()->make('web.default.pages.instructor_card', ['instructor' => $instructor]);
                $html .= '</div>';
            }

            return response()->json([
                'html' => $html,
                'last_page' => $instructors->lastPage(),
            ], 200);
        }

        if (empty($request->get('sort')) or !in_array($request->get('sort'), ['top_rate', 'top_sale'])) {
            $bestRateInstructorsQuery = $this->getBestRateUsers(deepClone($query), $role);

            $bestSalesInstructorsQuery = $this->getTopSalesUsers(deepClone($query), $role);
            $bestFollowersInstructorsQuery = $this->getTopFollowersUsers(deepClone($query), $role);

            $bestRateInstructors = $bestRateInstructorsQuery
                ->limit(8)
                ->get();

            $bestSalesInstructors = $bestSalesInstructorsQuery
                ->limit(8)
                ->get();

            $bestFollowersInstructors = $bestFollowersInstructorsQuery
                ->limit(8)
                ->get();
        }

        $categories = Category::where('parent_id', null)
            ->with('subCategories')
            ->get();
        //dd($instructors);
        $data = [
            'pageTitle' => trans('home.instructors'),
            'instructors' => $instructors,
            'instructorsCount' => deepClone($query)->count(),
            'bestRateInstructors' => $bestRateInstructors ?? null,
            'bestSalesInstructors' => $bestSalesInstructors ?? null,
            'bestFollowersInstructors' => $bestFollowersInstructors ?? null,
            'categories' => $categories,
            'matiereNames' => $matiereNames,
        ];

        return $data;
    }



       private function filterInstructors($request, $query, $role, $availableForMeeting = false)
    {
        $levels = $request->input('levels');
        $materials = $request->input('materials');
        $sort = $request->get('sort', null);
        $requestAvailableForMeetings = $request->get('available_for_meetings', null);
        // $availableForMeetings = $availableForMeeting === true 
        // && $requestAvailableForMeetings === null ? 'on': $request->get('available_for_meetings', null);
        $availableForMeetings = $request->get('available_for_meetings', 'off');  // Default to 'on'
        $hasFreeMeetings = $request->get('free_meetings', null);
        $withDiscount = $request->get('discount', null);
        $search = $request->get('search', null);
        
        if (!empty($levels)) {
            $query->whereHas('levels', function ($q) use ($levels) {
                $q->whereIn('id', $levels);
            });
        }
    
        if (!empty($materials)) {
            $query->whereHas('materials', function ($q) use ($materials) {
                $q->whereIn('id', $materials);
            });
        }

        if (!empty($categories) and is_array($categories)) {
            $userIds = UserOccupation::whereIn('category_id', $categories)->pluck('user_id')->toArray();

            $query->whereIn('users.id', $userIds);
        }

        if (!empty($sort) and $sort == 'top_rate') {
            $query = $this->getBestRateUsers($query, $role);
        }

        if (!empty($sort) and $sort == 'top_sale') {
            $query = $this->getTopSalesUsers($query, $role);
        }

        if (!empty($availableForMeetings) and $availableForMeetings == 'on') {
            $hasMeetings = DB::table('meetings')
                ->where('meetings.disabled', 0)
                ->join('meeting_times', 'meetings.id', '=', 'meeting_times.meeting_id')
                ->select('meetings.teacher_id', DB::raw('count(meeting_id) as counts'))
                ->groupBy('teacher_id')
                ->orderBy('counts', 'desc')
                ->get();

            $hasMeetingsInstructorsIds = [];
            if (!empty($hasMeetings)) {
                $hasMeetingsInstructorsIds = $hasMeetings->pluck('teacher_id')->toArray();
            }

            $query->whereIn('users.id', $hasMeetingsInstructorsIds);
        }

        if (!empty($hasFreeMeetings) and $hasFreeMeetings == 'on') {
            $freeMeetingsIds = Meeting::where('disabled', 0)
                ->where(function ($query) {
                    $query->whereNull('amount')->orWhere('amount', '0');
                })->groupBy('teacher_id')
                ->pluck('teacher_id')
                ->toArray();

            $query->whereIn('users.id', $freeMeetingsIds);
        }

        if (!empty($withDiscount) and $withDiscount == 'on') {
            $withDiscountMeetingsIds = Meeting::where('disabled', 0)
                ->whereNotNull('discount')
                ->groupBy('teacher_id')
                ->pluck('teacher_id')
                ->toArray();

            $query->whereIn('users.id', $withDiscountMeetingsIds);
        }

        if (!empty($search)) {
            $query->where(function ($qu) use ($search) {
                $qu->where('users.full_name', 'like', "%$search%")
                    ->orWhere('users.email', 'like', "%$search%")
                    ->orWhere('users.mobile', 'like', "%$search%");
            });
        }

        return $query;
    }

    private function getBestRateUsers($query, $role)
    {
        $query->leftJoin('webinars', function ($join) use ($role) {
            if ($role == Role::$organization) {
                $join->on('users.id', '=', 'webinars.creator_id');
            } else {
                $join->on('users.id', '=', 'webinars.teacher_id');
            }

            $join->where('webinars.status', 'active');
        })->leftJoin('webinar_reviews', function ($join) {
            $join->on('webinars.id', '=', 'webinar_reviews.webinar_id');
            $join->where('webinar_reviews.status', 'active');
        })
            ->whereNotNull('rates')
            ->select('users.*', DB::raw('avg(rates) as rates'))
            ->orderBy('rates', 'desc');

        if ($role == Role::$organization) {
            $query->groupBy('webinars.creator_id');
        } else {
            $query->groupBy('webinars.teacher_id');
        }

        return $query;
    }

    private function getTopSalesUsers($query, $role)
    {
        $query->leftJoin('sales', function ($join) {
            $join->on('users.id', '=', 'sales.seller_id')
                ->whereNull('refund_at');
        })
            ->whereNotNull('sales.seller_id')
            ->select('users.*', 'sales.seller_id', DB::raw('count(sales.seller_id) as counts'))
            ->groupBy('sales.seller_id')
            ->orderBy('counts', 'desc');

        return $query;
    }

    public function makeNewsletter(Request $request)
    {
        $contact = $request->input('newsletter_contact');
        $isEmail = filter_var($contact, FILTER_VALIDATE_EMAIL);
    
        $contactField = $isEmail ? 'email' : 'phone';
    
        $validationRules = [
            'newsletter_contact' => 'required|string|max:255|unique:newsletters,' . $contactField
        ];
        
    
        if ($isEmail) {
            $validationRules['newsletter_contact'] .= '|email'; 
        } else {
            $validationRules['newsletter_contact'] .= '|regex:/^[0-9]{8}$/';
        }
    
        $validator = \Validator::make($request->all(), $validationRules);

        if ($validator->fails()) {
            return redirect('/#newsletterFooter')->withErrors($validator)->withInput();
        }
    
        $data = $request->all();
        $user_id = null;
    
        if (auth()->check()) {
            $user = auth()->user();
            if ($isEmail) {
                if (empty($user->email)) {
                    $user->update([
                        'email' => $contact,
                        'newsletter' => true,
                    ]);
                } else if ($user->email === $contact) {
                    $user_id = $user->id;
                    $user->update(['newsletter' => true]);
                }
            }
        }
            $check = Newsletter::where($contactField, $contact)->first();
        if (!empty($check)) {
            if (!empty($check->user_id) && !empty($user_id) && $check->user_id != $user_id) {
                $toastData = [
                    'title' => trans('public.request_failed'),
                    'msg' => trans('update.this_contact_used_by_another_user'),
                    'status' => 'error',
                    'redirect' => '/#newsletterFooter'
                ];
                return redirect('/#newsletterFooter')->with(['toast' => $toastData]);

            } elseif (empty($check->user_id) && !empty($user_id)) {
                $check->update(['user_id' => $user_id]);
            }
        } else {
            Newsletter::create([
                'user_id' => $user_id,
                $contactField => $contact,
                'created_at' => now()->timestamp,
            ]);
        }
    
        if (!empty($user_id)) {
            $newsletterReward = RewardAccounting::calculateScore(Reward::NEWSLETTERS);
            RewardAccounting::makeRewardAccounting($user_id, $newsletterReward, Reward::NEWSLETTERS, $user_id, true);
        }
    
        $toastData = [
            'title' => trans('public.request_success'),
            'msg' => trans('site.create_newsletter_success'),
            'status' => 'success',
            'redirect' => '/#newsletterFooter'
        ];
        return redirect('/#newsletterFooter')->with(['toast' => $toastData]);
    }
    public function sendMessage(Request $request, $id)
    {
        if (!empty($id)) {
            $user = User::select('id', 'email')
                ->where('id', $id)
                ->first();

            if (!empty($user) and !empty($user->email)) {
                $data = $request->all();

                $validator = Validator::make($data, [
                    'title' => 'required|string',
                    'email' => 'required|email',
                    'description' => 'required|string',
                    'captcha' => 'required|captcha',
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'code' => 422,
                        'errors' => $validator->errors()
                    ], 422);
                }

                $mail = [
                    'title' => $data['title'],
                    'message' => trans('site.you_have_message_from', ['email' => $data['email']]) . "\n" . $data['description'],
                ];

                try {
                    \Mail::to($user->email)->send(new \App\Mail\SendNotifications($mail));

                    return response()->json([
                        'code' => 200
                    ]);
                } catch (Exception $e) {
                    return response()->json([
                        'code' => 500,
                        'message' => trans('site.server_error_try_again')
                    ]);
                }
            }

            return response()->json([
                'code' => 403,
                'message' => trans('site.user_disabled_public_message')
            ]);
        }
    }
    public function step2(){

       
        //$country=User::where('id',auth()->user()->id)->pluck('time_zone');
       // $coun = Country::where("name",  $country)->pluck('id');
        $cities =Region::where("country_id", 72)->where("type", 'city')->orderBy("title")->get();
        // $countries = Country::select("id", "name")->get();
         $level=School_level::all();
          $schools=School::all();
        $sec=School_level::select("id")->get();
        $sections =SectionMat::all();
        $options =Option::all();
       
         // On retourne la vue avec les pays
         return view('web.default.auth.step2', [
             'countries' => '',
             'cities' => $cities,
             'schools' => $schools,   
             'level' => $level, 
             'sections' =>$sections,
             'options' =>$options,
         ]);
    }
    public function findSchoolName(Request $request){
        if(!empty($request->city )){
        $data=School::select('name','id')->where('city',$request->city)->where('type','Secondaire')->take(100)->get();
          }
        
          else {
            $data=School::all();

        }
        return response()->json($data);//then sent this data to ajax success


    }
    public function findSchoolSection(Request $request){
        
        $data=SectionMat::select('name','id')->where('level_id',$request->level_id)->take(100)->get();
 
        return response()->json($data);

    }
    public function findSchoolOption(Request $request){
        if($request->level_id!=1 && $request->level_id!= 2 && $request->level_id==3){
            $data=Option::select('name','id')->where('niveau','3')->take(100)->get();
            }
            else if($request->level_id!=1 && $request->level_id!= 2 && $request->level_id==4){
                $data=Option::select('name','id')->where('niveau','4')->take(100)->get();
            }
          
            return response()->json($data);
    

    }
    public function saveUserInfo(Request $request){
        $user=User::where('id',auth()->user()->id)->get();

        auth()->user()->update([
    
           'school_id' => $request->name,
           'section_id' => $request->name_section,
           'level_id' => $request->name_level,
           'option_id'=>$request->name_option,
          ]);
      if(empty($request->name_section )){
       return redirect('/panel');
      }else{
      
        return redirect('/panel'); 
      
       }
       }
}

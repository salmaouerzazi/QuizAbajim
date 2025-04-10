<?php

namespace App\Http\Controllers\Panel;

use App\Enfant;
use App\Http\Controllers\Controller;
use App\Mixins\RegistrationPackage\UserPackage;
use App\Models\Comment;
use App\Models\Meeting;
use App\Models\ReserveMeeting;
use App\Models\Sale;
use App\Models\Support;
use App\User;
USE App\Models\Subscribe;
use App\Models\Webinar;
use App\Models\SectionMat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\School_level;
use App\Models\Video;
use App\Models\Material;
use App\Models\Manuels;
use App\Models\Option;
use App\Models\Role;
use App\Models\UserLevel;
use App\UserMatiere;
use DB;
use App\Models\CardReservation;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use App\Models\MeetingTime;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Route;
// UserController
use App\Http\Controllers\Panel\UserController;

class DashboardController extends Controller
{

    /**
     * For AJAX filtering
     * @param Request $request
     * @return JsonResponse
     */
    public final function getmaterialsforlevel(Request $request): JsonResponse
    {
        $currentDay = date('l');
        $sectionEnfantid = SectionMat::where('level_id', $request->level_id)->pluck('id');

        if (!empty($request->level_id)) {
            $data = Material::select('name', 'id', 'path', 'section_id')->where('section_id', $sectionEnfantid[0])->take(10)
                ->with(['section.level'])->get();
            $instructors = User::where('role_name', Role::$teacher)
                ->select('id', 'full_name', 'avatar', 'bio')
                ->where('status', 'active')
                ->where(function ($query) {
                    $query->where('ban', false)
                        ->orWhere(function ($query) {
                            $query->whereNotNull('ban_end_at')
                                ->where('ban_end_at', '<', time());
                        });
                })->with([
                    'meeting' => function ($query) use ($currentDay) {

                        $query->with(['meetingTimes' => function ($subQuery) use ($currentDay) {
                            $subQuery->where("day_label", strtolower($currentDay));
                        }]);
                        $query->withCount('meetingTimes');
                    },
                    'occupations'
                ])
                ->limit(8)
                ->get();
            foreach ($data as $material) {
                if ($material->section) {
                    $level = $material->section->level;
                    $material->level = $level;
                }
            }
        } else {
            $data = Material::all();
            $instructors = User::where('role_name', Role::$teacher)
                ->select('id', 'full_name', 'avatar', 'bio')
                ->where('status', 'active')
                ->where(function ($query) {
                    $query->where('ban', false)
                        ->orWhere(function ($query) {
                            $query->whereNotNull('ban_end_at')
                                ->where('ban_end_at', '<', time());
                        });
                })->with([
                    'meeting' => function ($query) use ($currentDay) { // Use the $currentDay variable

                        $query->with(['meetingTimes' => function ($subQuery) use ($currentDay) {
                            $subQuery->where("day_label", strtolower($currentDay));
                        }]);
                        $query->withCount('meetingTimes');
                    },
                    'occupations'
                ])
                ->limit(8)
                ->get();
        }

        return response()->json([
            'materials' => $data,
            'instructors' => $instructors
        ]);
    }
    public function DetailMaterial($id)
    {
         $material=Material::where('id',$id)->first();
        $user = auth()->user();
        $webinars = Webinar::where('status', 'active')->where('level_id', $user->level_id)
        ->orderBy('created_at', 'desc')
        ->limit(6)
        ->get();
 
        return view('web.default.panel.detail_material',['authUser'=>$user,'material'=>$material,'webinars'=> $webinars ]);
 
    }
    public function test()
    {
        $user = auth()->user();
        {
            $currentDay = date('l');
            $subscribes =Subscribe::where('id', '<>', 10)->get();
            $instructors = User::where('role_name', Role::$teacher)
                ->select('id', 'full_name', 'avatar', 'bio')
                ->where('status', 'active')
                ->where(function ($query) {
                    $query->where('ban', false)
                        ->orWhere(function ($query) {
                            $query->whereNotNull('ban_end_at')
                                ->where('ban_end_at', '<', time());
                        });
                })->with([
                    'meeting' => function ($query) use ($currentDay) {
    
                        $query->with(['meetingTimes' => function ($subQuery) use ($currentDay) {
                            $subQuery->where("day_label", strtolower($currentDay));
                        }]);
                        $query->withCount('meetingTimes');
                    },
                    'occupations'
                ])
                ->limit(8)
                ->get();
    
            $user = auth()->user();
            $guideProgress = is_string($user->guide_progress) ? json_decode($user->guide_progress, true) : $user->guide_progress;
            $sectionm = SectionMat::where('id', $user->section_id)->pluck('name');
            $levelm = School_level::where('id', $user->level_id)->pluck('name');
            $matieretearcher = Material::where('id', $user->matier_id)->pluck('name');
            $optiontearcher = Option::where('id', $user->option_id)->pluck('name');
            $enfants = Enfant::where("parent_id", "=", auth()->user()->id)->orderBy("id", "desc")->with('level')->get();
            $optiontearcher1 = option::where('name', 'Italien')->pluck('niveau');
            $videos = Video::where("id", ">", 37)->paginate(3);
            $matiereEnfant = Material::where('section_id', 19)->get();
            $userLevelName = School_level::where('id', $user->level_id)->pluck('name');
            $leveltt = [];
            $loadedlevel = [];
            if (!empty($user->option_id)) {
                foreach ($optiontearcher1 as $optionTeacher) {
    
                    $leveltt = School_level::where('id', $optionTeacher)->pluck('name');
                    if ($leveltt) {
                        $loadedlevel[] = [$leveltt];
                    }
                }
            }
    
            $option1 = [];
            $matiere1 = [];
            $options = [];
            $matiere = [];
    
            if (!empty($user->section_id)) {
                $matiere = Material::where('section_id', $user->section_id)->where('id','!=',7)->where('id','!=',11)->where('id','!=',14)->where('id','!=',15)->where('id','!=',18)->where('id','!=',19)->where('id','!=',20)->where('id','!=',21)->where('id','!=',23)->with('manuels')->get();
            
            }

            $manuel = collect();
            foreach ($matiere as $mat) {
                $manuels = Manuels::where('material_id', $mat->id)->where('id','!=',14)->where('id','!=',24)->where('id','!=',34)->where('id','!=',27)->where('id','!=',9)->where('id','!=',1313)->with(['matiere'])->get();//
                $mat->manuels = $manuels;
                $manuel->push($mat);
            }
            if (!empty($user->matier_id)) {
                $levelName = [];
                $sectiondd = SectionMat::where('id', $user->section_id)->pluck('name');
                $matieregetname = Material::where('id', $user->matier_id)->pluck('name');
                $filteredMatiere1 = Material::where('name', $matieregetname[0])
                    ->with(['section' => function ($query) {
                        $query->with('level');
                    }])
                    ->whereNotNull('path')->where('path', '<>', '')->get();
    
                foreach ($filteredMatiere1 as $material) {
                    if ($material->section) {
                        $levelName = $material->section->name;
                        // do something with $levelName
                    }
                }
                $loadedPaths = [];
    
                $matiere1 = $filteredMatiere1->filter(function ($matiere) use (&$loadedPaths) {
    
                    if (!in_array($matiere->path, $loadedPaths)) {
                        $loadedPaths[] = $matiere->path;
    
                        return true;
                    }
                    return false;
                });
            }
    
            $nextBadge = $user->getBadges(true, true);
    
            $reserveMeetings = MeetingTime::where('level_id', $user->level_id)->with('meeting.teacher')
    
            ->where('meet_date', '>=', date('Y-m-d'))
            ->where(function($query) {
                $currentTime = date('h:i A');
                    $query->where(function($query) use ($currentTime) {
                    $query->where('meet_date', '=', date('Y-m-d'));
                        //   ->whereRaw("STR_TO_DATE(SUBSTRING_INDEX(time, '-', 1), '%h:%i%p') > STR_TO_DATE(?, '%h:%i%p')", [$currentTime]);
                })
                ->orWhere('meet_date', '>', date('Y-m-d'));
            })
            ->whereDoesntHave('reservations', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->get();
    
    
            $instructor = User::where('role_name', Role::$teacher)->get();
    
            $data = [
                'pageTitle' => trans('panel.dashboard'),
                'nextBadge' => $nextBadge,
                'sectionm' => $sectionm,
                'levelm' => $levelm,
                'videos' => $videos,
                'matiere' => $matiere,
                'matiere1' => $matiere1,
                'option1' => $option1,
                'leveltt' => $leveltt,
                'options' => $options,
                'enfants' => $enfants,
                'matiereEnfant' => $matiereEnfant,
                'optiontearcher'  => $optiontearcher,
                'matieretearcher'  => $matieretearcher,
                'instructors'  => $instructors,
                'reserveMeetings' => $reserveMeetings,
                'userLevelName' => $userLevelName,
                'matiere1' => $manuel,
                'instructor' => $instructor,
                'subscribes' => $subscribes,
                'guide_progress' => $guideProgress['dashboard'] ?? [],
            ];
    
            if (!$user->isUser()) {
                $meetingIds = Meeting::where('teacher_id', $user->id)->pluck('id')->toArray();
                $pendingAppointments = ReserveMeeting::whereIn('meeting_id', $meetingIds)
                    ->whereHas('sale')
                    ->where('status', ReserveMeeting::$pending)
                    ->count();
    
                $userWebinarsIds = $user->webinars->pluck('id')->toArray();
                $supports = Support::whereIn('webinar_id', $userWebinarsIds)->where('status', 'open')->get();
    
                $comments = Comment::whereIn('webinar_id', $userWebinarsIds)
                    ->where('status', 'active')
                    ->whereNull('viewed_at')
                    ->get();
    
                $time = time();
                $firstDayMonth = strtotime(date('Y-m-01', $time)); // First day of the month.
                $lastDayMonth = strtotime(date('Y-m-t', $time)); // Last day of the month.
    
                $monthlySales = Sale::where('seller_id', $user->id)
                    ->whereNull('refund_at')
                    ->whereBetween('created_at', [$firstDayMonth, $lastDayMonth])
                    ->get();
    
                $data['pendingAppointments'] = $pendingAppointments;
                $data['supportsCount'] = count($supports);
                $data['commentsCount'] = count($comments);
    
                $data['monthlySalesCount'] = count($monthlySales) ? $monthlySales->sum('total_amount') : 0;
                $data['monthlyChart'] = $this->getMonthlySalesOrPurchase($user);
            } else {
                $webinarsIds = $user->getPurchasedCoursesIds();
    
                $webinars = Webinar::whereIn('id', $webinarsIds)
                    ->where('status', 'active')
                    ->get();
    
                $reserveMeetings = ReserveMeeting::where('user_id', $user->id)
                    ->whereHas('sale')
                    ->where('status', ReserveMeeting::$open)
                    ->get();
    
                $supports = Support::where('user_id', $user->id)
                    ->whereNotNull('webinar_id')
                    ->where('status', 'open')
                    ->get();
    
                $comments = Comment::where('user_id', $user->id)
                    ->whereNotNull('webinar_id')
                    ->where('status', 'active')
                    ->get();
    
                $data['webinarsCount'] = count($webinars);
                $data['supportsCount'] = count($supports);
                $data['commentsCount'] = count($comments);
                $data['reserveMeetings'] = $reserveMeetings;
                $data['reserveMeetingsCount'] = count($reserveMeetings);
                $data['monthlyChart'] = $this->getMonthlySalesOrPurchase($user);
            }
            $hasSubscribePack = \App\Models\OrderItem::query()
            ->where('user_id', auth()->id())
            ->where('model_type', 'App\Models\Subscribe')
            ->whereHas('order', function ($query) {
                $query->where('status', 'paid');
            })
            ->exists();
            $subscribedPack = \App\Models\OrderItem::query()
            ->where('user_id', auth()->id())
            ->where('model_type', 'App\Models\Subscribe')
            ->whereHas('order', function ($query) {
                $query->where('status', 'paid');
            })
            ->first();
            if ($hasSubscribePack) {
                $pack = \App\Models\Subscribe::query()
                ->where('id', $subscribedPack->model_id)
                ->first();
            }
            $data['optionsWithLevels'] = $options;
            $data['leveltt'] = $loadedlevel;
            $users = auth()->user();
            $parentid=User::where('id',$users->id)->first();
            $levels = School_level::all();
            return view('web.default.panel.test', [
            'authUser'=>$user,
            'users' => $users,
            'levels' => $levels,
            'parentid' => $parentid,    
            'pack' => $pack,
            'hasSubscribePack' => $hasSubscribePack,
            'subscribedPack' => $subscribedPack,
        ], $data);
        }
        
    
        return view('web.default.panel.test',['authUser'=>$user]);
    }
    /*
     * Display the dashboard page with the user's data
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public final function dashboard(Request $request): View
    {
        $user = auth()->user();
        $currentDay = strtolower(now()->format('l')); // Assuming you want to get the current day

        $instructors = User::where('role_name', Role::$teacher)
            ->select('id', 'full_name', 'avatar', 'bio')
            ->where('status', 'active')
            ->where(function ($query) {
                $query->where('ban', false)
                    ->orWhere(function ($query) {
                        $query->whereNotNull('ban_end_at')
                            ->where('ban_end_at', '<', time());
                    });
            })
            ->with([
                'meeting' => function ($query) use ($currentDay) {
                    $query->with(['meetingTimes' => function ($subQuery) use ($currentDay) {
                        $subQuery->where('day_label', $currentDay);
                    }]);
                },
                'occupations'
            ])
            ->limit(8)
            ->get();
        $meetingIds = Meeting::where('teacher_id', auth()->user()->id)->pluck('id');

        $reserveMeetingsQuery = ReserveMeeting::whereIn('meeting_id', $meetingIds)
            ->whereHas('sale');
        $reserveMeetings = $reserveMeetingsQuery
            ->orderBy('created_at', 'desc')->with(['meetingTime.level'])
            ->paginate(10);
        $reservation_percentage = [];
        foreach ($reserveMeetings as $reserveMeeting) {
            $meetingTime = $reserveMeeting->meetingTime;

            if ($meetingTime && $meetingTime->max_students > 0) {

                // Fetch student reservation count dynamically using the meeting_time_id
                $studentReservationCount = ReserveMeeting::where('meeting_time_id', $meetingTime->id)->count();
                $studentMax = $meetingTime->max_students;

                // Calculate percentage
                $percentage = ($studentReservationCount / $studentMax) * 100;

                // Add percentage to the meetingTime object
                $reservation_percentage[] = $percentage;
            } else {
                // If max_students is 0 or meetingTime is null, set percentage to 0
                if ($meetingTime) {
                    $reservation_percentage = 0;
                }
            }
        }

        $section = SectionMat::where('id', $user->section_id)->pluck('name')->first();

        $level = School_level::where('id', $user->level_id)->pluck('name')->first();

        // Retrieve the material names for the user
        $listmatiere = UserMatiere::where('teacher_id', $user->id)->pluck('matiere_id');

        $matiereNames = [];


        foreach ($listmatiere as $matiereId) {
            $matiereName = Material::where('id', $matiereId)->pluck('name')->first();
            if ($matiereName && !in_array($matiereName, $matiereNames)) {
                $matiereNames[] = $matiereName;
            }
        }

        $matieretearcher = Material::where('id', $listmatiere[0] ?? null)->pluck('name')->unique('name');
        $optiontearcher = Option::where('id', $user->option_id)->pluck('name')->unique('name');
        $enfants = Enfant::where("parent_id", "=", auth()->user()->id)->orderBy("id", "desc")->with('level')->get();
        $optiontearcher1 = Option::where('name', 'Italien')->pluck('niveau');
        $videos = Video::where("id", ">", 37)->paginate(3);
        $matiereEnfant = Material::where('section_id', 19)->get();
        $leveltt = [];
        $loadedlevel = [];

        if (!empty($user->option_id)) {
            foreach ($optiontearcher1 as $optionTeacher) {
                $leveltt = School_level::where('id', $optionTeacher)->pluck('name');
                if ($leveltt) {
                    $loadedlevel[] = [$leveltt];
                }
            }
        }

        $matiere = [];
        $option1 = [];
        $options = [];

        if (!empty($user->section_id)) {
            $matiere = Material::where('section_id', $user->section_id)->get();
        }
        if (!empty($user->option_id)) {
            $option1 = Option::where('id', $user->option_id)->get();
            $options = Option::where('name',  $option1[0]->name)->where('niveau', $user->level_id)->with('level')->get();
        }

        // ----------------------Sidebar part for teacher-------------------------
        $levelNameArray = [];
        $materialNameArray = [];
        $listMaterialArray = [];
        $userMaterialQuery = UserMatiere::query();
        $teacherLevelAndMaterialIds = $userMaterialQuery->where('teacher_id', $user->id)->get();
        $teacherLevelIds = $teacherLevelAndMaterialIds->pluck('level_id');
        foreach ($teacherLevelIds as $levelId) {
            $levelName = School_level::where('id', $levelId)->pluck('name')->first();
            $listMaterialIds = UserMatiere::where('teacher_id', $user->id)->where('level_id', $levelId)->pluck('matiere_id');
            $listMaterialArray[] = $listMaterialIds;
            if (!in_array($levelName, $levelNameArray))
                $levelNameArray[] = $levelName;
        }

        foreach ($listMaterialArray as $materialIds) {
            $materialNames = Material::whereIn('id', $materialIds)->pluck('name')->unique();
            $materialNameArray[] = $materialNames;
        }


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

        $userLevelAndMaterialIds =  $userMaterialQuery->where('teacher_id', $user->id)->get();
        $userLevelIds = UserMatiere::where('teacher_id', $user->id)->pluck('level_id')->unique();

        $levels = School_level::whereIn('id', $userLevelIds)->pluck('name', 'id');

        $matierePerLevels = $this->filtersByLevelAndMaterial($userMaterialQuery, $request);

        $sectionLevels = SectionMat::whereIn('level_id', $matierePerLevels)->pluck('id');

        $matieresIds = UserMatiere::where('teacher_id', $user->id)->whereIn('level_id', $matierePerLevels)->pluck('matiere_id')->unique();
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

        $webinars = Webinar::where(function ($query) use ($user) {
            if ($user->isTeacher()) {
                $query->where('teacher_id', $user->id);
            } 
        })
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        // ------------------- FILTER MANUELS BY LEVEL AND MATERIAL ----------------------------------------
        $matiere1 = $this->filterManuelsByMatiereAndLevel($request);
        $nextBadge = $user->getBadges(true, true);

        // -------------------- RETURN DATA TO THE BLADE ---------------------------------------
        $data = [
            'pageTitle' => trans('panel.dashboard'),
            'nextBadge' => $nextBadge,
            'sectionm' => $section,
            'levelm' => $level,
            'videos' => $videos,
            'matiere' => $matiere,
            'matiere1' => $matiere1,
            'option1' => $option1,
            'leveltt' => $leveltt,
            'options' => $options,
            'enfants' => $enfants,
            'reservation_percentage' => $reservation_percentage,
            'matiereEnfant' => $matiereEnfant,
            'optiontearcher'  => $optiontearcher,
            'matieretearcher'  => $matieretearcher,
            'matiereNames'  => $matiereNames,
            'matieregetnameall'  => $matiereNN,
            'userLevelIds'  => $userLevelAndMaterialIds,
            'levels' => $levels,
            'instructors' => $instructors,
            'levelnameArray' => $levelNameArray,
            'materialnameArray' => $materialNameArray,
            'reserveMeetings' => $reserveMeetings,
            'levelMaterials' => $levelMaterials,
            'webinars' => $webinars,
        ];
        // -------------------------------------------------------------------

        if (!$user->isUser()) {
            $meetingIds = Meeting::where('teacher_id', $user->id)->pluck('id')->toArray();
            $pendingAppointments = ReserveMeeting::whereIn('meeting_id', $meetingIds)
                ->whereHas('sale')
                ->where('status', ReserveMeeting::$pending)
                ->count();
            $userWebinarsIds = $user->webinars->pluck('id')->toArray();
            $supports = Support::whereIn('webinar_id', $userWebinarsIds)->where('status', 'open')->get();
            $comments = Comment::whereIn('webinar_id', $userWebinarsIds)
                ->where('status', 'active')
                ->whereNull('viewed_at')
                ->get();
            $time = time();
            $firstDayMonth = strtotime(date('Y-m-01', $time)); // First day of the month.
            $lastDayMonth = strtotime(date('Y-m-t', $time)); // Last day of the month.
            $monthlySales = Sale::where('seller_id', $user->id)
                ->whereNull('refund_at')
                ->whereBetween('created_at', [$firstDayMonth, $lastDayMonth])
                ->get();
            $data['pendingAppointments'] = $pendingAppointments;
            $data['supportsCount'] = count($supports);
            $data['commentsCount'] = count($comments);
            $data['monthlySalesCount'] = count($monthlySales) ? $monthlySales->sum('total_amount') : 0;
            $data['monthlyChart'] = $this->getMonthlySalesOrPurchase($user);
        } else {
            $webinarsIds = $user->getPurchasedCoursesIds();
            $webinars = Webinar::whereIn('id', $webinarsIds)
                ->where('status', 'active')
                ->get();
            $reserveMeetings = ReserveMeeting::where('user_id', $user->id)
                ->whereHas('sale')
                ->where('status', ReserveMeeting::$open)
                ->get();
            $supports = Support::where('user_id', $user->id)
                ->whereNotNull('webinar_id')
                ->where('status', 'open')
                ->get();
            $comments = Comment::where('user_id', $user->id)
                ->whereNotNull('webinar_id')
                ->where('status', 'active')
                ->get();
            $data['webinarsCount'] = count($webinars);
            $data['supportsCount'] = count($supports);
            $data['commentsCount'] = count($comments);
            $data['reserveMeetings'] = $reserveMeetings;
            $data['reserveMeetingsCount'] = count($reserveMeetings);
            $data['monthlyChart'] = $this->getMonthlySalesOrPurchase($user);
        }
        $data['optionsWithLevels'] = $options;
        $data['leveltt'] = $loadedlevel;
        return view(getTemplate() . '.panel.dashboard', $data);
    }

    /**
     * Filter the manuels by matiere and level
     * @param $query
     * @param $request
     * @return Collection
     */

    private function filterManuelsByMatiereAndLevel($request)
    {
        $by_level = $request->get('by_level');
        $by_matiere_name = $request->get('by_matiere');
        $teacher_id = auth()->id();

        $query = Manuels::select('manuels.*', 'materials.name as material_name', 'sectionsmat.level_id as section_level')
            ->join('materials', 'materials.id', '=', 'manuels.material_id')
            ->join('sectionsmat', 'sectionsmat.id', '=', 'materials.section_id')
            ->join('user_matiere', 'user_matiere.matiere_id', '=', 'materials.id')
            ->where('user_matiere.teacher_id', $teacher_id);

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


    /**
     * Filter functions for Material and Level
     * @param $query
     * @param $request
     * @return Collection
     * @throws ContainerExceptionInterface
     */
    private function filtersByLevelAndMaterial($query, $request): Collection
    {
        $by_level = $request->get('by_level');
        $by_matiere_name = $request->get('by_matiere');

        if (!empty($by_level) && !empty($by_matiere_name)) {
            $query = $query->where('level_id', $by_level)
                ->join('materials', 'materials.id', '=', 'user_matiere.matiere_id')
                ->where('materials.name', $by_matiere_name);
        } elseif (!empty($by_level)) {
            $query = $query->where('level_id', $by_level);
        } elseif (!empty($by_matiere_name)) {
            $query = $query->join('materials', 'materials.id', '=', 'user_matiere.matiere_id')
                ->where('materials.name', $by_matiere_name);
        }

        return $query->pluck('level_id');
    }


    public function dashboardenfant(Request $request)
    {
        $user = auth()->user();
        
        if ($user->role_name === 'organization') {
            $children = User::where('organ_id', $user->id)->get();

            if ($children->isEmpty()) {
                return view(getTemplate() . '.panel.dashboardenfant', [
                    'showAddChildModal' => true,
                ]);
            } else {
                $firstChild = $children->first();
                return app('App\Http\Controllers\Panel\UserController')->impersonate($firstChild->id);
            }
        }
        $currentDay = date('l');
        $subscribes =Subscribe::where('id', '<>', 10)->get();
        $instructors = User::where('role_name', Role::$teacher)
            ->select('id', 'full_name', 'avatar', 'bio')
            ->where('status', 'active')
            ->where(function ($query) {
                $query->where('ban', false)
                    ->orWhere(function ($query) {
                        $query->whereNotNull('ban_end_at')
                            ->where('ban_end_at', '<', time());
                    });
            })->with([
                'meeting' => function ($query) use ($currentDay) {

                    $query->with(['meetingTimes' => function ($subQuery) use ($currentDay) {
                        $subQuery->where("day_label", strtolower($currentDay));
                    }]);
                    $query->withCount('meetingTimes');
                },
                'occupations'
            ])
            ->limit(8)
            ->get();
    
            $cardreserve= CardReservation::where('enfant_id', $user->id)->first();
            $guideProgress = is_string($user->guide_progress) ? json_decode($user->guide_progress, true) : $user->guide_progress;
            $sectionm = SectionMat::where('id', $user->section_id)->pluck('name');
            $levelm = School_level::where('id', $user->level_id)->pluck('name');
            $matieretearcher = Material::where('id', $user->matier_id)->pluck('name');
            $optiontearcher = Option::where('id', $user->option_id)->pluck('name');
            $enfants = Enfant::where("parent_id", "=", auth()->user()->id)->orderBy("id", "desc")->with('level')->get();
            $optiontearcher1 = option::where('name', 'Italien')->pluck('niveau');
            $videos = Video::where("id", ">", 37)->paginate(3);
            $matiereEnfant = Material::where('section_id', 19)->get();
            $userLevelName = School_level::where('id', $user->level_id)->pluck('name');
            $leveltt = [];
            $loadedlevel = [];
            if (!empty($user->option_id)) {
                foreach ($optiontearcher1 as $optionTeacher) {
    
                    $leveltt = School_level::where('id', $optionTeacher)->pluck('name');
                    if ($leveltt) {
                        $loadedlevel[] = [$leveltt];
                    }
                }
            }
    
            $option1 = [];
            $matiere1 = [];
            $options = [];
            $matiere = [];
    
            if (!empty($user->section_id)) {
                $matiere = Material::where('section_id', $user->section_id)->where('id','!=',7)->where('id','!=',11)->where('id','!=',14)->where('id','!=',15)->where('id','!=',18)->where('id','!=',19)->where('id','!=',20)->where('id','!=',21)->where('id','!=',9)->with('manuels')->get();
                //
            }

            $manuel = collect();
            foreach ($matiere as $mat) {
                $manuels = Manuels::where('material_id', $mat->id)->where('id','!=',14)->where('id','!=',24)->where('id','!=',34)->where('id','!=',27)->where('id','!=',9)->with(['matiere'])->get(); //
                
                $mat->manuels = $manuels;
                $manuel->push($mat);
            }
            if (!empty($user->matier_id)) {
                $levelName = [];
                $sectiondd = SectionMat::where('id', $user->section_id)->pluck('name');
                $matieregetname = Material::where('id', $user->matier_id)->pluck('name');
                $filteredMatiere1 = Material::where('name', $matieregetname[0])
                    ->with(['section' => function ($query) {
                        $query->with('level');
                    }])
                    ->whereNotNull('path')->where('path', '<>', '')->get();
    
                foreach ($filteredMatiere1 as $material) {
                    if ($material->section) {
                        $levelName = $material->section->name;
                        // do something with $levelName
                    }
                }
                $loadedPaths = [];
    
                $matiere1 = $filteredMatiere1->filter(function ($matiere) use (&$loadedPaths) {
    
                    if (!in_array($matiere->path, $loadedPaths)) {
                        $loadedPaths[] = $matiere->path;
    
                        return true;
                    }
                    return false;
                });
            }
    
            $nextBadge = $user->getBadges(true, true);
    
            $reserveMeetings = MeetingTime::where('level_id', $user->level_id)->with('meeting.teacher')
    
            ->where('meet_date', '>=', date('Y-m-d'))
            ->where(function($query) {
                $currentTime = date('h:i A');
                    $query->where(function($query) use ($currentTime) {
                    $query->where('meet_date', '=', date('Y-m-d'));
                        //   ->whereRaw("STR_TO_DATE(SUBSTRING_INDEX(time, '-', 1), '%h:%i%p') > STR_TO_DATE(?, '%h:%i%p')", [$currentTime]);
                })
                ->orWhere('meet_date', '>', date('Y-m-d'));
            })
            ->whereDoesntHave('reservations', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->get();
    
    
            $instructor = User::where('role_name', Role::$teacher)->get();
            $webinars = Webinar::where('status', 'active')->where('level_id', $user->level_id)
                ->orderBy('created_at', 'desc')
                ->limit(6)
                ->get();
            $data = [
                'pageTitle' => trans('panel.dashboard'),
                'nextBadge' => $nextBadge,
                'sectionm' => $sectionm,
                'levelm' => $levelm,
                'videos' => $videos,
                'matiere' => $matiere,
                'matiere1' => $matiere1,
                'option1' => $option1,
                'leveltt' => $leveltt,
                'options' => $options,
                'enfants' => $enfants,
                'matiereEnfant' => $matiereEnfant,
                'optiontearcher'  => $optiontearcher,
                'matieretearcher'  => $matieretearcher,
                'instructors'  => $instructors,
                'reserveMeetings' => $reserveMeetings,
                'userLevelName' => $userLevelName,
                'matiere1' => $manuel,
                'instructor' => $instructor,
                'subscribes' => $subscribes,
                'cardreserve' => $cardreserve,
                'webinars' => $webinars,
                'guide_progress' => $guideProgress['dashboard'] ?? [],
            ];
    
            if (!$user->isUser()) {
                $meetingIds = Meeting::where('teacher_id', $user->id)->pluck('id')->toArray();
                $pendingAppointments = ReserveMeeting::whereIn('meeting_id', $meetingIds)
                    ->whereHas('sale')
                    ->where('status', ReserveMeeting::$pending)
                    ->count();
    
                $userWebinarsIds = $user->webinars->pluck('id')->toArray();
                $supports = Support::whereIn('webinar_id', $userWebinarsIds)->where('status', 'open')->get();
    
                $comments = Comment::whereIn('webinar_id', $userWebinarsIds)
                    ->where('status', 'active')
                    ->whereNull('viewed_at')
                    ->get();
    
                $time = time();
                $firstDayMonth = strtotime(date('Y-m-01', $time)); // First day of the month.
                $lastDayMonth = strtotime(date('Y-m-t', $time)); // Last day of the month.
    
                $monthlySales = Sale::where('seller_id', $user->id)
                    ->whereNull('refund_at')
                    ->whereBetween('created_at', [$firstDayMonth, $lastDayMonth])
                    ->get();
    
                $data['pendingAppointments'] = $pendingAppointments;
                $data['supportsCount'] = count($supports);
                $data['commentsCount'] = count($comments);
    
                $data['monthlySalesCount'] = count($monthlySales) ? $monthlySales->sum('total_amount') : 0;
                $data['monthlyChart'] = $this->getMonthlySalesOrPurchase($user);
            } else {
                $webinarsIds = $user->getPurchasedCoursesIds();
    
                $webinars = Webinar::whereIn('id', $webinarsIds)
                    ->where('status', 'active')
                    ->get();
    
                $reserveMeetings = ReserveMeeting::where('user_id', $user->id)
                    ->whereHas('sale')
                    ->where('status', ReserveMeeting::$open)
                    ->get();
    
                $supports = Support::where('user_id', $user->id)
                    ->whereNotNull('webinar_id')
                    ->where('status', 'open')
                    ->get();
    
                $comments = Comment::where('user_id', $user->id)
                    ->whereNotNull('webinar_id')
                    ->where('status', 'active')
                    ->get();
    
                $data['webinarsCount'] = count($webinars);
                $data['supportsCount'] = count($supports);
                $data['commentsCount'] = count($comments);
                $data['reserveMeetings'] = $reserveMeetings;
                $data['reserveMeetingsCount'] = count($reserveMeetings);
                $data['monthlyChart'] = $this->getMonthlySalesOrPurchase($user);
            }
            $hasSubscribePack = \App\Models\OrderItem::query()
            ->where('user_id', auth()->id())
            ->where('model_type', 'App\Models\Subscribe')
            ->whereHas('order', function ($query) {
                $query->where('status', 'paid');
            })
            ->exists();
            $subscribedPack = \App\Models\OrderItem::query()
            ->where('user_id', auth()->id())
            ->where('model_type', 'App\Models\Subscribe')
            ->whereHas('order', function ($query) {
                $query->where('status', 'paid');
            })
            ->first();
            $pack = null;
            if ($hasSubscribePack) {
                $pack = \App\Models\Subscribe::query()
                ->where('id', $subscribedPack->model_id)
                ->first();
            }
            $data['optionsWithLevels'] = $options;
            $data['leveltt'] = $loadedlevel;
            $users = auth()->user();
            $parentid=User::where('id',$users->id)->first();
            $levels = School_level::all();
            
            return view(getTemplate() . '.panel.dashboardenfant', [
            'authUser'=>$user,
            'users' => $users,
            'levels' => $levels,
            'parentid' => $parentid,    
            'pack' => $pack,
            'hasSubscribePack' => $hasSubscribePack,
            'subscribedPack' => $subscribedPack,
        ], $data);

        
        return view(getTemplate() . '.panel.dashboardenfant', $data);
    }

    public function fetchGuideProgress(Request $request)
    {
        $user = auth()->user();
        $parentId = $user->role_name === 'enfant' ? $user->organ_id : $user->id;
        $guideProgress = User::find($parentId)->guide_progress;
        $guideProgress = $guideProgress ? json_decode($guideProgress, true) : [];
        return response()->json($guideProgress);
    }
    

public function updateGuideProgress(Request $request)
{
    $user = auth()->user();
    
    $parent = $user->role_name === 'enfant' ? User::find($user->organ_id) : $user;
    
    if (!$parent) {
        return response()->json(['status' => 'error', 'message' => 'Parent not found'], 404);
    }
    
    $section = $request->input('page');
    $step = $request->input('step');
    
    $guideProgress = $parent->guide_progress ? json_decode($parent->guide_progress, true) : [];
    
    if (!isset($guideProgress[$section])) {
        $guideProgress[$section] = [];
    }

    if (!in_array($step, $guideProgress[$section])) {
        $guideProgress[$section][] = $step;
    }

    $parent->guide_progress = json_encode($guideProgress);
    $parent->save();

    return response()->json(['status' => 'success']);
}




    public function packs(Request $request): View {
        $user = auth()->user();

        $subscribes =Subscribe::where('id', '<>', 10)->get();
        $userenfant=User::where('organ_id',$user->id)->get();
        $data = [
            'subscribes' => $subscribes,
            'userenfant' => $userenfant,

        ];  
        return view(getTemplate() . '.panel.packs.packs', $data);
    }


    public function filters3($query, $request)
    {
        $by_level = $request->get('by_level');
        $by_matiere = $request->get('by_matiere');
        if ($request->has('by_level')) {
            $byLevel = $request->get('by_level');
            $query->where('level_column_name', $byLevel); // Adjust 'level_column_name' to your actual column name
        }

        // Check if 'by_matiere' parameter is provided
        if ($request->has('by_matiere')) {
            $byMatiere = $request->get('by_matiere');
            $query->where('matiere_column_name', $byMatiere); // Adjust 'matiere_column_name' to your actual column name
        }

        // Execute the query and get the results
        $results = $query->get();

        // Return the results, maybe pass them to a view
        // return view('your_view_name', compact('results'));
        return response()->json($results);
        if (!empty($by_level)) {
            // Apply condition directly to the query builder for 'by_level'
            $query->where('level_id', $by_level); // Replace 'level_id' with the actual column name for level
        }

        if (!empty($by_matiere)) {
            // Apply condition directly to the query builder for 'by_matiere'
            $query->where('matiere_id', $by_matiere); // Already correct, assuming 'matiere_id' is the column name
        }

        // Now you can get the results
        // Note: Don't call get() if you plan to do further manipulation with the builder instance
        return $query;
    }

    public function allinstructor()
    {
        $user = auth()->user();
        $sectionm = SectionMat::where('id', $user->section_id)->pluck('name');
        $levelm = School_level::where('id', $user->level_id)->pluck('name');
        $matiere = Material::where('section_id', $user->section_id)->get();
        $optiontearcher = option::where('id', $user->option_id)->pluck('name');


        $data = [
            'sectionm' => $sectionm,
            'levelm' => $levelm,
            'matiere' => $matiere,

            'optiontearcher' => $optiontearcher

        ];

        return view(getTemplate() . '.panel.all_instructor', $data);
    }
    public function getManuelBySMatiereId($id)
    {
        $user = auth()->user();
        $sectionm = SectionMat::where('id', $user->section_id)->pluck('name');
        $levelm = School_level::where('id', $user->level_id)->pluck('name');
        $matiere = Material::where('section_id', $user->section_id)->get();
        $optiontearcher = option::where('id', $user->option_id)->pluck('name');


        $data = [
            'sectionm' => $sectionm,

            'levelm' => $levelm,
            'matiere' => $matiere,
            'optiontearcher' => $optiontearcher
        ];

        return view(getTemplate() . '.panel.dashboard', $data);
    }
    private function getMonthlySalesOrPurchase($user)
    {
        $months = [];
        $data = [];

        // all 12 months
        for ($month = 1; $month <= 12; $month++) {
            $date = Carbon::create(date('Y'), $month);

            $start_date = $date->timestamp;
            $end_date = $date->copy()->endOfMonth()->timestamp;

            $months[] = trans('panel.month_' . $month);

            if (!$user->isUser()) {
                $monthlySales = Sale::where('seller_id', $user->id)
                    ->whereNull('refund_at')
                    ->whereBetween('created_at', [$start_date, $end_date])
                    ->sum('total_amount');

                $data[] = round($monthlySales, 2);
            } else {
                $monthlyPurchase = Sale::where('buyer_id', $user->id)
                    ->whereNull('refund_at')
                    ->whereBetween('created_at', [$start_date, $end_date])
                    ->count();

                $data[] = $monthlyPurchase;
            }
        }

        return [
            'months' => $months,
            'data' => $data
        ];
    }
    public function addEnfant(Request $request)
    {
        $authUser= auth()->user();
        if($authUser->isEnfant())
            $parentId = $authUser->organ_id;
        else 
            $parentId = $authUser->id;
        $childCount = Enfant::where('parent_id', $parentId)->count();

        if ($childCount >= 4) {
            return redirect()->back()->withErrors(
                ['max_children' => 'panel.max_children_error']
            )->withInput();
        }
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'sexe' => 'required|in:Garçon,Fille',
            'level_id' => 'required|exists:school_levels,id'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data = $validator->validated();
        $garconImages = ['/boy1.jpeg','/boy2.jpeg', '/f14.png', '/f16.png'];
        $filleImages = ['/girl1.jpeg','/girl2.jpeg', '/girl3.jpeg', '/girl4.jpeg'];
    
        $genderKey = $data['sexe'] . '_used_images';
        $usedImages = $request->session()->get($genderKey, []);
        $imagePool = $data['sexe'] === 'Garçon' ? $garconImages : $filleImages;        
        $availableImages = array_diff($imagePool, $usedImages);
        if (empty($availableImages)) {
            $availableImages = $imagePool;
            $usedImages = [];
        }
    
        $path = $availableImages[array_rand($availableImages)];
        $usedImages[] = $path;
        $request->session()->put($genderKey, $usedImages);

        

        $newUser = User::create([
            'full_name' => $data['nom'],
            'role_name' => 'enfant',
            'role_id' => 8,
            'level_id' => $data['level_id'],
            'section_id' => SectionMat::where('level_id', $data['level_id'])->value('id'),
            'status' => 'active',
            'organ_id' => $parentId,
            'avatar' => $path,
            'verified'=> 1,
            'language'=> 'AR',
            'financial_approval' => 0,
            'created_at' => time(),
        ]);
    
        if ($newUser) 
        {
            Enfant::create([
            'nom' => $data['nom'],
            'sexe' => $data['sexe'],
            'level_id' => $data['level_id'],
            'parent_id' => $parentId,
            'user_id' => $newUser->id,
            'path' => $path,
            'created_at' => now(),
            ]);

        }

        if ($childCount < 3) {
            $toastData = [
                'title' => trans('public.request_success'),
                'msg' => 'تم إضافة الطفل بنجاح',
                'status' => 'success'
                ];
        } else {
            $toastData = [
                'title' => trans('public.request_success'),
                'msg' => 'تم إضافة الطفل بنجاح. لقد وصلت إلى الحد الأقصى لعدد الأطفال المسموح به.',
                'status' => 'success'
            ];
        }
       
        return app('App\Http\Controllers\Panel\UserController')->impersonate($newUser->id)
            ->with(['toast' => $toastData]);

    }
    public function addEnfantFromSettings(Request $request)
    {
            $authUser= auth()->user();
            if($authUser->isEnfant())
                $parentId = $authUser->organ_id;
            else 
                $parentId = $authUser->id;
            $childCount = Enfant::where('parent_id', $parentId)->count();
    
            if ($childCount >= 4) {
                return redirect()->back()->withErrors(
                    ['max_children' => 'panel.max_children_error']
                )->withInput();
            }
            $validator = Validator::make($request->all(), [
                'nom' => 'required|string|max:255',
                'sexe' => 'required|in:Garçon,Fille',
                'level_id' => 'required|exists:school_levels,id'
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $data = $validator->validated();
            $garconImages = ['/boy1.jpeg','/boy2.jpeg', '/f14.png', '/f16.png'];
            $filleImages = ['/girl1.jpeg','/girl2.jpeg', '/girl3.jpeg', '/girl4.jpeg'];
        
            $genderKey = $data['sexe'] . '_used_images';
            $usedImages = $request->session()->get($genderKey, []);
            $imagePool = $data['sexe'] === 'Garçon' ? $garconImages : $filleImages;        
            $availableImages = array_diff($imagePool, $usedImages);
            if (empty($availableImages)) {
                $availableImages = $imagePool;
                $usedImages = [];
            }
        
            $path = $availableImages[array_rand($availableImages)];
            
            $usedImages[] = $path;
            $request->session()->put($genderKey, $usedImages);
            
    
            $newUser = User::create([
                'full_name' => $data['nom'],
                'role_name' => 'enfant',
                'role_id' => 8,
                'level_id' => $data['level_id'],
                'section_id' => SectionMat::where('level_id', $data['level_id'])->value('id'),
                'status' => 'active',
                'organ_id' => $parentId,
                'avatar' => $path,
                'verified'=> 1,
                'language'=> 'AR',
                'financial_approval' => 0,
                'created_at' => time(),
            ]);
        
            if ($newUser) 
            {
                Enfant::create([
                'nom' => $data['nom'],
                'sexe' => $data['sexe'],
                'level_id' => $data['level_id'],
                'parent_id' => $parentId,
                'user_id' => $newUser->id,
                'path' => $path,
                'created_at' => now(),
                ]);
    
            }
            if ($childCount < 3) {
                $toastData = [
                    'title' => trans('public.request_success'),
                    'msg' => 'تم إضافة الطفل بنجاح',
                    'status' => 'success'
                    ];
            } else {
                $toastData = [
                    'title' => trans('public.request_success'),
                    'msg' => 'تم إضافة الطفل بنجاح. لقد وصلت إلى الحد الأقصى لعدد الأطفال المسموح به.',
                    'status' => 'success'
                ];
            }
           
           return redirect('/panel/setting')->with(['toast' => $toastData]);

    }

    public function allMeetingsChild(Request $request): View
    {
        $user = auth()->user();
        $currentDay = date('l');
    
        $instructors = User::where('role_name', Role::$teacher)
            ->select('id', 'full_name', 'avatar', 'bio')
            ->where('status', 'active')
            ->where(function ($query) {
                $query->where('ban', false)
                    ->orWhere(function ($query) {
                        $query->whereNotNull('ban_end_at')
                              ->where('ban_end_at', '<', time());
                    });
            })->with([
                'meeting' => function ($query) use ($currentDay) {
                    $query->with(['meetingTimes' => function ($subQuery) use ($currentDay) {
                        $subQuery->where("day_label", strtolower($currentDay));
                    }]);
                    $query->withCount('meetingTimes');
                },
                'occupations'
            ])
            ->limit(8)
            ->get();
    
        $reserveMeetings = MeetingTime::where('level_id', $user->level_id)
            ->with('meeting.teacher')
            ->where('meet_date', '>=', date('Y-m-d'))
            ->where(function($query) {
                $currentTime = date('h:i A');
                $query->where(function($query) use ($currentTime) {
                    $query->where('meet_date', '=', date('Y-m-d'));
                        //   ->whereRaw("STR_TO_DATE(SUBSTRING_INDEX(time, '-', 1), '%h:%i%p') > STR_TO_DATE(?, '%h:%i%p')", [$currentTime]);
                })
                ->orWhere('meet_date', '>', date('Y-m-d'));
            })
            ->whereDoesntHave('reservations', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->get();
            $materials = Material::where('section_id', $user->section_id)->get();
            $uniqueMaterials = $materials->unique('name');
            
            $data = [
                'instruction' => $instructors,
                'reserveMeetings' => $reserveMeetings,
                'materials' => $uniqueMaterials
            ];
            return view(getTemplate() . '.panel.meeting.all_meetings', $data);
    }
    public function getFollowings()
    {
        $userId = auth()->id();

        $sortedFollowers = DB::table('teachers')
            ->where('users_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($follower) {
                $followerUser = User::find($follower->teacher_id);
                $follower->followerUser = [
                    'full_name' => $followerUser->full_name,
                    'avatar' => $followerUser->getAvatar(100),
                    'id' => $followerUser->id,
                    'followerCount' => DB::table('teachers')->where('teacher_id', $followerUser->id)->count(),
                ];
                return $follower;
            });

        return response()->json($sortedFollowers);
    }   
    
    public function getMaterialsByLevel($levelId)
    {
        $materials = Material::whereHas('section', function ($query) use ($levelId) {
            $query->where('level_id', $levelId);
        })->with(['submaterials' => function ($query) {
            $query->select('id', 'name', 'material_id');
        }])->get(['id', 'name']);
    
        return response()->json($materials);
    }
    

    
    public function getLevelsByMaterial($materialName)
    {
        $levels = School_level::whereHas('sectionsmat.materials', function($query) use ($materialName) {
            $query->where('name', $materialName);
        })->get();
    
        return response()->json($levels);
    }
    
}

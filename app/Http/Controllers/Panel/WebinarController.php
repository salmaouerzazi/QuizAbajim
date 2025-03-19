<?php

namespace App\Http\Controllers\Panel;

use App\Exports\WebinarStudents;
use App\Http\Controllers\Controller;
use App\Mixins\RegistrationPackage\UserPackage;
use App\Models\BundleWebinar;
use App\Models\Category;
use App\Models\Faq;
use App\Models\File;
use App\Models\Prerequisite;
use App\Models\Quiz;
use App\Models\Role;
use App\Models\Sale;
use App\Models\Session;
use App\Models\Tag;
use App\Models\TextLesson;
use App\Models\Favorite;
use App\Models\AdvertisingBanner;
use App\Models\Ticket;
use App\Models\Translation\WebinarTranslation;
use App\Models\WebinarChapter;
use App\Models\WebinarChapterItem;
use App\Models\WebinarExtraDescription;
use App\User;
use App\Models\Webinar;
use App\Models\WebinarPartnerTeacher;
use App\Models\WebinarFilterOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Validator;
use App\Models\SectionMat;
use App\Models\School_level;
use App\Models\Material;
use App\Models\Manuels;
use App\Models\Option;
use App\Models\QuizzesResult;
class WebinarController extends Controller
{
    public $tableName = 'webinars';
    public $columnId = 'webinar_id';

    public function course($slug, $justReturnData = true)
    {
       
        $user = auth()->user();
        $sectionm = SectionMat::where('id', $user->section_id)->pluck('name');
        $levelm = School_level::where('id', $user->level_id)->pluck('name');
        $matieretearcher = Material::where('id', $user->matier_id)->pluck('name');
        $optiontearcher = Option::where('id', $user->option_id)->pluck('name');          

        $matiere =[];
        if( !empty($user->section_id)){
        $matiere =Material::where('section_id', $user->section_id)->get();
        }
        if (auth()->check()) {
            $user = auth()->user();
        } else if (getFeaturesSettings('webinar_private_content_status')) {
            $data = [
                'pageTitle' => trans('update.private_content'),
                'pageRobot' => getPageRobotNoIndex(),
            ];

            return view('web.default.course.private_content', $data);
        }

        if (!empty($user) and !$user->access_content) {
            $data = [
                'pageTitle' => trans('update.not_access_to_content'),
                'pageRobot' => getPageRobotNoIndex(),
                'userNotAccess' => true
            ];

            return view('web.default.course.private_content', $data);
        }

        $course = Webinar::where('slug', $slug)
        ->when(
            !$user->isTeacher(),
            function ($query) {
                $query->where('status', 'active');
            }
        )
        ->with([
            'chapters' => function ($query) use ($user) {
                if (!$user->isTeacher()) {
                    $query->where('status', WebinarChapter::$chapterActive);
                }
                $query->orderBy('order', 'asc');
                $query->with([
                    'chapterItems' => function ($query) {
                        $query->orderBy('order', 'asc');
                    }
                ]);
            },
            'files' => function ($query) use ($user) {
                if (!$user->isTeacher()) {
                    $query->where('files.status', WebinarChapter::$chapterActive);
                }
                $query->join('webinar_chapters', 'webinar_chapters.id', '=', 'files.chapter_id')
                    ->select('files.*', DB::raw('webinar_chapters.order as chapterOrder'))
                    ->orderBy('chapterOrder', 'asc')
                    ->orderBy('files.order', 'asc')
                    ->with([
                        'learningStatus' => function ($query) use ($user) {
                            $query->where('user_id', $user->id ?? null);
                        }
                    ]);
            },
            'filterOptions',
            'teacher',
        ])
        ->first();
    
        if (empty($course)) {
            return $justReturnData ? false : back()->with('error', 'Course not found.');
        }
        $webinarContentCount = 0;
        if (!empty($course->files)) {
            $webinarContentCount += $course->files->count();
        }
        $filesWithoutChapter = $course->files->whereNull('chapter_id');
        if ($user) {   
            if (!empty($course->chapters) and count($course->chapters)) {
                foreach ($course->chapters as $chapter) {
                    if (!empty($chapter->chapterItems) and count($chapter->chapterItems)) {
                        foreach ($chapter->chapterItems as $chapterItem) {
                            if (!empty($chapterItem->quiz)) {
                                $chapterItem->quiz = $this->checkQuizResults($user, $chapterItem->quiz);
                            }
                        }
                    }
                }
            }

            if (!empty($course->quizzes) and count($course->quizzes)) {
                $course->quizzes = $this->checkQuizzesResults($user, $course->quizzes);
            }
        }

        $pageRobot = getPageRobot('course_show');

        $data = [
            'pageTitle' => $course->title,
            'pageDescription' => $course->seo_description,
            'pageRobot' => $pageRobot,
            'course' => $course,
            'user' => $user,
            'filesWithoutChapter' => $filesWithoutChapter,
            'sectionm' => $sectionm,
            'levelm' => $levelm,
            'matiere' => $matiere,

        ];

        if ($justReturnData) {
            return $data;
        }

        return view('web.default.panel.webinar.includes_courses.index', $data);
    }
    private function checkQuizzesResults($user, $quizzes)
    {
        $canDownloadCertificate = false;

        foreach ($quizzes as $quiz) {
            $quiz = $this->checkQuizResults($user, $quiz);
        }

        return $quizzes;
    }
    private function checkQuizResults($user, $quiz)
    {
        $canDownloadCertificate = false;

        $canTryAgainQuiz = false;
        $userQuizDone = QuizzesResult::where('quiz_id', $quiz->id)
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        if (count($userQuizDone)) {
            $quiz->user_grade = $userQuizDone->first()->user_grade;
            $quiz->result_count = $userQuizDone->count();
            $quiz->result = $userQuizDone->first();

            $status_pass = false;
            foreach ($userQuizDone as $result) {
                if ($result->status == QuizzesResult::$passed) {
                    $status_pass = true;
                }
            }

            $quiz->result_status = $status_pass ? QuizzesResult::$passed : $userQuizDone->first()->status;

            if ($quiz->certificate and $quiz->result_status == QuizzesResult::$passed) {
                $canDownloadCertificate = true;
            }
        }

        if (!isset($quiz->attempt) or (count($userQuizDone) < $quiz->attempt and $quiz->result_status !== QuizzesResult::$passed)) {
            $canTryAgainQuiz = true;
        }

        $quiz->can_try = $canTryAgainQuiz;
        $quiz->can_download_certificate = $canDownloadCertificate;

        return $quiz;
    }
    public function index(Request $request)
    {
        $user = auth()->user();

        if ($user->isUser()) {
            abort(404);
        }

        $query = Webinar::where(function ($query) use ($user) {
            if ($user->isTeacher()) {
                $query->where('teacher_id', $user->id);
            } elseif ($user->isOrganization()) {
                $query->where('creator_id', $user->id);
            }
        });

        $level = School_level::all();
        $material = Material::get()->unique('name');

        if ($request->filled('level_id') && $request->level_id !== 'all') {
            $query->where('level_id', $request->level_id);
        }

        if ($request->filled('material_name') && $request->material_name !== 'all') {
            $materialIds = Material::where('name', $request->material_name)->pluck('id');
            $query->whereIn('matiere_id', $materialIds);
        }
        
        

        if ($request->has('webinar_status') && $request->webinar_status !== 'all') {
            $query->where('status', $request->webinar_status);
        }
        

        $data = $this->makeMyClassAndInvitationsData($query, $user, $request);
        $data['pageTitle'] = trans('webinars.webinars_list_page_title');


        return view(getTemplate() . '.panel.webinar.index', $data, 
        [
            "level" => $level,
            "material" => $material
        ]
    );
    }


    public function invitations(Request $request)
    {
        $user = auth()->user();

        $invitedWebinarIds = WebinarPartnerTeacher::where('teacher_id', $user->id)->pluck('webinar_id')->toArray();

        $query = Webinar::where('status', 'active');

        if ($user->isUser()) {
            abort(404);
        }

        $query->whereIn('id', $invitedWebinarIds);

        $data = $this->makeMyClassAndInvitationsData($query, $user, $request);
        $data['pageTitle'] = trans('panel.invited_classes');
        

        return view(getTemplate() . '.panel.webinar.index', $data);
    }

    public function organizationClasses(Request $request)
    {
        $user = auth()->user();

        if (!empty($user->organ_id)) {
            $query = Webinar::where('creator_id', $user->organ_id)
                ->where('status', 'active');

            $query = $this->organizationClassesFilters($query, $request);

            $webinars = $query
                ->orderBy('created_at', 'desc')
                ->orderBy('updated_at', 'desc')
                ->paginate(10);

            $data = [
                'pageTitle' => trans('panel.organization_classes'),
                'webinars' => $webinars,
            ];

            return view(getTemplate() . '.panel.webinar.organization_classes', $data);
        }

        abort(404);
    }

    private function organizationClassesFilters($query, $request)
    {
        $from = $request->get('from', null);
        $to = $request->get('to', null);
        $type = $request->get('type', null);
        $sort = $request->get('sort', null);
        $free = $request->get('free', null);

        $query = fromAndToDateFilter($from, $to, $query, 'start_date');

        if (!empty($type) and $type != 'all') {
            $query->where('type', $type);
        }

        if (!empty($sort) and $sort != 'all') {
            if ($sort == 'expensive') {
                $query->orderBy('price', 'desc');
            }

            if ($sort == 'inexpensive') {
                $query->orderBy('price', 'asc');
            }

            if ($sort == 'bestsellers') {
                $query->whereHas('sales')
                    ->with('sales')
                    ->get()
                    ->sortBy(function ($qu) {
                        return $qu->sales->count();
                    });
            }

            if ($sort == 'best_rates') {
                $query->with([
                    'reviews' => function ($query) {
                        $query->where('status', 'active');
                    }
                ])->get()
                    ->sortBy(function ($qu) {
                        return $qu->reviews->avg('rates');
                    });
            }
        }

        if (!empty($free) and $free == 'on') {
            $query->where(function ($qu) {
                $qu->whereNull('price')
                    ->orWhere('price', '<', '0');
            });
        }

        return $query;
    }

    private function makeMyClassAndInvitationsData($query, $user, $request)
    {
        $webinarHours = deepClone($query)->sum('duration');

        $onlyNotConducted = $request->get('not_conducted');
        if (!empty($onlyNotConducted)) {
            $query->where('status', 'active')
                ->where('start_date', '>', time());
        }

        $query->with([
            'reviews' => function ($query) {
                $query->where('status', 'active');
            },
            'category',
            'teacher',
            'sales' => function ($query) {
                $query->where('type', 'webinar')
                    ->whereNull('refund_at');
            }
        ])->orderBy('updated_at', 'desc');

        $webinarsCount = $query->count();

        $webinars = $query->orderBy('created_at', 'desc')->paginate(9);

        $webinarSales = Sale::where('seller_id', $user->id)
            ->where('type', 'webinar')
            ->whereNotNull('webinar_id')
            ->whereNull('refund_at')
            ->with('webinar')
            ->get();

        $webinarSalesAmount = 0;
        $courseSalesAmount = 0;
        foreach ($webinarSales as $webinarSale) {
            if (!empty($webinarSale->webinar) and $webinarSale->webinar->type == 'webinar') {
                $webinarSalesAmount += $webinarSale->amount;
            } else {
                $courseSalesAmount += $webinarSale->amount;
            }
        }

        return [
            'webinars' => $webinars,
            'webinarsCount' => $webinarsCount,
            'webinarSalesAmount' => $webinarSalesAmount,
            'courseSalesAmount' => $courseSalesAmount,
            'webinarHours' => $webinarHours,
        ];
    }

    function array_replace_key($search, $replace, array $subject)
    {
        $updatedArray = [];

        foreach ($subject as $key => $value) {
            if (!is_array($value) && $key == $search) {
                $updatedArray = array_merge($updatedArray, [$replace => $value]);

                continue;
            }

            $updatedArray = array_merge($updatedArray, [$key => $value]);
        }

        return $updatedArray;
    }

    public function create(Request $request)
    {
        $user = auth()->user();

        if (!$user->isTeacher() and !$user->isOrganization()) {
            abort(404);
        }

        $userPackage = new UserPackage();
        $userCoursesCountLimited = $userPackage->checkPackageLimit('courses_count');

        if ($userCoursesCountLimited) {
            session()->put('registration_package_limited', $userCoursesCountLimited);
            return redirect()->back();
        }

        $categories = Category::where('parent_id', null)
            ->with('subCategories')
            ->get();

        $teachers = null;
        $isOrganization = $user->isOrganization();

        $webinar = new Webinar();

        if ($isOrganization) {
            $teachers = User::where('role_name', Role::$teacher)
                ->where('organ_id', $user->id)->get();
        }
        $levels = School_level::all();
        $materials = Material::get()->unique('name');
        $submaterials = $materials->first()->submaterials;

        $data = [
            'pageTitle' => trans('webinars.new_page_title'),
            'teachers' => $teachers,
            'categories' => $categories,
            'isOrganization' => $isOrganization,
            'currentStep' => 1,
            'userLanguages' => getUserLanguagesLists(),
            'levels' => $levels,
            'materials' => $materials,
            'submaterials' => $submaterials,
        ];

        return view(getTemplate() . '.panel.webinar.create', $data);
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if (!$user->isTeacher() and !$user->isOrganization()) {
            abort(404);
        }

        $userPackage = new UserPackage();
        $userCoursesCountLimited = $userPackage->checkPackageLimit('courses_count');

        if ($userCoursesCountLimited) {
            session()->put('registration_package_limited', $userCoursesCountLimited);

            return redirect()->back();
        }

        $currentStep = $request->get('current_step', 1);

        $rules = [
            'title' => 'required|max:255',
            'image_cover' => 'required',
            'level_id' => 'required',
            'material_id' => 'required',
            'submaterial_id' => in_array($request->material_id, [1, 4, 5, 12, 17, 22]) ? 'required' : 'sometimes',
        ];

        $this->validate($request, $rules);
        $data = $request->all();


        if ($request->hasFile('image_cover')) {
            $imagePath = $request->file('image_cover')->store('store', 'public');
            $data['image_cover'] = $imagePath;
        } else {
            $data['image_cover'] = null;
        }
        if (isset($data['submaterial_id']) && !empty($data['submaterial_id'])) {
            $data['submaterial_id'] = $data['submaterial_id'];
        }

        $webinar = Webinar::create([
            'teacher_id' => $user->isTeacher() ? $user->id : (!empty($data['teacher_id']) ? $data['teacher_id'] : $user->id),
            'creator_id' => $user->id,
            "thumbnail" => "",
            'slug' => Webinar::makeSlug($data['title']),
            'private' => (!empty($data['private']) and $data['private'] == 'on') ? true : false,
            'image_cover' => $data['image_cover'],
            'status' => (!empty($data['draft']) and $data['draft'] == 1)  ? Webinar::$isDraft : Webinar::$pending,
            'created_at' => time(),
            'type' => 'course',
            'level_id' => $data['level_id'],
            'matiere_id' => $data['material_id'],
            'submaterial_id' => $data['submaterial_id'] ?? null,
        ]);
        
        if ($webinar) {
            WebinarTranslation::updateOrCreate([
                'webinar_id' => $webinar->id,
                'locale' => mb_strtolower($data['locale']),
            ], [
                'title' => $data['title'],

            ]);
        }

        $url = '/panel/webinars/' . $webinar->id . '/step/1';

        return redirect($url);
    }

    public function edit(Request $request, $id, $step = 1)
    {
        $materialColors = config('constants.MATERIAL_COLORS');
        $user = auth()->user();
        $isOrganization = $user->isOrganization();

        if (!$user->isTeacher() && !$user->isOrganization()) {
            abort(404);
        }

        $locale = $request->get('locale', app()->getLocale());

        $levels = School_level::all();
        $materials = Material::with('submaterials')->get();
        
        $webinar = Webinar::where('id', $id)
            ->where(function ($query) use ($user) {
                $query->where('creator_id', $user->id)
                    ->orWhere('teacher_id', $user->id);

                $query->orWhereHas('webinarPartnerTeacher', function ($query) use ($user) {
                    $query->where('teacher_id', $user->id);
                });
            })
            ->with(['chapters.chapterItems'])
            ->first();

        if (empty($webinar)) {
            abort(404);
        }

        $selectedMaterial = Material::with('submaterials')->find($webinar->material_id);
        $submaterials = $selectedMaterial ? $selectedMaterial->submaterials : [];

        $data = [
            'pageTitle' => trans('public.edit') . ' ' . $webinar->title,
            'currentStep' => $step,
            'isOrganization' => $isOrganization,
            'userLanguages' => getUserLanguagesLists(),
            'locale' => mb_strtolower($locale),
            'defaultLocale' => getDefaultLocale(),
            'levels' => $levels,
            'materials' => $materials,
            'submaterials' => $submaterials,
            'webinar' => $webinar,
            'definedLanguage' => $webinar->translations ? $webinar->translations->pluck('locale')->toArray() : [],
            'materialColors' => $materialColors,
        ];

        return view(getTemplate() . '.panel.webinar.create', $data);
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();
        

        if (!$user->isTeacher()) {
            abort(404);
        }

        $webinar = Webinar::where('id', $id)
            ->where(function ($query) use ($user) {
                $query->where('creator_id', $user->id)
                    ->orWhere('teacher_id', $user->id);
            })->first();

        if (empty($webinar)) {
            abort(404);
        }

        $rules = [
            'title' => 'required|max:255',
            'image_cover' => 'sometimes|file|image',
            'material_id' => 'required',
            'level_id' => 'required',
            'submaterial_id' => in_array($request->material_id, [1, 4, 5, 12, 17, 22]) ? 'required' : 'sometimes',
        ];
        
        $this->validate($request, $rules); 
        $data = $request->all();
        
            
        if ($request->hasFile('image_cover')) {
            $imagePath = $request->file('image_cover')->store('store', 'public');
            $data['image_cover'] = $imagePath;
        } else {
            $data['image_cover'] = $webinar->image_cover;
        }

        $data['updated_at'] = time();
        $isDraft = (!empty($data['draft']) and $data['draft'] == 1);
        $data['status'] = $isDraft ? Webinar::$isDraft : Webinar::$pending;

        if (isset($data['submaterial_id']) && !empty($data['submaterial_id'])) {
            $data['submaterial_id'] = $data['submaterial_id'];
        }


        $webinar->update([
            'title' => $data['title'],
            'image_cover' => $data['image_cover'],
            'updated_at' => $data['updated_at'],
            'level_id' => $data['level_id'],
            'matiere_id' => $data['material_id'],
            'status' => $data['status'],
            'submaterial_id' => $data['submaterial_id'] ?? null,
        ]);

        // Update translation data
        WebinarTranslation::updateOrCreate([
            'webinar_id' => $webinar->id,
            'locale' => "ar",
        ], [
            'title' => $data['title'],
        ]);

        // Send notification if it's not a draft
        if (empty($data['draft'])) {
            sendNotification(
                'notification.course_created',
                'notification.course_created_msg',
                $user->id,
                null,
                'system',
                'single',
                ['title' => $webinar->title] 
            );
            
            }

        if (!$isDraft) {
            return redirect('/panel/webinars')->with('show_modal', true);
        }

        return redirect('/panel/webinars');
    }

    public function destroy(Request $request, $id)
    {
        $user = auth()->user();

        if (!$user->isTeacher() and !$user->isOrganization()) {
            abort(404);
        }

        $webinar = Webinar::where('id', $id)
            ->where('creator_id', $user->id)
            ->first();

        if (!$webinar) {
            abort(404);
        }

        $webinar->delete();

        return response()->json([
            'code' => 200,
            'redirect_to' => $request->get('redirect_to')
        ], 200);
    }

    public function duplicate($id)
    {
        $user = auth()->user();
        if (!$user->isTeacher() and !$user->isOrganization()) {
            abort(404);
        }

        $webinar = Webinar::where('id', $id)
            ->where(function ($query) use ($user) {
                $query->where(function ($query) use ($user) {
                    $query->where('creator_id', $user->id)
                        ->orWhere('teacher_id', $user->id);
                });

                $query->orWhereHas('webinarPartnerTeacher', function ($query) use ($user) {
                    $query->where('teacher_id', $user->id);
                });
            })
            ->first();

        if (!empty($webinar)) {
            $new = $webinar->toArray();

            $title = $webinar->title . ' ' . trans('public.copy');
            $description = $webinar->description;
            $seo_description = $webinar->seo_description;


            $new['created_at'] = time();
            $new['updated_at'] = time();
            $new['status'] = Webinar::$pending;

            $new['slug'] = Webinar::makeSlug($title);

            foreach ($webinar->translatedAttributes as $attribute) {
                unset($new[$attribute]);
            }

            unset($new['translations']);

            $newWebinar = Webinar::create($new);

            WebinarTranslation::updateOrCreate([
                'webinar_id' => $newWebinar->id,
                'locale' => mb_strtolower($webinar->locale),
            ], [
                'title' => $title,
                'description' => $description,
                'seo_description' => $seo_description,
            ]);


            return redirect('/panel/webinars/' . $newWebinar->id . '/edit');
        }

        abort(404);
    }

    public function exportStudentsList($id)
    {
        $user = auth()->user();

        if (!$user->isTeacher() and !$user->isOrganization()) {
            abort(404);
        }

        $webinar = Webinar::where('id', $id)
            ->where(function ($query) use ($user) {
                $query->where(function ($query) use ($user) {
                    $query->where('creator_id', $user->id)
                        ->orWhere('teacher_id', $user->id);
                });

                $query->orWhereHas('webinarPartnerTeacher', function ($query) use ($user) {
                    $query->where('teacher_id', $user->id);
                });
            })
            ->first();

        if (!empty($webinar)) {
            $sales = Sale::where('type', 'webinar')
                ->where('webinar_id', $webinar->id)
                ->whereNull('refund_at')
                ->with([
                    'buyer' => function ($query) {
                        $query->select('id', 'full_name', 'email', 'mobile');
                    }
                ])->get();

            if (!empty($sales) and !$sales->isEmpty()) {
                $export = new WebinarStudents($sales);
                return Excel::download($export, trans('panel.users') . '.xlsx');
            }

            $toastData = [
                'title' => trans('public.request_failed'),
                'msg' => trans('webinars.export_list_error_not_student'),
                'status' => 'error'
            ];
            return back()->with(['toast' => $toastData]);
        }

        abort(404);
    }

    public function search(Request $request)
    {
        $user = auth()->user();

        if (!$user->isTeacher() and !$user->isOrganization()) {
            return response('', 422);
        }

        $term = $request->get('term', null);
        $webinarId = $request->get('webinar_id', null);
        $option = $request->get('option', null);

        if (!empty($term)) {
            $webinars = Webinar::select('id', 'teacher_id')
                ->whereTranslationLike('title', '%' . $term . '%')
                ->where('id', '<>', $webinarId)
                ->with(['teacher' => function ($query) {
                    $query->select('id', 'full_name');
                }])
                //->where('creator_id', $user->id)
                ->get();

            foreach ($webinars as $webinar) {
                $webinar->title .= ' - ' . $webinar->teacher->full_name;
            }
            return response()->json($webinars, 200);
        }

        return response('', 422);
    }

    public function getTags(Request $request, $id)
    {
        $webinarId = $request->get('webinar_id', null);

        if (!empty($webinarId)) {
            $tags = Tag::select('id', 'title')
                ->where('webinar_id', $webinarId)
                ->get();

            return response()->json($tags, 200);
        }

        return response('', 422);
    }

    public function invoice($id)
    {
        $user = auth()->user();

        $sale = Sale::where('buyer_id', $user->id)
            ->where('webinar_id', $id)
            ->where('type', 'webinar')
            ->whereNull('refund_at')
            ->with([
                'order',
                'buyer' => function ($query) {
                    $query->select('id', 'full_name');
                },
            ])
            ->first();

        if (!empty($sale)) {
            $webinar = Webinar::where('status', 'active')
                ->where('id', $id)
                ->with([
                    'teacher' => function ($query) {
                        $query->select('id', 'full_name');
                    },
                    'creator' => function ($query) {
                        $query->select('id', 'full_name');
                    },
                    'webinarPartnerTeacher' => function ($query) {
                        $query->with([
                            'teacher' => function ($query) {
                                $query->select('id', 'full_name');
                            },
                        ]);
                    }
                ])
                ->first();

            if (!empty($webinar)) {
                $data = [
                    'pageTitle' => trans('webinars.invoice_page_title'),
                    'sale' => $sale,
                    'webinar' => $webinar
                ];

                return view(getTemplate() . '.panel.webinar.invoice', $data);
            }
        }

        abort(404);
    }

    public function purchases(Request $request)
    {
        $user = auth()->user();
        $sectionm = SectionMat::where('id', $user->section_id)->pluck('name');
        $levelm = School_level::where('id', $user->level_id)->pluck('name');
        $matieretearcher = Material::where('id', $user->matier_id)->pluck('name');
        $optiontearcher = Option::where('id', $user->option_id)->pluck('name');          

        $matiere =[];
        if( !empty($user->section_id)){
        $matiere =Material::where('section_id', $user->section_id)->get();
        }
        $query = Sale::where('sales.buyer_id', $user->id)
            ->whereNull('sales.refund_at')
            ->where('access_to_purchased_item', true)
            ->where(function ($query) {
                $query->where(function ($query) {
                    $query->whereNotNull('sales.webinar_id')
                        ->where('sales.type', 'webinar')
                        ->whereHas('webinar', function ($query) {
                            $query->where('status', 'active');
                        });
                });
                $query->orWhere(function ($query) {
                    $query->whereNotNull('sales.bundle_id')
                        ->where('sales.type', 'bundle')
                        ->whereHas('bundle', function ($query) {
                            $query->where('status', 'active');
                        });
                });
            });


        $sales = deepClone($query)
            ->with([
                'webinar' => function ($query) {
                    $query->with([
                        'files',
                        'reviews' => function ($query) {
                            $query->where('status', 'active');
                        },
                        'category',
                        'teacher' => function ($query) {
                            $query->select('id', 'full_name');
                        },
                    ]);
                    $query->withCount([
                        'sales' => function ($query) {
                            $query->whereNull('refund_at');
                        }
                    ]);
                },
                'bundle' => function ($query) {
                    $query->with([
                        'reviews' => function ($query) {
                            $query->where('status', 'active');
                        },
                        'category',
                        'teacher' => function ($query) {
                            $query->select('id', 'full_name');
                        },
                    ]);
                }
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $purchasedCount = deepClone($query)
            ->where(function ($query) {
                $query->whereHas('webinar');
                $query->orWhereHas('bundle');
            })
            ->count();

        $webinarsHours = deepClone($query)->join('webinars', 'webinars.id', 'sales.webinar_id')
            ->select(DB::raw('sum(webinars.duration) as duration'))
            ->sum('duration');
        $bundlesHours = deepClone($query)->join('bundle_webinars', 'bundle_webinars.bundle_id', 'sales.bundle_id')
            ->join('webinars', 'webinars.id', 'bundle_webinars.webinar_id')
            ->select(DB::raw('sum(webinars.duration) as duration'))
            ->sum('duration');

        $hours = $webinarsHours + $bundlesHours;

        $time = time();
        $upComing = deepClone($query)->join('webinars', 'webinars.id', 'sales.webinar_id')
            ->where('webinars.start_date', '>', $time)
            ->count();

        $data = [
            'pageTitle' => trans('webinars.webinars_purchases_page_title'),
            'sales' => $sales,
            'purchasedCount' => $purchasedCount,
            'hours' => $hours,
            'sectionm' => $sectionm,
            'levelm' => $levelm,
            'matiere' => $matiere,
            'upComing' => $upComing,
            'matieretearcher'  => $matieretearcher,
            'optiontearcher' => $optiontearcher,

        ];

        return view(getTemplate() . '.panel.webinar.purchases', $data);
    }
    public function handleFilters($request, $query)
    {
        $upcoming = $request->get('upcoming', null);
        $isFree = $request->get('free', null);
        $withDiscount = $request->get('discount', null);
        $isDownloadable = $request->get('downloadable', null);
        $sort = $request->get('sort', null);
        $filterOptions = $request->get('filter_option', []);
        $typeOptions = $request->get('type', []);
        $moreOptions = $request->get('moreOptions', []);

        $query->whereHas('teacher', function ($query) {
            $query->where('status', 'active')
                ->where(function ($query) {
                    $query->where('ban', false)
                        ->orWhere(function ($query) {
                            $query->whereNotNull('ban_end_at')
                                ->where('ban_end_at', '<', time());
                        });
                });
        });

        if ($this->tableName == 'webinars') {

            if (!empty($upcoming) and $upcoming == 'on') {
                $query->whereNotNull('start_date')
                    ->where('start_date', '>=', time());
            }

            if (!empty($isDownloadable) and $isDownloadable == 'on') {
                $query->where('downloadable', 1);
            }

            if (!empty($typeOptions) and is_array($typeOptions)) {
                $query->whereIn("{$this->tableName}.type", $typeOptions);
            }

            if (!empty($moreOptions) and is_array($moreOptions)) {
                if (in_array('subscribe', $moreOptions)) {
                    $query->where('subscribe', 1);
                }

                if (in_array('certificate_included', $moreOptions)) {
                    $query->whereHas('quizzes', function ($query) {
                        $query->where('certificate', 1)
                            ->where('status', 'active');
                    });
                }

                if (in_array('with_quiz', $moreOptions)) {
                    $query->whereHas('quizzes', function ($query) {
                        $query->where('status', 'active');
                    });
                }

                if (in_array('featured', $moreOptions)) {
                    $query->whereHas('feature', function ($query) {
                        $query->whereIn('page', ['home_categories', 'categories'])
                            ->where('status', 'publish');
                    });
                }
            }
        }

        if (!empty($isFree) and $isFree == 'on') {
            $query->where(function ($qu) {
                $qu->whereNull('price')
                    ->orWhere('price', '0');
            });
        }

        if (!empty($withDiscount) and $withDiscount == 'on') {
            $now = time();
            $webinarIdsHasDiscount = [];

            $tickets = Ticket::where('start_date', '<', $now)
                ->where('end_date', '>', $now)
                ->get();

            foreach ($tickets as $ticket) {
                if ($ticket->isValid()) {
                    $webinarIdsHasDiscount[] = $ticket->{$this->columnId};
                }
            }

            $specialOffersWebinarIds = SpecialOffer::where('status', 'active')
                ->where('from_date', '<', $now)
                ->where('to_date', '>', $now)
                ->pluck('webinar_id')
                ->toArray();

            $webinarIdsHasDiscount = array_merge($specialOffersWebinarIds, $webinarIdsHasDiscount);

            $webinarIdsHasDiscount = array_unique($webinarIdsHasDiscount);

            $query->whereIn("{$this->tableName}.id", $webinarIdsHasDiscount);
        }

        if (!empty($sort)) {
            if ($sort == 'expensive') {
                $query->orderBy('price', 'desc');
            }

            if ($sort == 'inexpensive') {
                $query->orderBy('price', 'asc');
            }

            if ($sort == 'bestsellers') {
                $query->leftJoin('sales', function ($join) {
                    $join->on("{$this->tableName}.id", '=', "sales.{$this->columnId}")
                        ->whereNull('refund_at');
                })
                    ->whereNotNull("sales.{$this->columnId}")
                    ->select("{$this->tableName}.*", "sales.{$this->columnId}", DB::raw("count(sales.{$this->columnId}) as salesCounts"))
                    ->groupBy("sales.{$this->columnId}")
                    ->orderBy('salesCounts', 'desc');
            }

            if ($sort == 'best_rates') {
                $query->leftJoin('webinar_reviews', function ($join) {
                    $join->on("{$this->tableName}.id", '=', "webinar_reviews.{$this->columnId}");
                    $join->where('webinar_reviews.status', 'active');
                })
                    ->whereNotNull('rates')
                    ->select("{$this->tableName}.*", DB::raw('avg(rates) as rates'))
                    ->groupBy("{$this->tableName}.id")
                    ->orderBy('rates', 'desc');
            }
        }

        if (!empty($filterOptions) and is_array($filterOptions)) {
            $webinarIdsFilterOptions = WebinarFilterOption::whereIn('filter_option_id', $filterOptions)
                ->pluck($this->columnId)
                ->toArray();

            $query->whereIn("{$this->tableName}.id", $webinarIdsFilterOptions);
        }

        return $query;
    }
    public function allcourses(Request $request)
    {
        $user = auth()->user();
        $level = School_level::all();
        $materials = Material::whereHas('section', function ($query) use ($user) {
            $query->where('level_id', $user->level_id);
        })->get()->unique('name');


        $materialColors = [
            'العربية' => '#FFB3BA',
            'رياضيات' => '#8EACCD',
            'الإيقاظ العلمي' => '#A0937D',
            'الفرنسية' => '#A6B37D',
            'المواد الاجتماعية' => '#F6D7A7',
            'الإنجليزية' => '#BAABDA',
        ];

        $webinarsQuery = Webinar::where('webinars.status', 'active')
            ->where('level_id', $user->level_id)
            ->where('private', false);

        $by_material = $request->get('material_name', null);
        if (!empty($by_material)) {
            $materialIds = Material::where('name', $by_material)->pluck('id');
            $webinarsQuery->whereIn('matiere_id', $materialIds);
        }

        $search = $request->get('search', null);
        if (!empty($search)) {
            $webinarsQuery->join('webinar_translations', 'webinars.id', '=', 'webinar_translations.webinar_id')
                ->select('webinars.*', 'webinar_translations.title as title')
                ->where('webinar_translations.locale', app()->getLocale())
                ->where(function ($query) use ($search) {
                    $query->where('webinar_translations.title', 'like', '%' . $search . '%')
                        ->orWhereHas('teacher', function ($query) use ($search) {
                            $query->where('full_name', 'like', '%' . $search . '%');
                        });
                });
        }

        $webinarsQuery = $this->handleFilters($request, $webinarsQuery);

        $sort = $request->get('sort', null);
        if (empty($sort) || $sort == 'newest') {
            $webinarsQuery = $webinarsQuery->orderBy("{$this->tableName}.created_at", 'desc')
                ->orderBy("{$this->tableName}.updated_at", 'desc');
        }

        $webinars = $webinarsQuery->with(['tickets'])->paginate(9);

        $seoSettings = getSeoMetas('classes');
        $data = [
            'pageTitle' => $seoSettings['title'] ?? '',
            'pageDescription' => $seoSettings['description'] ?? '',
            'pageRobot' => getPageRobot('classes'),
            'webinars' => $webinars,
            'coursesCount' => $webinars->total(),
            'level' => $level,
            'material' => $materials,
            'materialColors' => $materialColors,
        ];

        return view(getTemplate() . '.panel.webinar.allcourses', $data);
    }

    public function getJoinInfo(Request $request)
    {
        $data = $request->all();
        if (!empty($data['webinar_id'])) {
            $user = auth()->user();

            $checkSale = Sale::where('buyer_id', $user->id)
                ->where('webinar_id', $data['webinar_id'])
                ->where('type', 'webinar')
                ->whereNull('refund_at')
                ->first();

            if (!empty($checkSale)) {
                $webinar = Webinar::where('status', 'active')
                    ->where('id', $data['webinar_id'])
                    ->first();

                if (!empty($webinar)) {
                    $session = Session::select('id', 'creator_id', 'date', 'link', 'zoom_start_link', 'session_api', 'api_secret')
                        ->where('webinar_id', $webinar->id)
                        ->where('date', '>=', time())
                        ->orderBy('date', 'asc')
                        ->whereDoesntHave('agoraHistory', function ($query) {
                            $query->whereNotNull('end_at');
                        })
                        ->first();

                    if (!empty($session)) {
                        $session->date = dateTimeFormat($session->date, 'Y-m-d H:i', false);

                        $session->link = $session->getJoinLink(true);

                        return response()->json([
                            'code' => 200,
                            'session' => $session
                        ], 200);
                    }
                }
            }
        }

        return response()->json([], 422);
    }

    public function getNextSessionInfo($id)
    {
        $user = auth()->user();

        $webinar = Webinar::where('id', $id)
            ->where(function ($query) use ($user) {
                $query->where(function ($query) use ($user) {
                    $query->where('creator_id', $user->id)
                        ->orWhere('teacher_id', $user->id);
                });

                $query->orWhereHas('webinarPartnerTeacher', function ($query) use ($user) {
                    $query->where('teacher_id', $user->id);
                });
            })->first();

        if (!empty($webinar)) {
            $session = Session::where('webinar_id', $webinar->id)
                ->where('date', '>=', time())
                ->orderBy('date', 'asc')
                ->where('status', Session::$Active)
                ->whereDoesntHave('agoraHistory', function ($query) {
                    $query->whereNotNull('end_at');
                })
                ->first();

            if (!empty($session) and $session->title) {
                $session->date = dateTimeFormat($session->date, 'Y-m-d H:i', false);

                $session->link = $session->getJoinLink(true);

                if (!empty($session->agora_settings)) {
                    $session->agora_settings = json_decode($session->agora_settings);
                }
            }

            return response()->json([
                'code' => 200,
                'session' => $session,
                'webinar_id' => $webinar->id,
            ], 200);
        }

        return response()->json([], 422);
    }

    public function orderItems(Request $request)
    {
        $user = auth()->user();
        $data = $request->all();

        $validator = Validator::make($data, [
            'items' => 'required',
            'table' => 'required',
        ]);

        if ($validator->fails()) {
            return response([
                'code' => 422,
                'errors' => $validator->errors(),
            ], 422);
        }

        $tableName = $data['table'];
        $itemIds = explode(',', $data['items']);

        if (!is_array($itemIds) and !empty($itemIds)) {
            $itemIds = [$itemIds];
        }

        if (!empty($itemIds) and is_array($itemIds) and count($itemIds)) {
            switch ($tableName) {
                case 'tickets':
                    foreach ($itemIds as $order => $id) {
                        Ticket::where('id', $id)
                            ->where('creator_id', $user->id)
                            ->update(['order' => ($order + 1)]);
                    }
                    break;
                case 'sessions':
                    foreach ($itemIds as $order => $id) {
                        Session::where('id', $id)
                            ->where('creator_id', $user->id)
                            ->update(['order' => ($order + 1)]);
                    }
                    break;
                case 'files':
                    foreach ($itemIds as $order => $id) {
                        File::where('id', $id)
                            ->where('creator_id', $user->id)
                            ->update(['order' => ($order + 1)]);
                    }
                    break;
                case 'text_lessons':
                    foreach ($itemIds as $order => $id) {
                        TextLesson::where('id', $id)
                            ->where('creator_id', $user->id)
                            ->update(['order' => ($order + 1)]);
                    }
                    break;
                case 'prerequisites':
                    $webinarIds = $user->webinars()->pluck('id')->toArray();

                    foreach ($itemIds as $order => $id) {
                        Prerequisite::where('id', $id)
                            ->whereIn('webinar_id', $webinarIds)
                            ->update(['order' => ($order + 1)]);
                    }
                    break;
                case 'faqs':
                    foreach ($itemIds as $order => $id) {
                        Faq::where('id', $id)
                            ->where('creator_id', $user->id)
                            ->update(['order' => ($order + 1)]);
                    }
                    break;
                case 'webinar_chapters':
                    foreach ($itemIds as $order => $id) {
                        WebinarChapter::where('id', $id)
                            ->where('user_id', $user->id)
                            ->update(['order' => ($order + 1)]);
                    }
                    break;
                case 'webinar_chapter_items':
                    foreach ($itemIds as $order => $id) {
                        WebinarChapterItem::where('id', $id)
                            ->where('user_id', $user->id)
                            ->update(['order' => ($order + 1)]);
                    }
                case 'bundle_webinars':
                    foreach ($itemIds as $order => $id) {
                        BundleWebinar::where('id', $id)
                            ->where('creator_id', $user->id)
                            ->update(['order' => ($order + 1)]);
                    }
                    break;

                case 'webinar_extra_descriptions_learning_materials':
                    foreach ($itemIds as $order => $id) {
                        WebinarExtraDescription::where('id', $id)
                            ->where('creator_id', $user->id)
                            ->where('type', 'learning_materials')
                            ->update(['order' => ($order + 1)]);
                    }
                    break;

                case 'webinar_extra_descriptions_company_logos':
                    foreach ($itemIds as $order => $id) {
                        WebinarExtraDescription::where('id', $id)
                            ->where('creator_id', $user->id)
                            ->where('type', 'company_logos')
                            ->update(['order' => ($order + 1)]);
                    }
                    break;

                case 'webinar_extra_descriptions_requirements':
                    foreach ($itemIds as $order => $id) {
                        WebinarExtraDescription::where('id', $id)
                            ->where('creator_id', $user->id)
                            ->where('type', 'requirements')
                            ->update(['order' => ($order + 1)]);
                    }
                    break;

            }
        }

        return response()->json([
            'title' => trans('public.request_success'),
            'msg' => trans('update.items_sorted_successful')
        ]);
    }

    public function getContentItemByLocale(Request $request, $id)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'item_id' => 'required',
            'locale' => 'required',
            'relation' => 'required',
        ]);

        if ($validator->fails()) {
            return response([
                'code' => 422,
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = auth()->user();

        $webinar = Webinar::where('id', $id)
            ->where(function ($query) use ($user) {
                $query->where(function ($query) use ($user) {
                    $query->where('creator_id', $user->id)
                        ->orWhere('teacher_id', $user->id);
                });

                $query->orWhereHas('webinarPartnerTeacher', function ($query) use ($user) {
                    $query->where('teacher_id', $user->id);
                });
            })->first();

        if (!empty($webinar)) {

            $itemId = $data['item_id'];
            $locale = $data['locale'];
            $relation = $data['relation'];

            if (!empty($webinar->$relation)) {
                $item = $webinar->$relation->where('id', $itemId)->first();

                if (!empty($item)) {
                    foreach ($item->translatedAttributes as $attribute) {
                        try {
                            $item->$attribute = $item->translate(mb_strtolower($locale))->$attribute;
                        } catch (\Exception $e) {
                            $item->$attribute = null;
                        }
                    }

                    return response()->json([
                        'item' => $item
                    ], 200);
                }
            }
        }

        abort(403);
    }
}

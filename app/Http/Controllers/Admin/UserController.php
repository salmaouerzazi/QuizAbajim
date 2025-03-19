<?php

namespace App\Http\Controllers\Admin;

use App\Bitwise\UserLevelOfTraining;
use App\Exports\OrganizationsExport;
use App\Exports\StudentsExport;
use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Models\Badge;
use App\Models\BecomeInstructor;
use App\Models\Category;
use App\Models\ForumTopic;
use App\Models\Group;
use App\Models\GroupUser;
use App\Models\Region;
use App\Models\Role;
use App\Models\Sale;
use App\Models\UserBadge;
use App\Models\UserManualPurchase;
use App\Models\UserMeta;
use App\Models\UserOccupation;
use App\Models\UserRegistrationPackage;
use App\Models\Video;
use App\Models\Webinar;
use App\User;
use App\Models\School_level;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\UserLevel;

class UserController extends Controller
{

  
    public function staffs(Request $request)
    {
        $this->authorize('admin_staffs_list');

        $staffsRoles = Role::where('is_admin', true)->get();
        $staffsRoleIds = $staffsRoles->pluck('id')->toArray();


        $query = User::whereIn('role_id', $staffsRoleIds);
        $query = $this->filters($query, $request);

        $users = $query->orderBy('created_at', 'desc')
            ->paginate(10);

        $data = [
            'pageTitle' => trans('admin/main.staff_list_title'),
            'users' => $users,
            'staffsRoles' => $staffsRoles,
        ];

        return view('admin.users.staffs', $data);
    }

    public function organizations(Request $request, $is_export_excel = false)
    {
        $this->authorize('admin_organizations_list');

        $query = User::where('role_name', Role::$organization);

        $totalOrganizations = deepClone($query)->count();
        $verifiedOrganizations = deepClone($query)->where('verified', true)
            ->count();
        $totalOrganizationsTeachers = User::where('role_name', Role::$teacher)
            ->whereNotNull('organ_id')
            ->count();
        $totalOrganizationsStudents = User::where('role_name', Role::$enfant)
            ->whereNotNull('organ_id')
            ->count();
        $userGroups = Group::where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->get();


        $query = $this->filters($query, $request);

        if ($is_export_excel) {
            $users = $query->orderBy('created_at', 'desc')->get();
        } else {
            $users = $query->orderBy('created_at', 'desc')
                ->paginate(10);
        }


        $users = $this->addUsersExtraInfo($users);

        if ($is_export_excel) {
            return $users;
        }
        // 1. Calculate Average Online Time (Users Online)
        $averageOnlineTime = 0;
        $totalOnlineTime = 0;
        $usersCount = 0;

        $users->each(function ($user) use (&$totalOnlineTime, &$usersCount) {
            if (!empty($user->last_seen_at) && !empty($user->first_login_at)) {
                $onlineTime = DB::table('users')
                    ->select(DB::raw('TIMESTAMPDIFF(MINUTE, first_login_at, last_seen_at) as online_time'))
                    ->where('id', $user->id)
                    ->first()
                    ->online_time;

                $totalOnlineTime += $onlineTime;
                $usersCount++;
            }
        });

        if ($usersCount > 0) {
            $averageOnlineTime = floor($totalOnlineTime / $usersCount);
        }

        // 2. Calculate Average Minutes to Open Account
        $averageMinutesToOpen = User::whereNotNull('first_login_at')
            ->avg(DB::raw('TIMESTAMPDIFF(MINUTE, created_at, first_login_at)'));
                // 3. Count Users by Device Type
                $deviceStats = User::select('device_type', DB::raw('COUNT(*) as count'))
                    ->groupBy('device_type')
                    ->pluck('count', 'device_type');

        $data = [
            'pageTitle' => trans('admin/main.organizations'),
            'users' => $users,
            'totalOrganizations' => $totalOrganizations,
            'verifiedOrganizations' => $verifiedOrganizations,
            'totalOrganizationsTeachers' => $totalOrganizationsTeachers,
            'totalOrganizationsStudents' => $totalOrganizationsStudents,
            'userGroups' => $userGroups,
             'averageOnlineTime' => $averageOnlineTime, 
        'averageMinutesToOpen' => $averageMinutesToOpen,

        'deviceStats' => $deviceStats
        ];
      

        return view('admin.users.organizations', $data);
    }

    public function students(Request $request, $is_export_excel = false)
    {
        $this->authorize('admin_users_list');

        $query = User::where('role_name', Role::$enfant);

        $totalStudents = deepClone($query)->whereNotNull('organ_id')
        ->count();

        $WithSubscriptionCount = deepClone($query)->whereHas('subscriptions')
            ->count();
        
        $WithoutSubscriptionCount = deepClone($query)->whereDoesntHave('subscriptions')
            ->count();
        
        

        $totalOrganizationsStudents = User::where('role_name', Role::$organization)
            ->count();

        $organizations = User::select('id', 'full_name', 'created_at')
            ->where('role_name', Role::$organization)
            ->orderBy('created_at', 'desc')
            ->get();


        $query = $this->filters($query, $request);

        if ($is_export_excel) {
            $users = $query->orderBy('created_at', 'desc')->get();
        } else {
            $users = $query->orderBy('created_at', 'desc')
                ->paginate(10);
        }

        $users = $this->addUsersExtraInfo($users);

        if ($is_export_excel) {
            return $users;
        }
        $level = School_level::all();

        $data = [
            'pageTitle' => trans('public.students'),
            'users' => $users,
            'totalStudents' => $totalStudents,
            'totalOrganizationsStudents' => $totalOrganizationsStudents,
            'organizations' => $organizations,
            'WithSubscriptionCount' => $WithSubscriptionCount,
            'WithoutSubscriptionCount' => $WithoutSubscriptionCount,
            'level' =>$level,
        ];

        return view('admin.users.students', $data);
    }

    public function getByLevel($levelId)
    {
        $sectionIds = SectionMat::where('level_id', $levelId)->pluck('id')->toArray();
        
        $matieres = Material::whereIn('section_id', $sectionIds)->get();

        return response()->json($matieres);
    }

    public function instructors(Request $request, $is_export_excel = false)
    {
        $this->authorize('admin_instructors_list');

        $query = User::where('role_name', Role::$teacher);

        $filteredQuery = $this->filters(deepClone($query), $request);

        $totalInstructors = $filteredQuery->count();
        $totalVideos = Video::whereIn('user_id', $filteredQuery->pluck('id'))->count();
        $videoAllInstructorsCount = $filteredQuery->whereHas('videos')->count();
        $totalInstructorsWithoutVideos = $totalInstructors - $videoAllInstructorsCount;



        $level = School_level::all();
        $matieres = Material::get()->unique('name');
        $query = $this->filters($query, $request);

        if ($is_export_excel) {
            $users = $query->orderBy('created_at', 'desc')->get();
        } else {
            $users = $query->orderBy('created_at', 'desc')
                ->paginate(10);
        }

        $users = $this->addUsersExtraInfo($users);

        if ($is_export_excel) {
            return $users;
        }
        $videoInstructorscount = Video::whereIn('user_id', $filteredQuery->pluck('id'))
        ->selectRaw('user_id, count(*) as count')
        ->pluck('count', 'user_id');

        $sss = User::where('role_id', 4)->whereHas('videos')->count();
        $videoCountByTeacherId = Video::select('user_id', DB::raw('count(*) as total'))
            ->groupBy('user_id')
            ->pluck('total', 'user_id')
            ->toArray();
  
        $data = [
            'pageTitle' => trans('admin/main.instructors'),
            'users' => $users,
            'videoAllInstructorsCount' => $videoAllInstructorsCount, // This will now contain video counts for each use
            'videoInstructorscount' => $videoInstructorscount, // This will now contain video counts for each user
            'totalInstructorsWithoutVideos' => $totalInstructorsWithoutVideos, 
            'videoCountByTeacherId' =>$videoCountByTeacherId ,
            'totalVideos' => $totalVideos,
            'totalInstructors' => $totalInstructors,
            'level' =>$level,
            'matieres' =>$matieres,
        ];

        return view('admin.users.instructors', $data);
    }

    private function addUsersExtraInfo($users)
    {
        foreach ($users as $user) {
            $salesQuery = Sale::where('seller_id', $user->id)
                ->whereNull('refund_at');

            $classesSaleQuery = deepClone($salesQuery)->whereNotNull('webinar_id')
                ->whereNull('meeting_id')
                ->whereNull('promotion_id')
                ->whereNull('subscribe_id');

            $user->classesSalesCount = $classesSaleQuery->count();
            $user->classesSalesSum = $classesSaleQuery->sum('total_amount');

            $meetingsSaleQuery = deepClone($salesQuery)->whereNotNull('meeting_id')
                ->whereNull('webinar_id')
                ->whereNull('promotion_id')
                ->whereNull('subscribe_id');

            $user->meetingsSalesCount = $meetingsSaleQuery->count();
            $user->meetingsSalesSum = $meetingsSaleQuery->sum('total_amount');


            $purchasedQuery = Sale::where('buyer_id', $user->id)
                ->whereNull('refund_at');

            $classesPurchasedQuery = deepClone($purchasedQuery)->whereNotNull('webinar_id')
                ->whereNull('meeting_id')
                ->whereNull('promotion_id')
                ->whereNull('subscribe_id');

            $user->classesPurchasedsCount = $classesPurchasedQuery->count();
            $user->classesPurchasedsSum = $classesPurchasedQuery->sum('total_amount');

            $meetingsPurchasedQuery = deepClone($purchasedQuery)->whereNotNull('meeting_id')
                ->whereNull('webinar_id')
                ->whereNull('promotion_id')
                ->whereNull('subscribe_id');

            $user->meetingsPurchasedsCount = $meetingsPurchasedQuery->count();
            $user->meetingsPurchasedsSum = $meetingsPurchasedQuery->sum('total_amount');
        }

        return $users;
    }

    private function filters($query, $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');
        $full_name = $request->get('full_name');
        $sort = $request->get('sort');
        $group_id = $request->get('group_id');
        $status = $request->get('status');
        $role_id = $request->get('role_id');
        $organization_id = $request->get('organization_id');
        $phone_number = $request->get('phone_number');
        $level_id = $request->get('level_id');
        $matiere_name = $request->get('matiere_name');
        $child_level_id = $request->get('child_level_id');
        $query = fromAndToDateFilter($from, $to, $query, 'created_at');

        if (!empty($full_name)) {
            $query->where('full_name', 'like', "%$full_name%");
        }
        if (!empty($phone_number)) {
            $query->where('mobile', 'like', "%$phone_number%");
        }
        if ($sort == 'subscribed') {
            $query->whereHas('subscriptions', function ($q) {
                $q->whereNotNull('id');
            });
        }
    
        if ($sort == 'not_subscribed') {
            $query->whereDoesntHave('subscriptions');
        }

        if (!empty($role_id)) {
            $query->where('role_id', $role_id);
        }
        if (!empty($level_id)) {
            $userIds = DB::table('user_matiere')->where('level_id', $level_id)->pluck('teacher_id')->toArray();
            $query->whereIn('id', $userIds);
        }
        if (!empty($child_level_id)) {
            $userIds = DB::table('enfant')
                ->where('level_id', $child_level_id)
                ->pluck('user_id')
                ->toArray();
        
            $query->whereIn('id', $userIds);
        }
        

        if (!empty($matiere_name)) {
            $materialIds = DB::table('materials')
                ->where('name', 'like', "%$matiere_name%") 
                ->pluck('id')
                ->toArray();
        
            $userIds = DB::table('user_matiere')
                ->whereIn('matiere_id', $materialIds)
                ->pluck('teacher_id')
                ->toArray();
        
            $query->whereIn('id', $userIds);
        }
        

        if (!empty($organization_id)) {
            $query->where('organ_id', $organization_id);
        }

        return $query;
    }

    public function create()
    {
        $this->authorize('admin_users_create');

        $roles = Role::orderBy('created_at', 'desc')->get();
        $userGroups = Group::orderBy('created_at', 'desc')->where('status', 'active')->get();

        $data = [
            'pageTitle' => trans('admin/main.user_new_page_title'),
            'roles' => $roles,
            'userGroups' => $userGroups,
        ];


        return view('admin.users.create', $data);
    }

    private function username($data)
    {
        $email_regex = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i";

        $username = 'mobile';
        if (preg_match($email_regex, request('username', null))) {
            $username = 'email';
        }

        return $username;
    }

    public function store(Request $request)
    {
        $this->authorize('admin_users_create');
        $data = $request->all();

        $username = $this->username($data);
        $data[$username] = $data['username'];
        $request->merge([$username => $data['username']]);
        unset($data['username']);

        $this->validate($request, [
            $username => ($username == 'mobile') ? 'required|numeric|unique:users' : 'required|string|email|max:255|unique:users',
            'full_name' => 'required|min:3|max:128',
            'role_id' => 'required|exists:roles,id',
            'password' => 'required|string|min:6',
            'status' => 'required',
        ]);

        if (!empty($data['role_id'])) {
            $role = Role::find($data['role_id']);

            if (!empty($role)) {
                $referralSettings = getReferralSettings();
                $usersAffiliateStatus = (!empty($referralSettings) and !empty($referralSettings['users_affiliate_status']));


                $user = User::create([
                    'full_name' => $data['full_name'],
                    'role_name' => $role->name,
                    'role_id' => $data['role_id'],
                    $username => $data[$username],
                    'password' => User::generatePassword($data['password']),
                    'status' => $data['status'],
                    'affiliate' => $usersAffiliateStatus,
                    'verified' => true,
                    'created_at' => time(),
                ]);

                if (!empty($data['group_id'])) {
                    $group = Group::find($data['group_id']);

                    if (!empty($group)) {
                        GroupUser::create([
                            'group_id' => $group->id,
                            'user_id' => $user->id,
                            'created_at' => time(),
                        ]);
                    }
                }

                return redirect('/admin/users/' . $user->id . '/edit');
            }
        }

        $toastData = [
            'title' => '',
            'msg' => 'Role not find!',
            'status' => 'error'
        ];
        return back()->with(['toast' => $toastData]);
    }

    public function edit(Request $request, $id)
    {
        $this->authorize('admin_users_edit');

        $user = User::where('id', $id)
            ->with([
                'customBadges' => function ($query) {
                    $query->with('badge');
                },
                'occupations' => function ($query) {
                    $query->with('category');
                },
                'organization' => function ($query) {
                    $query->select('id', 'full_name');
                },
                'userRegistrationPackage'
            ])
            ->first();

        if (empty($user)) {
            abort(404);
        }

        if (!empty($user->location)) {
            $user->location = \Geo::getST_AsTextFromBinary($user->location);

            $user->location = \Geo::get_geo_array($user->location);
        }

        $userMetas = $user->userMetas;

        if (!empty($userMetas)) {
            foreach ($userMetas as $meta) {
                $user->{$meta->name} = $meta->value;
            }
        }

        $becomeInstructor = null;
        if (!empty($request->get('type')) and $request->get('type') == 'check_instructor_request') {
            $becomeInstructor = BecomeInstructor::where('user_id', $user->id)
                ->first();
        }

        $categories = Category::where('parent_id', null)
            ->with('subCategories')
            ->get();

        $occupations = $user->occupations->pluck('category_id')->toArray();

        $userBadges = $user->getBadges(false);

        $roles = Role::all();
        $badges = Badge::all();

        $userLanguages = getGeneralSettings('user_languages');
        if (!empty($userLanguages) and is_array($userLanguages)) {
            $userLanguages = getLanguages($userLanguages);
        } else {
            $userLanguages = [];
        }


        $provinces = null;
        $cities = null;
        $districts = null;

        $countries = Region::select(DB::raw('*, ST_AsText(geo_center) as geo_center'))
            ->where('type', Region::$country)
            ->get();

        if (!empty($user->country_id)) {
            $provinces = Region::select(DB::raw('*, ST_AsText(geo_center) as geo_center'))
                ->where('type', Region::$province)
                ->where('country_id', $user->country_id)
                ->get();
        }

        if (!empty($user->province_id)) {
            $cities = Region::select(DB::raw('*, ST_AsText(geo_center) as geo_center'))
                ->where('type', Region::$city)
                ->where('province_id', $user->province_id)
                ->get();
        }

        if (!empty($user->city_id)) {
            $districts = Region::select(DB::raw('*, ST_AsText(geo_center) as geo_center'))
                ->where('type', Region::$district)
                ->where('city_id', $user->city_id)
                ->get();
        }


        $data = [
            'pageTitle' => trans('admin/pages/users.edit_page_title'),
            'user' => $user,
            'userBadges' => $userBadges,
            'roles' => $roles,
            'badges' => $badges,
            'categories' => $categories,
            'occupations' => $occupations,
            'becomeInstructor' => $becomeInstructor,
            'userLanguages' => $userLanguages,
            'userRegistrationPackage' => $user->userRegistrationPackage,
            'countries' => $countries,
            'provinces' => $provinces,
            'cities' => $cities,
            'districts' => $districts,
        ];

        // Purchased Classes Data
        $data = array_merge($data, $this->getPurchasedClassesData($user));

        // Purchased Bundles Data
        $data = array_merge($data, $this->getPurchasedBundlesData($user));

        // Purchased Product Data
        $data = array_merge($data, $this->getPurchasedProductsData($user));

        if (auth()->user()->can('admin_forum_topics_lists')) {
            $data['topics'] = ForumTopic::where('creator_id', $user->id)
                ->with([
                    'posts' => function ($query) {
                        $query->orderBy('created_at', 'desc');
                    },
                    'forum'
                ])
                ->withCount('posts')
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('admin.users.edit', $data);
    }

    private function getPurchasedClassesData($user)
    {
        $manualAddedClasses = Sale::whereNull('refund_at')
            ->where('buyer_id', $user->id)
            ->whereNotNull('webinar_id')
            ->where('sales.manual_added', true)
            ->where('sales.access_to_purchased_item', true)
            ->whereHas('webinar')
            ->with([
                'webinar'
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        $manualDisabledClasses = Sale::whereNull('refund_at')
            ->where('buyer_id', $user->id)
            ->whereNotNull('webinar_id')
            ->where('sales.access_to_purchased_item', false)
            ->whereHas('webinar')
            ->with([
                'webinar'
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        $purchasedClasses = Sale::whereNull('refund_at')
            ->where('buyer_id', $user->id)
            ->whereNotNull('webinar_id')
            ->where('sales.access_to_purchased_item', true)
            ->where('sales.manual_added', false)
            ->whereHas('webinar')
            ->with([
                'webinar'
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        return [
            'manualAddedClasses' => $manualAddedClasses,
            'purchasedClasses' => $purchasedClasses,
            'manualDisabledClasses' => $manualDisabledClasses,
        ];
    }

    private function getPurchasedBundlesData($user)
    {
        $manualAddedBundles = Sale::whereNull('refund_at')
            ->where('buyer_id', $user->id)
            ->whereNotNull('bundle_id')
            ->where('sales.manual_added', true)
            ->where('sales.access_to_purchased_item', true)
            ->whereHas('bundle')
            ->with([
                'bundle'
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        $manualDisabledBundles = Sale::whereNull('refund_at')
            ->where('buyer_id', $user->id)
            ->whereNotNull('bundle_id')
            ->where('sales.access_to_purchased_item', false)
            ->whereHas('bundle')
            ->with([
                'bundle'
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        $purchasedBundles = Sale::whereNull('refund_at')
            ->where('buyer_id', $user->id)
            ->whereNotNull('bundle_id')
            ->where('sales.access_to_purchased_item', true)
            ->where('sales.manual_added', false)
            ->whereHas('bundle')
            ->with([
                'bundle'
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        return [
            'manualAddedBundles' => $manualAddedBundles,
            'purchasedBundles' => $purchasedBundles,
            'manualDisabledBundles' => $manualDisabledBundles,
        ];
    }

    private function getPurchasedProductsData($user)
    {
        $manualAddedProducts = Sale::whereNull('refund_at')
            ->where('buyer_id', $user->id)
            ->whereNotNull('product_order_id')
            ->where('sales.manual_added', true)
            ->where('sales.access_to_purchased_item', true)
            ->whereHas('productOrder')
            ->with([
                'productOrder' => function ($query) {
                    $query->with([
                        'product'
                    ]);
                }
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        $manualDisabledProducts = Sale::whereNull('refund_at')
            ->where('buyer_id', $user->id)
            ->whereNotNull('product_order_id')
            ->where('sales.access_to_purchased_item', false)
            ->whereHas('productOrder')
            ->with([
                'productOrder' => function ($query) {
                    $query->with([
                        'product'
                    ]);
                }
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        $purchasedProducts = Sale::whereNull('refund_at')
            ->where('buyer_id', $user->id)
            ->whereNotNull('product_order_id')
            ->where('sales.access_to_purchased_item', true)
            ->where('sales.manual_added', false)
            ->whereHas('productOrder')
            ->with([
                'productOrder' => function ($query) {
                    $query->with([
                        'product'
                    ]);
                }
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        return [
            'manualAddedProducts' => $manualAddedProducts,
            'purchasedProducts' => $purchasedProducts,
            'manualDisabledProducts' => $manualDisabledProducts,
        ];
    }

    public function update(Request $request, $id)
    {
        $this->authorize('admin_users_edit');

        $user = User::findOrFail($id);

        $this->validate($request, [
            'full_name' => 'required|min:3|max:128',
            'role_id' => 'required|exists:roles,id',
            'email' => (!empty($user->email)) ? 'required|email|unique:users,email,' . $user->id . ',id,deleted_at,NULL' : 'nullable|email|unique:users',
            'mobile' => (!empty($user->mobile)) ? 'required|numeric|unique:users,mobile,' . $user->id . ',id,deleted_at,NULL' : 'nullable|numeric|unique:users',
            'password' => 'nullable|string',
            'bio' => 'nullable|string|min:3|max:48',
            'about' => 'nullable|string|min:3',
            'certificate_additional' => 'nullable|string|max:255',
            'status' => 'required|' . Rule::in(User::$statuses),
            'ban_start_at' => 'required_if:ban,on',
            'ban_end_at' => 'required_if:ban,on',
        ]);

        $data = $request->all();

        $role = Role::where('id', $data['role_id'])->first();

        if (empty($role)) {
            $toastData = [
                'title' => trans('public.request_failed'),
                'msg' => 'Selected role not exist',
                'status' => 'error'
            ];
            return back()->with(['toast' => $toastData]);
        }

        if ($user->role_id != $role->id and $role->name == Role::$teacher) {
            $becomeInstructor = BecomeInstructor::where('user_id', $user->id)
                ->where('status', 'pending')
                ->first();

            if (!empty($becomeInstructor)) {
                $becomeInstructor->update([
                    'status' => 'accept'
                ]);
            }
        }


        $user->full_name = !empty($data['full_name']) ? $data['full_name'] : null;
        $user->role_name = $role->name;
        $user->role_id = $role->id;
        $user->timezone = $data['timezone'] ?? null;
        // $user->organ_id = !empty($data['organ_id']) ? $data['organ_id'] : null;
        $user->email = !empty($data['email']) ? $data['email'] : null;
        $user->mobile = !empty($data['mobile']) ? $data['mobile'] : null;
        $user->bio = !empty($data['bio']) ? $data['bio'] : null;
        $user->about = !empty($data['about']) ? $data['about'] : null;
        $user->status = !empty($data['status']) ? $data['status'] : null;
        $user->language = !empty($data['language']) ? $data['language'] : null;


        if (!empty($data['password'])) {
            $user->password = User::generatePassword($data['password']);
        }

        if (!empty($data['ban']) and $data['ban'] == '1') {
            $ban_start_at = strtotime($data['ban_start_at']);
            $ban_end_at = strtotime($data['ban_end_at']);

            $user->ban = true;
            $user->ban_start_at = $ban_start_at;
            $user->ban_end_at = $ban_end_at;
        } else {
            $user->ban = false;
            $user->ban_start_at = null;
            $user->ban_end_at = null;
        }

        $user->verified = (!empty($data['verified']) and $data['verified'] == '1');

        $user->affiliate = (!empty($data['affiliate']) and $data['affiliate'] == '1');

        $user->can_create_store = (!empty($data['can_create_store']) and $data['can_create_store'] == '1');

        $user->access_content = (!empty($data['access_content']) and $data['access_content'] == '1');

        $user->save();

        // save certificate_additional in user metas table
        $this->handleUserCertificateAdditional($user->id, $data['certificate_additional']);

        return redirect()->back();
    }

    private function handleUserCertificateAdditional($userId, $value)
    {
        $name = 'certificate_additional';

        if (empty($value)) {
            $checkMeta = UserMeta::where('user_id', $userId)
                ->where('name', $name)
                ->first();

            if (!empty($checkMeta)) {
                $checkMeta->delete();
            }
        } else {
            UserMeta::updateOrCreate([
                'user_id' => $userId,
                'name' => $name
            ], [
                'value' => $value
            ]);
        }
    }

    public function updateImage(Request $request, $id)
    {
        $this->authorize('admin_users_edit');

        $user = User::findOrFail($id);

        $user->avatar = $request->get('avatar', null);

        if (!empty($request->get('cover_img', null))) {
            $user->cover_img = $request->get('cover_img', null);
        }

        $user->save();

        return redirect()->back();
    }

    public function financialUpdate(Request $request, $id)
    {
        $this->authorize('admin_users_edit');

        $user = User::findOrFail($id);
        $data = $request->all();

        $user->update([
            'account_type' => $data['account_type'],
            'iban' => $data['iban'],
            'account_id' => $data['account_id'],
            'identity_scan' => $data['identity_scan'],
            'address' => $data['address'],
            'commission' => $data['commission'] ?? null,
            'financial_approval' => (!empty($data['financial_approval']) and $data['financial_approval'] == 'on')
        ]);

        return redirect()->back();
    }

    public function occupationsUpdate(Request $request, $id)
    {
        $this->authorize('admin_users_edit');

        $user = User::findOrFail($id);
        $data = $request->all();

        UserOccupation::where('user_id', $user->id)->delete();
        if (!empty($data['occupations'])) {

            foreach ($data['occupations'] as $category_id) {
                UserOccupation::create([
                    'user_id' => $user->id,
                    'category_id' => $category_id
                ]);
            }
        }

        return redirect()->back();
    }

    public function badgesUpdate(Request $request, $id)
    {
        $this->authorize('admin_users_edit');

        $this->validate($request, [
            'badge_id' => 'required'
        ]);

        $data = $request->all();
        $user = User::findOrFail($id);
        $badge = Badge::findOrFail($data['badge_id']);

        UserBadge::create([
            'user_id' => $user->id,
            'badge_id' => $badge->id,
            'created_at' => time()
        ]);

        // sendNotification('notification.new_badge', 
        // 'notification.new_badge_msg',
        // $user->id,
        // null,
        // 'system',
        // 'single',
        // ['title' => $badge->title]);

        return redirect()->back();
    }

    public function deleteBadge(Request $request, $id, $badge_id)
    {
        $this->authorize('admin_users_edit');

        $user = User::findOrFail($id);

        $badge = UserBadge::where('id', $badge_id)
            ->where('user_id', $user->id)
            ->first();

        if (!empty($badge)) {
            $badge->delete();
        }

        return redirect()->back();
    }

    public function destroy(Request $request, $id)
    {
        $this->authorize('admin_users_delete');

        $user = User::find($id);

        if ($user) {
            $user->delete();
        }

        return redirect()->back();
    }

    public function acceptRequestToInstructor($id)
    {
        $this->authorize('admin_users_edit');

        $user = User::findOrFail($id);

        $becomeInstructors = BecomeInstructor::where('user_id', $user->id)->first();

        if (!empty($becomeInstructors)) {
            $role = Role::where('name', $becomeInstructors->role)->first();

            if (!empty($role)) {
                $user->update([
                    'role_id' => $role->id,
                    'role_name' => $role->name,
                ]);

                $becomeInstructors->update([
                    'status' => 'accept'
                ]);
            }

            return redirect('/admin/users/' . $user->id . '/edit')->with(['msg' => trans('admin/pages/users.user_role_updated')]);
        }

        abort(404);
    }

    public function search(Request $request)
    {
        $term = $request->get('term');
        $option = $request->get('option');

        $users = User::select('id', 'full_name as name')
            //->where('role_name', Role::$user)
            ->where(function ($query) use ($term) {
                $query->where('full_name', 'like', '%' . $term . '%');
            });

        if ($option === "for_user_group") {
            $users->whereNotIn('id', GroupUser::all()->pluck('user_id'));
        }

        if ($option === "just_teacher_role") {
            $users->where('role_name', Role::$teacher);
        }

        if ($option === "just_student_role") {
            $users->where('role_name', Role::$user);
        }

        if ($option === "just_organization_role") {
            $users->where('role_name', Role::$organization);
        }

        if ($option === "just_organization_and_teacher_role") {
            $users->whereIn('role_name', [Role::$organization, Role::$teacher]);
        }

        if ($option === "consultants") {
            $users->whereHas('meeting', function ($query) {
                $query->where('disabled', false)
                    ->whereHas('meetingTimes');
            });
        }

        return response()->json($users->get(), 200);
    }

    public function impersonate($user_id)
    {
        $this->authorize('admin_users_impersonate');

        $user = User::findOrFail($user_id);

        if ($user->isAdmin()) {
            return redirect('/admin');
        }
  
        session()->put(['impersonated' => $user->id]);
        if ($user->isTeacher()) {
            return redirect('/panel');
        }
        if ($user->isOrganization()) {
            return redirect('/panel/enfant');
        }
        if ($user->isEnfant()) {
            return redirect('/panel/enfant');
        }

       
    }

    public function exportExcelOrganizations(Request $request)
    {
        $this->authorize('admin_users_export_excel');

        $users = $this->organizations($request, true);

        $usersExport = new OrganizationsExport($users);

        return Excel::download($usersExport, 'organizations.xlsx');
    }

    public function exportExcelInstructors(Request $request)
    {
        $this->authorize('admin_users_export_excel');

        $users = $this->instructors($request, true);

        $usersExport = new OrganizationsExport($users);

        return Excel::download($usersExport, 'instructors.xlsx');
    }

    public function exportExcelStudents(Request $request)
    {
        $this->authorize('admin_users_export_excel');

        $users = $this->students($request, true);

        $usersExport = new StudentsExport($users);

        return Excel::download($usersExport, 'students.xlsx');
    }

    public function userRegistrationPackage(Request $request, $id)
    {
        $this->authorize('admin_update_user_registration_package');

        $this->validate($request, [
            'instructors_count' => 'nullable|numeric',
            'students_count' => 'nullable|numeric',
            'courses_capacity' => 'nullable|numeric',
            'courses_count' => 'nullable|numeric',
            'meeting_count' => 'nullable|numeric',
        ]);

        $user = User::findOrFail($id);

        if ($user->isOrganization() or $user->isTeacher()) {
            $data = $request->all();

            UserRegistrationPackage::updateOrCreate([
                'user_id' => $user->id,
            ], [
                'instructors_count' => $data['instructors_count'] ?? null,
                'students_count' => $data['students_count'] ?? null,
                'courses_capacity' => $data['courses_capacity'] ?? null,
                'courses_count' => $data['courses_count'] ?? null,
                'meeting_count' => $data['meeting_count'] ?? null,
                'status' => $data['status'],
                'created_at' => time(),
            ]);

            return redirect()->back();
        }

        abort(404);
    }

    public function meetingSettings(Request $request, $id)
    {
        $this->authorize('admin_update_user_meeting_settings');

        $user = User::findOrFail($id);

        if ($user->isOrganization() or $user->isTeacher()) {
            $data = $request->all();

            $user->update([
                "level_of_training" => !empty($data['level_of_training']) ? (new UserLevelOfTraining())->getValue($data['level_of_training']) : null,
                "meeting_type" => $data['meeting_type'] ?? null,
                "group_meeting" => (!empty($data['group_meeting']) and $data['group_meeting'] == 'on'),
                "country_id" => $data['country_id'] ?? null,
                "province_id" => $data['province_id'] ?? null,
                "city_id" => $data['city_id'] ?? null,
                "district_id" => $data['district_id'] ?? null,
                "location" => (!empty($data['latitude']) and !empty($data['longitude'])) ? DB::raw("POINT(" . $data['latitude'] . "," . $data['longitude'] . ")") : null,
            ]);

            $updateUserMeta = [
                "gender" => $data['gender'] ?? null,
                "age" => $data['age'] ?? null,
                "address" => $data['address'] ?? null,
            ];

            foreach ($updateUserMeta as $name => $value) {
                $checkMeta = UserMeta::where('user_id', $user->id)
                    ->where('name', $name)
                    ->first();

                if (!empty($checkMeta)) {
                    if (!empty($value)) {
                        $checkMeta->update([
                            'value' => $value
                        ]);
                    } else {
                        $checkMeta->delete();
                    }
                } else if (!empty($value)) {
                    UserMeta::create([
                        'user_id' => $user->id,
                        'name' => $name,
                        'value' => $value
                    ]);
                }
            }

            return redirect()->back();
        }

        abort(404);
    }
}

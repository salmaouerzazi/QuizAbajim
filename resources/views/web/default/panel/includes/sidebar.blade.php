@php
    $getPanelSidebarSettings = getPanelSidebarSettings();

    $socials = getSocials();
    if (!empty($socials) and count($socials)) {
        $socials = collect($socials)->sortBy('order')->toArray();
    }

    $footerColumns = getFooterColumns();

    $userLanguages = !empty($generalSettings['site_language'])
        ? [$generalSettings['site_language'] => getLanguages($generalSettings['site_language'])]
        : [];

    if (!empty($generalSettings['user_languages']) and is_array($generalSettings['user_languages'])) {
        $userLanguages = getLanguages($generalSettings['user_languages']);
    }

    $localLanguage = [];

    foreach ($userLanguages as $key => $userLanguage) {
        $localLanguage[localeToCountryCode($key)] = $userLanguage;
    }
    use App\User;

@endphp

<style>
    .panel-sidebar .sidebar-menu {

        overflow: auto;
    }

    .modal-backdrop.show {
        opacity: 0 !important;
    }

    .modal-backdrop {
        position: relative;

    }

    .font-14 {
        font-size: 1rem !important;
        font-weight: 600;
        line-height: 1.4;
    }

    @media (max-width: 768px) {
        .img-cover-mobile-hidden {
            display: none;
        }

        .mobile-mt {
            margin-top: 20px;
        }

    }

    * {
        font-family: 'Tajawal', sans-serif;
    }
</style>

<div class=" xs-panel-nav d-flex d-lg-none justify-content-between py-5 px-15">
    <button
        class="sidebar-toggler btn-transparent d-flex flex-column-reverse align-items-center p-16 rounded-sm sidebarNavToggle"
        type="button">
        <span style="padding: 8px;font-color:black">{{ trans('navbar.menu') }}</span>
        <i class="fas fa-bars" width="16" height="16"></i>
    </button>

    <div class="user-info d-flex align-items-center">
        {{-- <div class="nav-icons-or-start-live navbar-order">
            <div class="d-none nav-notify-cart-dropdown top-navbar ">
                @include(getTemplate() . '.includes.notification-dropdown')
            </div>
        </div> --}}
        <img src="/assets/default/icons/logo_min.png" alt="logo" style="width: 40px; height: 50px;">
    </div>

</div>
<div class="panel-sidebar-overlay" id="panel-sidebar-overlay"></div>

<div class="panel-sidebar sidebar pt-50 pb-25 px-25" id="panelSidebar">
    <button class="btn-transparent panel-sidebar-close sidebarNavToggle">
        <i class="fas fa-times" width="24" height="24"></i>
    </button>

    <div class="user-info d-flex align-items-center flex-column flex-lg-column justify-content-lg-center">
        <a href="/panel" id ="ava" class="user-avatar bg-gray200">
            @if (!empty($authUser->avatar))
                <img src="{{ $authUser->getAvatar(100) }}" class="img-cover" alt="{{ $authUser->full_name }}">
            @else
                <img src="{{ $authUser->getAvatar(100) }}" class="img-cover" alt="{{ $authUser->full_name }}">
            @endif
        </a>

        <div class="d-flex flex-row align-items-center justify-content-center">
            <div class="d-flex sidebar-user-stats pb-10 ml-20 pb-lg-20 mt-lg-30">
                <div class="sidebar-user-stat-item d-flex">
                    <a href="/users/{{ $authUser->id }}/profile" class="user-name ">
                        <h3 class="font-14 font-weight-bold text-center">{{ $authUser->full_name }}</h3>
                    </a>

                </div>

                <div class="border-left mx-5"></div>
                <div class="sidebar-user-stat-item d-flex flex-column">
                    <span data-toggle="modal" data-target="#exampleModal1"
                        style="background: none; border: none; color: inherit; cursor: pointer;">
                        <strong class="text-center">
                            {{ DB::table('teachers')->where('teacher_id', $authUser->id)->count() }}
                        </strong>
                        <span class="font-12">{{ trans('panel.followers') }}</span>
                    </span>

                </div>
            </div>

            @if (!empty($authUser->getUserGroup()))
                <span class="create-new-user mt-10">{{ $authUser->getUserGroup()->name }}</span>
            @endif
        </div>
    </div>
    <ul id="panel-sidebar-scroll"
        class="sidebar-menu @if (!empty($authUser->userGroup)) has-user-group @endif @if (empty($getPanelSidebarSettings) or empty($getPanelSidebarSettings['background'])) without-bottom-image @endif"
        @if (!empty($isRtl) and $isRtl) data-simplebar-direction="rtl" @endif>
        <li class="sidenav-item">

            @if (!empty($levelMaterials))
                <div class="mb-3">
                    <a href="#mainLevelsCollapse"
                        class="d-flex justify-content-between align-items-center text-dark-blue text-decoration-none mainLevelsCollapse"
                        style="cursor: pointer; font-size: 1rem; font-weight: 600; padding: 10px 15px; border-radius: 5px; background-color: #f8f9fa;"
                        data-toggle="collapse" aria-expanded="false" aria-controls="mainLevelsCollapse">
                        <span>{{ trans('public.levels') }}</span>
                        <i class="fa fa-chevron-down" style="font-size: 14px; transition: transform 0.3s;"></i>
                    </a>
                    <div class="collapse" id="mainLevelsCollapse">
                        @foreach ($levelMaterials as $levelName => $materials)
                            <div class="mt-2">
                                <a href="#collapse{{ Str::slug($levelName) }}"
                                    class="d-flex justify-content-between align-items-center text-dark-blue text-decoration-none"
                                    style="cursor: pointer; font-size: 0.9rem; font-weight: 500; padding: 8px 10px; border-radius: 5px; background-color: #f1f3f5;"
                                    data-toggle="collapse" aria-expanded="false"
                                    aria-controls="collapse{{ Str::slug($levelName) }}">
                                    <span>{{ $levelName }}</span>
                                    <i class="fa fa-chevron-down"
                                        style="font-size: 12px; transition: transform 0.3s;"></i>
                                </a>
                                <div class="collapse" id="collapse{{ Str::slug($levelName) }}">
                                    <div class="d-flex flex-wrap" style="gap: 10px; padding-top: 10px;">
                                        @foreach ($materials as $material)
                                            @if (!empty($material))
                                                <a href="#{{ Str::slug($material) }}" class="badge badge-secondary"
                                                    style="font-size: 0.85rem; padding: 6px 12px; cursor: pointer;">
                                                    {{ $material }}
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </li>

        <li class="sidenav-item {{ request()->is('panel') ? 'sidenav-item-active' : '' }}">
            <a href="/panel" class="d-flex align-items-center">
                <span class="sidenav-item-icon mr-10">
                    @include('web.default.panel.includes.sidebar_icons.dashboard')
                </span>
                <span class="font-14 text-dark-blue font-weight-500">{{ trans('panel.dashboard') }}</span>
            </a>
        </li>
        <li class="sidenav-item {{ request()->is('panel/scolaire/teacher/mychaine') ? 'sidenav-item-active' : '' }}">
            <a href="/panel/scolaire/teacher/mychaine" class="d-flex align-items-center">
                <span class="sidenav-item-icon mr-10">
                    @include('web.default.panel.includes.sidebar_icons.requests')
                </span>
                <span class="font-14 text-dark-blue font-weight-500">{{ trans('panel.my_channel') }}</span>
            </a>
        </li>
       
                <span class="sidenav-item-icon mr-10">
                    @include('web.default.panel.includes.sidebar_icons.webinars')
                </span>
                <span class="font-14 text-dark-blue font-weight-500">{{ trans('public.additional_courses') }}</span>
            </a>
        </li>

        @if (getFeaturesSettings('webinar_assignment_status'))
            <li
                class="sidenav-item {{ (request()->is('panel/assignments') or request()->is('panel/assignments/*')) ? 'sidenav-item-active' : '' }}">
                <a class="d-flex align-items-center" data-toggle="collapse" href="#assignmentCollapse" role="button"
                    aria-expanded="false" aria-controls="assignmentCollapse">
                    <span class="sidenav-item-icon mr-10">
                        @include('web.default.panel.includes.sidebar_icons.assignments')
                    </span>
                    <span class="font-14 text-dark-blue font-weight-500">{{ trans('update.assignments') }}</span>
                </a>

                <div class="collapse {{ (request()->is('panel/assignments') or request()->is('panel/assignments/*')) ? 'show' : '' }}"
                    id="assignmentCollapse">
                    <ul class="sidenav-item-collapse">

                        <li class="mt-5 {{ request()->is('panel/assignments/my-assignments') ? 'active' : '' }}">
                            <a href="/panel/assignments/my-assignments">{{ trans('update.my_assignments') }}</a>
                        </li>

                        @if ($authUser->isOrganization() || $authUser->isTeacher())
                            <li
                                class="mt-5 {{ request()->is('panel/assignments/my-courses-assignments') ? 'active' : '' }}">
                                <a
                                    href="/panel/assignments/my-courses-assignments">{{ trans('update.students_assignments') }}</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </li>
        @endif
        <li
            class="sidenav-item {{ (request()->is('panel/meetings') or request()->is('panel/meetings/*')) ? 'sidenav-item-active' : '' }}">
            <a class="d-flex align-items-center" href="/panel/meetings/settings" {{-- data-toggle="collapse" href="#meetingCollapse" role="button"
                aria-expanded="false" aria-controls="meetingCollapse" --}}>
                <span class="sidenav-item-icon mr-10">
                    @include('web.default.panel.includes.sidebar_icons.assignments')
                </span>
                <span class="font-14 text-dark-blue font-weight-500">{{ trans('panel.meetings') }}</span>
            </a>

            {{-- <div class="collapse {{ (request()->is('panel/meetings') or request()->is('panel/meetings/*')) ? 'show' : '' }}"
                id="meetingCollapse">
                <ul class="sidenav-item-collapse">
                    <li class="mt-5 {{ request()->is('panel/meetings/requests') ? 'active' : '' }}">
                        <a href="/panel/meetings/requests">{{ trans('panel.requests') }}</a>
                    </li>
                    <li class="mt-5 {{ request()->is('panel/meetings/settings') ? 'active' : '' }}">
                        <a href="/panel/meetings/settings">{{ trans('panel.settings') }}</a>
                    </li>
                </ul>
            </div> --}}
        </li>
        
        <li
            class="sidenav-item {{ (request()->is('panel/quizzes') or request()->is('panel/quizzes/*')) ? 'sidenav-item-active' : '' }}">
            <a class="d-flex align-items-center" data-toggle="collapse" href="#quizCollapse" role="button"
                aria-expanded="false" aria-controls="quizCollapse">
                <span class="sidenav-item-icon mr-10" >
                    <i class="fas fa-question-circle" style="color: var(--primary);min-width:0%"></i>
                </span>
                <span class="font-14 text-dark-blue font-weight-500">{{ trans('panel.quiz') }}</span>
            </a>
            <div class="collapse {{ (request()->is('panel/quizzes') or request()->is('panel/quizzes/*')) ? 'show' : '' }}"
                id="quizCollapse">
                <ul class="sidenav-item-collapse">
                    <li class="mt-5 {{ request()->is('panel/quizzes') ? 'active' : '' }}">
                        <a href="/panel/quizzes">
                            <span class="sidenav-item-icon mr-10">
                                <i class="fas fa-question-circle" style="color: var(--primary); font-size: 20px; width: 20px;min-width:0%"></i>
                            </span>
                            <span>{{ trans('panel.quizzes') }}</span>
                        </a>
                    </li>

                </ul>
            </div>
        </li>

        @if ($authUser->checkCanAccessToStore())
            <li
                class="sidenav-item {{ (request()->is('panel/store') or request()->is('panel/store/*')) ? 'sidenav-item-active' : '' }}">
                <a class="d-flex align-items-center" data-toggle="collapse" href="#storeCollapse" role="button"
                    aria-expanded="false" aria-controls="storeCollapse">
                    <span class="sidenav-item-icon assign-fill mr-10">
                        @include('web.default.panel.includes.sidebar_icons.store')
                    </span>
                    <span class="font-14 text-dark-blue font-weight-500">{{ trans('update.store') }}</span>
                </a>

                <div class="collapse {{ (request()->is('panel/store') or request()->is('panel/store/*')) ? 'show' : '' }}"
                    id="storeCollapse">
                    <ul class="sidenav-item-collapse">
                        @if ($authUser->isOrganization() || $authUser->isTeacher())
                            <li class="mt-5 {{ request()->is('panel/store/products/new') ? 'active' : '' }}">
                                <a href="/panel/store/products/new">{{ trans('update.new_product') }}</a>
                            </li>

                            <li class="mt-5 {{ request()->is('panel/store/products') ? 'active' : '' }}">
                                <a href="/panel/store/products">{{ trans('update.products') }}</a>
                            </li>

                            @php
                                $sellerProductOrderWaitingDeliveryCount = $authUser->getWaitingDeliveryProductOrdersCount();
                            @endphp

                            <li class="mt-5 {{ request()->is('panel/store/sales') ? 'active' : '' }}">
                                <a href="/panel/store/sales">{{ trans('panel.sales') }}</a>

                                @if ($sellerProductOrderWaitingDeliveryCount > 0)
                                    <span
                                        class="d-inline-flex align-items-center justify-content-center font-weight-500 ml-15 panel-sidebar-store-sales-circle-badge">{{ $sellerProductOrderWaitingDeliveryCount }}</span>
                                @endif
                            </li>

                        @endif

                        <li class="mt-5 {{ request()->is('panel/store/purchases') ? 'active' : '' }}">
                            <a href="/panel/store/purchases">{{ trans('panel.my_purchases') }}</a>
                        </li>
                    </ul>
                </div>
            </li>
        @endif
        @php
            $rewardSetting = getRewardsSettings();
        @endphp
        <li class="sidenav-item {{ request()->is('panel/setting') ? 'sidenav-item-active' : '' }}">
            <a href="/panel/setting" class="d-flex align-items-center">
                <span class="sidenav-setting-icon sidenav-item-icon mr-10">
                    @include('web.default.panel.includes.sidebar_icons.setting')
                </span>
                <span class="font-14 text-dark-blue font-weight-500">{{ trans('panel.settings') }}</span>
            </a>
        </li>
        <li class="sidenav-item">
            <a href="/logout" class="d-flex align-items-center">
                <span class="sidenav-logout-icon sidenav-item-icon mr-10">
                    @include('web.default.panel.includes.sidebar_icons.logout')
                </span>
                <span class="font-14 text-dark-blue font-weight-500">{{ trans('panel.log_out') }}</span>
            </a>
        </li>

    </ul>
    <form action="/locale" method="post" class="mr-15 mx-md-20">
        {{ csrf_field() }}

        <input type="hidden" name="locale">

        <div class="language-select1">
            <div id="localItems" data-selected-country="{{ localeToCountryCode(mb_strtoupper(app()->getLocale())) }}"
                data-countries='{{ json_encode($localLanguage) }}'></div>
        </div>
    </form>
    <div>
    </div>

</div>

<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="followersModalLabel"
    aria-hidden="true" style="backdrop-filter: blur(10px);background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="justify-content: space-between; display: flex; align-items: center;">
                <h5 class="modal-title" id="followersModalLabel" style="margin-left: auto;">
                    {{ trans('panel.followers') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <input class="form-control" type="text" id="searchFollowers"
                placeholder="{{ trans('navbar.search_follower') }}"
                style="width:90%;margin:10px auto;border-radius:10px;padding:10px;" />

            <div class="modal-body" style="max-height: 400px; overflow-y: auto;">

                <ul id="followersList" class="list-group">
                    @php
                        $followers = DB::table('teachers')
                            ->where('teacher_id', $authUser->id)
                            ->orderBy('created_at', 'desc')
                            ->get()
                            ->map(function ($follower) {
                                $follower->followerUser = \App\User::find($follower->users_id);
                                return $follower;
                            })
                            ->groupBy(function ($follower) {
                                return $follower->followerUser->organ_id;
                            });
                    @endphp

                    @foreach ($followers as $organId => $followerGroup)
                        @php
                            $parent = $organId ? \App\User::find($organId) : null;
                        @endphp

                        <!-- Parent  -->
                        <li class="list-group-item"
                            style="display: flex; justify-content: space-between; align-items: center; padding: 10px; border-radius: 5px;margin:5px">
                            <div style="display: flex; align-items: center;">
                                @if (!empty($parent))
                                    <img src="{{ $parent->getAvatar(50) }}" class="img-cover"
                                        style="border-radius: 50%; width: 40px; height: 40px;"
                                        alt="{{ $parent->full_name }}">

                                    <span>{{ $parent->full_name }}</span>
                                @endif
                            </div>
                            <button class="btn btn-link btn-sm" data-toggle="collapse"
                                data-target="#collapseFollowers{{ $organId ?? 'no_parent' }}" aria-expanded="false"
                                aria-controls="collapseFollowers{{ $organId ?? 'no_parent' }}">
                                <i class="fa fa-chevron-down"></i>
                            </button>
                        </li>

                        <!-- Children (Followers) -->
                        <div class="collapse" id="collapseFollowers{{ $organId ?? 'no_parent' }}">
                            <ul class="list-group p-10">
                                @foreach ($followerGroup as $follower)
                                    <li class="list-group-item">
                                        <div style="display: flex; align-items: center;">
                                            <img src="{{ $follower->followerUser->getAvatar(50) }}" class="img-cover"
                                                style="border-radius: 50%; width: 40px; height: 40px;"
                                                alt="{{ $follower->followerUser->full_name }}">
                                            <span>{{ $follower->followerUser->full_name }}</span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

@push('scripts_bottom')
    <link href="/assets/default/vendors/flagstrap/css/flags.css" rel="stylesheet">
    <script>
        var appTranslations = {
            changeLanguage: "{{ __('languages.change_language') }}",
        };
    </script>

    <script src="/assets/default/vendors/flagstrap/js/jquery.flagstrap.min.js"></script>
    <script src="/assets/default/js/parts/top_nav_flags.min.js"></script>
    <!-- SCRIPT FOR SEARCHING FOLLOWERS -->
    <script>
        document.getElementById('searchFollowers').addEventListener('input', function() {

            var searchValue = this.value.toLowerCase();
            var listItems = document.querySelectorAll('#followersList li');
            listItems.forEach(function(item) {
                var name = item.querySelector('div[data-name]').getAttribute('data-name').toLowerCase();
                if (name.includes(searchValue)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });
        document.getElementById('searchFollowers').addEventListener('input', function() {
            const searchValue = this.value.toLowerCase();
            const parentGroups = document.querySelectorAll('#followersList > li');

            parentGroups.forEach(function(parentGroup) {
                const collapseTarget = parentGroup.querySelector('button[data-toggle="collapse"]')?.dataset
                    .target;
                const collapseContent = document.querySelector(collapseTarget);

                const parentName = parentGroup.querySelector('span').textContent.toLowerCase();
                const children = collapseContent?.querySelectorAll('li') || [];
                let groupVisible = false;

                if (parentName.includes(searchValue)) {
                    groupVisible = true;
                }

                children.forEach(function(child) {
                    const childName = child.textContent.toLowerCase();
                    if (childName.includes(searchValue)) {
                        groupVisible = true;
                        child.style.display = 'flex';
                    } else {
                        child.style.display = 'none';
                    }
                });

                if (groupVisible) {
                    parentGroup.style.display = 'flex';
                    collapseContent?.classList.add('show');
                } else {
                    parentGroup.style.display = 'none';
                    collapseContent?.classList.remove('show');
                }
            });
        });
    </script>
@endpush

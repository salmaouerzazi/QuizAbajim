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
@endphp

@push('styles_top')
    <link rel="stylesheet" href="/store/style.css">
    <link ref="stylesheet" href="/assets/default/css/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/default/css/lisr_free_parser.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
@endpush

<style>
    .success {
        color: #22db72;
        margin-left: 10px;
    }

    .svg-inline--fa {
        display: inline-block;
        font-size: inherit;
        height: 1em;
        overflow: visible;
        vertical-align: -.125em;
    }

    .font-14 {
        font-size: 1rem !important;
        font-weight: 600;
        line-height: 1.4;
    }

    .panel-sidebar {
        box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.1);
    }

    .vertical-separator {
        border-left: 1px solid #ccc;
        height: 24px;
        display: inline-block;
    }

    * {
        font-family: Tajawal, sans-serif;
    }

    .xs-panel-nav {
        top: 0;
    }

    .pack-sidebar-item {
        margin-top: 20px;
    }

    .modal-content {
        margin-top: 0 !important;
        margin-right: 0 !important;
    }

    .starburst {
        position: absolute;
        top: 35px;
        right: 40px;
        width: 65px;
        height: 65px;
        background-color: #e74c3c;
        color: white;
        text-align: center;
        line-height: 65px;
        font-weight: bold;
        font-size: 13px;
        clip-path: polygon(98.54% 62%, 88.4% 69.35%, 88.53% 81.87%, 76.2% 84.09%, 70.88% 95.43%, 58.81% 92.09%, 49.1% 99.99%, 39.68% 91.74%, 27.5% 94.65%, 22.59% 83.13%, 10.36% 80.47%, 10.93% 67.96%, 1.06% 60.25%, 7.01% 49.23%, 1.46% 38%, 11.6% 30.65%, 11.47% 18.13%, 23.8% 15.91%, 29.12% 4.57%, 41.19% 7.91%, 50.9% 0.01%, 60.32% 8.26%, 72.5% 5.35%, 77.41% 16.87%, 89.64% 19.53%, 89.07% 32.04%, 98.94% 39.75%, 92.99% 50.77%);
        z-index: 1;
    }

    .ribbon {
        position: absolute;
        left: -10px;
        top: -10px;
        z-index: 1;
        overflow: hidden;
        width: 120px;
        height: 120px;
        text-align: left;
    }

    .ribbon span {
        font-size: 15px;
        color: #fff;
        text-transform: uppercase;
        text-align: center;
        font-weight: bold;
        line-height: 30px;
        transform: rotate(-45deg);
        -webkit-transform: rotate(-45deg);
        width: 160px;
        display: flex;
        justify-content: center;
        align-items: center;
        background: #7377f9;
        box-shadow: 0 5px 15px -5px rgba(0, 0, 0, 0.75);
        position: absolute;
        top: 32px;
        left: -42px;
    }

    .price-container {
        text-align: center;
        font-size: 24px;
    }

    .pack-price {
        font-weight: bold;
    }

    .old-price {
        color: #888;
        position: relative;
        font-size: 20px;
    }

    .old-price::after {
        content: "";
        position: absolute;
        left: -10px;
        top: 50%;
        width: 125%;
        height: 2px;
        background-color: red;
        transform: rotate(-5deg);
    }

    .new-price {
        color: #2c3e50;
        display: block;
    }

    .subscribe-btn-container {
        position: relative;
        text-align: center;
    }

    .btn-subscribe {
        border-radius: 25px;
        position: relative;
        background-color: #1d3b65;
        color: #fff;
        font-size: 15px;
        font-weight: bold;
        margin: 5px auto;
        display: block;
        width: 80%;
    }

    .subscribe-btn-img {
        width: 100px;
        position: absolute;
        top: -45px;
        left: 0;
        z-index: 22;
    }

    .btn-subscribe:hover {
        background-color: #7f8bc2;
        color: #fff;
    }

    .percent {
        font-size: 20px;
        font-weight: bold;
        color: #fff;
        position: absolute;
        top: 40%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .text-percent {
        font-size: 15px;
        color: #fff;
        position: absolute;
        top: 45%;
        left: 50%;
        transform: translate(-50%, -50%);
        bottom: 0;
    }

    /* Show the `pack-sidebar-item` only on mobile devices (max-width: 576px) */
    @media (max-width: 576px) {
        .pack-sidebar-item {
            display: block;
        }
    }
</style>
<style>
    .upload-label {
        cursor: pointer;
        display: block;
        padding: 20px;
        transition: all 0.3s ease;
    }

    .upload-label:hover {
        background: #f8f9fa;
        border-color: #007bff;
    }

    .upload-icon {
        margin-bottom: 15px;
    }

    .upload-text h6 {
        margin-bottom: 5px;
        color: #2c3e50;
    }

    .file-upload-area {
        border: 2px dashed #ced4da;
        transition: border-color 0.3s ease;
        border-radius: 8px;
    }

    .file-upload-area:hover {
        border-color: var(--primary);
    }

    .card {
        padding: 15px;
        border: 2px solid #dee2e6;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .card.selected {
        border: 3px solid var(--primary);
        background: #e7f0ff;
    }

    .card:hover {
        transform: translateY(-2px);
    }

    .card-list {
        margin-bottom: 0 !important;
    }

    .wrapper {
        padding: 0px;
        box-shadow: none;
    }

    .plan-option {
        border: 2px solid #ddd;
        border-radius: 8px;
        padding: 10px 15px;
        margin-bottom: 10px;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: border-color 0.2s, background-color 0.2s;
    }

    .plan-option:hover {
        border-color: #aaa;
    }

    .plan-option.selected {
        border-color: #007bff;
        background: #eef4ff;
    }

    .plan-selection {
        margin: 5px;
        gap: 10px;
    }

    .plan-option {
        width: 100%
    }

    @media (min-width: 992px) {

        .modal-lg,
        .modal-xl {
            max-width: 900px;
        }
    }
</style>

<div class="xs-panel-nav d-flex d-lg-none py-5 px-15" style="justify-content: space-between">
    <div class="justify-content-start d-flex">
        <button
            class="sidebar-toggler btn-transparent d-flex flex-column-reverse align-items-center p-16 rounded-sm sidebarNavToggle"
            type="button">
            <span style="padding: 8px;font-color:black">{{ trans('navbar.menu') }}</span>
            <i data-feather="menu" width="16" height="16"></i>
        </button>
    </div>
    @php
        $userparent = \App\User::where('id', $authUser->organ_id)->orWhere('id', $authUser->id)->first();
        $countenfant = \App\User::where('organ_id', $userparent->id)->count();
        if ($userparent) {
            $enfant = \App\User::where('organ_id', $userparent->id)->get();
        }
    @endphp

    <?php
    $userparent = \App\User::where('id', $authUser->organ_id)->get();
    $idOrgan = \App\User::where('id', $authUser->id)->pluck('organ_id');
    $userLevelName = DB::table('school_levels')->where('id', $authUser->level_id)->pluck('name');
    ?>
    <div class="justify-content-end d-flex">
        <ul class="avatars">
            @if (!empty($enfant))
                @if ($countenfant < 4)
                    <li class="avatars__item">
                        <span class="avatars__others" data-toggle="modal" data-target="#exampleModal"
                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                            title="{{ trans('panel.add_child_here') }}">+</span>
                    </li>
                @endif
                @foreach ($enfant as $enf)
                    <a href="/panel/impersonate/user/{{ $enf->id }}">
                        <li class="avatars__item child-name" data-level-path="{{ $enf->path }}">
                            <img src="{{ $enf->getAvatar() }}" class="avatars__img"
                                style="@if ($enf->id !== $authUser->id) scale: 0.8; @endif" data-bs-toggle="tooltip"
                                data-bs-placement="bottom" data-bs-html="true" title="{{ $enf->full_name }}" />
                            @if ($enf->id == $authUser->id)
                                <span class="online-dot"></span>
                            @endif
                        </li>
                    </a>
                @endforeach
            @endif
        </ul>
        <a type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
            class="navbar-user d-flex align-items-center ml-50 justify-content-end">
            @if (!empty($userparent[0]->avatar))
                <img src="{{ $userparent[0]->avatar }}" class="rounded-circle mobile-avatar" width="50px"
                    height="50px" alt="{{ $userparent[0]->full_name }}">
            @else
                <img src="{{ $userparent[0]->getAvatar(100) }}" class="rounded-circle mobile-avatar" width="50px"
                    height="50px" alt="{{ $userparent[0]->full_name }}">
            @endif
        </a>
        <div class="dropdown-menu user-profile-dropdown" aria-labelledby="dropdownMenuButton">
            <span class="font-16 user-name ml-10 text-dark-blue font-16">{{ $userparent[0]->full_name }}</span>
            <hr class="mt-10 mb-10">
            <a class="dropdown-item" href="{{ route('parent.setting', ['user_id' => $authUser->id]) }}">
                @include('web.default.panel.includes.sidebar_icons.setting')
                <span class="font-16 text-dark-blue">{{ trans('panel.settings') }}</span>
            </a>
            <a class="dropdown-item" href="/logout">
                <img src="/assets/default/img/icons/sidebar/logout.svg" width="25" alt="nav-icon">
                <span class="font-16 text-dark-blue">{{ trans('panel.log_out') }}</span>
            </a>
        </div>
    </div>
</div>

<div class="panel-sidebar-overlay" id="panel-sidebar-overlay"></div>
<div class="panel-sidebar pt-50 pb-25 px-25" id="panelSidebar">
    <button class="btn-transparent panel-sidebar-close sidebarNavToggle">
        <i data-feather="x" width="24" height="24"></i>
    </button>

    <div class="user-info d-flex align-items-center flex-column flex-lg-column justify-content-lg-center">
        <a href="/panel/enfant" id="ava" class="user-avatar bg-gray200">
            <img src="{{ $authUser->getAvatar(100) }}" class="img-cover" id="pathpath"
                alt="{{ $authUser->full_name }}">
        </a>

        <div class="d-flex flex-row align-items-center justify-content-center mt-15">
            <a href="/panel/enfant" class="user-name">
                <h3 class="font-16 font-weight-bold text-center" id="useruser">{{ $authUser->full_name }}</h3>
            </a>
            <span class="vertical-separator mx-2"></span>
            <div class="sidebar-user-stat-item d-flex flex-column text-center">
                <span data-target="#followingModal"
                    style="background: none; border: none; color: inherit; cursor: pointer;"
                    @if (isset($sortedFollowers) && $sortedFollowers->count() > 0) data-toggle="modal" @endif>
                    <strong
                        id="followingCount">{{ DB::table('teachers')->where('users_id', $authUser->id)->count() }}</strong>
                    <span class="font-12">{{ trans('panel.following') }}</span>
                </span>
            </div>
        </div>

        @if (!empty($userLevelName[0]))
            <div class="mt-10">
                <p class="font-13">{{ $userLevelName[0] }} </p>
            </div>
        @endif

        @if (!empty($authUser->getUserGroup()))
            <span class="create-new-user mt-10">{{ $authUser->getUserGroup()->name }}</span>
        @endif
    </div>

    <ul id="panel-sidebar-scroll"
        class="sidebar-menu pt-10 @if (!empty($authUser->userGroup)) has-user-group @endif 
               @if (empty($getPanelSidebarSettings) or empty($getPanelSidebarSettings['background'])) without-bottom-image @endif"
        @if (!empty($isRtl) and $isRtl) data-simplebar-direction="rtl" @endif>

        <li class="sidenav-item {{ request()->is('panel/enfant') ? 'sidenav-item-active' : '' }}">
            <a href="/panel/enfant" class="d-flex align-items-center">
                <span class="sidenav-item-icon mr-10">
                    @include('web.default.panel.includes.sidebar_icons.books')
                </span>
                <span class="font-14 text-dark-blue font-weight-500">{{ trans('panel.books') }}</span>
            </a>
        </li>

        <li
            class="sidenav-item {{ (request()->is('panel/webinars') or request()->is('panel/webinars/*')) ? 'sidenav-item-active' : '' }}">
            <a class="d-flex align-items-center" href="/panel/webinars/allcourses">
                <span class="sidenav-item-icon mr-10">
                    @include('web.default.panel.includes.sidebar_icons.webinars')
                </span>
                <span class="font-14 text-dark-blue font-weight-500">{{ trans('panel.webinars') }}</span>
            </a>
        </li>
        <li
            class="sidenav-item {{ request()->is('panel/enfant/concours') or request()->is('panel/enfant/concours/*') }}">
            <a class="d-flex align-items-center position-relative" href="/panel/enfant/concours"
                style="background: linear-gradient(135deg, #17134780 50%, #25BEC8); border-radius: 2%;">

                <!-- Red "New" Badge -->
                <span class="position-absolute"
                    style="
                    height: 31px;
                    width: 31px;
                    background-color: red;
                    color: white;
                    font-size: 11px;
                    font-weight: bold;
                    padding: 6px 5px;
                    border-radius: 50%;
                    left: -10px;
                    top: -7px;
                    transform: rotate(-20deg);
                ">
                    جديد
                </span>
                <span class="sidenav-item-icon mr-10">
                    @include('web.default.panel.includes.sidebar_icons.concours')
                </span>
                <span class="font-14 text-white font-weight-500">{{ trans('panel.concours') }}</span>
            </a>
        </li>

        @if (getFeaturesSettings('webinar_assignment_status'))
            <li
                class="sidenav-item {{ (request()->is('panel/assignments') or request()->is('panel/assignments/*')) ? 'sidenav-item-active' : '' }}">
                <a class="d-flex align-items-center" data-toggle="collapse" href="#assignmentCollapse"
                    role="button" aria-expanded="false" aria-controls="assignmentCollapse">
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
                    </ul>
                </div>
            </li>
        @endif

        <li class="sidenav-item {{ request()->is('panel/wallet') ? 'sidenav-item-active' : '' }}">
            <a href="/panel/wallet" class="d-flex align-items-center">
                <span class="sidenav-item-icon mr-10">
                    @include('web.default.panel.includes.sidebar_icons.wallet')
                </span>
                <span class="font-14 text-dark-blue font-weight-500 font-14">{{ trans('panel.wallet') }}</span>
            </a>
        </li>

        <li class="sidenav-item {{ request()->is('panel/setting') ? 'sidenav-item-active' : '' }}">
            <a href="/panel/setting" class="d-flex align-items-center">
                <span class="sidenav-setting-icon sidenav-item-icon mr-10">
                    @include('web.default.panel.includes.sidebar_icons.setting')
                </span>
                <span class="font-14 text-dark-blue font-weight-500">{{ trans('panel.settings') }}</span>
            </a>
        </li>

        @if ($authUser->isEnfant())
            @if ($hasSubscribePack)
                @if (isset($pack))
                    <li class="sidenav-item pack-sidebar-item d-lg-none">
                        <div class="pack-card" style="max-width:175px;height:100px">
                            <div class="pack-card-image">
                                <img src="/{{ $pack->icon }}" alt="Pack Icon" style="width: 85px;">
                            </div>
                            <div class="pack-card-content">
                                <div class="pack-card-title">
                                    <h4 style="font-size: 0.9rem;">الإشتـــــــــراك</h4>
                                </div>
                                <p class="pack-title">{{ $pack->title }}</p>
                                <p class="pack-subtitle">
                                    {{ \Carbon\Carbon::now()->addDays($pack->days)->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </li>
                @endif
            @else
                <li class="sidenav-item no-pack-sidebar-item d-lg-none">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#subscriptionModal">
                        <div class="no-pack-card" style="max-width:175px;height:100px">
                            <div class="no-pack-image">
                                <img src="/assets/default/img/gift.png" alt="Subscribe Now">
                            </div>
                            <div class="no-pack-content" style="z-index: 22;">
                                <img src="/assets/default/img/subscribe-text.png" alt="Subscribe Now"
                                    style="width: 87%">
                            </div>
                        </div>
                    </a>
                </li>
            @endif
        @endif
    </ul>

</div>
<div class="modal fade" id="followingModal" tabindex="-1" role="dialog" aria-labelledby="followingsModalLabel"
    aria-hidden="true" style="backdrop-filter: blur(10px);background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="margin-top: 0;margin-right:0">
            <div class="modal-header" style="justify-content: space-between; display: flex; align-items: center;">
                <h5 class="modal-title" id="followersModalLabel" style="margin-left: auto;">
                    {{ trans('panel.followings') }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <input class="form-control" type="text" id="searchFollowers"
                placeholder={{ trans('navbar.search_follower') }}
                style="width:90%;margin:10px auto;border-radius:10px;padding:10px;" />
            <div class="modal-body" style="max-height: 500px;min-height:400px; overflow-y: auto;">
                <ul id="followersList" class="list-group">
                    @if (isset($sortedFollowers) && $sortedFollowers->count() > 0)
                        @foreach ($sortedFollowers as $follower)
                            <a href="/users/{{ $follower->followerUser->id }}/profile">
                                <li class="list-group-item"
                                    style="display: flex; justify-content: space-between; align-items: flex-start; padding: 10px">
                                    <div style="display: flex; align-items: center;"
                                        data-name="{{ $follower->followerUser->full_name }}">
                                        @if (!empty($follower->followerUser->avatar))
                                            <img src="{{ $follower->followerUser->getAvatar(100) }}"
                                                class="img-cover"
                                                style="border-radius: 50%; width: 50px; height: 50px;"
                                                alt="{{ $follower->followerUser->full_name }}">
                                        @else
                                            <img src="{{ $follower->followerUser->getAvatar(100) }}"
                                                class="img-cover" alt="{{ $follower->followerUser->full_name }}"
                                                data-default-avatar="{{ $follower->followerUser->getAvatar(100) }}"
                                                style="border-radius: 50%; width: 50px; height: 50px;">
                                        @endif
                                        <p style="color: #000;font-size: 16px;margin-right: 10px">
                                            {{ $follower->followerUser->full_name }}
                                        </p>
                                    </div>
                                    <span class="badge badge-primary badge-pill p-5"
                                        id="followerCount_{{ $follower->followerUser->id }}">
                                        {{ trans('panel.followers') }}
                                        {{ DB::table('teachers')->where('teacher_id', $follower->followerUser->id)->count() }}
                                    </span>
                                </li>
                            </a>
                        @endforeach
                    @else
                        <li class="list-group-item">No followers found.</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- ------------- SUBSCRIPTION MODAL ------------- -->
<div class="modal fade" id="subscriptionModal" tabindex="-1" aria-labelledby="subscriptionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content upgrade-modal-container shadow rounded-lg">
            <button type="button" class="close d-flex justify-content-end" data-bs-dismiss="modal"
                aria-label="Close">
                <span>&times;</span>
            </button>
            <div class="starburst">
                <span class="percent">60%</span>
                <span class="text-percent">خصم</span>
            </div>
            <div class="modal-body py-4 px-4">
                <div class="subscribe-plan flex-grow-1 d-flex flex-column rounded-sm pt-50 pb-20 px-20"
                    style="background-color: #f3f3ff; border: 10px solid #9aaad8;">
                    <div class="ribbon"><span>عرض خاص</span></div>
                    <h3 class="text-secondary text-center font-weight-bold font-20"
                        style="margin-bottom: 20px; align-self: center;">
                        الكرطابلة
                    </h3>
                    <img src="/assets/default/img/bag.png"
                        style="margin: 0 auto; display: block; align-self: center; height: 150px;" />
                    <div class="price-container">
                        <span class="old-price pack-price">300 د.ت </span>
                        <span class="new-price pack-price">120 د.ت </span>
                    </div>
                    <div class="mt-15" style="margin: 0 1rem; font-size: 0.9rem; line-height: 1.5;">
                        <p style="display: flex;">
                            <i class="fas fa-check" style="color: green; margin-left: 0.5rem;"></i>
                            @php
                                $namelevel = DB::table('school_levels')
                                    ->where('id', $authUser->level_id)
                                    ->pluck('name')
                                    ->first();
                            @endphp
                            فيديوهات تفسير وإصلاح كامل تمارين الكتب لكل مواد السّنة {{ $namelevel }}
                        </p>
                    </div>
                    <div class="subscribe-btn-container mt-30">
                        <img class="subscribe-btn-img" src="/assets/default/img/subscribe-btn.webp" />
                        <button class="btn btn-subscribe" aria-label="Subscribe" data-bs-dismiss="modal"
                            onClick="openPaymentModal();">
                            {{ trans('home.subscribe_now') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ------------- PAYMENT MODAL ------------- -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-secondary">{{ trans('panel.subscription_plan') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <h6 class="my-3">{{ trans('panel.payment_method') }}</h6>
                <div class="row">
                    <!-- AbaJim Card -->
                    <div class="col-6 col-lg-4 mb-20 charge-account-radio">
                        <input type="radio" class="online-gateway" name="gateway" id="abajim_card" checked
                            value="abajim_card" onclick="showSubOptions('abajim_card')">
                        <label for="abajim_card" style="height:100%"
                            class="rounded-sm d-flex flex-column align-items-center justify-content-center">
                            <img src="/abajimcard1.png" style="border-radius: 8px" width="50%" alt="">
                            <p class="mt-10 font-14 font-weight-500 text-dark-blue">
                                {{ trans('financial.pay_via') }}
                                <span class="font-weight-medium">{{ trans('panel.abajim_card') }}</span>
                            </p>
                        </label>
                    </div>

                    <!-- Bank Transfer -->
                    <div class="col-6 col-lg-4 mb-20 charge-account-radio">
                        <input type="radio" class="online-gateway" name="gateway" id="bank_transfer"
                            value="bank_transfer" onclick="showSubOptions('bank_transfer')">
                        <label for="bank_transfer" style="height:100%"
                            class="rounded-sm d-flex flex-column align-items-center justify-content-center">
                            <img src="/assets/default/icons/logoAttijari.png" width="50%" alt="">
                            <p class="mt-10 font-14 font-weight-500 text-dark-blue">
                                {{ trans('financial.pay_via') }}
                                <span class="font-weight-medium">{{ trans('panel.bank_or_post_transfer') }}</span>
                            </p>
                        </label>
                    </div>

                    <!-- Wallet -->
                    <div class="col-6 col-lg-4 mb-20 charge-account-radio">
                        <input type="radio" class="online-gateway" name="gateway" id="wallet" value="wallet"
                            disabled>
                        <label for="wallet" style="height:100%"
                            class="rounded-sm d-flex flex-column align-items-center justify-content-center">
                            <img src="/assets/default/icons/wallet.png" width="50%" alt="">
                            <p class="mt-10 font-14 font-weight-500 text-dark-blue">
                                {{ trans('financial.pay_via') }}
                                <span class="font-weight-medium">{{ trans('panel.wallet') }}</span>
                            </p>
                        </label>
                    </div>
                </div>

                <div id="abajim_sub_options" class="row" style="display: none;">
                    <!-- Reserve Card -->
                    <div class="col-6 col-lg-4">
                        <div class="card reserve-card" id="reserve-card" onclick="selectAbajimSubOption('reserve');">
                            <div class="d-flex flex-column justify-content-center align-items-center"
                                style="width: 100%; height: 100%;z-index:22">
                                <h6 class="font-20 font-weight-bold">{{ trans('panel.reserve_card') }}</h6>
                            </div>
                        </div>
                    </div>


                    <!-- Have Card-->
                    <div class="col-6 col-lg-4">
                        <div class="card selected pack-card" id="have_card_option"
                            onclick="selectAbajimSubOption('have');">
                            <div class="d-flex flex-column justify-content-center align-items-center"
                                style="width: 100%; height: 100%;z-index:22">
                                <h6 class="font-20 font-weight-bold">{{ trans('panel.have_card') }}</h6>
                            </div>
                        </div>
                    </div>

                    <!-- Support Card -->
                    <div class="col-6 col-lg-4">
                        <div class="card support-card" onclick="selectAbajimSubOption('support');">
                            <div class="d-flex flex-column justify-content-center align-items-center"
                                style="width: 100%; height: 100%;z-index:22">
                                <h6 class="font-20 font-weight-bold">{{ trans('panel.what_is_abajim_card') }}</h6>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="card-section" style="display: none;" class="mt-4">
                    <div class="wrapper" id="app">
                        <div class="card-form">
                            <div class="card-list">
                                <div class="card-item" v-bind:class="{ '-active' : isCardFlipped }">
                                    <div class="card-item__side -front">
                                        <div class="card-item__focus" v-bind:class="{'-active' : focusElementStyle }"
                                            v-bind:style="focusElementStyle" ref="focusElement">
                                        </div>
                                        <div class="card-item__cover">
                                            <img src="/9.jpeg" class="card-item__bg">
                                        </div>
                                        <div class="card-item__wrapper" @click="flipCard(true)"
                                            @mouseleave="flipCard(false)">
                                            <div class="card-item__top">
                                                <img src="/assets/default/img/chip.png" class="card-item__chip">
                                                <div class="card-item__type">
                                                    <transition name="slide-fade-up">
                                                        <img src="/store/1/logo_white.png" alt=""
                                                            class="card-item__typeImg">
                                                    </transition>
                                                </div>
                                            </div>
                                            <label for="cardNumber" class="card-item__number" ref="cardNumber">
                                                <template v-for="(n, $index) in displayCardNumber.split('')"
                                                    :key="$index">
                                                    <transition name="slide-fade-up">
                                                        <div class="card-item__numberItem" v-text="n"></div>
                                                    </transition>
                                                </template>
                                            </label>
                                            <div class="card-item__content">
                                                <label for="cardName" class="card-item__info" ref="cardName">
                                                    <div class="card-item__holder">اسم الطفل</div>
                                                    <transition name="slide-fade-up">
                                                        <div class="card-item__name" v-if="cardName.length"
                                                            key="1">
                                                            {{ $authUser->full_name }}
                                                        </div>
                                                        <div class="card-item__name" v-else key="2">
                                                            {{ $authUser->full_name }}
                                                        </div>
                                                    </transition>
                                                </label>
                                                <div class="card-item__date" ref="cardDate">
                                                    <label for="cardMonth" class="card-item__dateTitle">
                                                        تنتهي صلاحيتها
                                                    </label>
                                                    <label for="cardMonth" class="card-item__dateItem">
                                                        <transition name="slide-fade-up">
                                                            <span v-if="cardMonth" v-bind:key="cardMonth"></span>
                                                            <span v-else key="2">07</span>
                                                        </transition>
                                                    </label>/
                                                    <label for="cardYear" class="card-item__dateItem">
                                                        <transition name="slide-fade-up">
                                                            <span v-if="cardYear" v-bind:key="cardYear"></span>
                                                            <span v-else key="2">25</span>
                                                        </transition>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-item__side -back">
                                        <div class="card-item__cover">
                                            <img src="/assets/default/img/card_background.jpeg" class="card-item__bg">
                                        </div>
                                        <div class="card-item__band"></div>
                                        <div class="card-item__cvv">
                                            <div class="card-item__cvvTitle">المستوى</div>
                                            <div class="card-item__cvvBand">
                                                <?php
                                                $namelevel = DB::table('school_levels')->where('id', $authUser->level_id)->pluck('name')->first();
                                                ?>
                                                <span v-if="cardCvv">{{ $namelevel }}</span>
                                                <span v-else>{{ $namelevel }}</span>
                                            </div>
                                            <div class="card-item__type">
                                                <img src="/store/1/logo_white.png" alt=""
                                                    class="card-item__typeImg">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-input">
                                <label for="cardNumber" class="card-input__label">رمز البطاقة</label>
                                <input type="text" id="cardNumber" class="card-input__input"
                                    onmousedown="event.stopPropagation()" v-model="cardNumber" data-ref="cardNumber"
                                    maxlength="8" autocomplete="off" />
                            </div>
                            <div class="card-input">
                                <input type="text" id="cardName" class="card-input__input" v-model="cardName"
                                    v-on:focus="focusInput" v-on:blur="blurInput" data-ref="cardName"
                                    autocomplete="off" hidden>
                            </div>
                            <div class="card-form__row">
                                <div class="card-form__col -cvv">
                                    <div class="card-input">
                                        <select class="form-control js-webinar-content-locale" id="cardCvv"
                                            v-model="cardCvv" v-on:focus="flipCard(true)" v-on:blur="flipCard(false)"
                                            hidden>
                                            <option value="" disabled selected>اختر المستوى</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div id="errorContainer"></div>
                        </div>
                    </div>
                </div>

                <div id="reserveFormSection" style="display:none;" class="mt-4">
                    <p>
                        تمكنك بطاقة الشحن من تفعيل اشتراك سنوي في شبكة أباجيم من أجل التمتع بالكتب المدرسية
                        التفاعلية
                        مع خاصية مقاطع الفيديو التفسيرية و الدروس الاضافية, بعد إتمام تعبئة بياناتك، ستصلك البطاقة
                        على عنوانك في غضون 48 ساعة. تحتوي البطاقة على رمز سري يمنحك إمكانية تفعيل الاشتراك بكل
                        سهولة.
                    </p>
                    <div class="container d-flex justify-content-center mt-20">
                        <div class="cover atvImg">
                            <div class="atvImg-layer" data-img="/abajimcard1.png">
                                <img width="100%" src="/abajimcard1.png">
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('card_reservations.store') }}" method="POST">
                        @csrf
                        <div class="row mt-20">
                            <div class="form-group mb-3 col-md-6">
                                <label for="name"
                                    class="text-color-primary">{{ trans('panel.parent_name') }}</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ $parentid->organization->full_name ?? '' }}">
                            </div>
                            <div class="form-group mb-3 col-md-6">
                                <label for="phone_number"
                                    class="text-color-primary">{{ trans('panel.phone_number') }}</label>
                                <input type="text" name="phone_number" id="phone_number" class="form-control"
                                    value="{{ $parentid->organization->mobile ?? '' }}">
                            </div>
                            <div class="form-group mb-3 col-md-6">
                                <label for="child_level"
                                    class="text-color-primary">{{ trans('panel.child_level') }}</label>
                                <input type="text" class="form-control"
                                    value="{{ $users->childLevel->name ?? '' }}" disabled>
                            </div>
                            <div class="form-group mb-3 col-md-6">
                                <label for="city">اختر المدينة:</label>
                                <select name="city" id="city" class="form-control" required>
                                    <option value="" disabled selected>اختر المدينة</option>
                                    <option value="تونس">تونس</option>
                                    <option value="صفاقس">صفاقس</option>
                                    <option value="سوسة">سوسة</option>
                                    <option value="التضامن">التضامن</option>
                                    <option value="القيروان">القيروان</option>
                                    <option value="قابس">قابس</option>
                                    <option value="بنزرت">بنزرت</option>
                                    <option value="أريانة">أريانة</option>
                                    <option value="قفصة">قفصة</option>
                                    <option value="المنستير">المنستير</option>
                                    <option value="مدنين">مدنين</option>
                                    <option value="نابل">نابل</option>
                                    <option value="القصرين">القصرين</option>
                                    <option value="بن عروس">بن عروس</option>
                                    <option value="المهدية">المهدية</option>
                                    <option value="سيدي بوزيد">سيدي بوزيد</option>
                                    <option value="جندوبة">جندوبة</option>
                                    <option value="قبلي">قبلي</option>
                                    <option value="توزر">توزر</option>
                                    <option value="سليانة">سليانة</option>
                                    <option value="باجة">باجة</option>
                                    <option value="زغوان">زغوان</option>
                                    <option value="منوبة">منوبة</option>
                                </select>
                            </div>
                            <div class="form-group mb-3 col-md-12">
                                <label for="address" class="text-color-primary">{{ trans('panel.address') }}</label>
                                <input type="text" class="form-control" id="address" name="address"
                                    placeholder="{{ trans('panel.enter_address') }}">
                            </div>
                            <input type="hidden" name="user_id" id="user_id" class="form-control"
                                value="{{ $parentid->organ_id ?? '' }}">
                            <input type="hidden" name="level_id" id="level_id" class="form-control"
                                value="{{ $users->level_id ?? '' }}">
                            <input type="hidden" name="enfant_id" id="enfant_id" class="form-control"
                                value="{{ $users->id ?? '' }}">

                            <div class="form-group">
                                {{-- <button type="submit" class="btn btn-primary align-self-end">
                                    {{ trans('public.submit') }}
                                </button> --}}
                            </div>
                        </div>
                    </form>
                </div>

                <div id="supportSection" style="display: none;" class="mt-4">
                    <p>
                        <strong>هل تحتاج للمساعدة؟</strong><br>
                        إن كنت ترغب في الاستفسار حول كيفية الحصول على بطاقة، أو لديك أي أسئلة إضافية
                        حول تفعيل باقتك، يمكنك التواصل معنا عبر:
                        <br>
                        - البريد الإلكتروني: support@abajim.tn
                        <br>
                        - الهاتف: (+216) 12345678
                        <br><br>
                        فريق الدعم جاهز لمساعدتك على مدار الساعة لنسهل لك الوصول إلى كل خدماتنا.
                    </p>
                </div>

                <div id="virement-section" style="display: none;" class="mt-4">
                    <form id="bankTransferForm" action="{{ route('payment.proofs.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="level_id" value="{{ Auth::user()->level_id }}">

                        <div class="bank-transfer-ui">
                            <div class="rib-info mb-3 p-3 border rounded">
                                <h6>{{ trans('panel.bank_detail') }}</h6>
                                <img src="/assets/default/icons/logoAttijari.png" alt="ABJIM BANK"
                                    style="width: 150px;">
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex flex-column">
                                        <span>{{ config('constants.USER_BANK_NAME') }}</span>
                                        <span>{{ trans('panel.user_bank_name') }}</span>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span>{{ trans('panel.RIB') }}</span>
                                        <span>{{ config('constants.RIB_BANK') }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- File Upload -->
                            <div class="file-upload-area text-center p-4">
                                <input type="file" class="file-upload" id="bankProof" name="proof"
                                    accept="image/*,application/pdf" hidden>
                                <label for="bankProof" class="upload-label">
                                    <div class="upload-icon">
                                        <i class="bi bi-cloud-upload fs-1 text-primary"></i>
                                    </div>
                                    <div class="upload-text">
                                        <h6>{{ trans('panel.upload_transfer_proof') }}</h6>
                                        <p class="text-muted">{{ trans('panel.click_to_upload') }}</p>
                                    </div>
                                </label>
                            </div>

                            <div id="proofErrorContainer"></div>
                        </div>
                    </form>
                </div>

                <div class="total-container mt-4">
                    <div class="d-flex justify-content-between">
                        <span><strong>{{ trans('panel.total_price') }}</strong></span>
                        <span id="total-price" class="badge badge-light text-dark font-weight-bold font-16 p-5">120
                            DT</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="paymentButton" style="width: 30%;" onclick="processPayment()">
                    {{ trans('panel.complete_payment') }}
                </button>

                <button type="button" class="btn btn-outline-primary" style="width:15%" data-bs-dismiss="modal">
                    {{ trans('panel.cancel') }}
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts_bottom')
    <link href="/assets/default/vendors/flagstrap/css/flags.css" rel="stylesheet">
    <script src='https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js'></script>
    <script src='https://unpkg.com/vue-the-mask@0.11.1/dist/vue-the-mask.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        var appTranslations = {
            changeLanguage: "{{ __('languages.change_language') }}",
        };
    </script>
    <script src="/assets/default/vendors/flagstrap/js/jquery.flagstrap.min.js"></script>
    <script src="/assets/default/js/parts/top_nav_flags.min.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js'></script>
    <script src='https://unpkg.com/vue-the-mask@0.11.1/dist/vue-the-mask.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

    <script>
        // ------------------ FOLLOWERS SEARCH --------------------
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

        // ------------------ SUBSCRIPTION PLAN OPEN --------------------
        document.addEventListener('DOMContentLoaded', function() {
            const subscribePlans = document.querySelectorAll('.subscribe-plan');
            subscribePlans.forEach(plan => {
                plan.addEventListener('click', function() {
                    const planTitle = this.querySelector('h3').innerText;
                    const planDescription = this.querySelector('ul') ? this.querySelector('ul')
                        .innerHTML : '';
                    const planPrice = this.querySelector('.pack-price') ? this.querySelector(
                        '.pack-price').innerHTML : '';
                    const modalContent = `
                        <h4>${planTitle}</h4>
                        <ul>${planDescription}</ul>
                        <p><strong>{{ trans('home.price') }}:</strong> ${planPrice}</p>
                    `;
                    document.getElementById('modalContent').innerHTML = modalContent;
                    const subscriptionModal = new bootstrap.Modal(document.getElementById(
                        'subscriptionModal'));
                    subscriptionModal.show();
                });
            });
        });

        // ------------------ PAYMENT MODAL FLOW --------------------
        function openPaymentModal() {
            const subscriptionModalEl = document.getElementById('subscriptionModal');
            const subscriptionModal = bootstrap.Modal.getInstance(subscriptionModalEl);
            if (subscriptionModal) {
                subscriptionModal.hide();
            }
            const paymentModalEl = document.getElementById("paymentModal");
            const paymentModal = new bootstrap.Modal(paymentModalEl);
            paymentModal.show();
            showSubOptions('abajim_card');
        }

        function showSubOptions(method) {
            document.getElementById('abajim_sub_options').style.display = 'none';
            document.getElementById('card-section').style.display = 'none';
            document.getElementById('reserveFormSection').style.display = 'none';
            document.getElementById('supportSection').style.display = 'none';
            document.getElementById('virement-section').style.display = 'none';
            const subCards = document.querySelectorAll('#abajim_sub_options .card');
            subCards.forEach(c => c.classList.remove('selected'));

            if (method === 'abajim_card') {
                document.getElementById('abajim_sub_options').style.display = 'flex';
                document.getElementById('have_card_option').classList.add('selected');
                document.getElementById('card-section').style.display = 'block';
            } else if (method === 'bank_transfer') {
                document.getElementById('virement-section').style.display = 'block';
            } else if (method === 'wallet') {}
        }

        function updatePaymentButton() {
            let selectedGateway = document.querySelector('input[name="gateway"]:checked').value;
            let subOption = selectedAbajimOption();
            let paymentButton = document.getElementById("paymentButton");

            if (selectedGateway === "abajim_card") {
                if (subOption === "have") {
                    paymentButton.innerText = "{{ trans('panel.complete_payment') }}";
                } else if (subOption === "reserve") {
                    paymentButton.innerText = "{{ trans('panel.reserve_card') }}";
                } else {
                    paymentButton.innerText = "{{ trans('panel.complete_payment') }}";
                }
            } else if (selectedGateway === "bank_transfer") {
                paymentButton.innerText = "{{ trans('panel.submit_bank_proof') }}";
            } else if (selectedGateway === "wallet") {
                paymentButton.innerText = "{{ trans('panel.complete_payment') }}";
            }
        }


        function selectAbajimSubOption(option) {
            const subCards = document.querySelectorAll('#abajim_sub_options .card');
            subCards.forEach(c => c.classList.remove('selected'));
            document.getElementById('card-section').style.display = 'none';
            document.getElementById('reserveFormSection').style.display = 'none';
            document.getElementById('supportSection').style.display = 'none';
            if (option === 'have') {
                document.getElementById('have_card_option').classList.add('selected');
                document.getElementById('card-section').style.display = 'block';
            } else if (option === 'reserve') {
                event.currentTarget.classList.add('selected');
                document.getElementById('reserveFormSection').style.display = 'block';
            } else if (option === 'support') {
                event.currentTarget.classList.add('selected');
                document.getElementById('supportSection').style.display = 'block';
            }
            updatePaymentButton();
        }

        // ------------------ BANK PROOF FILE UPLOAD UI --------------------
        const bankProofInput = document.getElementById('bankProof');
        if (bankProofInput) {
            bankProofInput.addEventListener('change', function(e) {
                const label = document.querySelector('.upload-label');
                const errorContainer = document.getElementById('proofErrorContainer');
                if (errorContainer) {
                    errorContainer.innerHTML = '';
                }
                if (e.target.files.length > 0) {
                    label.innerHTML = `
                <div class="upload-success">
                    <i class="bi bi-check-circle-fill text-success fs-1"></i>
                    <div class="mt-2">${e.target.files[0].name}</div>
                </div>
                `;
                }
            });
        }

        // ------------------ VALIDATE CARD--------------------
        function validateCard() {
            const cardNumber = document.getElementById("cardNumber").value;
            fetch("/panel/validate-card", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                    },
                    body: JSON.stringify({
                        card_number: cardNumber
                    }),
                })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        const errorContainer = document.getElementById("errorContainer");
                        confetti({
                            particleCount: 1000,
                            spread: 1000,
                            origin: {
                                y: 0.6
                            }
                        });
                        const upgradeModalEl = document.getElementById("upgradeModal");
                        const upgradeModal = upgradeModalEl ? bootstrap.Modal.getInstance(upgradeModalEl) : null;
                        if (upgradeModal) {
                            upgradeModal.hide();
                        }
                        window.location.reload(true);
                    } else {
                        errorContainer.innerHTML =
                            `<div class="alert" style="color: red; font-weight: bold; text-align: center;">${data.message}</div>`;
                    }
                })
                .catch((error) => console.error("Error:", error));
        }

        // ------------------ CHILD NAME SWITCHING --------------------
        document.addEventListener('DOMContentLoaded', function() {
            var childNames = document.querySelectorAll('.child-name');
            childNames.forEach(function(childName) {
                childName.addEventListener('click', function() {
                    var container = document.querySelector('.wgh-slider__container');
                    if (container) {
                        container.innerHTML = '';
                    }
                    var fullName = childName.getAttribute('data-full-name');
                    var level_id = childName.getAttribute('data-level-id');
                    var namelavel = childName.getAttribute('data-level-name');
                    var imgE = childName.getAttribute('data-level-path');
                    if (document.getElementById('useruser')) {
                        document.getElementById('useruser').textContent = fullName;
                    }
                    var emaaa = document.getElementById('emaaa');
                    var path = document.getElementById('pathpath');
                    var ava = document.getElementById('ava');
                    if (emaaa) {
                        emaaa.textContent = "المستوى:" + namelavel;
                    }
                    if (path) {
                        path.src = '/' + imgE;
                        path.alt = fullName;
                    }
                    if (ava) {
                        ava.style.width = '40%';
                    }
                });
            });
        });

        function processPayment() {
            event.preventDefault();
            let selectedGateway = document.querySelector('input[name="gateway"]:checked')?.value;
            let subOption = selectedAbajimOption();
            let selectedPaymentMethod = document.querySelector('input[name="gateway"]:checked').value;
            let proofInput = document.getElementById("bankProof");
            let proofErrorContainer = document.getElementById("proofErrorContainer");
            proofErrorContainer.innerHTML = "";
            if (selectedGateway === "abajim_card") {
                if (subOption === "have") {
                    validateCard();
                } else if (subOption === "reserve") {
                    let reserveForm = document.querySelector("#reserveFormSection form");

                    reserveForm.submit();

                } else {
                    return;
                }
            } else if (selectedGateway === "bank_transfer") {
                let file = proofInput.files[0];

                if (!file) {
                    proofErrorContainer.innerHTML = `<div class="alert alert-danger mt-2">
                    {{ trans('panel.upload_transfer_proof_error') }}
                </div>`;
                    return;
                }

                if (file.size > 2 * 1024 * 1024) {
                    proofErrorContainer.innerHTML = `<div class="alert alert-danger mt-2">
                    {{ trans('panel.file_size_exceeded') }}
                </div>`;
                    return;
                }
                document.getElementById("bankTransferForm").submit();
            } else if (selectedGateway === "wallet") {
                submitWalletPayment();
            } else {
                alert("No payment method selected.");
            }
        }

        function selectedAbajimOption() {
            if (document.querySelector("#have_card_option").classList.contains("selected")) {
                return "have";
            } else if (document.querySelector("#reserve-card").classList.contains("selected")) {
                return "reserve";
            } else if (document.querySelector(".support-card.selected")) {
                return "support";
            } else {
                return null;
            }
        }
        document.addEventListener("DOMContentLoaded", updatePaymentButton);
        document.querySelectorAll('input[name="gateway"]').forEach(input => {
            input.addEventListener("change", updatePaymentButton);
        });
    </script>
@endpush

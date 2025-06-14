@php
    if (empty($authUser) and auth()->check()) {
        $authUser = auth()->user();
    }
    $navBtnUrl = null;
    $navBtnText = null;

    if (request()->is('forums*')) {
        $navBtnUrl = '/forums/create-topic';
        $navBtnText = trans('update.create_new_topic');
    } else {
        $navbarButton = getNavbarButton(!empty($authUser) ? $authUser->role_id : null);

        if (!empty($navbarButton)) {
            $navBtnUrl = $navbarButton->url;
            $navBtnText = $navbarButton->title;
        }
    }

    if ($authUser->isOrganization()) {
        $enfantsCount = \App\User::where('organ_id', $authUser->id)->count();
    }

@endphp

<head>
    <link rel="stylesheet" href="/assets/default/css/navbarPannelEnfant.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Rubik:wght@400;700&display=swap"
        rel="stylesheet">

</head>

<style>
    .modal-image {
        width: 100%;
        margin: 0 auto;
    }

    @media (max-width: 576px) {
        .modal-image {
            max-width: 190px;
            margin-bottom: 15px;
        }

        .font-16 {
            font-size: 1rem;
        }
    }

    @media (min-width: 991px) {
        .modal-content {
            margin-top: 100px;
        }
    }

    @media (max-width: 992px) {
        #navbar {
            display: none;
        }

        #navbarVacuum {
            display: block;
        }
    }

    .font-16,
    .font-20 {
        font-family: 'Tajawal', sans-serif;
    }

    .main-container {
        display: flex;
        align-items: center;
        box-sizing: border-box;
        transition: transform 0.3s ease;
    }

    .modal-header h5 {
        font-size: 1.5rem;
        font-weight: bold;
        padding: 8px;
    }

    .btn-primary {
        background: linear-gradient(45deg, #0056b3, #31a2b8);
    }

    /* Styles pour la cloche de notification */
    .notification-bell-container {
        position: relative;
        display: inline-block;
        cursor: pointer;
    }

    .notification-bell {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        transition: all 0.3s ease;
        background: linear-gradient(135deg, rgba(106, 17, 203, 0.05), rgba(37, 117, 252, 0.1));
    }

    .notification-bell:hover {
        background: linear-gradient(135deg, rgba(106, 17, 203, 0.1), rgba(37, 117, 252, 0.2));
        transform: translateY(-2px);
    }

    .notification-icon {
        font-size: 18px;
        color: #2575fc;
        transition: all 0.3s ease;
        animation: swing 2s infinite;
        transform-origin: top center;
    }

    .notification-bell:hover .notification-icon {
        color: #6a11cb;
    }

    .notification-badge {
        position: absolute;
        top: -5px;
        right: -5px;
        background: linear-gradient(135deg, #ff3e3e 0%, #ff7676 100%);
        color: white;
        font-size: 11px;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        box-shadow: 0 2px 5px rgba(255, 62, 62, 0.4);
    }

    .notification-dropdown {
        min-width: 320px;
        padding: 0;
        border-radius: 15px;
        border: none;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    }

    /* Animations */
    .pulse {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(255, 62, 62, 0.6);
        }

        70% {
            box-shadow: 0 0 0 8px rgba(255, 62, 62, 0);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(255, 62, 62, 0);
        }
    }

    @keyframes swing {
        20% {
            transform: rotate(8deg);
        }

        40% {
            transform: rotate(-8deg);
        }

        60% {
            transform: rotate(4deg);
        }

        80% {
            transform: rotate(-4deg);
        }

        100% {
            transform: rotate(0deg);
        }
    }

    .notification-bell.has-new {
        animation: ring 1.5s ease;
    }

    @keyframes ring {
        0% {
            transform: rotate(0);
        }

        5% {
            transform: rotate(15deg);
        }

        10% {
            transform: rotate(-15deg);
        }

        15% {
            transform: rotate(15deg);
        }

        20% {
            transform: rotate(-15deg);
        }

        25% {
            transform: rotate(15deg);
        }

        30% {
            transform: rotate(-15deg);
        }

        35% {
            transform: rotate(15deg);
        }

        40% {
            transform: rotate(-15deg);
        }

        45% {
            transform: rotate(0);
        }

        100% {
            transform: rotate(0);
        }
    }
</style>

<div id="navbarVacuum"></div>
<nav id="navbar" class="navbar navbar-expand-lg navbar-light">
    <div class="{{ (!empty($isPanel) and $isPanel) ? 'container-fluid' : 'container' }}">
        <div class="d-flex align-items-center justify-content-between w-100">
            <div class="logo-hidden">
                <a class="navbar-brand navbar-order d-flex align-items-center justify-content-center mr-0 {{ (empty($navBtnUrl) and empty($navBtnText)) ? 'ml-auto' : '' }}"
                    href="/panel/enfant">
                    @if (!empty($generalSettings['logo']))
                        <img src="{{ $generalSettings['logo'] }}" class="site-logo" alt="site logo">
                    @endif
                </a>
            </div>
            <div class="mx-lg-30 d-none d-lg-flex flex-grow-1 navbar-toggle-content " id="navbarContent">
                <div class="navbar-toggle-header text-right d-lg-none">
                    <button class="btn-transparent" id="navbarClose">
                        <i data-feather="x" width="32" height="32"></i>
                    </button>
                </div>
            </div>


            <!-- Modal -->
            <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            ...
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            $userOrder = DB::table('orders')
                ->where('user_id', auth()->user()->id)
                ->where('status', 'paid')
                ->exists();
            ?>
            @if (!empty($authUser->role_name == 'enfant') && !$userOrder)
                <div class="overlay"></div>
                <div class="main-container" id="mainContainer">
                    <div class="d-flex align-items-center justify-content-center">
                        <?php
                        $usermin = DB::table('user_min_watched')->where('user_id', $authUser->id)->pluck('minutes_watched_day')->first();
                        
                        $watchedSeconds = ($usermin ?? 0) * 60;
                        if ($watchedSeconds <= 600) {
                            $remainingMinutes = (600 - $watchedSeconds) / 60;
                        } else {
                            $remainingMinutes = 0;
                        }
                        
                        $userOrder = DB::table('orders')
                            ->where('user_id', auth()->user()->id)
                            ->where('status', 'paid')
                            ->exists();
                        ?>
                        <img src="/assets/default/icons/clock.png" width="50" height="50" />

                        <div class="countdown-text" id="remainingTime">
                            @php
                                $mins = floor($remainingMinutes);
                                $secs = floor(($remainingMinutes - $mins) * 60);
                            @endphp
                            <span>
                                {{ $mins . ':' . $secs }} {{ trans('panel.minutes') }}
                            </span>
                        </div>
                    </div>
                    <div class="countdown-input-wrapper">
                        <input type="number" class="countdown-input" value="90" id="timeInput"
                            placeholder="Enter Seconds" min="1" hidden>
                    </div>

                </div>
            @endif

            @php
                $userparent = \App\User::where('id', $authUser->organ_id)->orWhere('id', $authUser->id)->first();
                $countenfant = \App\User::where('organ_id', $userparent->id)->count();
                if ($userparent) {
                    $enfant = \App\User::where('organ_id', $userparent->id)->get();
                }
            @endphp

            @php
                use App\QuizNotificationUsers;

                $notifications = QuizNotificationUsers::with('notification')
                    ->where('receiver_id', $authUser->id)
                    ->orderByDesc('created_at')
                    ->where('is_read', false)
                    ->get();

                $unreadCount = $notifications->where('is_read', false)->count();
            @endphp
            <div class="dropdown me-3">
                <a class="nav-link position-relative notification-bell-container" href="#" role="button"
                    id="notifDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="notification-bell" onclick="testNotificationSound(event)">
                        <i class="fas fa-bell notification-icon"></i>
                        @if ($unreadCount > 0)
                            <span class="notification-badge pulse">{{ $unreadCount }}</span>
                        @endif
                    </div>
                </a>

                <div id="notifDropdownContainer" class="dropdown-menu dropdown-menu-right shadow notification-dropdown"
                    aria-labelledby="notifDropdown">
                    @include('web.default.includes.notification_dropdown')
                </div>

                <!-- Sons de notification -->
                <audio id="notificationSound" preload="auto">
                    <source src="{{ asset('assets/default/sounds/notification.mp3') }}" type="audio/mpeg">
                </audio>
                <audio id="clickSound" preload="auto">
                    <source src="{{ asset('assets/default/sounds/click.mp3') }}" type="audio/mpeg">
                </audio>
            </div>
        </div>


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
                                style="
                        @if ($enf->id !== $authUser->id) scale: 0.8; @endif"
                                data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-html="true"
                                title="{{ $enf->full_name }}" />
                            @if ($enf->id == $authUser->id)
                                <span class="online-dot"></span>
                            @endif
                        </li>
                    </a>
                @endforeach
            @endif

        </ul>


        <div class="nav-icons-or-start-live navbar-order">
            @if (empty($authUser))
                <a href="{{ empty($authUser) ? '/Instructor/register' : ($authUser->isAdmin() ? '/admin/webinars/create' : ($authUser->isVisiteur() ? '/become_instructor' : '/panel/webinars/new')) }}"
                    class="d-none d-lg-flex btn btn-sm btn-primary nav-start-a-live-btn">
                    Become Instructor
                </a>
            @endif
            <div class="d-none nav-notify-cart-dropdown top-navbar">
                @if ($authUser->isEnfant())
                    <?php
                    $userparent = \App\User::where('id', $authUser->organ_id)->get();
                    $idOrgan = DB::table('users')->where('id', $authUser->id)->pluck('organ_id');
                    ?>
                    <a href="#" class="navbar-user d-flex align-items-center ml-25" type="button"
                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @if (!empty($userparent[0]->avatar))
                            <img src="{{ $userparent[0]->getAvatar(100) }}" class="rounded-circle desktop-avatar"
                                alt="{{ $userparent[0]->full_name }}">
                        @else
                            <img src="{{ $userparent[0]->getAvatar(100) }}" class="rounded-circle desktop-avatar"
                                alt="{{ $userparent[0]->full_name }}">
                        @endif
                    </a>
                    <div class="dropdown-menu user-profile-dropdown" aria-labelledby="dropdownMenuButton">
                        <div class="d-md-none border-bottom mb-20 pb-10 text-right">
                            <i class="close-dropdown" data-feather="x" width="32" height="32"
                                class="mr-10"></i>
                        </div>
                        <span class="font-16 user-name ml-10 text-dark-blue font-16">{{ $userparent[0]->full_name }}
                        </span>
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
                @elseif ($authUser->isOrganization())
                    <a href="#" class="navbar-user d-flex align-items-center ml-25" type="button"
                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @if (!empty($authUser->avatar))
                            <img src="{{ $authUser->getAvatar(100) }}" class="rounded-circle desktop-avatar"
                                alt="{{ $authUser->full_name }}">
                        @else
                            <img src="{{ $authUser->getAvatar(100) }}" class="rounded-circle desktop-avatar"
                                alt="{{ $authUser->full_name }}">
                        @endif
                    </a>
                    <div class="dropdown-menu user-profile-dropdown" aria-labelledby="dropdownMenuButton">
                        <div class="d-md-none border-bottom mb-20 pb-10 text-right">
                            <i class="close-dropdown" data-feather="x" width="32" height="32"
                                class="mr-10"></i>
                        </div>
                        <span class="font-16 user-name ml-10 text-dark-blue font-16">{{ $authUser->full_name }}
                        </span>
                        <hr class="mt-10 mb-10">


                        <a class="dropdown-item" href="/panel/setting">
                            @include('web.default.panel.includes.sidebar_icons.setting')
                            <span class="font-16 text-dark-blue">{{ trans('panel.settings') }}</span>
                        </a>
                        <a class="dropdown-item" href="/logout">
                            <img src="/assets/default/img/icons/sidebar/logout.svg" width="25" alt="nav-icon">
                            <span class="font-16 text-dark-blue">{{ trans('panel.log_out') }}</span>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    </div>
</nav>

<style>
    .form-control {
        border: 1px solid rgba(167, 166, 166, 0.786);
        background-color: #f9f9f97a;
    }

    .gender-container {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-top: 20px;
    }

    .name-container {
        gap: 75px;
        width: 98%
    }


    .gender-input {
        position: relative;
        border: 1px solid rgba(167, 166, 166, 0.786);
        border-radius: 7px;
        text-align: center;
        padding: 7px 0;
        width: 180px;
        cursor: pointer;
        background-color: #f9f9f97a;
        transition: all 0.3sease-in-out;
        cursor: pointer;
    }

    .gender-input:hover {
        background-color: #e6f4ff;
        cursor: pointer;
    }

    .gender-image {
        position: absolute;
        left: -4px;
        top: -23px;
        width: 70px;
        height: 70px;
        margin-bottom: 10px;
    }

    .gender-field {
        display: none;
    }

    .gender-input label {
        display: block;
        font-size: 18px;
        color: var(--primary);
        font-weight: bold;
    }

    .gender-input.selected {
        background-color: var(--primary);
        color: white;
        border-color: var(--primary);
    }

    .gender-input.selected label {
        color: white;
    }
</style>
<style>
    .levels-container {
        display: flex;
        gap: 20px;
        margin-top: 10px;
        justify-content: start;
        flex-wrap: wrap;
    }

    .level-input {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: start;
        justify-content: center;
        border: 1px solid rgba(167, 166, 166, 0.786);
        border-radius: 25px 7px 7px 25px;
        padding: 9px 10px;
        width: 170px;
        cursor: pointer;
        background-color: #f9f9f97a;
        transition: all 0.3sease-in-out;
        text-align: center;
    }

    .level-input:hover {
        background-color: #e6f4ff;
        cursor: pointer;
    }

    .level-input input {
        display: none;
    }

    .level-input.selected {
        background-color: var(--primary);
        color: white;
    }

    .level-image {
        position: absolute;
        left: 0;
        width: 47px;
        height: 47px;
        border-radius: 50%;
        top: 0px;
    }

    .level-input.selected .level-image {
        border: 2px solid white;
    }

    .level-input label {
        font-size: 16px;
        font-weight: bold;
        color: var(--primary);
    }

    .level-input.selected label {
        color: white;
    }

    @media(max-width: 576px) {
        .gender-container {
            gap: 5px;
        }

        .name-container {
            gap: 5px;
        }

        .gender-input {
            width: 150px;
        }

        .level-input label {
            font-size: 13px;
        }

        .level-input {
            width: 150px;
        }

        .gender-input label {
            font-size: 13px;
            padding: 0 13px;
            text-align: start;
        }

        .gender-image {
            top: -30px;
        }

    }
</style>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="font-20" id="exampleModalLabel"> {{ trans('panel.add_child') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mt-15 d-flex align-items-center">
                    <form class="d-flex flex-column" method="post" action="/panel/enfant/post">
                        {{ csrf_field() }}
                        <div class="form-group d-flex align-items-center name-container">
                            <label for="childNameInput" class="font-16 font-weight-bold text-secondary">الإسم</label>
                            <input type="text" name="nom" placeholder="الإسم" id="childNameInput"
                                class="font-16 form-control" value="{{ old('nom') }}">
                        </div>
                        <div class="invalid-feedback d-none child-name-error">
                            {{ trans('public.child_name_required') }}</div>
                        <div class="form-group d-lg-flex align-items-center" style="gap: 40px;">
                            <div class="d-flex flex-column align-items-start">
                                <label for="sexe" class="font-16 font-weight-bold text-secondary">الجنس</label>
                                <h6 class="font-12 text-secondary">(الرّجاء الإختيار)</h6>
                            </div>
                            <div class="gender-container">
                                <div class="gender-input">
                                    <input type="text" name="sexe" class="gender-field" value="Garçon"
                                        readonly>
                                    <img src="/assets/default/img/boy.png" alt="Garçon" class="gender-image">
                                    <label>ذكر</label>
                                </div>
                                <div class="gender-input">
                                    <input type="text" name="sexe" class="gender-field" value="Fille"
                                        readonly>
                                    <img src="/assets/default/img/girl.png" alt="Fille" class="gender-image">
                                    <label>أنثى</label>
                                </div>
                            </div>
                        </div>
                        <div class="invalid-feedback d-none gender-error">{{ trans('public.gender_required') }}</div>
                        <div class="form-group d-lg-flex align-items-center" style="gap: 50px;">
                            <?php
                            $leveeeel = DB::table('school_levels')->where('id', '>', 5)->get();
                            ?>
                            <div class="d-flex flex-column align-items-start">
                                <label for="level" class="font-16 font-weight-bold text-secondary">المستوى
                                    الدّراسي</label>
                                <h6 class="font-12 text-secondary">(الرّجاء الإختيار)</h6>
                            </div>
                            <div class="levels-container">
                                @foreach ($leveeeel as $level)
                                    <div class="level-input" data-value="{{ $level->id }}">
                                        <img src="{{ asset('assets/default/icons/level_' . $level->id . '.png') }}"
                                            alt="{{ $level->name }}" class="level-image">
                                        <label>{{ $level->name }}</label>
                                        <input type="radio" name="level_id" value="{{ $level->id }}"
                                            {{ old('level_id') == $level->id ? 'selected' : '' }} hidden>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="invalid-feedback d-none level-error">{{ trans('public.level_required') }}</div>
                        <div class="col-lg-12 mt-30 d-flex justify-content-center">
                            <button type="submit" style="width: 50%;" class="btn btn-primary font-16">إضافة
                                طفل</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="exampleModalSetting" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="font-20" id="exampleModalLabel"> {{ trans('panel.add_child') }}</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mt-15 d-flex align-items-center">
                    <form class="d-flex flex-column" method="post" action="/panel/enfant/post/settings">
                        {{ csrf_field() }}
                        <div class="form-group d-flex align-items-center" style="gap: 40px;">
                            <label for="childNameInput" class="font-16 font-weight-bold text-secondary">الإسم</label>
                            <input type="text" name="nom" id="childNameInput"
                                class="font-16 form-control {{ $errors->has('nom') ? 'is-invalid' : '' }}"
                                value="{{ old('nom') }}">
                        </div>
                        <div class="invalid-feedback d-none child-name-error">
                            {{ trans('public.child_name_required') }}</div>
                        <div class="form-group d-flex align-items-center" style="gap: 40px;">
                            <div class="d-flex flex-column align-items-start">
                                <label for="sexe" class="font-16 font-weight-bold text-secondary">الجنس</label>
                                <h6 class="font-12 text-secondary">(الرّجاء الإختيار)</h6>
                            </div>
                            <div class="gender-container">
                                <div class="gender-input">
                                    <input type="text" name="sexe" class="gender-field" value="Garçon"
                                        readonly>
                                    <img src="/assets/default/img/boy.png" alt="Garçon" class="gender-image">
                                    <label>ذكر</label>
                                </div>
                                <div class="gender-input">
                                    <input type="text" name="sexe" class="gender-field" value="Fille"
                                        readonly>
                                    <img src="/assets/default/img/girl.png" alt="Fille" class="gender-image">
                                    <label>أنثى</label>
                                </div>
                            </div>
                        </div>
                        <div class="invalid-feedback d-none gender-error">{{ trans('public.gender_required') }}</div>
                        <div class="form-group d-flex align-items-center" style="gap: 40px;">
                            <?php
                            $leveeeel = DB::table('school_levels')->where('id', '>', 5)->get();
                            ?>
                            <div class="d-flex flex-column align-items-start">
                                <label for="level" class="font-16 font-weight-bold text-secondary">المستوى
                                    الدّراسي</label>
                                <h6 class="font-12 text-secondary">(الرّجاء الإختيار)</h6>
                            </div>
                            <div class="levels-container">
                                @foreach ($leveeeel as $level)
                                    <div class="level-input" data-value="{{ $level->id }}">
                                        <img src="{{ asset('assets/default/icons/level_' . $level->id . '.png') }}"
                                            alt="{{ $level->name }}" class="level-image">

                                        <label>{{ $level->name }}</label>
                                        <input type="radio" name="level_id" value="{{ $level->id }}"
                                            {{ old('level_id') == $level->id ? 'checked' : '' }} hidden>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="invalid-feedback d-none level-error">{{ trans('public.level_required') }}</div>
                        <div class="col-lg-12 mt-30 d-flex justify-content-center">
                            <button type="submit" style="width: 50%;" class="btn btn-primary font-16">إضافة
                                طفل</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>


@push('scripts_bottom')
    <script src="/assets/default/js/parts/navbar.min.js"></script>

    <!-- Script pour la gestion des sons de notification -->
    <script>
        // Variable pour suivre si le son a été activé par une interaction utilisateur
        let soundEnabled = false;

        // Activer le son après une interaction utilisateur
        document.addEventListener('click', function() {
            soundEnabled = true;
        }, {
            once: true
        });

        // Fonction pour tester le son de notification (lors du clic sur la cloche)
        function testNotificationSound(event) {
            // Empêcher l'ouverture du dropdown si on fait un double-clic sur la cloche
            if (event.detail > 1) { // détecter le double-clic
                event.preventDefault();
                event.stopPropagation();

                // Activer le son
                soundEnabled = true;

                // Jouer le son de notification
                const sound = document.getElementById('notificationSound');
                if (sound) {
                    // Force le chargement du son
                    sound.load();

                    // Jouer le son avec volume normal
                    sound.volume = 1.0;

                    // Ajouter l'animation de sonnerie à la cloche
                    const bell = event.currentTarget;
                    bell.classList.add('has-new');

                    // Essayer de jouer le son
                    const playPromise = sound.play();
                    if (playPromise !== undefined) {
                        playPromise
                            .then(() => {
                                console.log('Le son de notification fonctionne correctement!');
                            })
                            .catch(error => {
                                console.error('Erreur lors de la lecture du son de notification:', error);
                                alert(
                                    'Le son ne peut pas être joué. Vérifiez les paramètres de votre navigateur pour autoriser le son sur ce site.');
                            });
                    }

                    // Supprimer la classe d'animation après son exécution
                    setTimeout(() => {
                        bell.classList.remove('has-new');
                    }, 1500);
                }
            }
        }

        // Fonction améliorée pour jouer le son de notification
        function playNotificationSound() {
            // Remarque : La vérification de soundEnabled est ignorée pour que le son se joue toujours
            // lorsqu'une notification arrive

            const sound = document.getElementById('notificationSound');
            if (!sound) return;

            // Forcer le chargement du son
            sound.load();
            sound.volume = 1.0;

            // Activer la variable soundEnabled pour que les sons futurs fonctionnent aussi
            soundEnabled = true;

            // Essayer de jouer le son
            try {
                // Jouer le son de manière forcée
                sound.currentTime = 0; // Réinitialiser la position de lecture
                const playPromise = sound.play();
                if (playPromise !== undefined) {
                    playPromise.catch(error => {
                        console.error('Erreur lors de la lecture du son:', error);
                        // Tentative alternative de lecture du son
                        setTimeout(() => {
                            sound.play().catch(() => {});
                        }, 100);
                    });
                }
            } catch (e) {
                console.error('Erreur lors de la lecture du son:', e);
            }

            // Ajouter l'animation à la cloche
            const bell = document.querySelector('.notification-bell');
            if (bell) {
                bell.classList.remove('has-new');
                setTimeout(() => {
                    bell.classList.add('has-new');
                }, 10);
            }
        }

        // Fonction pour jouer le son de clic
        function playClickSound() {
            if (!soundEnabled) return;

            const sound = document.getElementById('clickSound');
            if (!sound) return;

            sound.volume = 0.5;
            sound.load();
            sound.play().catch(() => {});
        }

        // Écouter les nouvelles notifications via Echo (Laravel)
        if (typeof Echo !== 'undefined') {
            Echo.private("child.{{ auth()->id() }}")
                .listen(".quiz.notification", (e) => {
                    console.log('Nouvelle notification reçue:', e);

                    // Jouer le son de notification
                    playNotificationSound();

                    // Mettre à jour le compteur de notifications dans la barre de navigation
                    updateNotificationBadge();

                    // Mettre à jour le dropdown des notifications s'il est déjà ouvert
                    updateNotificationDropdown(e);
                });
        }

        // Fonction pour mettre à jour le badge de notification
        function updateNotificationBadge() {
            const badge = document.querySelector('.notification-bell .notification-badge');
            const bellIcon = document.querySelector('.notification-bell .notification-icon');

            if (badge) {
                // Incrémenter le compteur existant
                let count = parseInt(badge.textContent || '0') + 1;
                badge.textContent = count;
                badge.classList.add('pulse'); // Ajouter l'animation
                badge.style.display = 'flex';

                // Réappliquer l'animation si nécessaire
                badge.classList.remove('pulse');
                setTimeout(() => badge.classList.add('pulse'), 10);
            } else if (bellIcon && bellIcon.parentNode) {
                // Créer un nouveau badge s'il n'existe pas
                const newBadge = document.createElement('span');
                newBadge.className = 'notification-badge pulse';
                newBadge.textContent = '1';
                bellIcon.parentNode.appendChild(newBadge);
            }

            // Ajouter une animation à l'icône de cloche
            const bell = document.querySelector('.notification-bell');
            if (bell) {
                bell.classList.add('has-new');
                setTimeout(() => bell.classList.remove('has-new'), 1500);
            }
        }

        // Fonction pour mettre à jour le contenu du dropdown des notifications
        function updateNotificationDropdown(notification) {
            // Vérifier si le dropdown est ouvert
            const container = document.getElementById('notifDropdownContainer');
            if (!container || getComputedStyle(container).display === 'none') {
                // Le dropdown n'est pas ouvert, pas besoin de mettre à jour son contenu
                return;
            }

            // À ce stade, nous mettrions à jour le dropdown - cette partie est gérée par notification_dropdown.blade.php
            // via le script qui écoute également les événements .quiz.notification
        }

        // Ajouter un gestionnaire d'événements de clic pour les notifications
        document.addEventListener('DOMContentLoaded', function() {
            // Attacher le son de clic aux éléments de notification
            const dropdownContainer = document.getElementById('notifDropdownContainer');
            if (dropdownContainer) {
                dropdownContainer.addEventListener('click', function(e) {
                    if (e.target.closest('.notification-card') || e.target.closest(
                        '.btn-read-notification')) {
                        playClickSound();
                    }
                });
            }

            // Notification pour l'utilisateur sur comment tester le son
            console.log('Double-cliquez sur l\'icône de cloche pour tester le son de notification');
        });
    </script>

    <script>
        function updateRemainingTime() {
            fetch('/panel/get-user-minutes')
                .then(response => response.json())
                .then(data => {
                    const userMinutes = data.minutes_watched || 0;
                    const watchedSeconds = userMinutes * 60;
                    let remainingSeconds = 0;

                    if (watchedSeconds <= 600) {
                        remainingSeconds = 600 - watchedSeconds; // Remaining time in seconds
                    } else {
                        remainingSeconds = 0;
                    }

                    // Convert remainingSeconds into minutes and seconds
                    const mins = Math.floor(remainingSeconds / 60); // Whole minutes
                    const secs = Math.round(remainingSeconds % 60); // Round seconds to avoid floating-point issues

                    // Format as MM:SS
                    const formattedTime = mins + ':' + secs.toString().padStart(2, '0');

                    // Update the text content
                    document.getElementById('remainingTime').textContent = formattedTime +
                        ' {{ trans('panel.minutes') }}';
                })
                .catch(error => console.error('Error fetching user minutes:', error));
        }

        setInterval(updateRemainingTime, 10000);
        updateRemainingTime();

        //     document.addEventListener('DOMContentLoaded', function() {

        //     @if ($errors->has('nom') || $errors->has('sexe') || $errors->has('level_id'))
        //         window.preventDefault = true;
        //     @endif

        // });
    </script>
    <script>
        function loadNotifications() {
            fetch("{{ route('child.notifications.ajax') }}")
                .then(response => response.json())
                .then(data => {
                    document.getElementById('notifDropdownContainer').innerHTML = data.html;

                    const badge = document.querySelector('#notifDropdown .badge');
                    if (data.unreadCount > 0) {
                        if (!badge) {
                            const newBadge = document.createElement('span');
                            newBadge.className =
                                "position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger";
                            newBadge.innerText = data.unreadCount;
                            document.getElementById('notifDropdown').appendChild(newBadge);
                        } else {
                            badge.innerText = data.unreadCount;
                        }
                    } else if (badge) {
                        badge.remove();
                    }
                })
                .catch(error => console.error("Erreur AJAX notifications :", error));
        }

        // Rafraîchit toutes les 15 secondes
        setInterval(loadNotifications, 15000);
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('childNameInput');
            const output = document.getElementById('newChildName');

            input.addEventListener('input', function() {
                // Update the H3 element with the input's value
                output.textContent = input.value;
            });
        });
    </script>
    <script>
        let countdownInterval;
        let isRunning = false;
        const countdownCircle = document.querySelector(".countdown-circle");
        //const countdownText = document.getElementById("countdown");
        const timeInput = document.getElementById("timeInput");
        const startButton = document.getElementById("startButton");
        const stopButton = document.getElementById("stopButton");
        const startIcon = document.getElementById("startIcon");
        const stopIcon = document.getElementById("stopIcon");
        const circumference = 2 * Math.PI * 45;
        const videoBackground = document.getElementById("video-background");
        const mainContainer = document.getElementById("mainContainer");

        const seasonColors = {
            winter: ["#e0f7fa", "#b2ebf2", "#80deea"], // Ice Blue, Light Cyan, and Light Sky Blue
            spring: ["#ADD8E6", "#FFFACD", "#FFB6C1"], // Light Blue, Lemon Chiffon (Soft Yellow), Light Pink
            summer: ["#FF4500", "#FF7F50", "#FFD700"],
            fall: ["#A0522D", "#D2691E", "#FF8C00"]
        };

        function preloadVideo(url) {
            return new Promise((resolve) => {
                const video = document.createElement("video");
                video.preload = "auto";
                video.src = url;
                video.oncanplaythrough = () => resolve();
            });
        }

        async function changeSeason(season) {
            await preloadVideo(seasonVideos[season]);
            videoBackground.src = seasonVideos[season];
            videoBackground.load();
            videoBackground.oncanplaythrough = () => {
                videoBackground.style.opacity = 1;
            };

            const gradient = document.getElementById("calm-gradient");
            gradient.innerHTML = `
            <stop offset="0%" style="stop-color:${seasonColors[season][0]}" />
            <stop offset="50%" style="stop-color:${seasonColors[season][1]}" />
            <stop offset="100%" style="stop-color:${seasonColors[season][2]}" />
        `;

            const countdownInput = document.querySelector(".countdown-input");
            countdownInput.style.borderColor = seasonColors[season][2];

            document.querySelectorAll(".season-icon").forEach((icon) => {
                icon.classList.remove("active");
                icon.style.color = "";
            });

            const activeIcon = document.getElementById(`${season}Icon`);
            activeIcon.classList.add("active");
            activeIcon.style.color = seasonColors[season][2];
        }
        document.addEventListener("DOMContentLoaded", () => {
            startCountdown();
        });

        function startCountdown() {
            const duration = parseInt(timeInput.value) || 600;
            if (duration <= 0) {
                return;
            }

            let timeLeft = duration;
            isRunning = true;

            countdownCircle.style.animation = "none";
            countdownCircle.getBoundingClientRect();
            countdownCircle.style.animation = `moveGradient ${duration}s linear`;
            countdownCircle.style.strokeDasharray = `${circumference} ${circumference}`;

            updateCountdown(timeLeft, duration);

            countdownInterval = setInterval(() => {
                timeLeft--;
                if (timeLeft < 0) {

                    return;
                }
                updateCountdown(timeLeft, duration);
            }, 1000);

            timeInput.disabled = true;
        }

        function updateCountdown(timeLeft, duration) {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;

            const progress = (duration - timeLeft) / duration;
            const dashoffset = circumference * (1 - progress);
            countdownCircle.style.strokeDashoffset = dashoffset;
        }


        function incrementTime() {
            timeInput.value = (parseInt(timeInput.value) || 0) + 1;
        }

        function decrementTime() {
            timeInput.value = Math.max((parseInt(timeInput.value) || 0) - 1, 1);
        }

        function showTooltip() {
            const tooltip = startButton.querySelector(".tooltip");
            tooltip.style.visibility = "visible";
            tooltip.style.opacity = "1";
            setTimeout(() => {
                tooltip.style.visibility = "hidden";
                tooltip.style.opacity = "0";
            }, 2000);
        }

        timeInput.addEventListener("input", () => {
            if (timeInput.value.trim()) {
                startButton.querySelector(".tooltip").style.display = "none";
            } else {
                startButton.querySelector(".tooltip").style.display = "block";
            }
        });

        function resizeContainer(scale) {
            mainContainer.style.transform = `scale(${scale})`;
        }
    </script>
    <script>
        document.querySelectorAll('.gender-input').forEach(input => {
            input.addEventListener('click', function() {
                document.querySelectorAll('.gender-input').forEach(option => {
                    option.classList.remove('selected');
                    option.querySelector('.gender-field').removeAttribute('name');
                });

                this.classList.add('selected');
                this.querySelector('.gender-field').setAttribute('name', 'sexe');
            });
        });

        // document.querySelectorAll('.level-input').forEach(level => {
        //     level.addEventListener('click', function () {
        //         option.classList.remove('selected');
        //         option.querySelector('input').checked = false;
        //     });
        //     this.classList.add('selected');
        //     this.querySelector('input').checked = true;
        // });

        document.querySelectorAll('.level-input').forEach(level => {
            level.addEventListener('click', function() {
                // Remove 'selected' class from all levels
                document.querySelectorAll('.level-input').forEach(option => {
                    option.classList.remove('selected');
                    option.querySelector('input').checked = false;
                });

                this.classList.add('selected');
                this.querySelector('input').checked = true;
            });
        });


        document.querySelector('form').addEventListener('submit', function(event) {
            let valid = true; // Assume the form is valid initially

            const genderSelected = document.querySelector('.gender-input.selected');
            const levelSelected = document.querySelector('.level-input.selected');
            const genderError = document.querySelector('.gender-error');
            const levelError = document.querySelector('.level-error');
            const childNameInput = document.getElementById('childNameInput');
            const childNameError = document.querySelector('.child-name-error');

            // Reset error messages
            genderError.classList.remove('d-block');
            levelError.classList.remove('d-block');
            childNameError.classList.remove('d-block');

            // Validate gender selection
            if (!genderSelected) {
                valid = false;
                genderError.classList.add('d-block');
            }

            // Validate level selection
            if (!levelSelected) {
                valid = false;
                levelError.classList.add('d-block');
            }

            // Validate child name input
            if (!childNameInput.value) {
                valid = false;
                childNameError.classList.add('d-block');
            }

            // Prevent form submission if any validation failed
            if (!valid) {
                event.preventDefault();
            }
        });
    </script>

    @if ($authUser->isOrganization())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const enfantCount = {{ $enfantsCount }};
                if (enfantCount == 0) {
                    $('#exampleModal').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $('#exampleModal').modal('show');

                }
            });
        </script>
    @endif
@endpush

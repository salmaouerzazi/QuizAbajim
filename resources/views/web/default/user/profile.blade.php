@php
    $layout = auth()->check() ? getTemplate() . '.panel.layouts.panel_layout' : getTemplate() . '.layouts.app';
@endphp

@extends($layout)


@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/persian-datepicker/persian-datepicker.min.css" />
    <link rel="stylesheet" href="/assets/default/css/css-stars.css">
    <link rel="stylesheet" href="/assets/default/css/style.css">
    <link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
<style>
    .border-left {
        border-left: 1px solid #ececec !important;
    }

    .profile-name {
        font-size: 0.8rem;
    }

    @media (min-width: 576px) {
        .profile-name {
            font-size: 1.5rem;
        }
    }

    .nav-tabs {
        border-bottom: 1px solid #ececec;
    }

    .nav-tabs .nav-item {
        border-radius: 0.25rem;
        padding: 10px;
        transition: all 0.3s ease-in-out;
    }

    .nav-tabs .nav-item a {
        text-decoration: none;
        color: var(--primary);
        border: 1px solid var(--primary);
        border-radius: 0.25rem;
        padding: 10px;
    }

    .nav-tabs .nav-item a:hover {
        background: linear-gradient(45deg, #0056b3, #31a2b8);
        color: white;
        border: none;
        border-radius: 0.25rem;
        padding: 10px;
        box-shadow: 0px 3px 10px rgba(0, 86, 179, 0.2);
    }

    /* When active, remove border completely */
    .nav-tabs .nav-item a.active {
        border: none !important;
        outline: none !important;
        background: linear-gradient(45deg, #0056b3, #31a2b8);
        color: white !important;
        border-radius: 0.25rem;
        padding: 10px;
        box-shadow: 0px 3px 10px rgba(0, 86, 179, 0.2);
    }
</style>

@section('content')
    <section class="site-top-banner position-relative">
        <img src="{{ $user->getCover() }}" class="img-cover" alt="" />
    </section>

    <section class="container">
        <div class="rounded-lg shadow-sm px-25 py-20 px-lg-50 py-lg-35 position-relative user-profile-info bg-white">
            <div class="row profile-info-box d-flex align-items-start justify-content-between">

                <!-- MAIN COLUMN -->
                <div class="col-12 user-details">
                    <div class="d-flex flex-sm-row align-items-start align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="user-profile-avatar bg-gray200 flex-shrink-0">
                                <img src="{{ $user->getAvatar(190) }}" class="img-cover" alt="{{ $user['full_name'] }}" />

                                @if ($user->offline)
                                    <span
                                        class="user-circle-badge unavailable d-flex align-items-center justify-content-center">
                                        <i data-feather="slash" width="20" height="20" class="text-white"></i>
                                    </span>
                                @elseif($user->verified)
                                    <span
                                        class="user-circle-badge has-verified d-flex align-items-center justify-content-center">
                                        <i data-feather="check" width="20" height="20" class="text-white"></i>
                                    </span>
                                @endif
                            </div>

                            <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center">
                                <div class="d-flex flex-column ml-20">
                                    <h2 class="profile-name font-weight-bold text-dark-blue mb-0">
                                        {{ $user['full_name'] }}
                                    </h2>
                                    <span class="text-gray d-block">
                                        {{ $user['headline'] }}
                                    </span>
                                    <div class="follower-count mt-1">
                                        <span id="followerCount_{{ $user['id'] }}">
                                            {{ DB::table('teachers')->where('teacher_id', $user['id'])->count() }}
                                        </span>
                                        {{ trans('panel.followers') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @include('web.default.user.follow_user.follow_user', ['user_id' => $user['id']])
                    </div>

                    @if (!empty($user->about))
                        <div class="mt-10">
                            <h3 class="font-16 text-dark-blue font-weight-bold">
                                {{ trans('site.about') }}
                            </h3>
                            <div class="mt-5">
                                @php
                                    $aboutText = strip_tags($user->about);
                                    $maxLength = 440;
                                    if (strlen($aboutText) > $maxLength) {
                                        $displayText = substr($aboutText, 0, $maxLength) . '...';
                                    } else {
                                        $displayText = $aboutText;
                                    }
                                @endphp
                                <p>{!! nl2br($displayText) !!}</p>
                            </div>
                        </div>
                    @endif

                    <h3 class="font-16 text-dark-blue font-weight-bold mt-10 mb-5">
                        {{ trans('panel.teacher_levels_materials') }} :
                    </h3>
                    <div class="w-100 d-flex align-items-center justify-content-center justify-content-lg-start">
                        <div class="d-flex followers-status flex-wrap">
                            @if (!empty($levelMaterials))
                                @foreach ($levelMaterials as $levelName => $materials)
                                    <span class="font-14 font-weight-bold text-dark-blue mr-5 mb-2">
                                        {{ $levelName }} :
                                        @foreach ($materials as $material)
                                            <span class="font-14 ml-2 text-dark-blue" style="font-weight: 400">
                                                {{ $material }}
                                            </span>
                                        @endforeach
                                    </span>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container mt-30">
        <section class="rounded-lg border px-10 pb-35 pt-5 position-relative">
            <ul class="nav nav-tabs d-flex align-items-center px-10 px-lg-50 pb-15" id="tabs-tab" role="tablist">
                <li class="nav-item tab-item  mt-30">
                    <a class="position-relative text-dark-blue font-weight-500 font-14 active" id="about-tab"
                        data-toggle="tab" href="#about" role="tab" aria-controls="about"
                        aria-selected="true">{{ trans('site.about') }}</a>
                </li>
                <li class="nav-item tab-item  mt-30">
                    <a class="position-relative text-dark-blue font-weight-500 font-14 {{ request()->get('tab') == 'posts' ? 'active' : '' }}"
                        id="webinars-tab" data-toggle="tab" href="#posts" role="tab" aria-controls="posts"
                        aria-selected="false">{{ trans('panel.myscolaiemanuel') }}</a>
                </li>
                <li class="nav-item tab-item  mt-30">
                    <a class="position-relative text-dark-blue font-weight-500 font-14 {{ request()->get('tab') == 'webinars' ? 'active' : '' }}"
                        id="webinars-tab" data-toggle="tab" href="#webinars" role="tab" aria-controls="webinars"
                        aria-selected="false">{{ trans('panel.classes') }}</a>
                </li>

                @if ($user->isOrganization())
                    <li class="nav-item tab-item  mr-lg-50 mt-30">
                        <a class="position-relative text-dark-blue font-weight-500 font-14 {{ request()->get('tab') == 'instructors' ? 'active' : '' }}"
                            id="instructors-tab" data-toggle="tab" href="#instructors" role="tab"
                            aria-controls="instructors" aria-selected="false">{{ trans('home.instructors') }}</a>
                    </li>
                @endif

                @if (!empty(getStoreSettings('status')) and getStoreSettings('status'))
                    <li class="nav-item tab-item mr-20 mr-lg-50 mt-30">
                        <a class="position-relative text-dark-blue font-weight-500 font-14 {{ request()->get('tab') == 'products' ? 'active' : '' }}"
                            id="webinars-tab" data-toggle="tab" href="#products" role="tab" aria-controls="products"
                            aria-selected="false">{{ trans('update.products') }}</a>
                    </li>
                @endif



                @if (!empty(getFeaturesSettings('forums_status')) and getFeaturesSettings('forums_status'))
                    <li class="nav-item tab-item mr-20 mr-lg-50 mt-30">
                        <a class="position-relative text-dark-blue font-weight-500 font-14 {{ request()->get('tab') == 'forum' ? 'active' : '' }}"
                            id="webinars-tab" data-toggle="tab" href="#forum" role="tab" aria-controls="forum"
                            aria-selected="false">{{ trans('update.forum') }}</a>
                    </li>
                @endif

                {{-- <li class="tab-item mr-20 mr-lg-50 mt-30">
                    <a class="position-relative text-dark-blue font-weight-500 font-14 {{ request()->get('tab') == 'badges' ? 'active' : '' }}"
                        id="badges-tab" data-toggle="tab" href="#badges" role="tab" aria-controls="badges"
                        aria-selected="false">{{ trans('site.badges') }}</a>
                </li> --}}

                {{-- <li class="tab-item mr-20 mr-lg-50 mt-30">
                    <a class="position-relative text-dark-blue font-weight-500 font-14 {{ request()->get('tab') == 'appointments' ? 'active' : '' }}"
                        id="appointments-tab" data-toggle="tab" href="#appointments" role="tab"
                        aria-controls="appointments" aria-selected="false">{{ trans('panel.live_sessions') }}</a>
                </li> --}}
            </ul>

            <div class="tab-content" id="nav-tabContent">

                <div class="tab-pane fade px-20 px-lg-50" id="about" role="tabpanel" aria-labelledby="about-tab">
                    @include('web.default.user.profile_tabs.about')
                </div>

                <div class="tab-pane fade" id="webinars" role="tabpanel" aria-labelledby="webinars-tab">
                    @include('web.default.user.profile_tabs.webinars')
                </div>

                @if ($user->isOrganization())
                    <div class="tab-pane fade" id="instructors" role="tabpanel" aria-labelledby="instructors-tab">
                        @include('web.default.user.profile_tabs.instructors')
                    </div>
                @endif

                <div class="tab-pane fade" id="posts" role="tabpanel" aria-labelledby="posts-tab">
                    @include('web.default.user.profile_tabs.posts')
                </div>

                @if (!empty(getFeaturesSettings('forums_status')) and getFeaturesSettings('forums_status'))
                    <div class="tab-pane fade" id="forum" role="tabpanel" aria-labelledby="forum-tab">
                        @include('web.default.user.profile_tabs.forum')
                    </div>
                @endif

                @if (!empty(getStoreSettings('status')) and getStoreSettings('status'))
                    <div class="tab-pane fade" id="products" role="tabpanel" aria-labelledby="products-tab">
                        @include('web.default.user.profile_tabs.products')
                    </div>
                @endif

                <div class="tab-pane fade" id="badges" role="tabpanel" aria-labelledby="badges-tab">
                    @include('web.default.user.profile_tabs.badges')
                </div>

                <div class="tab-pane fade px-20 px-lg-50" id="appointments" role="tabpanel"
                    aria-labelledby="appointments-tab">
                    @include('web.default.user.profile_tabs.appointments')
                </div>
            </div>
        </section>
    </div>

    <!-- Unfollow Confirmation Modal -->
    <div class="modal fade" id="confirmUnfollowModal" tabindex="-1" aria-labelledby="confirmUnfollowModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title p-5" id="confirmUnfollowModalLabel">{{ trans('panel.confirm_unfollow') }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ trans('panel.confirm_unfollow_desc') }}
                </div>
                <div class="modal-footer">
                    <form method="POST" id="unfollowForm">
                        @csrf
                        <input type="hidden" id="unfollowUserId" name="user_id">
                        <button type="submit" class="btn btn-danger">{{ trans('panel.unfollow') }}</button>
                    </form>


                </div>
            </div>
        </div>
    </div>


    @include('web.default.user.send_message_modal')
@endsection

@push('scripts_bottom')
    <script>
        var unFollowLang = '{{ trans('panel.unfollow') }}';
        var followLang = '{{ trans('panel.follow') }}';
        var reservedLang = '{{ trans('meeting.reserved') }}';
        var availableDays = {{ json_encode($times) }};
        var messageSuccessSentLang = '{{ trans('site.message_success_sent') }}';
        var followersText = '{{ trans('panel.followers') }}';
    </script>
    <script src="/assets/default/vendors/persian-datepicker/persian-date.js"></script>
    <script src="/assets/default/vendors/persian-datepicker/persian-datepicker.js"></script>
    {{-- <script src="/assets/default/js/parts/profile.min.js"></script> --}}
    <script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            var urlParams = new URLSearchParams(window.location.search);
            var activeTab = urlParams.get('tab') || 'about';
            $('.tab-pane').removeClass('show active');
            $('#' + activeTab).addClass('show active');
            $('.tab-item a').removeClass('active');
            $('a[href="#' + activeTab + '"]').addClass('active');

            $('.tab-item a').on('click', function(e) {
                e.preventDefault();
                var targetTab = $(this).attr('href').substring(1);

                $('.tab-pane').removeClass('show active');
                $('#' + targetTab).addClass('show active');

                $('.tab-item a').removeClass('active');
                $(this).addClass('active');

                var url = new URL(window.location.href);
                url.searchParams.set('tab', targetTab);
                window.history.pushState({}, '', url);
            });

            window.addEventListener('popstate', function(event) {
                var urlParams = new URLSearchParams(window.location.search);
                var activeTab = urlParams.get('tab') || 'about';

                $('.tab-pane').removeClass('show active');
                $('#' + activeTab).addClass('show active');
                $('.tab-item a').removeClass('active');
                $('a[href="#' + activeTab + '"]').addClass('active');
            });
        });
    </script>
@endpush

@extends(getTemplate() . '.panel.layouts.panel_layout')

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
</style>

@section('content')
    <section class="site-top-banner position-relative">
        <img src="{{ $user->getCover() }}" class="img-cover" alt="" />
    </section>

    <section class="container">
        <div class="rounded-lg shadow-sm px-25 py-20 px-lg-50 py-lg-35 position-relative user-profile-info bg-white">
            <div class="row profile-info-box d-flex align-items-start justify-content-between">
                <div class="col-12 user-details d-flex align-items-center">
                    <div class="user-profile-avatar bg-gray200">
                        @if (!empty($user->avatar))
                            <img src="{{ $user->getAvatar(190) }}" class="img-cover" alt="{{ $user['full_name'] }}" />
                        @else
                            <img src="{{ $user->getAvatar(190) }}" class="img-cover" alt="{{ $user['full_name'] }}" />
                        @endif

                        @if ($user->offline)
                            <span class="user-circle-badge unavailable d-flex align-items-center justify-content-center">
                                <i data-feather="slash" width="20" height="20" class="text-white"></i>
                            </span>
                        @elseif($user->verified)
                            <span class="user-circle-badge has-verified d-flex align-items-center justify-content-center">
                                <i data-feather="check" width="20" height="20" class="text-white"></i>
                            </span>
                        @endif
                    </div>
                    <div class="ml-20 ml-lg-40">
                        <div class="row">
                            <div class="col-12 col-md-9">
                                <h1 class="font-24 font-weight-bold text-dark-blue">{{ $user['full_name'] }}</h1>
                                <span class="text-gray">{{ $user['headline'] }}</span>
                                <div class="follower-count">
                                    <span
                                        id="followerCount_{{ $user['id'] }}">{{ DB::table('teachers')->where('teacher_id', $user['id'])->count() }}</span>
                                    {{ trans('panel.followers') }}
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                @auth
                                    <button type="button" id="followToggle" data-user-id="{{ $user['id'] }}"
                                        class="btn btn-{{ !empty($authUserIsFollower) && $authUserIsFollower ? 'danger' : 'primary' }} btn-sm">
                                        @if (!empty($authUserIsFollower) && $authUserIsFollower)
                                            {{ trans('panel.unfollow') }}
                                        @else
                                            {{ trans('panel.follow') }}
                                        @endif
                                    </button>
                                @else
                                    <button type="button" onclick="window.location.href='/login';"
                                        class="btn btn-primary btn-sm">
                                        {{ trans('panel.follow') }}
                                    </button>
                                @endauth
                            </div>
                        </div>
                        @if (!empty($user->about))
                            <div class="mt-10">
                                <h3 class="font-16 text-dark-blue font-weight-bold">{{ trans('site.about') }}</h3>
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

                        <h3 class="font-16 text-dark-blue font-weight-bold mt-10">
                            {{ trans('panel.teacher_levels_materials') }}
                        </h3>
                        <div class="w-100 d-flex align-items-center justify-content-center justify-content-lg-start">
                            <div class="d-flex followers-status">
                                @if (!empty($levelMaterials))
                                    @foreach ($levelMaterials as $levelName => $materials)
                                        <span class="font-14 font-weight-bold text-dark-blue mr-5">{{ $levelName }} :
                                            @foreach ($materials as $material)
                                                <span class="font-14 text-dark-blue"> {{ $material->name }}
                                                    |
                                                </span>
                                            @endforeach
                                        </span>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        @if ($user->public_message)
                            <button type="button"
                                class="js-send-message btn btn-border-white rounded btn-sm mt-15">{{ trans('site.send_message') }}</button>
                        @endif



                        {{-- <div class="user-reward-badges d-flex flex-wrap align-items-center mt-15">
                            @if (!empty($userBadges))
                                @foreach ($userBadges as $userBadge)
                                    <div class="mr-15" data-toggle="tooltip" data-placement="bottom" data-html="true"
                                        title="{!! !empty($userBadge->badge_id) ? nl2br($userBadge->badge->description) : nl2br($userBadge->description) !!}">
                                        <img src="{{ !empty($userBadge->badge_id) ? $userBadge->badge->image : $userBadge->image }}"
                                            width="32" height="32"
                                            alt="{{ !empty($userBadge->badge_id) ? $userBadge->badge->title : $userBadge->title }}">
                                    </div>
                                @endforeach
                            @endif
                        </div> --}}
                    </div>
                </div>
                {{-- <div class="col-md-6">
                    <div class="row mt-30 w-100 d-flex align-items-center justify-content-around">
                        <div class="col-6 col-md-3 user-profile-state d-flex flex-column align-items-center">
                            <div class="state-icon orange p-15 rounded-lg">
                                <img src="/assets/default/img/profile/students.svg" alt="">
                            </div>
                            <span class="font-20 text-dark-blue font-weight-bold mt-5">{{ $user->students_count }}</span>
                            <span class="font-14 text-gray">{{ trans('quiz.students') }}</span>
                        </div>

                        <div class="col-6 col-md-3 user-profile-state d-flex flex-column align-items-center">
                            <div class="state-icon blue p-15 rounded-lg">
                                <img src="/assets/default/img/profile/webinars.svg" alt="">
                            </div>
                            <span class="font-20 text-dark-blue font-weight-bold mt-5">{{ count($webinars) }}</span>
                            <span class="font-14 text-gray">{{ trans('webinars.classes') }}</span>
                        </div>

                        <div class="col-6 col-md-3 mt-20 mt-md-0 user-profile-state d-flex flex-column align-items-center">
                            <div class="state-icon green p-15 rounded-lg">
                                <img src="/assets/default/img/profile/reviews.svg" alt="">
                            </div>
                            <span class="font-20 text-dark-blue font-weight-bold mt-5">{{ $user->reviewsCount() }}</span>
                            <span class="font-14 text-gray">{{ trans('product.reviews') }}</span>
                        </div>

                        <div class="col-6 col-md-3 mt-20 mt-md-0 user-profile-state d-flex flex-column align-items-center">
                            <div class="state-icon royalblue p-15 rounded-lg">
                                <img src="/assets/default/img/profile/appointments.svg" alt="">
                            </div>
                            <span class="font-20 text-dark-blue font-weight-bold mt-5">{{ $appointments }}</span>
                            <span class="font-14 text-gray">{{ trans('site.appointments') }}</span>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </section>

    <div class="container mt-30">
        <section class="rounded-lg border px-10 pb-35 pt-5 position-relative">
            <ul class="nav nav-tabs d-flex align-items-center px-20 px-lg-50 pb-15" id="tabs-tab" role="tablist">
                <li class="nav-item mr-20 mr-lg-50 mt-30">
                    <a class="position-relative text-dark-blue font-weight-500 font-14 active" id="about-tab"
                        data-toggle="tab" href="#about" role="tab" aria-controls="about"
                        aria-selected="true">{{ trans('site.about') }}</a>
                </li>
                <li class="nav-item mr-20 mr-lg-50 mt-30">
                    <a class="position-relative text-dark-blue font-weight-500 font-14 {{ request()->get('tab') == 'posts' ? 'active' : '' }}"
                        id="webinars-tab" data-toggle="tab" href="#posts" role="tab" aria-controls="posts"
                        aria-selected="false">{{ trans('panel.myscolaiemanuel') }}</a>
                </li>
                {{-- <li class="nav-item mr-20 mr-lg-50 mt-30">
                    <a class="position-relative text-dark-blue font-weight-500 font-14 {{ request()->get('tab') == 'webinars' ? 'active' : '' }}"
                        id="webinars-tab" data-toggle="tab" href="#webinars" role="tab" aria-controls="webinars"
                        aria-selected="false">{{ trans('panel.classes') }}</a>
                </li> --}}

                @if ($user->isOrganization())
                    <li class="nav-item mr-20 mr-lg-50 mt-30">
                        <a class="position-relative text-dark-blue font-weight-500 font-14 {{ request()->get('tab') == 'instructors' ? 'active' : '' }}"
                            id="instructors-tab" data-toggle="tab" href="#instructors" role="tab"
                            aria-controls="instructors" aria-selected="false">{{ trans('home.instructors') }}</a>
                    </li>
                @endif

                @if (!empty(getStoreSettings('status')) and getStoreSettings('status'))
                    <li class="nav-item mr-20 mr-lg-50 mt-30">
                        <a class="position-relative text-dark-blue font-weight-500 font-14 {{ request()->get('tab') == 'products' ? 'active' : '' }}"
                            id="webinars-tab" data-toggle="tab" href="#products" role="tab" aria-controls="products"
                            aria-selected="false">{{ trans('update.products') }}</a>
                    </li>
                @endif



                @if (!empty(getFeaturesSettings('forums_status')) and getFeaturesSettings('forums_status'))
                    <li class="nav-item mr-20 mr-lg-50 mt-30">
                        <a class="position-relative text-dark-blue font-weight-500 font-14 {{ request()->get('tab') == 'forum' ? 'active' : '' }}"
                            id="webinars-tab" data-toggle="tab" href="#forum" role="tab" aria-controls="forum"
                            aria-selected="false">{{ trans('update.forum') }}</a>
                    </li>
                @endif

                {{-- <li class="nav-item mr-20 mr-lg-50 mt-30">
                    <a class="position-relative text-dark-blue font-weight-500 font-14 {{ request()->get('tab') == 'badges' ? 'active' : '' }}"
                        id="badges-tab" data-toggle="tab" href="#badges" role="tab" aria-controls="badges"
                        aria-selected="false">{{ trans('site.badges') }}</a>
                </li> --}}

                {{-- <li class="nav-item mr-20 mr-lg-50 mt-30">
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
            var initialTab = window.location.hash ? window.location.hash : '#about';

            $('.tab-pane').removeClass('show active');
            $(initialTab).addClass('show active');

            $('.nav-item a').on('click', function(e) {
                e.preventDefault();
                $('.tab-pane').removeClass('show active');
                var targetTab = $(this).attr('href');
                $(targetTab).addClass('show active');
            });

            $('.nav-item a').on('click', function(e) {
                e.preventDefault();
                var targetTab = $(this).attr('href').substring(1);
                var url = new URL(window.location.href);
                url.searchParams.set('tab', targetTab);
                window.history.pushState({}, '', url);
                $('.tab-pane').removeClass('show active');
                $('#' + targetTab).addClass('show active');
            });
        });

        window.addEventListener('popstate', function(event) {
            var url = new URL(window.location.href);
            var activeTab = url.searchParams.get('tab') || 'about';
            $('.tab-pane').removeClass('show active');
            $('#' + activeTab).addClass('show active');
        });

        let subscriptionStatusArray = {};
        let followRequestInProgress = {};
        let followerCountTracker = {};

        document.addEventListener("DOMContentLoaded", function() {
            const followButton = document.getElementById("followToggle");
            if (followButton) {
                followButton.addEventListener('click', function() {
                    const userId = this.getAttribute('data-user-id');
                    handleFollowUnfollow(userId);
                });
            }
        });

        function handleFollowUnfollow(teacherId) {
            if (followRequestInProgress[teacherId]) {
                return;
            }

            const isSubscribed = subscriptionStatusArray[teacherId];
            const url = isSubscribed ? `/panel/unfollow/${teacherId}` : `/panel/add`;
            const method = 'POST';

            followRequestInProgress[teacherId] = true;

            fetch(url, {
                    method: method,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        teacher_id: teacherId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log("Response Data:", data);
                    if (data.isSubscribed !== undefined) {
                        subscriptionStatusArray[teacherId] = data.isSubscribed;
                        followerCountTracker[teacherId] = data.newFollowerCount;
                        updateFollowUI(teacherId, data.isSubscribed, data.newFollowerCount);
                    }
                })
                .catch(error => console.error('Error:', error))
                .finally(() => {
                    followRequestInProgress[teacherId] = false;
                });
        }

        function updateFollowUI(teacherId, isSubscribed, newFollowerCount) {
            const followButton = document.getElementById("followToggle");
            const followerCountElement = document.getElementById(`followerCount_${teacherId}`);

            if (isSubscribed) {
                followButton.classList.replace('btn-primary', 'btn-danger');
                followButton.textContent = unFollowLang;
            } else {
                followButton.classList.replace('btn-danger', 'btn-primary');
                followButton.textContent = followLang;
            }

            if (followerCountElement) {
                followerCountElement.textContent = newFollowerCount;
            }
        }
    </script>
@endpush

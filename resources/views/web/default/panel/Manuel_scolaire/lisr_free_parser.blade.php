@extends(getTemplate() . '.panel.layouts.panel_layout')
@php
    if (empty($authUser) and auth()->check()) {
        $authUser = auth()->user();
    }
@endphp

@push('styles_top')
    <link ref="stylesheet" href="/assets/default/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/default/css/lisr_free_parser.css">
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
@endpush

<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')
    <div class="row">
        @if (request()->has(['icon', 'page']))
            <div
                class="col-12 @if (count($videos) === 1) col-lg-9 @elseif (count($videos) === 0) col-12 @else col-lg-8 @endif">
                <?php
                $currentDateTimestamp = now()->startOfDay()->timestamp;
                
                $usermin = DB::table('user_min_watched')
                    ->where('user_id', auth()->user()->id)
                    ->first();
                $userOrder = DB::table('orders')
                    ->where('user_id', auth()->user()->id)
                    ->where('status', 'paid')
                    ->exists();
                ?>
                @if (count($videos) > 0)
                    <div class="video-details-container">
                        <h1 id="title" class="video-title">
                            {{ $videos[0]->manuel->name }} : {{ $videos[0]->titleAll }}
                        </h1>
                        <input type="hidden" id="id_teacher" data-teacher-id={{ $videos[0]->teachers->id }}
                            name="user_idteacher" value="{{ $videos[0]->teachers->id }}">
                        <video id="mainVideoPlayer" data-video-id="{{ $videos[0]->id }}" class="video-player"
                            oncontextmenu="return false;" controls controlsList="nodownload"
                            @if (
                                ($usermin->minutes_watched_day ?? 0) >= 10.0 &&
                                    !$userOrder &&
                                    $currentDateTimestamp == $usermin->latest_watched_day) disabled="disabled"
                                data-bs-toggle="modal" 
                                data-bs-target="#subscriptionModal" @endif>
                            <source src="{{ asset($videos[0]->video) }}" type="video/mp4">
                            <source src="{{ asset($videos[0]->video) }}" type="video/webm">
                            {{ trans('panel.no_support_video') }}
                        </video>

                        <div class="video-controls mb-50">
                            <div id="top-row" class="teacher-info">
                                @if (!empty($videos[0]->teachers->avatar))
                                    <img id="img" src="{{ $videos[0]->teachers->avatar }}" alt=""
                                        class="teacher-avatar">
                                @else
                                    <img id="img" src="{{ $videos[0]->teachers->getAvatar(100) }}"
                                        class=" teacher-avatar" alt="{{ $videos[0]->teachers->full_name }}">
                                @endif
                                <div class="d-flex flex-column">
                                    <a href="/users/{{ $videos[0]->teachers->id }}/profile" target="_blank"
                                        id="teacherLink" class="teacher-name font-14"
                                        data-teacher-id="{{ $videos[0]->teachers->id }}">
                                        <span id="nameteac" class="font-14">{{ $videos[0]->teachers->full_name }}

                                        </span>
                                    </a>
                                    <span id="followersCount" class="font-14 followers-count"
                                        data-teacher-id="{{ $videos[0]->teachers->id }}">
                                        {{ trans('panel.followers') }}
                                        {{ DB::table('teachers')->where('teacher_id', $videos[0]->teachers->id)->count() }}
                                    </span>
                                </div>
                                <div class="btn-group">
                                    <div class="unsubscribe-section follow-control"
                                        style="display: {{ $isSubscribed ? '' : 'none' }}"
                                        data-teacher-id="{{ $videos[0]->teachers->id }}">

                                        <button type="button" class="btn btn-success dropdown-toggle text-dark"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            {{ trans('panel.followed') }}
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#confirmUnfollowModal"
                                                    data-teacher-id="{{ $videos[0]->teachers->id }}">
                                                    {{ trans('panel.unfollow') }}
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="subscribe-section follow-control"
                                        style="display: {{ $isSubscribed ? 'none' : '' }}"
                                        data-teacher-id="{{ $videos[0]->teachers->id }}">
                                        <button class="btn btn-primary follow-button"
                                            data-teacher-id="{{ $videos[0]->teachers->id }}" onclick="handleFollow(event)">
                                            {{ trans('panel.follow') }}
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center" style="align-items:center!important">
                                <button id="likeButton" class="like-button" data-video-id="{{ $videos[0]->id }}">
                                    <i id="likeIcon"
                                        class="{{ auth()->user()->likes()->where('video_id', $videos[0]->id)->exists() ? 'fas fa-heart' : 'far fa-heart' }}"
                                        style="font-size: 35px; color: {{ auth()->user()->likes()->where('video_id', $videos[0]->id)->exists() ? '#f52e4b' : 'black' }};">
                                    </i>

                                </button>
                                <span id="likesCount">{{ $videos[0]->likes }}</span>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="d-flex flex-column align-items-center justify-content-center mt-20">
                        <img width="300px" src="/assets/default/icons/no-videos.webp" />
                        <h2 class="section-title text-center font-20">
                            {{ trans('panel.no_videos_found') }}
                        </h2>
                        <p class="mt-1 text-center font-14">
                            {{ trans('panel.no_videos_found_desc') }}
                        </p>
                    </div>
                @endif
            </div>

            @if (count($videos) > 1)
                <div class="col-lg-4 col-12">
                    <h1 class="more-videos-title text-center">{{ trans('panel.more_videos') }}</h1>
                    @foreach ($videos as $video)
                        @php
                            $teacherId = $video->teachers->id;
                            $titleAll = $video->titleAll;
                            $isSubscribed = $subscriptions[$teacherId] ?? false;
                            $isLiked = auth()->user()->likes()->where('video_id', $video->id)->exists();
                        @endphp
                        <input id="titleloadvideo" value="{{ $video->titleAll }}" hidden>
                        <div class="webinar-card webinar-list webinar-list-2 d-flex m-30">
                            <div class="webinar-card-body d-flex flex-column">
                                <div class="image-box" style="cursor: pointer" data-video-url="{{ asset($video->video) }}"
                                    data-video-id="{{ $video->id }}" data-titleAll="{{ $titleAll }}"
                                    data-teacher-name="{{ $video->teachers->full_name }}"
                                    data-teacher-id="{{ $teacherId }}"
                                    data-teacher-avatar="{{ !empty($video->teachers->avatar) ? $video->teachers->avatar : $video->teachers->getAvatar(100) }}"
                                    data-likes="{{ $video->likes }}"
                                    data-follows="{{ DB::table('teachers')->where('teacher_id', $teacherId)->count() }}"
                                    data-is-liked="{{ $isLiked ? 'true' : 'false' }}"
                                    data-is-subscribed="{{ $isSubscribed ? 'true' : 'false' }}">
                                    <video width="100%" height="100%">
                                        <source src="{{ asset($video->video) }}" type="video/mp4">
                                        <source src="{{ asset($video->video) }}" type="video/webm">
                                    </video>
                                </div>
                                <div class="d-flex" style="justify-content:space-between">
                                    <div class="user-inline-avatar d-flex align-items-center">
                                        <div class="avatar bg-gray100">
                                            @if (!empty($video->teachers->avatar))
                                                <img src="{{ $video->teachers->avatar }}" alt=""
                                                    class="img-cover">
                                            @else
                                                <img src="{{ $video->teachers->getAvatar(100) }}" class="img-cover"
                                                    alt="{{ $video->teachers->full_name }}">
                                            @endif
                                        </div>
                                        <div class="d-flex justify-content-center flex-column">
                                            <a href="" target="_blank" class="user-name ml-5 font-14">
                                                {{ $video->teachers->full_name }}
                                            </a>
                                            <span class="font-14 followers-count"
                                                data-teacher-id="{{ $video->teachers->id }}">
                                                {{ trans('panel.followers') }}
                                                {{ DB::table('teachers')->where('teacher_id', $video->teachers->id)->count() }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <img width="15" height="15" src="/heart1.png" class="webinar-icon" />
                                        <span style="font-size: small;" data-video-id="{{ $video->id }}"
                                            class="date-published ml-5">{{ $video->likes }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @else
            <!-- If no icon/page in request -->
            <div class="col-sm-11 mt-5 manuel-scolaire ">
                @if (!empty($t3DPathManuels[0]))
                    <a href="{{ $t3DPathManuels[0] }}" class="fp-embed" data-fp-width="100%" data-fp-height="80vh"
                        data-options='{"LinkTarget": "none"}'></a>
                @else
                    <object data="{{ asset($pdfPath) }}#toolbar=0&page={{ $page }}&zoom=auto"
                        type="application/pdf" width="100%" height="100%">
                        <p>Unable to display PDF file. <a href="{{ $pdfPath }}">Download</a> instead.</p>
                    </object>
                @endif
            </div>

            <div class="col-lg-1 d-none d-lg-block scrollable-manuels">
                @php
                    $currentManuelId = request()->segment(3);
                @endphp
                @foreach ($Manuels as $manuel)
                    <a href="/panel/scolaire/{{ $manuel->id }}">
                        <img class="manuel-image"
                            style="border: {{ $manuel->id == $currentManuelId ? '1px solid var(--primary)' : 'none' }};"
                            src="{{ asset($manuel->logo) }}" alt="{{ $manuel->name }}">
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    <!-- ------------- UNFOLLOW MODAL ------------- -->
    <div class="modal fade" id="confirmUnfollowModal" tabindex="-1" aria-labelledby="confirmUnfollowModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmUnfollowModalLabel">{{ trans('panel.confirm_unfollow') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{ trans('panel.confirm_unfollow_desc') }}
                </div>
                <div class="modal-footer">
                    <form method="POST" action="" id="unfollowForm">
                        @csrf
                        <button type="submit" class="btn btn-danger">{{ trans('panel.unfollow') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts_bottom')
    <script>
        const followersText = "{{ trans('panel.followers') }}";
        const isEnfant = "{{ $authUser->isEnfant() }}";
        const next = "{{ trans('panel.next') }}";
        const followedText = "{{ trans('panel.followed') }}";
        const followText = "{{ trans('panel.followed') }}";
        const updateGuideProgressUrl = "{{ route('update.guide.progress') }}";
        const fetchProgressUrl = "{{ route('fetch.progress') }}";
        const description1 = "{{ trans('panel.step_1_child_manuel_description_part_1') }}";
        const description2 = "{{ trans('panel.step_1_child_manuel_description_part_2') }}";
        const description3 = "{{ trans('panel.step_1_child_manuel_description_part_3') }}";
        const description4 = "{{ trans('panel.step_1_child_manuel_description_part_4') }}";
        const descriptionStep2 = "{{ trans('panel.step_2_child_manuel_description') }}";
    </script>
    <script async defer src="/assets/default/js/panel/flowpaper.min.js"></script>
    <script src="/assets/default/js/parts/main.min.js"></script>
    <script src="https://unpkg.com/shepherd.js@8.1.0/dist/js/shepherd.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/shepherd.js@8.1.0/dist/css/shepherd.css" />
    <script src="/assets/default/js/panel/lisr_free_parser.js?time={{ now() }}"></script>
    @if (empty($justMobileApp) and checkShowCookieSecurityDialog())
        @include('web.default.includes.cookie-security')
    @endif
    <script src='https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js'></script>
    <script src='https://unpkg.com/vue-the-mask@0.11.1/dist/vue-the-mask.js'></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('{{ route('clear-session') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    cache: 'no-cache',
                    body: JSON.stringify({})
                })
                .then(response => response.json())
                .then(data => console.log(data.success))
                .catch(error => console.error('Fetch error:', error));
        });
    </script>
@endpush

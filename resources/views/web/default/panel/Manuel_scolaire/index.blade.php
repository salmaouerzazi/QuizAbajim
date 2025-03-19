@extends(getTemplate() . '.panel.layouts.panel_layout')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/daterangepicker/daterangepicker.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/video/video-js.min.css">
    <link rel="stylesheet" href="/assets/default/css/manuelScolaire.css">
@endpush
<style>
    .modal {
        z-index: 509px !important;
    }

    * {
        font-family: 'Tajawal', sans-serif;
    }

    .activities-container {
        padding: 20px;
        margin: auto;
    }

    .activities-container .row {
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
    }

    .activities-container .col-md-3 {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 30px;
    }

    .activities-container .col-md-3 div {
        background-color: #f0f4f7;
        border-radius: 12px;
        padding: 15px;
        width: 100%;
        transition: transform 0.3s;
    }

    .activities-container .col-md-3:hover div {
        transform: translateY(-5px);
    }

    .stats-icon {
        width: 80px;
        height: 70px;
    }

    @media (max-width: 767px) {
        .stats-icon {
            width: 70px;
            height: 70px;
        }
    }

    .activities-container .col-md-3:nth-child(1) div {
        background-color: #e9f5ff;
    }

    .activities-container .col-md-3:nth-child(2) div {
        background-color: #e9ffe9;
    }

    .activities-container .col-md-3:nth-child(3) div {
        background-color: #fff0f0;
    }

    .activities-container .col-md-3:nth-child(4) div {
        background-color: #f0e9ff;
    }

    .panel-section-card {
        background-color: #ffffff;
        border-radius: 12px;
        width: 100%;
        transition: transform 0.3s;
        margin: auto;
    }

    .input-label {
        display: block;
        margin-bottom: 8px;
        color: #333;
        font-size: 16px;
    }

    .select2-container--default .select2-selection--single {
        border: 1px solid #ccc;
        border-radius: 4px;
        height: calc(1.5em + .75rem + 2px);
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 1.5;
        padding-left: 12px;
    }

    @media (max-width: 768px) {
        .panel-section-card {
            padding: 15px;
        }
    }

    option {
        font-family: 'Tajawal', sans-serif !important;
    }

    .video-section {
        padding: 20px;
        background-color: #f8f9fa;
    }

    .section-title {
        font-size: 16px;
        color: #333;
        padding: 10px
    }

    .video-card {
        margin: 10px;
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        background: #d0d0d0;
    }

    .image-box {
        position: relative;
        height: 180px;
        background: #000;
    }

    .img-cover {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 10px 10px 0 0;
    }

    .video-details {
        padding: 10px;
    }

    .videos-section {
        margin: auto;
        background-color: #ffffff;
        border-radius: 12px;
    }

    .no-videos-found {
        text-align: center;
        padding: 20px;
    }


    .no-videos-image {
        width: 250px;
        animation: bounce 2s infinite;
    }

    @keyframes bounce {

        0%,
        20%,
        50%,
        80%,
        100% {
            transform: translateY(0);
        }

        40% {
            transform: translateY(-20px);
        }

        60% {
            transform: translateY(-10px);
        }
    }

    .no-videos-title {
        font-size: 24px;
        color: #333;
        margin-bottom: 10px;
    }

    .no-videos-hint {
        font-size: 16px;
        color: #666;
        margin-bottom: 20px;
    }

    .btn.home-button {
        padding: 10px 20px;
        font-size: 16px;
        color: #fff;
        background-color: var(--primary-border);
        border-radius: 4px;
        text-decoration: none;
        transition: background-color 0.3s;
    }

    .btn.home-button:hover {
        background-color: var(--primary);
    }

    .form-control {
        font-size: 16px !important
    }
</style>
@section('content')
    <section class="pl-20 pr-20">
        <div class="panel-section-card activities-container">
            <div class="row">
                <div class="col-6 col-md-3 mt-30 mt-md-0 d-flex align-items-center justify-content-center">
                    <div class="d-flex flex-column align-items-center text-center">
                        <img src="/assets/default/icons/video-icon.png" alt="" class="stats-icon">
                        <strong
                            class="font-30 text-dark-blue font-weight-bold mt-5">{{ !empty($videocount) ? $videocount : 0 }}</strong>
                        <span class="text-gray font-weight-500"
                            style="font-family:'Tajawal', sans-serif">{{ trans('panel.number_videos') }}</span>
                    </div>
                </div>

                <div class="col-6 col-md-3 mt-30 mt-md-0 d-flex align-items-center justify-content-center">
                    <div class="d-flex flex-column align-items-center text-center">
                        <img src="/assets/default/icons/clock-icon.png" alt="" style="width: 60px;"
                            class="stats-icon">
                        <strong class="font-30 text-dark-blue font-weight-bold mt-5">{{ $totalMinutesWatched }}</strong>
                        <span class="text-gray font-weight-500"
                            style="font-family:'Tajawal', sans-serif">{{ trans('panel.number_minutes') }}</span>
                    </div>
                </div>

                <div class="col-6 col-md-3 mt-30 mt-md-0 d-flex align-items-center justify-content-center mt-5 mt-md-0">
                    <div class="d-flex flex-column align-items-center text-center">
                        <img src="/assets/default/icons/views-icon.png" style="width: 120px;">
                        <strong class="font-30 text-dark-blue font-weight-bold mt-5">{{ $totalViews }}</strong>
                        <span class="text-gray font-weight-500" style="font-family:'Tajawal', sans-serif">
                            {{ trans('panel.total_views') }}
                        </span>
                    </div>
                </div>

                <div class="col-6 col-md-3 mt-30 mt-md-0 d-flex align-items-center justify-content-center mt-5 mt-md-0">
                    <div class="d-flex flex-column align-items-center text-center">
                        <img src="/assets/default/icons/like-icon.png" alt="" class="stats-icon">
                        <strong class="font-30 text-dark-blue font-weight-bold mt-5">{{ $totalLikesCount }}</strong>
                        <span class="text-gray font-weight-500"
                            style="font-family:'Tajawal', sans-serif">{{ trans('panel.number_likes') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="pl-20 pr-20">
        <div class="panel-section-card py-20 px-25 mt-10">
            <form method="get" class="row">
                <div class="col-12 col-lg-3">
                    <h2 class="section-title"> {{ trans('panel.search_specific_video') }} </h2>
                </div>
                <div class="col-12 col-lg-3">
                    <div class="form-group mb-20 mb-lg-0">
                        <select class="form-control" style="font-family: 'Tajawal', sans-serif;" id="level_id"
                            name="level_id" onchange="this.form.submit()">
                            <option disabled selected>{{ trans('public.sort_by_level') }}</option>
                            <option value="">{{ trans('public.all') }}</option>
                            @foreach ($level as $lvl)
                                <option value="{{ $lvl->id }}"
                                    {{ request()->get('level_id') == $lvl->id ? 'selected' : '' }}>
                                    {{ $lvl->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-12 col-lg-3">
                    <div class="form-group mb-20 mb-lg-0">
                        <select id="manuel_id" style="font-family: 'Tajawal', sans-serif;" name="manuel_name"
                            onchange="this.form.submit()" class="form-control select2">
                            <option disabled selected>{{ trans('panel.scolar_book') }}</option>
                            <option value="all"
                                {{ old('manuel_name', request()->get('manuel_name')) == 'all' ? 'selected' : '' }}>
                                {{ trans('public.all') }}</option>
                            @foreach ($manuelfiltre as $m)
                                <option value="{{ $m }}"
                                    {{ request()->get('manuel_name') == $m ? 'selected' : '' }}>
                                    {{ $m }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-12 col-lg-3">
                    <div class="form-group mb-20 mb-lg-0">
                        <input style="font-family: 'Tajawal', sans-serif;!important" type="number" min="0"
                            name="page_number" class="form-control" placeholder="{{ trans('panel.page_number') }}"
                            value="{{ request()->get('page_number', '') }}" oninput="handleInput(this)" />
                    </div>
                </div>
                <script>
                    let inputTimeout;

                    function handleInput(input) {
                        clearTimeout(inputTimeout);
                        inputTimeout = setTimeout(() => {
                            input.form.submit();
                        }, 500); // Adjust the delay as needed
                    }
                </script>
            </form>
        </div>
    </section>
    <section class="mt-10 pl-20 pr-20">
        <div class="panel-section-card py-20 px-25 mt-20">
            @if (!empty($video) and !$video->isEmpty())
                @if ($video != '[]')
                    <div class="scrollable-div" id="scrollable-div">
                        <div class="row">
                            @foreach ($video as $videoItem)
                                <div id="videoPopupModal{{ $videoItem->id }}" class="modal" tabindex="-1" role="dialog"
                                    aria-hidden="true"
                                    style="backdrop-filter: blur(10px);background-color: rgba(0, 0, 0, 0.5);display: none;">
                                    <div class="modal-content">
                                        <div class="modal-header"
                                            style="justify-content: space-between; display: flex; align-items: center;">
                                            <h5 class="modal-title">{{ $videoItem->titleAll }}</h5>
                                            <button type="button" data-dismiss="modal" class="close" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>

                                        </div>
                                        <div class="modal-body">
                                            <video id="videoSource{{ $videoItem->id }}" class="img-cover" controls>
                                                <source src="{{ $videoItem->video }}" type="video/mp4">
                                                <source src="{{ $videoItem->video }}" type="video/webm">
                                            </video>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4 col-md-4">
                                    <div class="webinar-card webinar-list webinar-list-2 d-flex flex-column mt-30">
                                        <div class="image-box">
                                            <div class="rounded-lg shadow-sm">
                                                <div class="course-img">
                                                    <div id="webinarDemoVideoBtn{{ $videoItem->id }}"
                                                        data-video-source="{{ $videoItem->video }}"
                                                        style=" position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);box-shadow: 0 20px 12px 0 rgba(0, 0, 0, 0.1);background-color: #ffffff;width: 96px;height: 96px;border-radius: 50%;z-index: 2;"
                                                        class="course-video-icon cursor-pointer d-flex align-items-center justify-content-center">
                                                        <i data-feather="play" width="25" height="25"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <video class="img-cover"
                                                onclick="playInMainPlayer('{{ asset($videoItem->video) }}','{{ $videoItem->titre }}','{{ $videoItem->teachers->full_name }}','{{ $videoItem->user_id }}','{{ $videoItem->teachers->avatar }}'); storeTeacherId('{{ $videoItem->teachers->id }}');">
                                                <source src="{{ $videoItem->video }}" type="video/mp4">
                                                <source src="{{ $videoItem->video }}" type="video/webm">
                                            </video>
                                        </div>
                                        <!-- Popup Modal -->
                                        <div class="webinar-card-body w-100 d-flex flex-column">
                                            <div class="d-flex align-items-center justify-content-between mb-10">
                                                <a href="" target="_blank">
                                                    <h3 class="font-16 text-dark-blue font-weight-bold">
                                                        {{ $videoItem->titleAll }}
                                                    </h3>
                                                </a>
                                                <div class="btn-group dropdown table-actions">
                                                    <button type="button" class="btn-transparent dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <i data-feather="more-vertical" height="20"></i>
                                                    </button>
                                                    <div class="dropdown-menu ">
                                                        <a class="webinar-actions d-block mt-10" data-toggle="modal"
                                                            data-target="#editTitleModal{{ $videoItem->id }}">تغيير
                                                            العنوان</a>

                                                        @if (
                                                            $videoItem->manuel->id == 5 ||
                                                                $videoItem->manuel->id == 3 ||
                                                                $videoItem->manuel->id == 2 ||
                                                                $videoItem->manuel->id == 6)
                                                            <a href="/panel/scolaire/view/teacher/{{ $videoItem->manuel_id }}?icon={{ $videoItem->numero }}&page={{ $videoItem->page - 1 }}"
                                                                class="webinar-actions d-block mt-10"
                                                                id="myBtn">{{ trans('public.edit') }}</a>
                                                        @else
                                                            <a href="/panel/scolaire/view/teacher/{{ $videoItem->manuel_id }}?icon={{ $videoItem->numero }}&page={{ $videoItem->page }}"
                                                                class="webinar-actions d-block mt-10"
                                                                id="myBtn">{{ trans('public.edit') }}</a>
                                                        @endif

                                                        <a href="/panel/video/{{ $videoItem->id }}/delete"
                                                            class="webinar-actions d-block mt-10 text-danger delete-action">{{ trans('public.delete') }}</a>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="user-inline-avatar d-flex align-items-center">
                                                @php
                                                    $materialsname = DB::table('materials')
                                                        ->where('id', $videoItem->manuel->material_id)
                                                        ->pluck('name');

                                                    $materialssection = DB::table('materials')
                                                        ->where('id', $videoItem->manuel->material_id)
                                                        ->pluck('section_id');

                                                    $materialsnamesection = DB::table('sectionsmat')
                                                        ->where('id', $materialssection[0])
                                                        ->pluck('level_id');
                                                    $materiallevel = DB::table('school_levels')
                                                        ->where('id', $materialsnamesection[0])
                                                        ->pluck('name');
                                                @endphp
                                                <div class="user-inline-avatar d-flex align-items-center">
                                                    <div class="avatar bg-gray200">
                                                        <img src="/{{ $videoItem->manuel->logo }}" class="img-cover"
                                                            alt="">
                                                    </div>
                                                    <a href="" target="_blank" class="user-name ml-5 font-14">
                                                        كتاب
                                                        {{ $videoItem->manuel->name }} السّنة {{ $materiallevel[0] }}</a>
                                                </div>
                                            </div>


                                            <a
                                                onclick="playInMainPlayer('{{ asset($videoItem->video) }}','{{ $videoItem->titre }}','{{ $videoItem->teachers->full_name }}','{{ $videoItem->user_id }}','{{ $videoItem->teachers->avatar }}')"></a>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="mt-10 d-flex justify-content-between">
                                                        <div class="d-flex align-items-center">
                                                            <a
                                                                href="/panel/scolaire/view/teacher/{{ $videoItem->manuel_id }}?icon={{ $videoItem->numero }}&page="{{ $videoItem->page }}>

                                                                <span style="font-size: small;"
                                                                    class="duration ml-5 font-8 mt-10">
                                                                    @if (
                                                                        $videoItem->manuel->id == 5 ||
                                                                            $videoItem->manuel->id == 3 ||
                                                                            $videoItem->manuel->id == 2 ||
                                                                            $videoItem->manuel->id == 6)
                                                                        الصّفحة {{ $videoItem->page - 1 }}
                                                                    @else
                                                                        الصّفحة {{ $videoItem->page }}
                                                                    @endif
                                                                </span>

                                                            </a>
                                                        </div>
                                                        <div class="d-flex align-items-center">

                                                            <div class="d-flex align-items-center">
                                                                <img width="20" height="20" src="/oeil.png"
                                                                    class="webinar-icon" />
                                                                <span style="font-size: small;"
                                                                    class="duration ml-5 font-8">{{ $videoItem->viewers_count }}
                                                                </span>
                                                            </div>

                                                            <div class="vertical-line h-25 mx-15"></div>
                                                            <div class="d-flex align-items-center">
                                                                <img width="15" height="15" src="/heart1.png"
                                                                    class="webinar-icon" />
                                                                <span style="font-size: small;"
                                                                    class="date-published ml-5">{{ $videoItem->likes }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="webinar-price-box d-flex flex-column justify-content-center align-items-center">
                                                        <span class="real"></span>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="editTitleModal{{ $videoItem->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="editTitleModalLabel" aria-hidden="true">
                                    <div class="modal-content" style="margin-top: 90px;">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">تغيير العنوان</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post"
                                                action="{{ route('videos.updateTitle', ['id' => $videoItem->id]) }}">
                                                @csrf
                                                <label for="email">تغيير العنوان</label><br>
                                                <input type="text" name="titleAll" class="form-control"
                                                    value="{{ $videoItem->titleAll }}" placeholder="تغيير العنوان" />

                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">تعديل</button>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!-- Add pagination links -->
                        <div class="mt-50 pt-30">
                            {{ $video->appends(request()->input())->links('vendor.pagination.panel') }}
                        </div>

                    </div>
                @endif
            @else
                <div class="no-videos-found">
                    <img src="/assets/default/icons/no-video-found.png" alt="No Videos" class="no-videos-image">
                    <h2 class="no-videos-title">{{ trans('panel.no_videos') }}</h2>
                    <p class="no-videos-hint">{{ trans('panel.start_creating_video') }}</p>
                    <a href="/panel" class="btn home-button">{{ trans('panel.click_here') }}</a>
                </div>

            @endif
        </div>
    </section>
    @include('web.default.panel.webinar.make_next_session_modal')
@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/daterangepicker/daterangepicker.min.js"></script>

    <script>
        var undefinedActiveSessionLang = '{{ trans('webinars.undefined_active_session ') }}';
        var saveSuccessLang = '{{ trans('webinars.success_store ') }}';
    </script>

    <script src="/assets/default/js/panel/make_next_session.min.js"></script>
    <script src="/assets/default/vendors/video/video.min.js"></script>
    <script src="/assets/default/vendors/video/youtube.min.js"></script>
    <script src="/assets/default/vendors/video/vimeo.js"></script>
    <script src="/assets/default/js/parts/video_player_helpers.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modal = document.getElementById("myModal");
            var btn = document.getElementById("myBtn");
            var span = document.getElementsByClassName("close")[0];

            btn.onclick = function() {
                modal.style.display = "block";
            }

            span.onclick = function() {
                pauseAndHideModal(modal);
            }

            window.onclick = function(event) {
                if (event.target == modal) {
                    pauseAndHideModal(modal);
                }
            }

            document.querySelectorAll('.course-video-icon').forEach(button => {
                button.addEventListener('click', function() {
                    const videoId = this.id.replace('webinarDemoVideoBtn', '');
                    const videoSource = this.getAttribute('data-video-source');
                    const mainPlayer = document.getElementById(`videoSource${videoId}`);
                    if (mainPlayer) {
                        mainPlayer.src = videoSource;
                        mainPlayer.load();
                        mainPlayer.play();
                    } else {
                        console.error("Video element not found.");
                    }
                    document.getElementById(`videoPopupModal${videoId}`).style.display = "block";
                });
            });

            document.querySelectorAll('.close').forEach(closeButton => {
                closeButton.addEventListener('click', function() {
                    const modalToClose = this.closest('.modal');
                    pauseAndHideModal(modalToClose);
                });
            });

            window.addEventListener('click', function(event) {
                if (event.target.classList.contains('modal')) {
                    pauseAndHideModal(event.target);
                }
            });

            function pauseAndHideModal(modal) {
                if (modal) {
                    const video = modal.querySelector('video');
                    if (video) {
                        video.pause();
                    }
                    modal.style.display = "none";
                }
            }
        });
    </script>
@endpush

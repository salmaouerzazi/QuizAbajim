@extends(getTemplate() . '.panel.layouts.panel_layout')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/chartjs/chart.min.css" />
    <link rel="stylesheet" href="/assets/default/vendors/apexcharts/apexcharts.css" />
    <!-- Style CSS -->
    <link rel="stylesheet" href="/assets/default/css/style.css">
    <link rel="stylesheet" type="text/css" href="/assets/default/css/demo.css" />
    <link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/owl-carousel2/owl.carousel.min.css">
    <link rel="stylesheet" href="/newtemplate/css/netflix.css">

    <style>
        .dashboard-title {
            color: #1d3b65;
        }

        .styled-select {
            width: 100%;
            font-size: 1.1rem;
            font-family: 'Tajawal', sans-serif;
        }

        .styled-select:hover {
            border-color: #25bec8;
            box-shadow: 0 0 0 0.2rem rgba(37, 190, 200, 0.25);
        }

        .styled-select:focus {
            border-color: #25bec8;
            outline: none;
            box-shadow: 0 0 0 0.2rem rgba(37, 190, 200, 0.25);
        }

        .styled-select option:disabled {
            color: #6c757d;
        }

        .view-all {
            border: 2px solid #1d3b65;
            color: #1d3b65;
            border-radius: 5px;
            font-family: 'Tajawal', sans-serif;
            padding: 10px
        }

        .view-all:hover {
            background-color: #1d3b65;
            color: #fff;
        }

        .swiper-container,
        .swiper-container-webinars {
            position: relative;
            padding-bottom: 30px;
            flex: 1;
        }

        .swiper-pagination-webinars {
            position: absolute;
            bottom: 10px;
            width: 100%;
            text-align: center;
            z-index: 10;
        }

        .webinar-card {
            border-radius: 10px;
            padding: 20px;
            height: 100%;
            width: 100%;
        }

        .manuel-card {
            border-radius: 10px;
            overflow: hidden;
            background-color: #fff;
            transition: transform 0.3s;
            border: 1px solid #e5e5e5;
            height: 100%;
        }

        .manuel-card .image-box {
            height: 300px;
            overflow: hidden;
            position: relative;
        }

        @media (max-width: 576px) {
            .manuel-card .image-box {
                height: 510px;
            }
        }

        .manuel-card .image-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .manuel-card-body {
            padding: 15px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .primary {
            color: #1d3b65;
        }

        .skeleton-placeholder {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .skeleton-manuel-card {
            background-color: #e0e0e0;
            width: calc(20% - 15px);
            height: 320px;
            position: relative;
            overflow: hidden;
            border-radius: 10px;
        }

        .skeleton-webinar-card {
            background-color: #e0e0e0;
            width: calc(33.33% - 15px);
            height: 250px;
            position: relative;
            overflow: hidden;
            border-radius: 10px;
        }

        .skeleton-manuel-card::after,
        .skeleton-webinar-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: -150px;
            width: 200px;
            height: 100%;
            background: linear-gradient(to right, transparent 0%, rgba(255, 255, 255, 0.2) 50%, transparent 100%);
            animation: skeleton-loading 1.5s infinite;
        }

        @keyframes skeleton-loading {
            0% {
                left: -150px;
            }

            100% {
                left: 100%;
            }
        }

        @media (max-width: 768px) {

            .skeleton-placeholder .skeleton-manuel-card:nth-child(n+2),
            .skeleton-placeholder .skeleton-webinar-card:nth-child(n+2) {
                display: none;
            }

            .skeleton-webinar-card {
                width: 100%;
                height: 250px;
            }

            .skeleton-manuel-card {
                width: 100%;
                height: 510px;
                /* match your mobile .image-box height */
            }
        }

        .swiper-button-prev-manuels,
        .swiper-button-next-manuels {
            color: #fff;
            background: #1d3b65;
            width: 35px;
            height: 60px;
            position: absolute;
            top: 45%;
            transform: translateY(-50%);
            z-index: 20;
            cursor: pointer;
        }

        .swiper-button-next-manuels {
            left: -15px;
            border-top-right-radius: 30px;
            border-bottom-right-radius: 30px;
        }

        .swiper-button-prev-manuels {
            right: -15px;
            border-top-left-radius: 30px;
            border-bottom-left-radius: 30px;
        }

        @media (max-width: 768px) {
            .swiper-button-next-manuels {
                left: -10px;
            }

            .swiper-button-prev-manuels {
                right: -10px;
            }
        }

        .swiper-button-next-manuels:after,
        .swiper-button-prev-manuels:after {
            font-family: 'swiper-icons';
            font-weight: 400;
            z-index: 1;
        }

        .swiper-container-rtl .swiper-button-prev-manuels:after {
            font-size: 60px;
            content: '\2039';
            position: absolute;
            top: -7.5px;
            right: 3.6px;
        }

        .swiper-container-rtl .swiper-button-next-manuels:after {
            content: '\203A';
            font-size: 60px;
            position: absolute;
            top: -7.5px;
            left: 3.6px;
        }

        .shrinked-title {
            width: 50px;
        }

        .dashboard-subtitle {
            color: #1d3b65;
            font-size: 1.2rem;
            font-weight: 600;
        }

        .custom-select {
            border: 2px solid #1d3b65;
        }

        /*
                  When we switch to 'mobile-view-manuels',
                  just stack the items one under another.
                */
        .mobile-view-manuels {
            display: block !important;
            width: 100% !important;
        }

        .mobile-view-manuels .swiper-wrapper {
            display: block !important;
        }

        .mobile-view-manuels .swiper-slide {
            display: block !important;
            width: 100% !important;
            margin-bottom: 16px;
        }

        /* Hide the navigation arrows on mobile when stacking */
        @media (max-width: 576px) {

            .swiper-button-next-manuels,
            .swiper-button-prev-manuels {
                display: none !important;
            }
        }
    </style>
@endpush

@section('content')
    {{-- -------------------- Manuels ----------------- --}}
    <section class="pl-20 pr-20">
        <div class="panel-section-card py-20 px-2">
            <div class="row">
                <div class="col-lg-8 col-12 mb-10">
                    @if (!empty($matiere1))
                        <h1 class="dashboard-title">{{ trans('panel.myscolaiemanuel') }}</h1>
                        <h3 class="dashboard-subtitle ml-5"> ({{ trans('panel.start_creating') }})</h3>
                    @endif
                </div>
                <div class="col-lg-2 col-6 mb-10">
                    <form method="get">
                        @if (!empty($userLevelIds))
                            <select name="by_level" class="custom-select styled-select" onchange="this.form.submit()">
                                <option disabled selected>{{ trans('public.sort_by_level') }}</option>
                                <option value="">{{ trans('public.all') }}</option>
                                @foreach ($levels as $levelid => $levelname)
                                    <option value="{{ $levelid }}"
                                        @if (request()->get('by_level') == $levelid) selected="selected" @endif>
                                        {{ $levelname }}
                                    </option>
                                @endforeach
                            </select>
                            @if (request()->has('by_matiere'))
                                <input type="hidden" name="by_matiere" value="{{ request()->get('by_matiere') }}">
                            @endif
                        @endif
                    </form>
                </div>

                <div class="col-lg-2 col-6">
                    <form method="get">
                        @if (!empty($matieregetnameall))
                            <select name="by_matiere" class="custom-select styled-select" onchange="this.form.submit()">
                                <option disabled selected>{{ trans('public.sort_by_matiere') }}</option>
                                <option value="">{{ trans('public.all') }}</option>
                                @foreach ($matiereNames as $matiere)
                                    <option value="{{ $matiere }}"
                                        @if (request()->get('by_matiere') == $matiere) selected="selected" @endif>
                                        {{ $matiere }}
                                    </option>
                                @endforeach
                            </select>
                            @if (request()->has('by_level'))
                                <input type="hidden" name="by_level" value="{{ request()->get('by_level') }}">
                            @endif
                        @endif
                    </form>
                </div>
            </div>

            <!-- Skeleton placeholder shown first -->
            <div id="manuels-skeleton" class="skeleton-placeholder">
                @for ($i = 0; $i < 5; $i++)
                    <div class="skeleton-manuel-card"></div>
                @endfor
            </div>

            <!-- Actual content hidden by default -->
            <div id="manuels-content" style="display: none;">
                <div class="swiper-container swiper-container-manuels">
                    <div class="swiper-wrapper">
                        @foreach ($matiere1 as $material)
                            @foreach ($material->manuels as $manuel)
                                <div class="swiper-slide">
                                    <a href="/panel/scolaire/teacher/{{ $manuel->id }}">
                                        <div class="manuel-card">
                                            <div class="image-box">
                                                <img src="{{ $manuel->logo }}" class="img-cover"
                                                    alt="{{ $manuel->name }}">
                                            </div>
                                            <div class="manuel-card-body w-100 d-flex flex-column">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="badge badge-primary">
                                                        {{ $manuel->matiere->section->level->name }}
                                                    </span>
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-video mr-5 primary"></i>
                                                        @php
                                                            $videoCount = \Illuminate\Support\Facades\DB::table(
                                                                'videos',
                                                            )
                                                                ->where('manuel_id', $manuel->id)
                                                                ->where('user_id', $authUser->id)
                                                                ->count();
                                                            $likeCount = DB::table('likes')
                                                                ->join('videos', 'likes.video_id', '=', 'videos.id')
                                                                ->where('videos.manuel_id', $manuel->id)
                                                                ->where('videos.user_id', $authUser->id)
                                                                ->count();
                                                            $viewCount = DB::table('user_views')
                                                                ->join(
                                                                    'videos',
                                                                    'user_views.video_id',
                                                                    '=',
                                                                    'videos.id',
                                                                )
                                                                ->where('videos.manuel_id', $manuel->id)
                                                                ->where('videos.user_id', $authUser->id)
                                                                ->count();
                                                        @endphp
                                                        <span class="stat-value primary">{{ $videoCount }}</span>
                                                    </div>
                                                </div>

                                                <div
                                                    class="d-flex align-items-center justify-content-between flex-wrap mt-auto">
                                                    <h3 class="font-12 text-dark-blue" title="{{ $manuel->name }}">
                                                        {{ Str::limit($manuel->name, 14, '...') }}
                                                    </h3>
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-eye mr-5" style="color: #25bec8"></i>
                                                        <span class="stat-value primary">{{ $viewCount }}</span>
                                                        <i class="fas fa-heart ml-10 mr-5" style="color: red"></i>
                                                        <span class="stat-value primary">{{ $likeCount }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        @endforeach
                    </div>

                    <div class="swiper-button-prev swiper-button-prev-manuels"></div>
                    <div class="swiper-button-next swiper-button-next-manuels"></div>
                </div>
            </div>

        </div>
    </section>
    {{-- -------------------- Courses ----------------- --}}
    <section class="pl-20 pr-20">
        <div class="panel-section-card py-20 px-25">
            <div class="d-flex justify-content-between align-items-center mb-10">
                <h1 class="dashboard-title">{{ trans('panel.webinars') }}</h1>
                <a href="/panel/webinars" class="view-all">{{ trans('panel.view_all') }}</a>
            </div>
            <div id="webinars-skeleton" class="skeleton-placeholder">
                @for ($i = 0; $i < 3; $i++)
                    <div class="skeleton-webinar-card"></div>
                @endfor
            </div>

            <div id="webinars-content" style="display: none;">
                <div class="row">
                    <div class="swiper-container swiper-container-webinars">
                        <div class="swiper-wrapper">
                            @if (!empty($webinars))
                                @foreach ($webinars as $webinar)
                                    <div class="swiper-slide">
                                        <div class="webinar-card webinar-list">
                                            <div class="image-box">
                                                <img src="/store/{{ $webinar->image_cover }}" class="img-cover"
                                                    alt="">
                                                @switch($webinar->status)
                                                    @case(\App\Models\Webinar::$active)
                                                        @if ($webinar->isWebinar())
                                                            @if ($webinar->start_date > time())
                                                                <span
                                                                    class="badge badge-primary">{{ trans('panel.not_conducted') }}</span>
                                                            @elseif($webinar->isProgressing())
                                                                <span
                                                                    class="badge badge-secondary">{{ trans('webinars.in_progress') }}</span>
                                                            @else
                                                                <span
                                                                    class="badge badge-secondary">{{ trans('public.finished') }}</span>
                                                            @endif
                                                        @else
                                                            <span
                                                                class="badge badge-secondary">{{ trans('webinars.' . $webinar->type) }}</span>
                                                        @endif
                                                    @break

                                                    @case(\App\Models\Webinar::$isDraft)
                                                        <span class="badge badge-danger">{{ trans('public.draft') }}</span>
                                                    @break

                                                    @case(\App\Models\Webinar::$pending)
                                                        <span class="badge badge-warning">{{ trans('public.waiting') }}</span>
                                                    @break

                                                    @case(\App\Models\Webinar::$inactive)
                                                        <span class="badge badge-danger">{{ trans('public.rejected') }}</span>
                                                    @break
                                                @endswitch
                                            </div>

                                            <div class="webinar-card-body w-100 d-flex flex-column">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <h3 class="font-16 text-dark-blue font-weight-bold">
                                                        {{ $webinar->title }}
                                                    </h3>

                                                    @if ($webinar->isOwner($authUser->id) or $webinar->isPartnerTeacher($authUser->id))
                                                        <div class="btn-group dropdown table-actions">
                                                            <button type="button" class="btn-transparent dropdown-toggle"
                                                                data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false">
                                                                <i data-feather="more-vertical" height="20"></i>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                @if (!empty($webinar->start_date))
                                                                    <button type="button"
                                                                        data-webinar-id="{{ $webinar->id }}"
                                                                        class="js-webinar-next-session webinar-actions btn-transparent d-block">
                                                                        {{ trans('public.create_join_link') }}
                                                                    </button>
                                                                @endif
                                                                <a href="{{ $webinar->getLearningPageUrl() }}"
                                                                    target="_blank" class="webinar-actions d-block mt-10">
                                                                    {{ trans('update.learning_page') }}
                                                                </a>
                                                                <a href="/panel/webinars/{{ $webinar->id }}/edit"
                                                                    class="webinar-actions d-block mt-10">
                                                                    {{ trans('public.edit') }}
                                                                </a>
                                                                @if ($webinar->isWebinar())
                                                                    <a href="/panel/webinars/{{ $webinar->id }}/step/4"
                                                                        class="webinar-actions d-block mt-10">
                                                                        {{ trans('public.sessions') }}
                                                                    </a>
                                                                @endif
                                                                @if ($authUser->id == $webinar->creator_id)
                                                                    <a href="/panel/webinars/{{ $webinar->id }}/duplicate"
                                                                        class="webinar-actions d-block mt-10">
                                                                        {{ trans('public.duplicate') }}
                                                                    </a>
                                                                @endif
                                                                @if ($webinar->creator_id == $authUser->id)
                                                                    <a href="/panel/webinars/{{ $webinar->id }}/delete"
                                                                        class="webinar-actions d-block mt-10 text-danger delete-action">
                                                                        {{ trans('public.delete') }}
                                                                    </a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div
                                                    class="d-flex align-items-center justify-content-between flex-wrap mt-auto">
                                                    <div class="d-flex align-items-start flex-column mt-20 mr-15">
                                                        <span class="stat-title">{{ trans('public.item_id') }}:</span>
                                                        <span class="stat-value">#{{ $webinar->id }}</span>
                                                    </div>
                                                    <div class="d-flex align-items-start flex-column mt-20 mr-15">
                                                        <span class="stat-title">{{ trans('public.level') }}:</span>
                                                        <span class="stat-value">
                                                            {{ !empty($webinar->level_id) ? $webinar->level->name : '' }}
                                                        </span>
                                                    </div>
                                                    <div class="d-flex align-items-start flex-column mt-20 mr-15">
                                                        <span
                                                            class="stat-title">{{ trans('public.material_or_field') }}:</span>
                                                        <span class="stat-value">
                                                            {{ !empty($webinar->matiere_id) ? $webinar->material->name : '' }}
                                                        </span>
                                                    </div>
                                                    @if (!empty($webinar->submaterial_id))
                                                        <div class="d-flex align-items-start flex-column mt-20 mr-15">
                                                            <span
                                                                class="stat-title">{{ trans('public.material') }}:</span>
                                                            <span class="stat-value">
                                                                {{ !empty($webinar->submaterial_id) ? $webinar->submaterial->name : '' }}
                                                            </span>
                                                        </div>
                                                    @endif
                                                    @if (
                                                        !empty($webinar->partner_instructor) and
                                                            $webinar->partner_instructor and
                                                            $authUser->id != $webinar->teacher_id and
                                                            $authUser->id != $webinar->creator_id)
                                                        <div class="d-flex align-items-start flex-column mt-20 mr-15">
                                                            <span
                                                                class="stat-title">{{ trans('panel.invited_by') }}:</span>
                                                            <span class="stat-value">
                                                                {{ $webinar->teacher->full_name }}
                                                            </span>
                                                        </div>
                                                    @elseif($authUser->id != $webinar->teacher_id and $authUser->id != $webinar->creator_id)
                                                        <div class="d-flex align-items-start flex-column mt-20 mr-15">
                                                            <span
                                                                class="stat-title">{{ trans('webinars.teacher_name') }}:</span>
                                                            <span class="stat-value">
                                                                {{ $webinar->teacher->full_name }}
                                                            </span>
                                                        </div>
                                                    @elseif(
                                                        $authUser->id == $webinar->teacher_id and
                                                            $authUser->id != $webinar->creator_id and
                                                            $webinar->creator->isOrganization())
                                                        <div class="d-flex align-items-start flex-column mt-20 mr-15">
                                                            <span
                                                                class="stat-title">{{ trans('webinars.organization_name') }}:</span>
                                                            <span class="stat-value">
                                                                {{ $webinar->creator->full_name }}
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div
                                                    class="d-flex align-items-center justify-content-between flex-wrap mt-auto">
                                                    <div class="d-flex align-items-start flex-column mt-20 mr-15">
                                                        <span
                                                            class="stat-title">{{ trans('public.chapter_number') }}:</span>
                                                        <span class="stat-value">{{ $webinar->chapters->count() }}</span>
                                                    </div>
                                                    <div class="d-flex align-items-start mt-20 mr-15">
                                                        <i class="fas fa-video primary mr-5"></i>
                                                        <span class="stat-value">{{ $webinar->files->count() }}</span>
                                                    </div>
                                                    @if ($webinar->status === \App\Models\Webinar::$active)
                                                        <div class="d-flex align-items-start mt-20 mr-15">
                                                            <i class="fas fa-heart mr-5" style="color: red"></i>
                                                            <span class="stat-value">0</span>
                                                        </div>
                                                        <div class="d-flex align-items-start mt-20 mr-15">
                                                            <i class="fas fa-eye mr-5" style="color: #25bec8"></i>
                                                            <span class="stat-value">0</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-12 justify-content-center">
                                    @include(getTemplate() . '.includes.no-result', [
                                        'file_name' => 'webinar.png',
                                        'title' => trans('panel.you_not_have_any_webinar'),
                                        'hint' => trans('panel.no_result_hint'),
                                        'btn' => [
                                            'url' => '/panel/webinars/new',
                                            'text' => trans('panel.create_a_webinar'),
                                        ],
                                    ])
                                </div>
                            @endif
                        </div>
                        <div class="swiper-pagination swiper-pagination-webinars"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/apexcharts/apexcharts.min.js"></script>
    <script src="/assets/default/vendors/chartjs/chart.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
    <script src="/assets/default/vendors/owl-carousel2/owl.carousel.min.js"></script>
    <script src="/assets/default/vendors/parallax/parallax.min.js"></script>
    <script src="/assets/default/js/parts/home.min.js"></script>
    <script src="/assets/default/js/panel/dashboard.min.js"></script>

    <script>
        // Example for toggling a #22 element (unrelated to Swiper):
        document.addEventListener('DOMContentLoaded', function() {
            let currentIndex = 0;
            const items = document.querySelectorAll('#22');
            const totalItems = items.length;

            function showItem(index) {
                items.forEach(item => item.style.display = 'none');
                items[index].style.display = 'block';
            }

            function nextItem() {
                currentIndex = (currentIndex + 1) % totalItems;
                showItem(currentIndex);
            }

            if (totalItems) {
                showItem(0);
                setInterval(nextItem, 5000);
            }

            // Example usage for child-names:
            var childNames = document.querySelectorAll('.child-name');
            childNames.forEach(function(childName) {
                childName.addEventListener('click', function() {
                    var container = document.querySelector('.wgh-slider__container');
                    container.innerHTML = '';

                    var fullName = childName.getAttribute('data-full-name');
                    var level_id = childName.getAttribute('data-level-id');
                    var csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;

                    $.ajax({
                        type: 'GET',
                        url: '/panel/getmaterialsforlevel',
                        data: {
                            'level_id': level_id
                        },
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        success: function(data, textStatus, jqXHR) {
                            if (jqXHR.getResponseHeader('Content-Type').indexOf(
                                    'application/json') > -1) {
                                var container = document.querySelector(
                                    '.wgh-slider__container');
                                container.innerHTML = '';

                                data.forEach(function(material, key) {
                                    var div = document.createElement('div');
                                    div.className = 'wgh-slider-item';
                                    div.innerHTML = `
                                        <div class="wgh-slider-item__inner">
                                            <figure class="wgh-slider-item-figure">
                                                <img style="width: 400px; height: 400px !important"
                                                     class="wgh-slider-item-figure__image"
                                                     src="${material.path}" 
                                                     alt="${material.name}" />
                                                <figcaption class="wgh-slider-item-figure__caption">
                                                    <a href="/panel/scolaire/213">${material.name}</a>
                                                    <p>مستوى: ${material.level ? material.level.name : 'N/A'}</p>
                                                </figcaption>
                                            </figure>
                                            <label class="wgh-slider-item__trigger" for="slide-${key+1}"
                                                   title="${material.name}"></label>
                                        </div>
                                    `;
                                    container.appendChild(div);
                                });
                            } else {
                                console.error('Unexpected content type:', jqXHR
                                    .getResponseHeader('Content-Type'));
                            }
                        },
                        error: function(xhr, status, error) {
                            if (xhr.status == 404) {
                                console.error('Materials not found: 404');
                            } else if (xhr.status == 500) {
                                console.error('Server error: 500');
                            } else {
                                console.error('AJAX error:', status, error);
                            }
                        },
                        beforeSend: function(xhr) {
                            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                        }
                    });

                    document.getElementById('userName').textContent = fullName;
                });
            });
        });
    </script>

    <script>
        // We'll store the Manuels Swiper instance here if needed
        let manuelsSwiper = null;
        // Initialize Swiper for manuels
        function initManuelsSwiper() {
            manuelsSwiper = new Swiper('.swiper-container-manuels', {
                slidesPerView: 1,
                spaceBetween: 10,
                navigation: {
                    nextEl: '.swiper-button-next-manuels',
                    prevEl: '.swiper-button-prev-manuels',
                },
                loop: false,
                breakpoints: {
                    576: {
                        slidesPerView: 2,
                    },
                    768: {
                        slidesPerView: 4,
                    },
                    992: {
                        slidesPerView: 5,
                    },
                },
                on: {
                    slideChange: function() {
                        toggleNavigationVisibility(this);
                    },
                },
            });
        }

        // Destroy Swiper for manuels if it exists
        function destroyManuelsSwiper() {
            if (manuelsSwiper) {
                manuelsSwiper.destroy(true, true);
                manuelsSwiper = null;
            }
        }

        // Show/hide navigation arrows depending on the Swiper slide position
        function toggleNavigationVisibility(swiperInstance) {
            const {
                isBeginning,
                isEnd
            } = swiperInstance;
            if (swiperInstance.navigation) {
                const {
                    nextEl,
                    prevEl
                } = swiperInstance.navigation;
                if (prevEl) {
                    prevEl.style.display = isBeginning ? 'none' : 'flex';
                }
                if (nextEl) {
                    nextEl.style.display = isEnd ? 'none' : 'flex';
                }
            }
        }

        // Handle whether to show stacked or swiper based on screen width
        function handleResize() {
            const manuelsContainer = document.querySelector('.swiper-container-manuels');
            const isMobile = window.innerWidth <= 576;

            if (isMobile) {
                // If mobile, destroy the swiper (if active) and add the stacked class for manuels
                destroyManuelsSwiper();
                manuelsContainer.classList.add('mobile-view-manuels');

            } else {
                // If desktop, remove stacked class and initialize swiper (if not initialized) for manuels
                manuelsContainer.classList.remove('mobile-view-manuels');
                if (!manuelsSwiper) {
                    initManuelsSwiper();
                }

            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // 1) Hide skeleton, show content
            const manuelsSkeleton = document.getElementById('manuels-skeleton');
            const manuelsContent = document.getElementById('manuels-content');
            manuelsSkeleton.style.display = 'none';
            manuelsContent.style.display = 'block';

            // 2) Same for webinars skeleton
            const webinarsSkeleton = document.getElementById('webinars-skeleton');
            const webinarsContent = document.getElementById('webinars-content');
            webinarsSkeleton.style.display = 'none';
            webinarsContent.style.display = 'block';

            // 3) Call handleResize once on page load (for manuels)
            handleResize();

            // 4) Also listen for screen resizing
            window.addEventListener('resize', handleResize);

            // 5) Initialize Webinars Swiper
            var webinarsSwiper = new Swiper('.swiper-container-webinars', {
                slidesPerView: 1,
                spaceBetween: 10,
                pagination: {
                    el: '.swiper-pagination-webinars',
                    clickable: true,
                },
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                },
                loop: true,
                breakpoints: {
                    768: {
                        slidesPerView: 2,
                    },
                    992: {
                        slidesPerView: 3,
                    },
                },
            });


        });
    </script>
@endpush

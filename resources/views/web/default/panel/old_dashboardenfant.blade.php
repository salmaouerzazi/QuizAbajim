@extends(getTemplate() . '.panel.layouts.panel_layout')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/chartjs/chart.min.css" />
    <link rel="stylesheet" href="/assets/default/vendors/apexcharts/apexcharts.css" />
    <link rel="stylesheet" href="/assets/default/css/app.css">
    <link rel="stylesheet" href="/assets/default/css/style.css">
    <link rel="stylesheet" href="/assets/default/css/dashboard_enfant.css">
    <link rel="stylesheet" type="text/css" href="/assets/default/css/demo.css" />
    <link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/owl-carousel2/owl.carousel.min.css">
    <link rel="stylesheet" href="/assets/vendors/wrunner-html-range-slider-with-2-handles/css/wrunner-default-theme.css">
@endpush

<style>

    .add-square-container-child {
        position: relative;
        width: 100%;
        max-width: 230px;
        height: 230px;
        border: 2px solid #1e3a8a;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #ffffff;
        border-radius: 10px;
        cursor: pointer;
        margin-bottom: 2%;
    }

    .avatar-child {
        max-width: 100px;
        border-radius: 50%;
    }

    .edit-icon img {
        width: 50px;
        background-color: rgba(0, 0, 0, 0.5);
        border-radius: 50%;
    }

    .edit-icon {
        position: absolute;
        top: 0;
        right: 20%;
        padding: 5px;
    }

    @media (max-width: 991px) {
        .edit-icon {
            right: 15%;
        }
    }

    @media (max-width: 768px) {
        .avatar-child {
            max-width: 80px;
        }
        .font-20 {
            font-size: 16px;
        }
        .add-square-container-child {
            max-width: 230px;
            height: 230px;
            margin-right: 0 !important;
        }
        .edit-icon {
            right: 35%;
        }
    }

    @media (max-width: 576px) {
        .edit-icon {
            right: 30%;
        }
        .avatar-child {
            max-width: 70px;
        }
        .font-20 {
            font-size: 14px;
        }
        .edit-icon img {
            width: 40px;
        }
    }

    .shepherd-button-next {
        background-color: var(--primary) !important;
        color: white;
    }

    .shepherd-element {
        border-radius: 35px;
        border: 2px solid var(--primary);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15) !important;
        max-width: 400px;
        font-family: 'Tajawal', sans-serif !important;
        text-align: center;
    }

    .shepherd-element .shepherd-text {
        font-size: 18px;
        color: black;
        margin-bottom: 20px;
        line-height: 1.5;
    }

    .shepherd-arrow:before {
        content: url('/assets/default/icons/click.png') !important;
        transform: scale(0.07) rotate(0deg) !important;
        top: -23px !important;
        left: 15px !important;
    }

    .shepherd-arrow {
        background-color: white !important;
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

    .swiper-button-prev-manuels,
    .swiper-button-next-manuels {
        color: #fff !important;
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
        font-size: 30px;
        font-weight: 800;
        content: '\2039';
        position: absolute;
        top: 6.5px;
        right: 3.6px;
    }

    .swiper-container-rtl .swiper-button-next-manuels:after {
        content: '\203A';
        font-size: 30px;
        position: absolute;
        top: 6.5px;
        font-weight: 800;
        left: 3.6px;
    }

    .toast-box {
        position: fixed;
        bottom: 20px;
        border-radius: 25px;
        background: linear-gradient(135deg, #6bd4da 0%, #1e3b65 100%);
        padding: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.5s ease-in-out;
        opacity: 0;
        color: #fff;
        transform: translateY(20px);
        z-index: 1000;
    }

    .toast-box.show {
        opacity: 1;
        transform: translateY(0);
    }

    .toast-box.rtl-box {
        left: 10px;
    }

    .toast-box.ltr-box {
        right: 10px;
    }

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


    @media (max-width: 576px) {
        .swiper-button-next-manuels,
        .swiper-button-prev-manuels {
            display: none !important;
        }
    }
</style>

@php
    $userenfant = DB::table('users')
        ->where('organ_id', $authUser->id)
        ->orderBy('id', 'desc')
        ->get();
@endphp

@section('content')

        <!-- <section class="pl-20 pr-20">
            <div class="panel-section-card px-2">
                <div id="manuels-skeleton" class="skeleton-placeholder">
                    @for ($i = 0; $i < 5; $i++)
                        <div class="skeleton-manuel-card"></div>
                    @endfor
                </div>
                <div id="manuels-content" style="display: none;">
                    <div class="swiper-container swiper-container-manuels">
                        <div class="swiper-wrapper">
                            @foreach ($matiere1 as $material)
                                @foreach ($material->manuels as $manuel)
                                    <div class="swiper-slide">
                                        <a href="/panel/scolaire/{{ $manuel->id }}">
                                            <div class="manuel-card">
                                                <div class="image-box">
                                                    <img src="{{ asset($manuel->logo) }}" class="img-cover"
                                                         alt="{{ $manuel->name }}">
                                                </div>
                                                <div class="manuel-card-body w-100 d-flex flex-column">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span class="badge badge-primary">
                                                            {{ $manuel->matiere->section->level->name }}
                                                        </span>
                                                        <div class="d-flex align-items-center">
                                                            <i class="fas fa-video mr-5 primary"></i>
                                                            <span class="stat-value primary">
                                                                {{ $manuel->videos->count() }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center justify-content-between flex-wrap mt-auto">
                                                        <h3 class="font-12 text-dark-blue">{{ $manuel->name }}</h3>
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
        </section> -->
        @include('web.default.panel.manuels_section_child')

    <!-- -------------------------------- فضاء الولي ---------------------------------->
    <!-- @if ($authUser->isOrganization())
        @php
            $userenfantCount = DB::table('users')
                ->where('organ_id', $authUser->id)
                ->count();
        @endphp

        <section class="frame-section">
            <div class="section-content">
                @if (session('child_added'))
                    @if ($userenfantCount != 0)
                        <div class="{{ App::isLocale('ar') ? 'toast-box rtl-box' : 'toast-box ltr-box' }}" id="toastMessage">
                            @if ($userenfantCount == 4)
                                <p style="margin: 0; font-size: 20px; font-weight: bold;">
                                    {{ trans('panel.you_achieved_limit') }}
                                </p>
                            @elseif ($userenfantCount < 4)
                                @if (4 - $userenfantCount == 1)
                                    <p style="margin: 0; font-size: 20px; font-weight: bold;">
                                        {{ trans('panel.you_can_add_more_1_child') }}
                                    </p>
                                @elseif (4 - $userenfantCount == 2)
                                    <p style="margin: 0; font-size: 20px; font-weight: bold;">
                                        {{ trans('panel.you_can_add_more_2_children') }}
                                    </p>
                                @else
                                    <p style="margin: 0; font-size: 20px; font-weight: bold;">
                                        {{ trans('panel.you_can_add_more_3_children') }}
                                    </p>
                                @endif
                            @endif
                        </div>
                    @endif
                @endif

                @if ($userenfantCount > 0)
                    <div class="panel-title mt-30">
                        <h1 class="font-36 font-weight-bold text-secondary">{{ trans('panel.title') }}</h1>
                    </div>
                @elseif ($userenfantCount == 0)
                    <div class="panel-title mt-30">
                        <h1 class="font-36 font-weight-bold text-secondary">{{ trans('panel.add_children') }}</h1>
                    </div>
                @endif

                <div class="containerc" style="margin-top:5%">
                    @if ($userenfantCount == 0)
                        <div class="row">
                            <div class="col-12 d-flex flex-column align-items-center justify-content-center">
                                <div class="add-square-container-child first-square text-center">
                                    <span data-toggle="modal" data-target="#exampleModal">
                                        <div class="add-square-icon-wrapper">
                                            <img class="add-square-icon" loading="lazy" alt="Add"
                                                 src="/assets/default/icons/add-icon.jpeg"
                                                 width="150px" height="150px" />
                                        </div>
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($userenfantCount < 4 && $userenfantCount > 0)
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12 mb-3 d-flex flex-column align-items-center">
                                <div class="add-square-container-child second-square text-center" style="margin-right: 20px">
                                    <span data-toggle="modal" data-target="#exampleModal">
                                        <img class="add-square-icon" loading="lazy" alt="Add"
                                             src="/assets/default/icons/add-icon.jpeg"
                                             width="150px" height="150px" />
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <div class="row" style="margin-bottom:50px">
                                    @if (!empty($userenfant))
                                        @foreach ($userenfant as $enf)
                                            @php
                                                $levelenfant = DB::table('school_levels')
                                                    ->where('id', $enf->level_id)
                                                    ->pluck('name');
                                            @endphp
                                            <div class="col-lg-4 col-md-6 col-sm-12 mb-3 d-flex flex-column align-items-center">
                                                <a href="/panel/impersonate/user/{{ $enf->id }}">
                                                    <img class="avatar-child img-fluid"
                                                         src="{{ $enf->avatar }}" alt="Avatar">
                                                </a>
                                                <a href="/panel/impersonate/user/{{ $enf->id }}/setting" class="edit-icon">
                                                    <img src="/store/1/default_images/edit.png"
                                                         style="width:50px; background-color: rgba(0,0,0,0.5); border-radius: 50%;" />
                                                </a>
                                                <div class="flex-container text-center mt-2">
                                                    <span class="text-secondary font-20 d-block">
                                                        {{ $enf->full_name }}
                                                    </span>
                                                    <span class="font-weight-bold text-secondary font-20">
                                                        {{ $levelenfant[0] }}
                                                    </span>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="container">
                            <div class="row justify-content-center">
                                @if (!empty($userenfant))
                                    @foreach ($userenfant as $enf)
                                        @php
                                            $levelenfant = DB::table('school_levels')
                                                ->where('id', $enf->level_id)
                                                ->pluck('name');
                                        @endphp
                                        <div class="col-lg-3 col-md-6 col-sm-12 mb-4 d-flex justify-content-center">
                                            <div class="text-center">
                                                <a href="/panel/impersonate/user/{{ $enf->id }}">
                                                    <img class="avatar-child img-fluid"
                                                         src="{{ $enf->avatar }}" alt="Avatar">
                                                </a>
                                                <a href="/panel/impersonate/user/{{ $enf->id }}/setting" class="edit-icon">
                                                    <img src="/store/1/default_images/edit.png"
                                                         style="width:50px; background-color: rgba(0,0,0,0.5); border-radius: 50%;" />
                                                </a>
                                                <div class="flex-container mt-2">
                                                    <span class="text-secondary font-20 d-block">
                                                        {{ $enf->full_name }}
                                                    </span>
                                                    <span class="font-weight-bold text-secondary font-20 d-block">
                                                        {{ $levelenfant[0] }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif -->

@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
    <script src="/assets/default/vendors/owl-carousel2/owl.carousel.min.js"></script>
    <script src="/assets/default/vendors/parallax/parallax.min.js"></script>
    <script src="/assets/default/js/parts/home.min.js"></script>
    <script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
    <script src="/assets/default/vendors/toast/jquery.toast.min.js"></script>
    <script src="/assets/vendors/wrunner-html-range-slider-with-2-handles/js/wrunner-jquery.js"></script>
    <script src="{{ asset('/sw.js') }}"></script>

    <script src="https://unpkg.com/shepherd.js@8.1.0/dist/js/shepherd.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/shepherd.js@8.1.0/dist/css/shepherd.css" />

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toastMessage = document.getElementById('toastMessage');
            if (toastMessage) {
                function showToast() {
                    toastMessage.classList.add('show');
                    setTimeout(() => {
                        toastMessage.classList.remove('show');
                    }, 5000);
                }
                setTimeout(showToast, 500);
            }
        });
    </script>

    @if ($authUser->isOrganization())
        <script>
            document.addEventListener('DOMContentLoaded', async function() {
                let guideProgress = {!! json_encode($guide_progress ?? []) !!};
                let latestProgress = await fetchGuideProgress();
                let currentStep = 1;

                if (latestProgress?.includes('step1_completed') && !latestProgress.includes('step2_completed')) {
                    currentStep = 2;
                } else if (latestProgress?.includes('step2_completed') && !latestProgress.includes('step3_completed')) {
                    currentStep = 3;
                }

                const tour = new Shepherd.Tour({
                    defaultStepOptions: {
                        scrollTo: true,
                        classes: 'shadow-md bg-purple-dark',
                        cancelIcon: {
                            enabled: true
                        },
                        buttons: [{
                            text: '{{ trans('panel.next') }}',
                            action: async function() {
                                await updateProgress('dashboard', `step${currentStep}_completed`);
                                currentStep++;
                                tour.next();
                            },
                            classes: 'shepherd-button shepherd-button-next'
                        }]
                    }
                });

                let userenfantCount = {{ $userenfantCount }};
                setupSteps(userenfantCount, latestProgress);

                function setupSteps(userenfantCount, latestProgress) {
                    if (userenfantCount == 0 && !latestProgress.includes('step1_completed')) {
                        const firstSquare = document.querySelector('.first-square');
                        tour.addStep({
                            id: 'dashboard-step-1',
                            text: '{{ trans('panel.step_1_description') }}',
                            attachTo: {
                                element: '.first-square',
                                on: 'bottom'
                            }
                        });
                        if (firstSquare) {
                            firstSquare.addEventListener('click', async function() {
                                if (currentStep === 1) {
                                    try {
                                        await updateProgress('dashboard', 'step1_completed');
                                        currentStep++;
                                        tour.next();
                                    } catch (error) {
                                        console.error(error);
                                    }
                                }
                            });
                        }
                    }

                    const secondSquare = document.querySelector('.second-square');
                    if (userenfantCount > 0 && !latestProgress.includes('step2_completed')) {
                        tour.addStep({
                            id: 'dashboard-step-2',
                            text: '{{ trans('panel.step_2_description') }}',
                            attachTo: {
                                element: '.second-square',
                                on: 'bottom'
                            }
                        });
                        if (secondSquare) {
                            secondSquare.addEventListener('click', async function() {
                                try {
                                    await updateProgress('dashboard', 'step2_completed');
                                    currentStep++;
                                    tour.next();
                                } catch (error) {
                                    console.error(error);
                                }
                            });
                        }
                    }

                    if (userenfantCount > 0 && !latestProgress.includes('step3_completed')) {
                        const avatarChild = document.querySelector('.avatar-child');
                        tour.addStep({
                            id: 'dashboard-step-3',
                            text: '{{ trans('panel.step_3_description') }}',
                            attachTo: {
                                element: '.avatar-child',
                                on: 'bottom'
                            }
                        });
                        if (avatarChild) {
                            avatarChild.addEventListener('click', async function() {
                                try {
                                    await updateProgress('dashboard', 'step3_completed');
                                    currentStep++;
                                    tour.next();
                                } catch (error) {
                                    console.error(error);
                                }
                            });
                        }
                    }
                }

                $('#exampleModal').on('shown.bs.modal', function() {
                    if (tour.getCurrentStep() && tour.getCurrentStep().id === 'dashboard-step-3') {
                        tour.hide();
                    }
                });

                $('#exampleModal').on('hidden.bs.modal', function() {
                    if (currentStep === 3 && !guideProgress.includes('step3_completed')) {
                        tour.show('dashboard-step-3');
                    }
                });

                function updateProgress(page, step) {
                    fetch('{{ route('update.guide.progress') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ page: page, step: step })
                    })
                    .then(response => response.json())
                    .then(data => console.log('Progress updated:', data));
                }

                async function fetchGuideProgress() {
                    const response = await fetch('{{ route('fetch.progress') }}', {
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });
                    const data = await response.json();
                    console.log('Progress fetched:', data);
                    return data?.dashboard || [];
                }

                tour.start();
                if (currentStep <= 3) {
                    tour.show(`dashboard-step-${currentStep}`);
                }
            });
        </script>
    @endif

    <!-- Shepherd JS for Enfant -->
    @if ($authUser->isEnfant())
        <script>
            document.addEventListener('DOMContentLoaded', async function() {
                function getRoundedCircle() {
                    if (window.innerWidth <= 768) {
                        return document.querySelector('.mobile-avatar');
                    } else {
                        return document.querySelector('.desktop-avatar');
                    }
                }

                const guideProgress = await fetchGuideProgress();
                const bookCard = document.querySelector('.manuel-card');
                console.log('Guide progress:', guideProgress);
                const roundedCircle = getRoundedCircle();

                let currentStep = 1;
                if (guideProgress.includes('step1_child_completed') && !guideProgress.includes('step2_child_completed')) {
                    currentStep = 2;
                }

                const tour = new Shepherd.Tour({
                    defaultStepOptions: {
                        scrollTo: true,
                        classes: 'shadow-md bg-purple-dark',
                        popperOptions: {
                            modifiers: [{
                                name: 'offset',
                                options: { offset: [0, 10] }
                            }],
                        },
                        cancelIcon: {
                            enabled: true
                        },
                        buttons: [{
                            text: '{{ trans('panel.next') }}',
                            action: async function() {
                                await updateProgress('dashboard', `step${currentStep}_child_completed`);
                                currentStep++;
                                if (currentStep <= 2) {
                                    tour.next();
                                } else {
                                    tour.complete();
                                }
                            },
                            classes: 'shepherd-button shepherd-button-next'
                        }]
                    }
                });

                setupTourSteps(guideProgress);

                function setupTourSteps(guideProgress) {
                    // Step 1
                    if (!guideProgress.includes('step1_child_completed')) {
                        tour.addStep({
                            id: 'dashboard-child-step-1',
                            text: '{{ trans('panel.step_1_child_description') }}',
                            attachTo: {
                                element: '.manuel-card',
                                on: 'bottom'
                            }
                        });
                        console.log('Book card:', bookCard);
                        if (bookCard) {
                            bookCard.addEventListener('click', async function() {
                                try {
                                    await updateProgress('dashboard', 'step1_child_completed');
                                    currentStep++;
                                    tour.next();
                                } catch (error) {
                                    console.error(error);
                                }
                            });
                            console.log('Book card event listener added');
                        }
                    }

                    // Step 2
                    if (!guideProgress.includes('step2_child_completed')) {
                        tour.addStep({
                            id: 'dashboard-child-step-2',
                            text: '{{ trans('panel.step_2_child_description') }}',
                            attachTo: {
                                element: roundedCircle,
                                on: 'bottom'
                            }
                        });
                        if (roundedCircle) {
                            roundedCircle.addEventListener('click', async function() {
                                try {
                                    await updateProgress('dashboard', 'step2_child_completed');
                                    currentStep++;
                                    tour.next();
                                } catch (error) {
                                    console.error(error);
                                }
                            });
                        }
                    }

                    tour.start();
                    if (currentStep <= 2) {
                        tour.show(`dashboard-child-step-${currentStep}`);
                    }
                }

                async function fetchGuideProgress() {
                    const response = await fetch('{{ route('fetch.progress') }}', {
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });
                    const data = await response.json();
                    return data?.dashboard || [];
                }

                function updateProgress(page, step) {
                    fetch('{{ route('update.guide.progress') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ page: page, step: step })
                    })
                    .then(response => response.json())
                    .then(data => console.log('Progress updated:', data));
                }
            });
        </script>

        <script>
            let manuelsSwiper = null;

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

            function destroyManuelsSwiper() {
                if (manuelsSwiper) {
                    manuelsSwiper.destroy(true, true);
                    manuelsSwiper = null;
                }
            }

            function toggleNavigationVisibility(swiperInstance) {
                const { isBeginning, isEnd } = swiperInstance;
                if (swiperInstance.navigation) {
                    const { nextEl, prevEl } = swiperInstance.navigation;
                    if (prevEl) {
                        prevEl.style.display = isBeginning ? 'none' : 'flex';
                    }
                    if (nextEl) {
                        nextEl.style.display = isEnd ? 'none' : 'flex';
                    }
                }
            }

            function handleResize() {
    const manuelsContainer = document.querySelector('.swiper-container-manuels');
    if (!manuelsContainer) return;

    const isMobile = window.innerWidth <= 576;
    if (isMobile) {
        destroyManuelsSwiper();
        manuelsContainer.classList.add('mobile-view-manuels');
    } else {
        manuelsContainer.classList.remove('mobile-view-manuels');
        if (!manuelsSwiper) {
            initManuelsSwiper();
        }
    }
}


            document.addEventListener('DOMContentLoaded', function() {
                // Hide skeleton, show content
                const manuelsSkeleton = document.getElementById('manuels-skeleton');
                const manuelsContent = document.getElementById('manuels-content');
                if (manuelsSkeleton && manuelsContent) {
                    manuelsSkeleton.style.display = 'none';
                    manuelsContent.style.display = 'block';
                }

                // Initial call
                handleResize();
                // Listen for resizing
                window.addEventListener('resize', handleResize);
            });
        </script>
    @endif

@endpush

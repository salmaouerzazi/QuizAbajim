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

@php
    $userenfant = DB::table('users')
        ->where('organ_id', $authUser->id)
        ->orderBy('id', 'desc')
        ->get();
    $userenfantCount = DB::table('users')
            ->where('organ_id', $authUser->id)
            ->count();
            $firstChild = null;

    if ($userenfantCount > 0) {
        $firstChild = DB::table('users')
            ->where('organ_id', $authUser->id)
            ->first();
    }
@endphp

@section('content')
    @include('web.default.panel.manuels_section_child')
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

    @if(isset($showAddChildModal) && $showAddChildModal)
        <script>
            $(document).ready(function() {
                $('#exampleModal').modal('show');
            });
        </script>
    @endif


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
                const manuelsSkeleton = document.getElementById('manuels-skeleton');
                const manuelsContent = document.getElementById('manuels-content');
                if (manuelsSkeleton && manuelsContent) {
                    manuelsSkeleton.style.display = 'none';
                    manuelsContent.style.display = 'block';
                }
                handleResize();
                window.addEventListener('resize', handleResize);
            });
        </script>
    @endif
@endpush

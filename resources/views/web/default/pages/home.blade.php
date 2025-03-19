@extends(getTemplate() . '.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/css/home.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/owl-carousel2/owl.carousel.min.css">
    <meta name="theme-color" content="#6777ef" />
    <link rel="apple-touch-icon" href="{{ asset('logo.PNG') }}">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400&display=swap"
        as="style">
@endpush

@section('content')
    <section class="slider-container slider-hero-section2 position-relative" style="border-radius: 2rem;padding:10px">
        <div class="container text-center d-flex flex-column">
            <div class="row slider-content hero-section2 mt-20">
                <div
                    class="col-lg-8 col-md-12 col-sm-12 col-xs-12 d-flex flex-column justify-content-center align-items-center">
                    <h1 class="page-title text-secondary" style="font-weight:bolder;">
                        <span class="brand-name"> {{ trans('home.title') }}</span>
                        <br>
                        <span class="slogan mb-20">{{ trans('home.title2') }}</span>
                    </h1>

                    <div class="d-flex justify-content-center align-items-center">
                        <div class="right-side">
                            <br>
                            <h2 class="page-subtitle font-weight-bold text-secondary">
                                {{ trans('home.subtitle') }}
                            </h2>
                            <img src="/assets/default/icons/two-lines.png" alt="hero image" width="35%">
                        </div>
                        <div class="left-side d-none d-lg-flex">
                            <img src="/assets/default/icons/orange-lines.png" alt="hero image" width="20%">
                        </div>
                    </div>

                    <form action="/search" method="get" class="d-inline-flex mt-4 justify-content-center w-100">
                        <div class="form-group d-flex align-items-center m-0 slider-search p-2 bg-white">
                            <input type="text" name="search" class="form-control border-0 mr-lg-3"
                                placeholder="{{ trans('home.slider_search_placeholder') }}" />
                            <button type="submit" class="btn btn-primary rounded-pill">{{ trans('home.find') }}</button>
                        </div>
                    </form>
                    <a href="/register"
                        class="d-lg-flex btn btn-primary nav-start-a-live-btn register-btn mt-25 p-20">{{ trans('public.start_now') }}</a>
                    <img src="/assets/default/icons/arrow.png" alt="hero image" class="arrow-img d-none d-lg-flex">
                </div>
                <div class="col-lg-4 col-md-12 d-none d-lg-flex justify-content-center align-items-center">
                    <img src="/assets/default/img/left-hero.png" alt="hero image" class="image-hero">
                </div>
            </div>
        </div>
        <div class="discover-more" id="discover-more">
            <div class="mouse-icon">
                <div class="mouse-wheel"></div>
            </div>
            <div class="arrow-down"></div>
            <p class="discover-text">إكتشف المزيد</p>
        </div>

    </section>

    <div class="stats-container" id="stats-container">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-lg-3 mt-25 mt-lg-0">
                    <div class="stats-item d-flex flex-column align-items-center text-center py-30 px-5 w-100"
                        style="  border: 4px solid rgba(93, 219, 219, 0.23000000417232513);">
                        <img src="/assets/default/img/teacher.png" alt="" width="130" height="120"
                            alt="Skillful teacher number" loading="lazy" />
                        <strong class="stat-number mt-10">{{ $skillfulTeachersCount }}</strong>
                        <h3 class="stat-title">{{ trans('home.skillful_teachers') }}</h3>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3 mt-25 mt-lg-0">
                    <div class="stats-item d-flex flex-column align-items-center text-center py-30 px-5 w-100"
                        style="  border: 4px solid rgba(236, 229, 241, 1);">
                        <img src="/assets/default/icons/happy-kid.webp" alt="" width="120" height="120"
                            alt="Students Count Kids" loading="lazy" />
                        <strong class="stat-number mt-10">{{ $StudentsCountKids }}</strong>
                        <h3 class="stat-title">{{ trans('home.happy_students') }}</h3>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3 mt-25 mt-lg-0">
                    <div class="stats-item d-flex flex-column align-items-center text-center py-30 px-5 w-100"
                        style="   border: 4px solid rgba(29, 59, 101, 0.2199999988079071);">
                        <img src="/assets/default/img/live-videos.png" alt="" width="150" height="120"
                            alt="Live Class Count" loading="lazy" />
                        <strong class="stat-number mt-10">{{ $WebinarCount }}</strong>
                        <h3 class="stat-title">دروس إضافية </h3>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3 mt-25 mt-lg-0">
                    <div class="stats-item d-flex flex-column align-items-center text-center py-30 px-5 w-100"
                        style="  border: 4px solid #EECEB9">
                        <img src="/assets/default/img/videos.png" alt="" width="150" height="120"
                            alt="Video Count" loading="lazy" />
                        <strong class="stat-number mt-10">{{ $VideoCount }}</strong>
                        <h3 class="stat-title">{{ trans('home.offline_courses') }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- --------------------DETAILS BLOC ----------------------------------- --}}

    <section class="home-section home-section-swiper container find-instructor-section position-relative">
        <div class="row align-items-center">
            <div class="col-12 col-lg-6">
                <h2 class="font-30 font-weight-bold text-secondary">
                    {{ trans('home.details_title') }}
                </h2>
                <h4 class="font-weight-normal mt-10" style="text-align: justify;font-size:20px">
                    {{ trans('home.details_subtitle') }}
                </h4>
            </div>

            <div class="col-12 col-lg-6 mt-20 mt-lg-0">
                <div class="position-relative ">
                    <img src="/assets/default/img/home/dot.png" class="find-instructor-section-dots" alt="dots"
                        loading="lazy">

                    <img src="/assets/default/img/home/circle-4.png" class="find-instructor-section-circle"
                        alt="circle" loading="lazy">
                    <video controls class="responsive-video" loading="lazy">
                        <source src="video/intro ringing.mp4" type="video/mp4">
                    </video>

                </div>
            </div>
        </div>
    </section>

    {{-- DESCRIPTION SECTION FOR PARENT AND INSTRUCTOR --}}

    <section class="home-sections home-sections-swiper container find-instructor-section position-relative"
        style="margin-top: 120px!important">
        <div class="container">
            <div class="row justify-content-lg-between justify-content-center align-items-center">


                <!-- Parent Space -->
                <div class="space-card">
                    <div class="card-content">
                        <img src="assets/default/img/parent-image.png" alt="Parent Space" class="space-image"
                            loading="lazy">
                        <h2 class="text-secondary" style="font-size: 30px;margin-bottom: 20px;">
                            {{ trans('home.parent_space') }}
                        </h2>
                        <p style="font-size: 20px;color: #000000;margin-bottom: 40px;">
                            {{ trans('home.parent_space_description') }}
                        </p>

                    </div>
                    <a href="/register" class="cta-button">
                        {{ trans('home.register_now') }}
                    </a>
                </div>
                <!-- Teacher Space -->
                <div class="space-card">
                    <div class="card-content">
                        <img src="assets/default/img/teacher-image.png" alt="Teacher Space" class="space-image">
                        <h2 class="text-secondary" style="font-size: 30px;margin-bottom: 20px;">
                            {{ trans('home.teacher_space') }}
                        </h2>
                        <p style="font-size:20px;color: #000000;margin-bottom: 40px;">
                            {{ trans('home.teacher_space_description') }}
                        </p>
                    </div>
                    <a href="/Instructor/register" class="cta-button">
                        {{ trans('home.become_instructor') }}
                    </a>

                </div>
            </div>
        </div>
    </section>

    {{--  TABS --}}
    <section class="home-sections home-sections-swiper container position-relative">
        <div class="text-center">
            <h2 class="font-weight-bold text-secondary" style="margin-bottom:30px;font-size:2.2rem">
                {{ trans('home.manuels') }}
            </h2>
        </div>

        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist"
            style="justify-content: center;align-items:center;align-self:center;justify-self:center">
            <li class="nav-item mb-10" role="presentation">
                <a class="nav-link active" id="pills-first-tab" data-bs-toggle="pill" href="#pills-first"
                    role="tab" aria-controls="pills-first" aria-selected="true">
                    <h3 style="font-size: 1rem!important;">{{ trans('home.first_level') }}</h3>
                </a>
            </li>

            <li class="nav-item" role="presentation">
                <a class="nav-link" id="pills-second-tab" data-bs-toggle="pill" href="#pills-second" role="tab"
                    aria-controls="pills-second" aria-selected="false">
                    <h3 style="font-size: 1rem!important;">{{ trans('home.second_level') }}</h3>
                </a>
            </li>

            <li class="nav-item" role="presentation">

                <a class="nav-link" id="pills-third-tab" data-bs-toggle="pill" href="#pills-third" role="tab"
                    aria-controls="pills-third" aria-selected="false">
                    <h3 style="font-size: 1rem!important;">{{ trans('home.third_level') }}</h3>
                </a>

            </li>

            <li class="nav-item" role="presentation">

                <a class="nav-link" id="pills-fourth-tab" data-bs-toggle="pill" href="#pills-fourth" role="tab"
                    aria-controls="pills-fourth" aria-selected="false">
                    <h3 style="font-size: 1rem!important;">{{ trans('home.fourth_level') }}</h3>
                </a>

            </li>

            <li class="nav-item" role="presentation">
                <a class="nav-link" id="pills-fifth-tab" data-bs-toggle="pill" href="#pills-fifth" role="tab"
                    aria-controls="pills-fifth" aria-selected="false">
                    <h3 style="font-size: 1rem!important;">{{ trans('home.fifth_level') }}</h3>
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="pills-sixth-tab" data-bs-toggle="pill" href="#pills-sixth" role="tab"
                    aria-controls="pills-sixth" aria-selected="false">
                    <h3 style="font-size: 1rem!important;">{{ trans('home.sixth_level') }}</h3>
                </a>

            </li>

        </ul>

        @php

            $manuels_1 = App\Models\Manuels::whereHas('matiere.section', function ($query) {
                $query->where('level_id', 6);
            })->get();

            $manuels_2 = App\Models\Manuels::whereHas('matiere.section', function ($query) {
                $query->where('level_id', 7);
            })->get();

            $manuels_3 = App\Models\Manuels::whereHas('matiere.section', function ($query) {
                $query->where('level_id', 8);
            })->get();

            $manuels_4 = App\Models\Manuels::whereHas('matiere.section', function ($query) {
                $query->where('level_id', 9);
            })->get();

            $manuels_5 = App\Models\Manuels::whereHas('matiere.section', function ($query) {
                $query->where('level_id', 10);
            })->get();

            $manuels_6 = App\Models\Manuels::whereHas('matiere.section', function ($query) {
                $query->where('level_id', 11);
            })->get();

        @endphp

        <div class="tab-content" id="pills-tabContent"
            style="justify-content: center;align-items:center;justify-self:center;
            background-color:#e0e7ff;border-radius:10px;padding:20px;width: 100%!important;height:300px">

            <div class="tab-pane fade show active" id="pills-first" role="tabpanel" aria-labelledby="pills-first-tab">
                <div class=" swiper-container">
                    <div class="swiper-wrapper" style="justify-content:center">
                        @foreach ($manuels_1 as $manuel)
                            <div class="swiper-slide col-6 col-md-2">
                                <a href="#" data-bs-toggle="modal"
                                    data-bs-target="#manuelModal{{ $manuel->id }}">
                                    <img src="{{ $manuel->logo }}"
                                        alt="اصلاح كتاب {{ $manuel->name }} السنة {{ $manuel->matiere->section->level->name }}"
                                        width="100%" height="90%" style="border-radius:10px">
                                </a>
                                <!-- Hidden but SEO-friendly title -->
                                <h4 class="sr-only">اصلاح كتاب {{ $manuel->name }} السنة
                                    {{ $manuel->matiere->section->level->name }} </h4>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
            <div class="tab-pane fade" id="pills-second" role="tabpanel" aria-labelledby="pills-second-tab">
                <div class=" swiper-container">
                    <div class="swiper-wrapper" style="justify-content:center">
                        @foreach ($manuels_2 as $manuel)
                            <div class="swiper-slide col-6 col-md-2">
                                <a href="#" data-bs-toggle="modal"
                                    data-bs-target="#manuelModal{{ $manuel->id }}">
                                    <img src="{{ $manuel->logo }}"
                                        alt="اصلاح كتاب {{ $manuel->name }} السنة {{ $manuel->matiere->section->level->name }}"
                                        width="100%" height="90%" style="border-radius:10px">
                                </a>
                                <h4 class="sr-only">اصلاح كتاب {{ $manuel->name }} السنة
                                    {{ $manuel->matiere->section->level->name }} </h4>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>


            <div class="tab-pane fade" id="pills-third" role="tabpanel" aria-labelledby="pills-third-tab">
                <div class="row swiper-container" style="justify-content: center">
                    <div class="swiper-wrapper" style="justify-content:center">
                        @foreach ($manuels_3 as $manuel)
                            <div class="swiper-slide col-6 col-md-2">

                                <a href="#" data-bs-toggle="modal"
                                    data-bs-target="#manuelModal{{ $manuel->id }}">
                                    <img src="{{ $manuel->logo }}"
                                        alt="اصلاح كتاب {{ $manuel->name }} السنة {{ $manuel->matiere->section->level->name }}"
                                        width="100%" height="90%" style="border-radius:10px">
                                </a>
                                <h4 class="sr-only">اصلاح كتاب {{ $manuel->name }} السنة
                                    {{ $manuel->matiere->section->level->name }} </h4>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>

            <div class="tab-pane fade" id="pills-fourth" role="tabpanel" aria-labelledby="pills-fourth-tab">
                <div class="row swiper-container testimonials-swiper px-12">
                    <div class="swiper-wrapper" style="justify-content:flex-start">
                        @foreach ($manuels_4 as $manuel)
                            <div class="swiper-slide col-6 col-md-2">
                                <a href="#" data-bs-toggle="modal"
                                    data-bs-target="#manuelModal{{ $manuel->id }}">
                                    <img src="{{ $manuel->logo }}"
                                        alt="اصلاح كتاب {{ $manuel->name }} السنة {{ $manuel->matiere->section->level->name }}"
                                        width="100%" height="90%" style="border-radius:10px">
                                </a>
                                <h4 class="sr-only">اصلاح كتاب {{ $manuel->name }} السنة
                                    {{ $manuel->matiere->section->level->name }} </h4>
                            </div>
                        @endforeach
                    </div>
                    {{-- <div class="swiper-pagination testimonials-swiper-pagination"></div> --}}
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>

            <div class="tab-pane fade" id="pills-fifth" role="tabpanel" aria-labelledby="pills-fifth-tab">
                <div class="row swiper-container testimonials-swiper">
                    <div class="swiper-wrapper" style="justify-content:flex-start">
                        @foreach ($manuels_5 as $manuel)
                            <div class="swiper-slide col-6 col-md-2">
                                <a href="#" data-bs-toggle="modal"
                                    data-bs-target="#manuelModal{{ $manuel->id }}">
                                    <img src="{{ $manuel->logo }}"
                                        alt="اصلاح كتاب {{ $manuel->name }} السنة {{ $manuel->matiere->section->level->name }}"
                                        width="100%" height="90%" style="border-radius:10px">

                                </a>
                                <h4 class="sr-only">اصلاح كتاب {{ $manuel->name }} السنة
                                    {{ $manuel->matiere->section->level->name }} </h4>
                            </div>
                        @endforeach

                    </div>

                    {{-- <div class="swiper-pagination testimonials-swiper-pagination"></div> --}}
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>

                </div>

            </div>

            <div class="tab-pane fade" id="pills-sixth" role="tabpanel" aria-labelledby="pills-sixth-tab">
                <div class="row swiper-container testimonials-swiper">
                    <div class="swiper-wrapper" style="justify-content:flex-start">
                        @foreach ($manuels_6 as $manuel)
                            <div class="swiper-slide col-6 col-md-2">
                                <a href="#" data-bs-toggle="modal"
                                    data-bs-target="#manuelModal{{ $manuel->id }}">
                                    <img src="{{ $manuel->logo }}"
                                        alt="اصلاح كتاب {{ $manuel->name }} السنة {{ $manuel->matiere->section->level->name }}"
                                        width="100%" height="90%" style="border-radius:10px">
                                </a>
                                <h4 class="sr-only">اصلاح كتاب {{ $manuel->name }} السنة
                                    {{ $manuel->matiere->section->level->name }} </h4>

                            </div>
                        @endforeach

                    </div>

                    {{-- <div class="swiper-pagination testimonials-swiper-pagination"></div> --}}
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>

            </div>

        </div>

    </section>
    <style>
        .swiper-button-next,
        .swiper-button-prev {
            color: #22bec8;
            background-color: rgba(29, 59, 101, 0.5);
            ;

            border-radius: 50%;
            padding: 30px;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);

            z-index: 10;
        }

        .swiper-button-prev {
            left: 10px;
        }

        .swiper-button-next {
            right: 10px;
        }

        .swiper-button-next:hover,
        .swiper-button-prev:hover {
            background-color: rgba(34, 190, 200, 0.5);
        }

        .accordion-body {
            font-size: 1.2rem;
        }
    </style>


    {{-- ----------------------------- LESSONS BLOC -------------------------------- --}}
    <section class="home-sections home-sections-swiper container position-relative">
        <div class="text-center">
            <h2 class="font-weight-bold text-secondary font-30" style="margin-bottom:30px;font-size:1.9rem">
                {{ trans('home.examples') }}
            </h2>
        </div>
        <div class="row justify-content-center align-items-center">
            <!-- Swiper Container -->
            <div class="swiper-container">
                <!-- Additional Swiper Wrapper -->
                <div class="swiper-wrapper">
                    @foreach ($videos as $video)
                        <!-- Each Video Card as a Swiper Slide -->
                        <div class="swiper-slide col-sm-4">
                            <div>
                                <div class="card custom-card" data-bs-toggle="modal"
                                    data-bs-target="#videoModal{{ $video->id }}" style="cursor:pointer">
                                    <div class="position-relative">
                                        <img src="{{ $video->thumbnail }}" class="card-img-top"
                                            alt="{{ $video->titre }}">
                                        <div class="play-icon">
                                            <i class="fas fa-play-circle"></i>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <h3 style="font-size: 1.2rem;" class="card-title">{{ $video->titre }}</h3>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <!-- Manual Section -->
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $video->manuel->logo }}" alt="{{ $video->titre }}"
                                                    style="width: 40px; height: 40px; border-radius: 50%">
                                                <h4 class="card-title ml-1 mr-1 font-16">{{ $video->manuel->name }}</h4>
                                            </div>

                                            <!-- User Section -->
                                            <div class="d-flex align-items-center">
                                                @if (!empty($video->teacher->avatar))
                                                    <img src="{{ $video->teacher->getAvatar(100) }}"
                                                        alt="{{ $video->teacher->full_name }}"
                                                        style="width: 40px; height: 40px; border-radius: 50%">
                                                @else
                                                    <img src="{{ $video->teacher->getAvatar(100) }}"
                                                        alt="{{ $video->teacher->full_name }}"
                                                        style="width: 40px; height: 40px; border-radius: 50%">
                                                @endif
                                                <h6 class="card-title ml-1 mr-1 font-16">{{ $video->teacher->full_name }}
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="/login" class="btn btn-primary custom-btn"
                                    style="margin-top: 10px">{{ trans('home.start_learning') }}</a>

                            </div>

                        </div>
                    @endforeach
                </div>

                <!-- If you want to add navigation arrows -->
                {{-- <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>  --}}

                <!-- If you want pagination bullets -->
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>

    @foreach ($homeSections as $homeSection)
        @if (
            $homeSection->name == \App\Models\HomeSection::$full_advertising_banner and
                !empty($advertisingBanners1) and
                count($advertisingBanners1))
            <div class="home-sections home-sections-swiper container">
                <div class="row">
                    @foreach ($advertisingBanners1 as $banner1)
                        <div class="col-{{ $banner1->size }}">
                            <a href="{{ $banner1->link }}">
                                <img src="{{ $banner1->image }}" class="img-cover rounded-sm"
                                    alt="{{ $banner1->title }}">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        {{-- ---------------------------- INSTRUCTORS BLOCK ------------------------------------- --}}
        @if ($homeSection->name == \App\Models\HomeSection::$instructors and !empty($instructors) and !$instructors->isEmpty())
            <section class="home-sections container" style="margin-top: 150px">
                <div class="d-flex justify-content-between">

                    <h2 class="font-weight-bold font-30 text-secondary">
                        {{ trans('home.homeinstructors') }}</h2>

                    <a href="/instructors" class="btn btn-border-white">{{ trans('home.all_instructors') }}</a>
                </div>

                <div class="position-relative ltr">
                    <div class="owl-carousel customers-testimonials instructors-swiper-container" style="height:250px">
                        @foreach ($instructors as $instructor)
                            <div class="item">
                                <div class="shadow-effect">
                                    <div class="instructors-card d-flex flex-column align-items-center">
                                        <div class="instructors-card-avatar">
                                            <img src="{{ $instructor->getAvatar(108) }}"
                                                alt="{{ $instructor->full_name }}" class="rounded-circle img-cover">
                                        </div>
                                        <div class="instructors-card-info mt-10 d-flex"
                                            style="align-items:center;justify-content:space-between">
                                            <a href="/login" class="btn"
                                                style="margin-right:10px;padding:10px;border:1px solid  var(--primary-border-hover)">
                                                {{ trans('home.follow') }}
                                            </a>
                                            <a href="{{ $instructor->getProfileUrl() }}" target="_blank">
                                                <h3 class="font-16 font-weight-bold text-dark-blue">
                                                    {{ $instructor->full_name }}
                                                </h3>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </section>
        @endif
    @endforeach
    <section class="home-sections home-sections-swiper container position-relative">
        <div class="text-center ">
            <h2 class="text-secondary" style="font-size:30px">كيفية الاشتراك</h2>
            <p class="section-hint" style="font-size: 20px">{{ trans('home.subscribe_now_hint') }}</p>
        </div>
        <div class="discount-block row">
            <div class="col-md-6 mt-40">
                <h3>أحصل على بطاقة</h3>
                <p>{{ trans('home.card_block_description') }}</p>
                <a href="/card_reservations" class="btn btn-primary">{{ trans('home.subscribe_now') }}</a>
            </div>
            <div class="col-md-6">
                <div class="cover atvImg mgg">
                    <div class="atvImg-layer" data-img="/abajimcard1.png"></div>
                </div>
            </div>
        </div>
    </section>
    {{-- --------------------PACKS BLOC ----------------------------------- --}}

    {{-- @foreach ($homeSections as $homeSection)

        @if ($homeSection->name == \App\Models\HomeSection::$subscribes and !empty($subscribes) and !$subscribes->isEmpty())
            @include('web.default.panel.packs.includes.packsComponent')
        @endif
    @endforeach --}}

    {{-- SPECIAL OFFER BLCOCK --}}
    {{-- <section class="home-sections home-sections-swiper container position-relative">
    
        <div class="discount-block">
            <h2>{{ trans('home.discount_block') }}</h2>
            <p>
                {{ trans('home.discount_block_description') }}
            </p>
            <a href="/login" class="btn btn-primary">{{ trans('home.subscribe_now') }}</a>
        </div>
    </section> --}}


    @foreach ($homeSections as $homeSection)
        {{-- --------------------REVIEW BLOC ----------------------------------- --}}
        @if (
            $homeSection->name == \App\Models\HomeSection::$testimonials and
                !empty($testimonials) and
                !$testimonials->isEmpty())
            <div class="position-relative testimonials-container">

                <div id="parallax1" class="ltr">
                    <div data-depth="0.2" class="gradient-box left-gradient-box"></div>
                </div>

                <section class="container home-sections home-sections-swiper">
                    <div class="text-center">

                        <h2 class="text-secondary" style="font-size:30px">{{ trans('home.testimonials') }}</h2>
                        <p class="section-hint" style="font-size: 20px">{{ trans('home.testimonials_hint') }}</p>
                    </div>

                    <div class="position-relative">
                        <div class="swiper-container testimonials-swiper px-12">
                            <div class="swiper-wrapper">
                                @foreach ($testimonials as $testimonial)
                                    <div class="swiper-slide">
                                        <div
                                            class="testimonials-card  position-relative py-15 py-lg-30 px-10 px-lg-20 rounded-sm shadow bg-white text-center">
                                            <div class="d-flex flex-column align-items-center">
                                                <div class="testimonials-user-avatar">
                                                    <img src="{{ $testimonial->user_avatar }}"
                                                        alt="{{ $testimonial->user_name }}"
                                                        class="img-cover rounded-circle">
                                                </div>
                                                <h4 class="font-16 font-weight-bold text-secondary mt-30">
                                                    {{ $testimonial->user_name }}</h4>

                                            </div>
                                            <div class="comment-scrollable">
                                                <p class=" text-gray font-14">
                                                    {!! nl2br($testimonial->comment) !!}
                                                </p>
                                            </div>

                                            <div class="bottom-gradient"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </div>

                        <div class="d-flex justify-content-center">
                            <div class="swiper-pagination testimonials-swiper-pagination"></div>
                        </div>
                    </div>
                </section>

                <div id="parallax2" class="ltr">
                    <div data-depth="0.4" class="gradient-box right-gradient-box"></div>
                </div>

                <div id="parallax3" class="ltr">
                    <div data-depth="0.8" class="gradient-box bottom-gradient-box"></div>
                </div>
            </div>
        @endif
    @endforeach

    {{--  ---------------------------- FAQ ---------------------------- --}}
    <section class="home-sections home-sections-swiper container position-relative">
        <div class="text-center">
            <h2 class=" font-weight-bold font-30 " style="color: rgba(29, 59, 101, 1);margin-bottom:30px;">
                {{ trans('home.faq') }}
            </h2>
        </div>
        <div class="accordion accordion-flush" id="accordionExample">
            <div class="accordion-item" style="background-color:#cecbef">
                <h3 class="accordion-header" id="headingOne" style="justify-content: space-between">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" aria-label="collapse One"
                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        {{ trans('faq.faq_question_1') }}
                    </button>

                </h3>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        {{ trans('faq.faq_answer_1') }}
                    </div>
                </div>
            </div>
            <div class="accordion-item" style="background-color: #dfd9e4">
                <h3 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        aria-label="collapse Two" data-bs-target="#collapseTwo" aria-expanded="false"
                        aria-controls="collapseTwo">
                        {{ trans('faq.faq_question_2') }}
                    </button>
                </h3>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        {{ trans('faq.faq_answer_2') }}
                    </div>
                </div>
            </div>
            <div class="accordion-item" style="background-color:#c9d7e7">
                <h3 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        aria-label="collapse Three" data-bs-target="#collapseThree" aria-expanded="false"
                        aria-controls="collapseThree">
                        {{ trans('faq.faq_question_3') }}
                    </button>
                </h3>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        {{ trans('faq.faq_answer_3') }}
                    </div>
                </div>
            </div>
            <div class="accordion-item" style="background-color:#d0eaec">
                <h3 class="accordion-header" id="headingFour">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        aria-label="collapse Four" data-bs-target="#collapseFour" aria-expanded="false"
                        aria-controls="collapseFour">
                        {{ trans('faq.faq_question_4') }}
                    </button>
                </h3>
                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        {{ trans('faq.faq_answer_4') }}
                    </div>
                </div>
            </div>
            <div class="accordion-item" style="background-color:#c9dae2">
                <h3 class="accordion-header" id="headingFive">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        aria-label="collapse Five" data-bs-target="#collapseFive" aria-expanded="false"
                        aria-controls="collapseFive">
                        {{ trans('faq.faq_question_5') }}
                    </button>
                </h3>
                <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        {{ trans('faq.faq_answer_5') }}
                    </div>
                </div>
            </div>
            <div class="accordion-item" style="background-color:#d6d5df">
                <h3 class="accordion-header" id="headingSix">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        aria-label="collapse Six" data-bs-target="#collapseSix" aria-expanded="false"
                        aria-controls="collapseSix">
                        {{ trans('faq.faq_question_6') }}
                    </button>
                </h3>
                <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        {{ trans('faq.faq_answer_6') }}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal 1 -->
    <!-- Video List -->
    @foreach ($videos as $video)
        <!-- Modal -->
        <div class="modal fade" id="videoModal{{ $video->id }}" tabindex="-1"
            aria-labelledby="videoModal{{ $video->id }}Label" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="align-items: center">
                        <h5 class="modal-title" id="videoModal{{ $video->id }}Label">{{ $video->titre }}</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"
                            aria-label="Time">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="height: 500px">
                        <!-- Empty src initially -->
                        <video controls id="videoPlayer{{ $video->id }}" style="width: 100%; height: 100%;"
                            loading="lazy">
                            <source data-src="{{ $video->video }}" type="video/mp4">
                        </video>
                    </div>
                </div>
            </div>
        </div>
    @endforeach



    <!-- Modals for each manuel (No content inside the modal body yet) -->
    @foreach ([$manuels_1, $manuels_2, $manuels_3, $manuels_4, $manuels_5, $manuels_6] as $manuels)
        @foreach ($manuels as $manuel)
            <div class="modal fade" id="manuelModal{{ $manuel->id }}" tabindex="-1"
                aria-labelledby="manuelModalLabel{{ $manuel->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title" style="font-size: 35px;" id="manuelModalLabel{{ $manuel->id }}">
                                {{ $manuel->name }}</h2>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"
                                aria-label="Time">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body lolo" id="manuelModalBody{{ $manuel->id }}" style="height:800px">
                            <!-- Content will be loaded dynamically here -->
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endforeach
    <!-- Modals for each manuel -->
    {{-- @foreach ([$manuels_1, $manuels_2, $manuels_3, $manuels_4, $manuels_5, $manuels_6] as $manuels)
        @foreach ($manuels as $manuel)
            <div class="modal fade" id="manuelModal{{ $manuel->id }}" tabindex="-1"
                aria-labelledby="manuelModalLabel{{ $manuel->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title" style="font-size: 35px;" id="manuelModalLabel{{ $manuel->id }}">
                                {{ $manuel->name }}</h1>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" style="height:800px">
                         

                            @php
                                $documents = json_decode($manuel->documents);
                            @endphp

                            @if ($documents && count($documents) > 0)
                                @foreach ($documents as $document)
                                    @if (!empty($document->{'3d_path_enfant'}))
                                        <a href="{{ $document->{'3d_path_enfant'} }}" class="fp-embed"
                                            data-fp-width="100%" data-fp-height="100%" style="max-width: 100%"></a>
                                    @else
                                        <span>{{ $document->name }} (No 3D path available)</span>
                                    @endif
                                @endforeach
                            @else
                                <p>No documents available.</p>
                            @endif 
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endforeach --}}
@endsection



@push('scripts_bottom')
    <script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
    <script src="/assets/default/vendors/owl-carousel2/owl.carousel.min.js"></script>
    <script src="/assets/default/vendors/parallax/parallax.min.js"></script>
    <script src="/assets/default/js/parts/home.min.js"></script>
    <script src="{{ asset('/sw.js') }}"></script>
    <script src="/assets/default/js/parts/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script async defer src="https://cdn-online.flowpaper.com/zine/3.8.4/js/embed.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        if (!navigator.serviceWorker.controller) {
            navigator.serviceWorker.register("/sw.js").then(function(reg) {
                console.log("Service worker has been registered for scope: " + reg.scope);
            });
        }
        document.addEventListener('DOMContentLoaded', function() {
            let options = {
                root: null,
                rootMargin: '0px',
                threshold: 0.1
            };

            let observer = new IntersectionObserver(function(entries, observer) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, options);

            let target = document.querySelector('.home-section');
            let homeSections = document.querySelectorAll('.home-sections');
            let statsContainer = document.querySelector('.stats-container');

            homeSections.forEach(homeSection => {
                observer.observe(homeSection);
            });

            observer.observe(statsContainer);
            observer.observe(target);


            const monthlyBtn = document.getElementById('monthlyBtn');
            const yearlyBtn = document.getElementById('yearlyBtn');
            const prices = document.querySelectorAll('.pack-price');

            function updatePrices(isYearly) {
                const currentMonth = new Date().getMonth() + 1;
                let monthsLeftInYear = 0;

                if (currentMonth < 6) {
                    monthsLeftInYear = 6 - currentMonth;
                } else {
                    monthsLeftInYear = 12 - currentMonth + 6;
                }
                prices.forEach(priceElement => {
                    const basePrice = parseFloat(priceElement.dataset.basePrice);
                    let finalPrice = basePrice;
                    if (isYearly) {
                        finalPrice = monthsLeftInYear * basePrice;
                    }
                    priceElement.innerHTML =
                        `<del>${finalPrice.toFixed(2)} DT</del>`;
                });
            }

            monthlyBtn.addEventListener('click', function() {
                monthlyBtn.classList.add('active');
                yearlyBtn.classList.remove('active');
                updatePrices(false);
            });

            yearlyBtn.addEventListener('click', function() {
                monthlyBtn.classList.remove('active');
                yearlyBtn.classList.add('active');
                updatePrices(true);
            });

            updatePrices(false);
        });
    </script>
    <script>
        if (!navigator.serviceWorker.controller) {
            navigator.serviceWorker.register("/sw.js").then(function(reg) {
                console.log("Service worker has been registered for scope: " + reg.scope);
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            let options = {
                root: null,
                rootMargin: '0px',
                threshold: 0.1
            };

            let observer = new IntersectionObserver(function(entries, observer) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, options);

            let target = document.querySelector('.home-section');
            let homeSections = document.querySelectorAll('.home-sections');
            let statsContainer = document.querySelector('.stats-container');

            homeSections.forEach(homeSection => {
                observer.observe(homeSection);
            });

            observer.observe(statsContainer);
            observer.observe(target);

            const monthlyBtn = document.getElementById('monthlyBtn');
            const yearlyBtn = document.getElementById('yearlyBtn');
            const prices = document.querySelectorAll('.pack-price');

            function updatePrices(isYearly) {
                const currentMonth = new Date().getMonth() + 1;
                let monthsLeftInYear = 0;

                if (currentMonth < 6) {
                    monthsLeftInYear = 6 - currentMonth;
                } else {
                    monthsLeftInYear = 12 - currentMonth + 6;
                }

                prices.forEach(priceElement => {
                    const basePrice = parseFloat(priceElement.dataset.basePrice);
                    let finalPrice = basePrice;
                    if (isYearly) {
                        finalPrice = monthsLeftInYear * basePrice;
                    }
                    priceElement.innerHTML =
                        `<span>${finalPrice.toFixed(2)} د.ت</span>`;
                });
            }

            monthlyBtn.addEventListener('click', function() {
                monthlyBtn.classList.add('active');
                yearlyBtn.classList.remove('active');
                updatePrices(false);
            });

            yearlyBtn.addEventListener('click', function() {
                monthlyBtn.classList.remove('active');
                yearlyBtn.classList.add('active');
                updatePrices(true);
            });

            // Initialize with yearly price and set the yearly button active
            yearlyBtn.classList.add('active');
            updatePrices(true); // Apply yearly price calculation on page load
        });
    </script>



    <script>
        $(document).ready(function() {
            // Event listener for when the modal is shown
            $('[id^=videoModal]').on('show.bs.modal', function(event) {
                var modal = $(this);
                var videoId = modal.attr('id').replace('videoModal',
                    ''); // Extract video ID from the modal ID
                var videoPlayer = $('#videoPlayer' + videoId); // Get the video player element
                var videoSrc = videoPlayer.find('source').data(
                    'src'); // Get the video src from data-src attribute

                // Set the video src if it's not already set
                if (!videoPlayer.find('source').attr('src')) {
                    videoPlayer.find('source').attr('src', videoSrc); // Set the src attribute
                    videoPlayer[0].load(); // Reload the video element with the new src
                }
            });

            // Optional: Pause and remove the video src when modal is hidden to prevent background play
            $('[id^=videoModal]').on('hide.bs.modal', function(event) {
                var modal = $(this);
                var videoId = modal.attr('id').replace('videoModal', '');
                var videoPlayer = $('#videoPlayer' + videoId);

                // Pause the video and reset the src attribute
                videoPlayer[0].pause();
                videoPlayer.find('source').attr('src', ''); // Clear the src
                videoPlayer[0].load(); // Reset the video player
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Add an event listener to load modal content when the modal is shown
            $('[id^=manuelModal]').on('show.bs.modal', function(event) {
                var modal = $(this);
                var modalId = modal.attr('id'); // Get the modal id
                var manuelId = modalId.replace('manuelModal', ''); // Extract manuel id

                // Check if the content has already been loaded
                if (modal.find('.modal-body')) {

                    // Make an AJAX request to fetch the modal content
                    $.ajax({
                        url: '/get-manuel-documents/' +
                            manuelId, // Adjust the URL according to your route
                        method: 'GET',
                        success: function(response) {
                            // Inject the response (HTML) into the modal body of this specific modal
                            modal.find('.lolo').html(response);
                        },
                        error: function() {
                            console.error("Error loading documents:", error);

                            modal.find('.modal-body').html(
                                '<p>Error loading documents. Please try again.</p>');
                        }
                    });
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const lazyBackgrounds = document.querySelectorAll('.slider-container');

            const lazyBackgroundObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.style.background =
                            'linear-gradient(0deg, #1a2c5e, #33548e);'; // Use optimized format here
                        lazyBackgroundObserver.unobserve(entry
                            .target); // Stop observing once the image is loaded
                    }
                });
            });

            lazyBackgrounds.forEach(function(lazyBackground) {
                lazyBackgroundObserver.observe(lazyBackground);
            });
        });

        function supportsWebP() {
            var elem = document.createElement('canvas');
            if (!!(elem.getContext && elem.getContext('2d'))) {
                // was able or not to get WebP representation
                return elem.toDataURL('image/webp').indexOf('data:image/webp') == 0;
            }
            return false;
        }

        document.addEventListener('DOMContentLoaded', function() {
            const container = document.querySelector('.slider-container');

            if (supportsWebP()) {
                container.style.backgroundImage =
                'url(/assets/default/img/abajim-hero-section.webp)'; // Use WebP format
            } else {
                container.style.backgroundImage =
                'url(/assets/default/img/abajim-hero-section.png)'; // Fallback to PNG
            }
        });
    </script>
    <script>
        function atvImg() {
            var d = document,
                de = d.documentElement,
                bd = d.getElementsByTagName('body')[0],
                htm = d.getElementsByTagName('html')[0],
                win = window,
                imgs = d.querySelectorAll('.atvImg'),
                totalImgs = imgs.length,
                supportsTouch = 'ontouchstart' in win || navigator.msMaxTouchPoints;

            if (totalImgs <= 0) {
                return;
            }

            for (var l = 0; l < totalImgs; l++) {

                var thisImg = imgs[l],
                    layerElems = thisImg.querySelectorAll('.atvImg-layer'),
                    totalLayerElems = layerElems.length;

                if (totalLayerElems <= 0) {
                    continue;
                }

                while (thisImg.firstChild) {
                    thisImg.removeChild(thisImg.firstChild);
                }

                var containerHTML = d.createElement('div'),
                    shineHTML = d.createElement('div'),
                    shadowHTML = d.createElement('div'),
                    layersHTML = d.createElement('div'),
                    layers = [];

                thisImg.id = 'atvImg__' + l;
                containerHTML.className = 'atvImg-container';
                shineHTML.className = 'atvImg-shine';
                shadowHTML.className = 'atvImg-shadow';
                layersHTML.className = 'atvImg-layers';

                for (var i = 0; i < totalLayerElems; i++) {
                    var layer = d.createElement('div'),
                        imgSrc = layerElems[i].getAttribute('data-img');

                    layer.className = 'atvImg-rendered-layer';
                    layer.setAttribute('data-layer', i);
                    layer.style.backgroundImage = 'url(' + imgSrc + ')';
                    layersHTML.appendChild(layer);

                    layers.push(layer);
                }

                containerHTML.appendChild(shadowHTML);
                containerHTML.appendChild(layersHTML);
                containerHTML.appendChild(shineHTML);
                thisImg.appendChild(containerHTML);

                var w = thisImg.clientWidth || thisImg.offsetWidth || thisImg.scrollWidth;
                thisImg.style.transform = 'perspective(' + w * 3 + 'px)';

                if (supportsTouch) {
                    win.preventScroll = false;

                    (function(_thisImg, _layers, _totalLayers, _shine) {
                        thisImg.addEventListener('touchmove', function(e) {
                            if (win.preventScroll) {
                                e.preventDefault();
                            }
                            processMovement(e, true, _thisImg, _layers, _totalLayers, _shine);
                        });
                        thisImg.addEventListener('touchstart', function(e) {
                            win.preventScroll = true;
                            processEnter(e, _thisImg);
                        });
                        thisImg.addEventListener('touchend', function(e) {
                            win.preventScroll = false;
                            processExit(e, _thisImg, _layers, _totalLayers, _shine);
                        });
                    })(thisImg, layers, totalLayerElems, shineHTML);
                } else {
                    (function(_thisImg, _layers, _totalLayers, _shine) {
                        thisImg.addEventListener('mousemove', function(e) {
                            processMovement(e, false, _thisImg, _layers, _totalLayers, _shine);
                        });
                        thisImg.addEventListener('mouseenter', function(e) {
                            processEnter(e, _thisImg);
                        });
                        thisImg.addEventListener('mouseleave', function(e) {
                            processExit(e, _thisImg, _layers, _totalLayers, _shine);
                        });
                    })(thisImg, layers, totalLayerElems, shineHTML);
                }
            }

            function processMovement(e, touchEnabled, elem, layers, totalLayers, shine) {

                var bdst = bd.scrollTop || htm.scrollTop,
                    bdsl = bd.scrollLeft,
                    pageX = (touchEnabled) ? e.touches[0].pageX : e.pageX,
                    pageY = (touchEnabled) ? e.touches[0].pageY : e.pageY,
                    offsets = elem.getBoundingClientRect(),
                    w = elem.clientWidth || elem.offsetWidth || elem.scrollWidth,
                    h = elem.clientHeight || elem.offsetHeight || elem.scrollHeight,
                    wMultiple = 320 / w,
                    offsetX = 0.52 - (pageX - offsets.left - bdsl) / w,
                    offsetY = 0.52 - (pageY - offsets.top - bdst) / h,
                    dy = (pageY - offsets.top - bdst) - h / 2,
                    dx = (pageX - offsets.left - bdsl) - w / 2,
                    yRotate = (offsetX - dx) * (0.09 * wMultiple),
                    xRotate = (dy - offsetY) * (0.009 * wMultiple),
                    imgCSS = 'rotateX(' + xRotate + 'deg) rotateY(' + yRotate + 'deg)',
                    arad = Math.atan2(dy, dx),
                    angle = arad * 180 / Math.PI - 90;

                if (angle < 0) {
                    angle = angle + 360;
                }

                if (elem.firstChild.className.indexOf(' over') != -1) {
                    imgCSS += ' scale3d(1.07,1.07,1.07)';
                }
                elem.firstChild.style.transform = imgCSS;

                shine.style.transform = 'translateX(' + (offsetX * totalLayers) - 0.1 + 'px) translateY(' + (offsetY *
                    totalLayers) - 0.1 + 'px)';

                var revNum = totalLayers;
                for (var ly = 0; ly < totalLayers; ly++) {
                    layers[ly].style.transform = 'translateX(' + (offsetX * revNum) * ((ly * 2.5) / wMultiple) +
                        'px) translateY(' + (offsetY * totalLayers) * ((ly * 2.5) / wMultiple) + 'px)';
                    revNum--;
                }
            }

            function processEnter(e, elem) {
                elem.firstChild.className += ' over';
            }

            function processExit(e, elem, layers, totalLayers, shine) {

                var container = elem.firstChild;

                container.className = container.className.replace(' over', '');
                container.style.transform = '';
                shine.style.cssText = '';

                for (var ly = 0; ly < totalLayers; ly++) {
                    layers[ly].style.transform = '';
                }

            }
        }
        atvImg();
    </script>
    <script>
        document.getElementById('discover-more').addEventListener('click', function() {
            const nextSection = document.getElementById('stats-container');
            if (nextSection) {
                nextSection.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    </script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js'></script>
    <script src='https://unpkg.com/vue-the-mask@0.11.1/dist/vue-the-mask.js'></script>
@endpush
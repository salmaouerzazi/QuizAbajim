@push('styles_top')
    <link rel='stylesheet' href='/bookss/swiper-bundle.min.css'>
    <link rel="stylesheet" href="/bookss/style.css">
    <link rel='stylesheet' href='https://pro.fontawesome.com/releases/v5.7.0/css/all.css'>
@endpush
@section('content')
    <style>
        .no-pack-image-concours img {
            width: 103%;
            height: auto;
            margin-bottom: 10px;
        }

        .no-pack-card-concours {
            display: flex;
            justify-content: start;
            align-items: center;
            background: linear-gradient(135deg, #9719D2CC, #25BEC8CC);
            border-radius: 15px;
            width: 100%;
            max-width: 300px;
            margin: auto;
            position: relative;
            color: #ffffff;
            height: 130px;
        }

        .no-pack-card-concours::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            {{-- background: url(/concours/sub_concour.png) no-repeat; --}} background-size: 230px;
            opacity: 0.3;
            z-index: 0;
        }

        .pack-card-concours {
            display: flex;
            justify-content: start;
            align-items: center;
            background: linear-gradient(135deg, #1d3b65, #25bec8);
            border-radius: 15px;
            width: 100%;
            max-width: 300px;
            margin: auto;
            position: relative;
            color: #ffffff;
            height: 130px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 20%;
        }

        .order-summary {
            margin-left: 1.5rem;
            padding: 1rem;
            display: flex;
            flex-direction: column;
        }

        .order-summary>div {
            margin: 6px;
        }

        .order-status {
            color: #338A9A;
            font-size: 0.9rem;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .order-date {
            font-size: 1.5rem;
            font-weight: 700;
        }

        .order-day {
            color: #338A9A;
            font-size: 0.9rem;
            font-weight: 300;
            letter-spacing: 0.5px;
        }

        .back-btn {
            margin-right: 50px;
            font-size: 1rem;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            text-align: center;
            box-shadow: 5px 5px 25px 0px rgba(0, 0, 0, 0.2);
            display: flex;
            justify-content: center;
            align-items: center;
            transition: all 0.2s;
            cursor: pointer;
        }

        .back-btn:hover {
            transform: scale(1.2);
            box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
        }

        .hero-img-container {
            width: 100%;
            height: 300px;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            padding-bottom: 20px;
        }

        .hero-img-container::before {
            height: 20px;
            width: 20px;
            background-color: #0268EE;
            position: absolute;
            top: 25px;
            right: 150px;
            content: '';
            border-radius: 50%;
        }

        .arc {
            border: 1px solid #000;
            display: inline-block;
            min-width: 200px;
            min-height: 200px;
            padding: 0.5em;
            border-radius: 50%;
            border-top-color: transparent;
            border-left-color: transparent;
            border-bottom-color: transparent;
            opacity: 0.4;
            position: absolute;
            transform: rotate(-40deg);
            left: -10px;
        }

        .pattern {
            width: 50px;
            height: 50px;
            background-image: url("data:image/svg+xml;base64,PHN2ZyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnIHdpZHRoPScxMCcgaGVpZ2h0PScxMCc+CiAgPHJlY3Qgd2lkdGg9JzEwJyBoZWlnaHQ9JzEwJyBmaWxsPSd3aGl0ZScgLz4KICA8Y2lyY2xlIGN4PSc0JyBjeT0nNCcgcj0nNCcgZmlsbD0nYmxhY2snLz4KPC9zdmc+");
            opacity: 0.1;
            position: absolute;
            right: 30px;
            top: 30px;
            transform: scale(1.2);
        }

        .triangle1 {
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 0 10px 20px 10px;
            border-color: transparent transparent #767EEF transparent;
            position: absolute;
            top: 50px;
            left: 130px;
            transform: rotate(-45deg);
        }

        .hero-img {
            width: 80%;
        }

        .order-status-container {
            z-index: 3;
            display: flex;
            width: 100%;
            height: 30%;
            justify-content: space-evenly;
            align-items: center;
            {{-- background-color: white; --}} border-top-right-radius: 50px;
            border-top-left-radius: 50px;
            position: relative;
            {{-- box-shadow: 0 14px 28px rgba(0,0,0,0.02), 0 10px 10px rgba(0,0,0,0.2); --}}
        }

        .order-status-container::before {
            content: '';
            position: absolute;
            width: 26%;
            height: 5px;
            background-color: #aaadf5;
            opacity: 0.8;
            border-radius: 14px;
            top: 30%;
            left: 25%;
        }

        .status-item {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            height: 150px;
            padding-top: 20px;
        }

        .status-item>div {
            margin: 10px;
        }

        .status-circle {
            height: 35px;
            width: 35px;
            background-color: #665CF5;
            border-radius: 50%;
            border: 5px solid white;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.19), 0 6px 6px rgba(0, 0, 0, 0.23);
            z-index: 5;
            transition: all 0.2s;
            cursor: pointer;
        }

        .status-circle:hover {
            transform: scale(1.2);
            box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
        }

        .status-text {
            font-size: 0.8rem;
            font-weight: 500;
        }

        .status-text span {
            display: block;
            text-align: center;
            padding: 2px;
        }

        .green {
            color: #338A9A;
        }

        .first::before {
            content: '';
            height: 6px;
            width: 25%;
            background-color: #5858EF;
            position: absolute;
            z-index: 4;
            top: 44px;
            left: 54%;
        }

        .second::before {
            content: '';
            height: 4px;
            width: 210px;
            background-color: #5858EF;
            position: absolute;
            z-index: 4;
            top: 83px;
            left: 100px;
            opacity: 0.2;
        }

        .order-details-container {
            position: relative;
            z-index: 6;
            background-color: #767EEF;
            border-top-right-radius: 50px;
            border-top-left-radius: 50px;
            border-bottom-left-radius: 20px;

            border-bottom-right-radius: 20px;

            padding-top: 20px;
            transform: translateY(-20px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.19), 0 6px 6px rgba(0, 0, 0, 0.23);
            cursor: default;
        }

        .animation {
            margin-top: 4%;

            position: relative;
            z-index: 6;
            border-top-right-radius: 50px;
            border-top-left-radius: 50px;
            padding-top: 20px;
            transform: translateY(-45px);
            cursor: default;
        }

        .odc-header {
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        .cta-text {
            margin-top: 40px;
            margin-right: 25px;
            color: white;
            font-size: 0.9rem;
            text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.18);
        }

        .cta-button {
            margin-top: 20px;
            padding: 20px 40px;
            background-color: #4E4DED;
            border: 0;
            border-radius: 10px;
            color: white;
            font-size: 1rem;
            font-weight: 500;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.10), 0 6px 6px rgba(0, 0, 0, 0.05);
            animation: shadow-pulse 1s infinite;
            cursor: pointer;
        }

        @keyframes shadow-pulse {
            0% {
                box-shadow: 0 0 0 0px rgba(255, 255, 255, 0.2);
            }

            100% {
                box-shadow: 0 0 0 35px rgba(255, 255, 255, 0);
            }
        }

        .cta-button:focus {
            outline: none;
        }

        .order-details-container::before {
            content: '';
            position: absolute;
            width: 70px;
            height: 3px;
            background-color: #EAEBFF;
            opacity: 0.8;
            border-radius: 2px;
            top: 20px;
            left: 150px;
        }

        .odc-wrapper {
            margin: 30px;
        }

        .odc-header-line {
            margin-top: 30px;
            color: white;
            font-size: 1.5rem;
            font-weight: 500;
            margin-bottom: 40px
        }

        .odc-header-details {
            color: white;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .product-container {
            background-color: #828AF1;
            border-radius: 20px;
            padding: 10px;
        }

        .product {
            display: flex;
            justify-content: flex-start;
            align-items: center;
        }

        .product span {
            display: block;
            color: white;
            margin-left: 25px;
            margin-bottom: 8px;
            flex-grow: 1;
        }

        .product span:first-child {
            font-weight: 300;
            font-size: 0.8rem;
        }

        .product span:last-child {
            font-weight: 500;
            font-size: 1.3rem;
        }

        .img-photo {
            width: 90px;
            transform: rotate(-35deg)
        }

        .cancellation {
            margin-top: 20px;
            background-color: #828AF1;
            border-radius: 20px;
            padding: 30px 20px;
            color: white;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
        }

        .shipping-desc {
            color: white;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .shipping-address {
            margin-top: 20px;
            background-color: #828AF1;
            border-radius: 20px;
            padding: 20px 20px;
            color: white;
            font-weight: bold;
            margin-bottom: 20px;

        }

        .shipping-address1 {
            margin-top: 9px;
            padding: 5px 5px;

            color: white;
            font-weight: bold;


        }


        .footer {
            position: absolute;
            bottom: 15px;
            right: 15px;
            font-size: 0.9rem;
        }

        .footer small {
            font-size: 0.7rem;
        }

        .footer a {
            color: #3273dc;
            cursor: pointer;
            text-decoration: none;
            border-bottom: 2px solid rgba(50, 115, 220, .1);
            padding-bottom: 2px;
        }

        .footer a:hover {
            color: #1e57b4;
            border-bottom-color: #1e57b4;
        }
    </style>
    <div class="row mt-sm-50">
        <div class="col-12 col-lg-9 col-md-9">
            <div class="d-flex flex-column justify-content-between align-items-start mb-10 ml-30 mt-10">
                <h1 class="dashboard-title" style="color: #0759B4;">إصلاح جميع المناظرات</h1>
            </div>
            <div class="swiper-container manuel-card">
                <div class="swiper">
                    <div class="swiper-wrapper">
                        @if ($authUser->isEnfant())
                            @foreach ($concour as $c)
                                <div class="swiper-slide imgb"
                                    style="background-image: url('{{ asset($c->image_cover_path) }}');"
                                    onclick="handleBookClick(this, {{ $c->id }}, swiper)"
                                    @if ($loop->first) class="swiper-slide-active" @endif>
                                    <div class="author">
                                        <img class="logo" src="/assets/default/icons/video.svg" alt="Video Icon">
                                        <span>
                                            18 {{ trans('panel.video') }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            @for ($i = 0; $i < 3; $i++)
                                <div class="swiper-slide imgb" style="background-color: #e0e0e0;"></div>
                            @endfor
                        @endif
                    </div>
                    <div class="p-5">
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 d-none d-md-block">
            @if ($authUser->isEnfant())
                {{-- @if ($hasSubscribePack)
                    @if (isset($pack)) --}}
                {{-- <li class="sidenav-item pack-sidebar-item">
                            <div class="pack-card">
                                    <div class="pack-card-image">
                                        <img src="/{{ $pack->icon }}" alt="Pack Icon">
                                    </div>
                                    <div class="pack-card-content">
                                        <div class="pack-card-title">
                                            <h4>الإشتـــــــــراك</h4>   
                                        </div>
                                        <p class="pack-title">{{ $pack->title }}</p>
                                        <p class="pack-subtitle">{{ \Carbon\Carbon::now()->addDays($pack->days)->format('d/m/Y') }}</p>
                                    </div>
                            </div>
                        </li>
                    @endif
                    @else --}}
                <li class="sidenav-item no-pack-sidebar-item" style="margin-top: 20%;">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#subscriptionModal">
                        <div class="no-pack-card-concours">
                            <div class="no-pack-content" style="z-index: 22;">
                                <img src="/assets/default/img/subscribe-text.png" alt="Subscribe Now" style="width: 154%">
                            </div>
                            <div class="no-pack-image-concours">
                                <img src="/concours/sub_concour.png" alt="Subscribe Now">
                            </div>

                        </div>
                    </a>
                </li>
                {{-- @endif --}}
                {{-- <li class="sidenav-item-item mt-15">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#reservationModal">
                            @if (empty($cardreserve))
                                <div class="reserve-card" style="background: linear-gradient(135deg, #ffcc00, #ff6600);">
                                    <div class="reserve-card-image">
                                        <img src="/assets/default/img/credit-card.png" alt="Subscribe Now">
                                    </div>
                                    <div class="reserve-card-content" style="z-index: 22;">
                                        <img src="/assets/default/img/card-text.png " alt="Reserve Now" style="width: 100%">
                                    </div>
                                </div>
                                @elseif($cardreserve->status == \App\Models\CardReservation::STATUS_WAITING)
                                <div class="reserve-card-waiting">
                                    <div class="reserve-card-image">
                                        <img src="/assets/default/img/card-waiting.webp" alt="Subscribe Now">
                                    </div>
                                    <div class="reserve-card-content" style="z-index: 22;">
                                        <img src="/assets/default/img/card-waiting.png" alt="Reserve Now" style="width: 100%">
                                    </div>
                                </div>
                                @elseif($cardreserve->status == \App\Models\CardReservation::STATUS_APPROVED)
                                <div class="support-card">
                                    <div class="reserve-card-image">
                                        <img src="/assets/default/img/support-img.png" alt="Subscribe Now">
                                    </div>
                                    <div class="reserve-card-content" style="z-index: 22;">
                                        <img src="/assets/default/img/help-text.png " alt="Reserve Now" style="width: 170px">
                                    </div>
                                </div>
                                @endif
                            </a>
                </li> --}}
            @else
                @for ($i = 0; $i < 2; $i++)
                    <li class="sidenav-item gray-card m-">
                        <div class="gray-card-content"
                            style="background: #e0e0e0; padding: 20px; border-radius: 10px;margin: 10px">
                            <div class="gray-card-image" style="width: 100%; height: 150px;"></div>
                        </div>
                    </li>
                @endfor
            @endif
        </div>
    </div>

@endsection

@push('scripts_bottom')
    <script>
        var undefinedActiveSessionLang = '{{ trans('webinars.undefined_active_session') }}';
    </script>
    <script src='https://animejs.com/lib/anime.min.js'></script>
    <script src='/bookss/swiper-bundle.min.js'></script>
    <script src="/bookss/script.js"></script>
    <script src="/assets/default/js/panel/join_webinar.min.js"></script>
    <script>
        function handleBookClick(element, manuelId, swiperInstance) {
            if (element.classList.contains('swiper-slide-active')) {
                window.location.href = `/panel/enfant/concours/${manuelId}`;
                return;
            }
            const realIndex = parseInt(element.getAttribute('data-swiper-slide-index'), 10);
            swiperInstance.slideToLoop(realIndex, 500);
        }
        //anime.js library
        let drawer_open = false;

        document.querySelector(".cta-button").addEventListener("mouseup", function() {
            setDisplayBlock('forminput');
            cta_button_hide.play();
        })

        document.querySelector(".back-btn").addEventListener("mouseup", function() {
            if (drawer_open) {

                slidedown.play();
                setDisplayBlock('forminput');


                cta_button_show.play();
            }
        })

        function setDisplayBlock(className) {
            // Get all elements with the class name
            const elements = document.querySelectorAll(`.${className}`);

            // Loop through each element and set its display to 'block'
            elements.forEach(element => {
                element.style.display = 'block';
            });
        }
        let cta_button_show = anime({
            targets: ['.cta-button', '.cta-text'],
            translateY: ['-15', '0'],
            opacity: ['0', '1'],
            easing: 'easeInOutSine',
            delay: anime.stagger(200),
            autoplay: false,
            // loop: false
            duration: 500,
            complete: function() {}
        });

        let cta_button_hide = anime({
            targets: ['.cta-button', '.cta-text'],
            translateY: ['0', '-15'],
            opacity: ['1', '0'],
            easing: 'easeInOutSine',
            delay: anime.stagger(200),
            autoplay: false,
            // loop: false
            duration: 500,
            complete: function() {
                slideup.play();
                drawer_open = true;
            }
        });


        let slidedown = anime({
            targets: '.animation',
            translateY: ['-2000px', '-40px'],
            duartion: 1000,
            autoplay: false,
            begin: function() {
                show_hideCTA("block");
                drawer_open = false;
            }
        })

        let slideup = anime({
            targets: '.animation',
            translateY: ['-40px', '-2000px'],
            autoplay: false,
            begin: function() {
                show_hideCTA("none");
            }
        })



        function show_hideCTA(param) {
            document.querySelector(".cta-button").style.display = param;
            document.querySelector(".cta-text").style.display = param;
        }
    </script>
@endpush

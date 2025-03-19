@push('styles_top')
    <link rel='stylesheet' href='/bookss/swiper-bundle.min.css'>
    <link rel="stylesheet" href="/bookss/style.css">
    <link rel='stylesheet' href='https://pro.fontawesome.com/releases/v5.7.0/css/all.css'>
@endpush


@section('content')
    <style>
        .pack-card::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('/assets/default/img/bag.png') no-repeat;
            background-size: 130px;
            opacity: 0.3;
            z-index: 0;
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
            <div class="d-flex flex-column justify-content-between align-items-start mb-10 ml-30 mt-30">
                <h1 class="dashboard-title">{{ trans('panel.manuels') }}</h1>
            </div>
            <div class="swiper-container manuel-card">
                <div class="swiper">
                    <div class="swiper-wrapper">
                        @if ($authUser->isEnfant())
                            @foreach ($matiere1 as $material)
                                @foreach ($material->manuels as $manuel)
                                    <div class="swiper-slide imgb"
                                        style="background-image: url('{{ asset($manuel->logo) }}');"
                                        onclick="handleBookClick(this, {{ $manuel->id }}, swiper)"
                                        @if ($loop->first) class="swiper-slide-active" @endif>
                                        <div class="author">
                                            <img class="logo" src="/assets/default/icons/video.svg" alt="Video Icon">
                                            <span>
                                                {{ $manuel->videos->count() }} {{ trans('panel.video') }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
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
                @if ($hasSubscribePack)
                    @if (isset($pack))
                        <li class="sidenav-item pack-sidebar-item">
                            <div class="pack-card">
                                <div class="pack-card-image">
                                    <img src="/{{ $pack->icon }}" alt="Pack Icon">
                                </div>
                                <div class="pack-card-content">
                                    <div class="pack-card-title">
                                        <h4>الإشتـراك</h4>
                                    </div>
                                    <p class="pack-title">{{ $pack->title }}</p>
                                    <p class="pack-subtitle">
                                        {{ \Carbon\Carbon::now()->addDays($pack->days)->format('d/m/Y') }}</p>
                                </div>
                            </div>
                        </li>
                    @endif
                @else
                    <li class="sidenav-item no-pack-sidebar-item" style="margin-top: 20%;">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#subscriptionModal">
                            <div class="no-pack-card">
                                <div class="no-pack-image">
                                    <img src="/assets/default/img/gift.png" alt="Subscribe Now">
                                </div>
                                <div class="no-pack-content" style="z-index: 22;">
                                    <img src="/assets/default/img/subscribe-text.png " alt="Subscribe Now"
                                        style="width: 87%">
                                </div>
                            </div>
                        </a>
                    </li>
                @endif
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

    @if ($authUser->isEnfant())
        <div class="modal fade" id="reservationModal" tabindex="-1" aria-labelledby="reservationModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content upgrade-modal-container">
                    <div class="modal-header">
                        @if (empty($cardreserve))
                            <h3 class="modal-title text-color-primary-5"> {{ trans('panel.reserve_card') }} </h3>
                        @else
                            <h3 class="modal-title text-color-primary-5"> تاريخ الوصول طلب</h3>
                        @endif
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <spann>&times;</spann>
                        </button>
                    </div>
                    <div class="modal-body">
                        @if (empty($cardreserve))
                            <p>تمكنك بطاقة الشحن من تفعيل اشتراك سنوي في شبكة أباجيم من أجل التمتع بالكتب المدرسية التفاعلية
                                مع خاصية مقاطع الفيديو التفسيرية و الدروس الاضافية, بعد إتمام تعبئة بياناتك، ستصلك البطاقة
                                على عنوانك في غضون 48 ساعة. تحتوي البطاقة على رمز سري يمنحك إمكانية تفعيل الاشتراك بكل
                                سهولة.
                            </p>
                            <div class="container d-flex justify-content-center mt-20">
                                <div class="cover atvImg">
                                    <div class="atvImg-layer" data-img="/abajimcard1.png">
                                        <img width="100%" ; src="/abajimcard1.png">
                                    </div>
                                </div>
                            </div>
                            <form action="{{ route('card_reservations.store') }}" method="POST">
                                @csrf
                                <div class="row mt-20">
                                    <div class="form-group mb-3 col-md-6">
                                        <label for="name"
                                            class="text-color-primary">{{ trans('panel.parent_name') }}</label>
                                        <input type="text" name="name" id="name" class="form-control"
                                            value="{{ $parentid->organization->full_name }}">
                                    </div>
                                    <div class="form-group mb-3 col-md-6">
                                        <label for="phone_number"
                                            class="text-color-primary">{{ trans('panel.phone_number') }}</label>
                                        <input type="text" name="phone_number" id="phone_number" class="form-control"
                                            value="{{ $parentid->organization->mobile }}">
                                    </div>
                                    <div class="form-group mb-3 col-md-6">
                                        <label for="child_level"
                                            class="text-color-primary">{{ trans('panel.child_level') }}</label>
                                        <input type="text" class="form-control"
                                            value="{{ $users->childLevel->name }}" disabled>
                                    </div>
                                    <div class="form-group mb-3 col-md-6">
                                        <label for="city">اختر المدينة:</label>
                                        <select name="city" id="city" class="form-control" required>
                                            <option value="" disabled selected>اختر المدينة</option>
                                            <option value="تونس">تونس</option>
                                            <option value="صفاقس">صفاقس</option>
                                            <option value="سوسة">سوسة</option>
                                            <option value="التضامن">التضامن</option>
                                            <option value="القيروان">القيروان</option>
                                            <option value="قابس">قابس</option>
                                            <option value="بنزرت">بنزرت</option>
                                            <option value="أريانة">أريانة</option>
                                            <option value="قفصة">قفصة</option>
                                            <option value="المنستير">المنستير</option>
                                            <option value="مدنين">مدنين</option>
                                            <option value="نابل">نابل</option>
                                            <option value="القصرين">القصرين</option>
                                            <option value="بن عروس">بن عروس</option>
                                            <option value="المهدية">المهدية</option>
                                            <option value="سيدي بوزيد">سيدي بوزيد</option>
                                            <option value="جندوبة">جندوبة</option>
                                            <option value="قبلي">قبلي</option>
                                            <option value="توزر">توزر</option>
                                            <option value="سليانة">سليانة</option>
                                            <option value="باجة">باجة</option>
                                            <option value="زغوان">زغوان</option>
                                            <option value="منوبة">منوبة</option>
                                        </select>

                                    </div>
                                    <div class="form-group mb-3 col-md-12">
                                        <label for="address"
                                            class="text-color-primary">{{ trans('panel.address') }}</label>
                                        <input type="text" class="form-control" id="address" name="address"
                                            placeholder="{{ trans('panel.enter_address') }}">
                                    </div>
                                    <input type="hidden" name="user_id" id="user_id" class="form-control"
                                        value="{{ $parentid->organ_id }}">
                                    <input type="hidden" name="level_id" id="level_id" class="form-control"
                                        value="{{ $users->level_id }}">
                                    <input type="hidden" name="enfant_id" id="enfant_id" class="form-control"
                                        value="{{ $users->id }}">

                                    <div class="form-group">
                                        <button type="submit"
                                            class="btn btn-primary align-self-end">{{ trans('public.submit') }}</button>
                                    </div>
                                </div>
                            </form>
                        @elseif($cardreserve->status == \App\Models\CardReservation::STATUS_WAITING)
                            <div class="iphone">
                                <div class="header">
                                    <div class="order-summary">
                                        <div class="order-status">تاريخ الوصول</div>
                                        @php

                                            // Parse the created_at timestamp
                                            $createdDate = \Carbon\Carbon::parse($cardreserve->created_at);

                                            // Get the current date
                                            $currentDate = \Carbon\Carbon::now();

                                            // Combine today's date with the time of created_at
$combinedDate = $createdDate
    ->copy()
    ->setDate($currentDate->year, $currentDate->month, $currentDate->day);
$incrementedDate = $combinedDate->addDays(2);
$tunisianMonths = [
    'January' => 'جانفي',
    'February' => 'فيفري',
    'March' => 'مارس',
    'April' => 'أفريل',
    'May' => 'ماي',
    'June' => 'جوان',
    'July' => 'جويلية',
    'August' => 'أوت',
    'September' => 'سبتمبر',
    'October' => 'أكتوبر',
    'November' => 'نوفمبر',
    'December' => 'ديسمبر',
];
$arabicDays = [
    'Sunday' => 'الأحد',
    'Monday' => 'الإثنين',
    'Tuesday' => 'الثلاثاء',
    'Wednesday' => 'الأربعاء',
    'Thursday' => 'الخميس',
    'Friday' => 'جمعة',
    'Saturday' => 'السبت',
];
// Get the month name in English and map it to the Tunisian Arabic name
$monthName = $tunisianMonths[$incrementedDate->format('F')];
$dayName = $arabicDays[$incrementedDate->format('l')]; // 'l' gives the full day name

// Format the full date as "DD Month YYYY"
$formattedDate =
    $incrementedDate->format('d') .
    ' ' .
    $monthName .
    ' ' .
    $incrementedDate->format('Y');

                                        @endphp
                                        <div class="order-date">
                                            {{ $formattedDate }}


                                        </div>
                                        <div class="order-day">
                                            {{ $dayName }}
                                        </div>
                                    </div>
                                    <div class="action-btn">
                                        <div class="back-btn"><i class="far fa-long-arrow-left"></i></div>
                                    </div>
                                </div>

                                <div class="order-status-container">
                                    <div class="status-item first">
                                        <div class="status-circle"></div>
                                        <div class="status-text">
                                            اليوم
                                        </div>
                                    </div>

                                    <div class="status-item">
                                        <div class="status-circle"></div>
                                        <div class="status-text green">
                                            <span>خارج للتسليم </span>
                                        </div>
                                    </div>
                                    <div class="status-item">
                                        <div class="status-circle"></div>
                                        <div class="status-text green">
                                            <span>الوصول جمعة</span>

                                        </div>
                                    </div>
                                </div>
                                <div class="animation">
                                    <div class="order-details-container">
                                        <div class="odc-header mt-5">

                                            <div class="cta-button-container">
                                                <button class="cta-button">تعديل العنوان </button>
                                            </div>
                                        </div>
                                        <div class="odc-wrapper">
                                            <div class="odc-header-line">
                                                تفاصيل طلبك
                                            </div>

                                            <div class="product-container">
                                                <div class="product">
                                                    <div class="product-photo">
                                                        <img src="/abajimcard1.png" class="img-photo">
                                                    </div>
                                                    <div class="product-desc" style="margin-right: 7%;">
                                                        <span>120 د.ت </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="shipping-desc" style="margin-top: 3%;">عنوان الشحن الخاص بك</div>

                                            <div class="shipping-address">
                                                {{ $cardreserve->name }}<br>
                                                {{ $cardreserve->phone_number }}<br>
                                                {{ $cardreserve->address }}<br>

                                            </div>
                                            <div class="shipping-address1">

                                            </div>

                                        </div>
                                    </div>
                                    <div class="forminput" style="display:none">
                                        <form action="/panel/card_reservations/update/{{ $cardreserve->id }}"
                                            method="POST">
                                            @csrf
                                            <div class="row mt-20">


                                                <div class="form-group mb-3 col-md-6">
                                                    <label for="name"
                                                        class="text-color-primary">{{ trans('panel.parent_name') }}</label>
                                                    <input type="text" name="name" id="name"
                                                        class="form-control" value="{{ $cardreserve->name }}">
                                                </div>
                                                <div class="form-group mb-3 col-md-6">
                                                    <label for="phone_number"
                                                        class="text-color-primary">{{ trans('panel.phone_number') }}</label>
                                                    <input type="text" name="phone_number" id="phone_number"
                                                        class="form-control" value="{{ $cardreserve->phone_number }}">
                                                </div>
                                                <div class="form-group mb-3 col-md-6">
                                                    <label for="child_level"
                                                        class="text-color-primary">{{ trans('panel.child_level') }}</label>
                                                    <select name="level_id" class="form-control">
                                                        <option value="{{ $cardreserve->level->name }}">
                                                            {{ $cardreserve->level->name }}</option>
                                                        @foreach ($levels as $lv)
                                                            <option value="{{ $lv->id }}">{{ $lv->name }}
                                                            </option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                                <div class="form-group mb-3 col-md-6">
                                                    <label for="city">اختر المدينة:</label>
                                                    <select name="city" id="city" class="form-control" required>
                                                        <option value="" disabled selected>اختر المدينة</option>
                                                        <option value="تونس">تونس</option>
                                                        <option value="صفاقس">صفاقس</option>
                                                        <option value="سوسة">سوسة</option>
                                                        <option value="التضامن">التضامن</option>
                                                        <option value="القيروان">القيروان</option>
                                                        <option value="قابس">قابس</option>
                                                        <option value="بنزرت">بنزرت</option>
                                                        <option value="أريانة">أريانة</option>
                                                        <option value="قفصة">قفصة</option>
                                                        <option value="المنستير">المنستير</option>
                                                        <option value="مدنين">مدنين</option>
                                                        <option value="نابل">نابل</option>
                                                        <option value="القصرين">القصرين</option>
                                                        <option value="بن عروس">بن عروس</option>
                                                        <option value="المهدية">المهدية</option>
                                                        <option value="سيدي بوزيد">سيدي بوزيد</option>
                                                        <option value="جندوبة">جندوبة</option>
                                                        <option value="قبلي">قبلي</option>
                                                        <option value="توزر">توزر</option>
                                                        <option value="سليانة">سليانة</option>
                                                        <option value="باجة">باجة</option>
                                                        <option value="زغوان">زغوان</option>
                                                        <option value="منوبة">منوبة</option>
                                                    </select>
                                                </div>
                                                <div class="form-group mb-3 col-md-12">
                                                    <label for="address"
                                                        class="text-color-primary">{{ trans('panel.address') }}</label>
                                                    <input type="text" class="form-control" id="address"
                                                        value="{{ $cardreserve->address }}" name="address"
                                                        placeholder="{{ trans('panel.enter_address') }}">
                                                </div>
                                                <input type="hidden" name="user_id" id="user_id" class="form-control"
                                                    value="{{ $parentid->organ_id }}">
                                                <input type="hidden" name="level_id" id="level_id"
                                                    class="form-control" value="{{ $users->level_id }}">
                                                <input type="hidden" name="enfant_id" id="enfant_id"
                                                    class="form-control" value="{{ $users->id }}">
                                                {{ $users->id }}
                                                <div class="form-group ml-40">
                                                    <button type="submit" class="btn btn-primary ">تعديل العنوان
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @elseif($cardreserve->status == \App\Models\CardReservation::STATUS_APPROVED)
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="panel-section-card  px-25">
            <div class="d-flex align-items-center mb-10">
                <h1 class="dashboard-title">
                    {{ trans('panel.webinars') }}
                </h1>
                <h4 class="text-color-primary-5 ml-10">({{ trans('panel.soon') }})</h4>
            </div>
            <div id="webinars-content">
                <div class="row">
                    @if (!empty($matiere))
                        @foreach ($matiere as $matiere)
                            <div class="col-md-4">
                                <div class="webinar-card webinar-list">
                                    <div class="image-box">
                                        <img src="{{ $matiere->material_image }}" alt="{{ $matiere->name }}"
                                            height="100%" width="100%">
                                    </div>
                                    <style>
                                        .avatar-item img {
                                            transition: transform 0.2s ease, box-shadow 0.2s ease;
                                        }

                                        .hover-lift:hover {
                                            transform: translateY(-2px);
                                            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                                        }
                                    </style>

                                    <div class="webinar-card-body w-100 d-flex flex-column">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <h2 class="font-16 text-dark-blue font-weight-bold">
                                                <a href="/"></a>
                                                {{ $matiere->name }} {{ $matiere->section->level->name }}
                                            </h2>
                                            @php
                                                $teachers = \DB::table('user_matiere')
                                                    ->where('matiere_id', $matiere->id)
                                                    ->pluck('teacher_id');
                                            @endphp
                                            @php
                                                $teacherNames = \App\User::where('status', 'active')
                                                    ->whereIn(
                                                        'id',
                                                        \DB::table('user_matiere')
                                                            ->where('matiere_id', $matiere->id)

                                                            ->pluck('teacher_id'),
                                                    )
                                                    ->where(function ($query) {
                                                        $query
                                                            ->whereHas('videos')
                                                            ->orWhereHas('webinars', function ($query) {
                                                                $query->where('status', 'active');
                                                            });
                                                    })
                                                    ->paginate(5);
                                                $teachers = \App\User::where('status', 'active')
                                                    ->whereIn(
                                                        'id',
                                                        \DB::table('user_matiere')
                                                            ->where('matiere_id', $matiere->id)
                                                            ->pluck('teacher_id'),
                                                    )
                                                    ->where(function ($query) {
                                                        $query
                                                            ->whereHas('videos')
                                                            ->orWhereHas('webinars', function ($query) {
                                                                $query->where('status', 'active');
                                                            });
                                                    })
                                                    ->get();

                                                $teachercount = $teachers->slice(5)->count();
                                            @endphp
                                        </div>

                                        <div class="d-flex align-items-center flex-wrap gap-2 py-2">
                                            @php
                                                $visibleTeachers = 5;
                                                $remainingTeachers = $teacherNames->count() - $visibleTeachers;
                                            @endphp
                                            @foreach ($teacherNames->take($visibleTeachers) as $teacher)
                                                <div class="avatar-item position-relative">
                                                    <a href="/users/{{ $teacher->id }}/profile"
                                                        class="text-decoration-none">
                                                        <img src="{{ $teacher->getAvatar() }}"
                                                            class="rounded-circle border-2 border-white hover-lift shadow-sm"
                                                            width="45" height="45"
                                                            alt="{{ $teacher->full_name }}" data-bs-toggle="tooltip"
                                                            data-bs-placement="bottom" title="{{ $teacher->full_name }}">
                                                    </a>
                                                </div>
                                            @endforeach

                                            @if ($remainingTeachers > 0)
                                                <div class="avatar-item">
                                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                                        style="width: 45px; height: 45px;" data-bs-toggle="tooltip"
                                                        data-bs-placement="bottom"
                                                        title="{{ $teacherNames->pluck('full_name')->join(', ', ' and ') }}">
                                                        +{{ $remainingTeachers }}
                                                    </div>
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
            </div>
        </div>
    @else
        <div class="panel-section-card py-20 px-25">
            <div class="d-flex justify-content-between align-items-center mb-10">
            </div>

            <div id="webinars-content">
                <div class="row">
                    <div class="swiper-container">
                        <div class="swiper-wrapper col-md-4">
                            @for ($i = 0; $i < 4; $i++)
                                <div class="swiper-slide ml-5">
                                    <div class="webinar-card webinar-list" style="opacity: 0.5;">
                                        <div class="image-box">

                                        </div>
                                        <div class="webinar-card-body w-100 d-flex flex-column">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <h2 class="font-16 text-dark-blue font-weight-bold"
                                                    style="background:#888">

                                                </h2>
                                            </div>

                                            <div
                                                class="d-flex align-items-center justify-content-between flex-wrap mt-auto">
                                                <figcaption class="mt-10">
                                                    <div class="user-inline-avatar d-flex align-items-center">

                                                    </div>
                                                </figcaption>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                        <div class="swiper-pagination swiper-pagination-webinars"></div>
                    </div>
                </div>
            </div>
        </div>
    @endif

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
                window.location.href = `/panel/scolaire/${manuelId}`;
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

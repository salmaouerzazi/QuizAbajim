@php
            $backgroundColors = ['#ffffff', '#ffffff', '#ffffff'];
            $borderColors = ['rgba(93, 219, 219, 1)', '#FFFF00', '#FF00FF'];
            $prices = [
            trans('home.first_second_level') => 24,
            trans('home.third_fourth_level') => 28,
            trans('home.fifth_sixth_level') => 32,
            ];

            $unitaryPrice = 24;

            $popularIndex = null;
            $counter = 0;
            $subscribesArray = $subscribes->all();

            foreach ($subscribesArray as $index => $subscribe) {
                if ($subscribe->is_popular) {
                    $popularIndex = $index;
                    break;
                }
            }

            if ($popularIndex !== null) {
                $popularPlan = $subscribesArray[$popularIndex];
                unset($subscribesArray[$popularIndex]);
                $middleIndex = intdiv(count($subscribesArray) + 1, 2);
                array_splice($subscribesArray, $middleIndex, 0, [$popularPlan]);
                $subscribes = collect($subscribesArray);
            }

        @endphp

<div class="position-relative subscribes-container pe-none user-select-none">
                <section class="container home-sections home-sections-swiper">
                    <div class="text-center">
                        <h2 class="text-secondary" style="font-size:30px">{{ trans('home.subscribe_now') }}</h2>
                        <p class="section-hint" style="font-size: 20px">{{ trans('home.subscribe_now_hint') }}</p>
                    </div>

                    <ul class="nav nav-tabs mt-3 d-flex justify-content-between align-items-center" id="packTabs">
                        <div class="d-flex">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab"
                                    href="#tab1">{{ trans('home.first_second_level') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab"
                                    href="#tab2">{{ trans('home.third_fourth_level') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab"
                                    href="#tab3">{{ trans('home.fifth_sixth_level') }}</a>
                            </li>
                        </div>
                        <div class="d-flex ms-auto mr-40">
                            <li class="nav-item ml-10">
                                <button id="yearlyBtn"
                                    class="py-5 px-10 d-lg-flex btn btn-sm btn-primary nav-start-a-live-btn active"style="width:100px"
                                    aria-label="Yearly">
                                    {{ trans('home.yearly') }}
                                </button>
                            </li>
                            <li class="nav-item ml-10">
                                <button id="monthlyBtn"
                                    class="py-5 px-10 d-lg-flex btn btn-sm btn-primary text-white nav-start-a-live-btn ml-5 "
                                    style="width:100px" aria-label="Monthly">
                                    {{ trans('home.monthly') }}
                                </button>
                            </li>
                            
                        </div>

                    </ul>

                    <div class="tab-content mt-4">
                        @foreach ([trans('home.first_second_level'), trans('home.third_fourth_level'), trans('home.fifth_sixth_level')] as $index => $groupName)
                            <div id="tab{{ $index + 1 }}" class="tab-pane {{ $index == 0 ? 'active' : '' }}">
                                <div class="subscribes-swiper px-12">
                                    <div class="row swiper-wrapper py-20" style="display: flex;">
                                        @foreach ($subscribes as $subscribe)
                                            <div class="col-md-4 d-flex">
                                                <div class="subscribe-plan flex-grow-1 d-flex flex-column rounded-sm pt-50 pb-20 px-20"
                                                    style="background-color: {{ $backgroundColors[$counter % count($backgroundColors)] }};
                                                            border: 4px solid {{ $borderColors[$counter % count($borderColors)] }}; display: flex; flex-direction: column;">

                                                    @if ($subscribe->is_popular)
                                                        <button class="badge badge-popular px-15 py-5"
                                                            aria-label="Popular">
                                                            <span style="color:white">{{ trans('panel.popular') }}</span>
                                                        </button>
                                                    @endif

                                                    <!-- Title -->
                                                    <h3 class="text-secondary text-center font-weight-bold font-20"
                                                        style="margin-bottom: 20px; align-self: center;">
                                                        {{ $subscribe->title }}
                                                    </h3>

                                                    <!-- Icon -->
                                                    <img src="/{{ $subscribe->icon }}" alt="{{ $subscribe->title }}"
                                                        style="margin: 0 auto; display: block; align-self: center;  height: 150px;" />


                                                    <!-- Description List -->
                                                    <ul class="flex-grow-1" style="margin-top: 30px;">
                                                        @foreach (explode("\n", $subscribe->description) as $line)
                                                            <li>
                                                                <i class="fas fa-check success" width="20" height="20"></i>
                                                                <span class="description-span">
                                                                    {!! preg_replace(
                                                                        '/🟢/',
                                                                        '<span class="recording-indicator"></span>',
                                                                        $line
                                                                    ) !!}
                                                                </span>
                                                            </li>
                                                        @endforeach
                                                    </ul>

                                                    <!-- Price  -->
                                                    @if ($subscribe->title == 'الكرطابلة')
                                                        <span class="font-16 text-center pack-price font-weight-bold"
                                                            data-base-price="{{ $prices[$groupName] }}"
                                                            style="background-color:azure;padding:10px;border-radius:8px;margin-bottom:10px;
                                                        border: 2px solid {{ $subscribe->title == 'كتيِّب' ? 'rgba(93, 219, 219, 1)' : '#FFFF00' }}">
                                                            <del>{{ addCurrencyToPrice($prices[$groupName]) }}</del>
                                                            {{-- <span style="color: green;">{{ trans('home.free') }}</span> --}}
                                                        </span>
                                                    @elseif ($subscribe->title == 'كتيِّب')
                                                        <span class="font-16 text-center pack-price font-weight-bold"
                                                            data-base-price="{{ $unitaryPrice }}"
                                                            style="background-color:azure;padding:10px;border-radius:8px;margin-bottom:10px;
                                                                border: 2px solid {{ $subscribe->title == 'كتيِّب' ? 'rgba(93, 219, 219, 1)' : '#FFFF00' }}">
                                                            <del>{{ addCurrencyToPrice($unitaryPrice) }}</del>
                                                            {{-- <span style="color: green;">{{ trans('home.free') }}</span> --}}
                                                        </span>
                                                    @else
                                                        <div style="height: 48px; margin-top: 20px;"></div>
                                                    @endif




                                                    <!-- Subscribe Button -->
                                                    @if (auth()->check())
                                                        <form action="/panel/financial/pay-subscribes" method="post"
                                                            class="w-100 mt-auto">
                                                            {{ csrf_field() }}
                                                            <input name="amount" value="{{ $prices[$groupName] }}"
                                                                type="hidden">
                                                            <input name="id" value="{{ $subscribe->id }}"
                                                                type="hidden">
                                                            <button type="submit" class="btn btn-primary btn-block"
                                                                aria-label="Subscribe">
                                                                {{ trans('home.subscribe_now') }}
                                                            </button>
                                                        </form>
                                                    @else
                                                        <button class="btn btn-primary mt-auto" aria-label="Subscribe">
                                                            <a style="color:white"
                                                                href="{{ route('auth.login') }}">{{ trans('home.subscribe_now') }}</a>
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>

                                            @php
                                                $counter++;
                                            @endphp
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>


                </section>
            </div>
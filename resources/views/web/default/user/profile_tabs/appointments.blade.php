@if (!empty($meetings) && !$meetings->isEmpty())

    @push('styles_top')
        <link rel="stylesheet" href="/assets/vendors/wrunner-html-range-slider-with-2-handles/css/wrunner-default-theme.css">
        <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    @endpush
    @if (!empty($levelMaterials))


        {{-- <div class="mt-10 d-flex  flex-wrap">
                 @foreach ($levelMaterials as $levelName => $materials)
                    <form id="MeetingForm"  method="get" action="" class="mb-0">

                        <div class="checkbox-button bordered-200 mt-5 mr-15">
                               <?php
                               $levelid = DB::table('school_levels')->where('name', $levelName)->pluck('id');
                               
                               ?>
                            <input type="checkbox" name="level_meeting_id" id="levelCheckbox1{{ $levelid[0] }}"
                                    value="{{ $levelid[0] }}" class="level-filter"  onchange="this.form.submit()">
                                <label for="levelCheckbox1{{ $levelid[0] }}" style="background-color: #22bec8;color: #ffffff!important;">{{ $levelName }} :</label>
                          
                                    @foreach ($materials as $material)
                                        <input type="checkbox" name="material_meeting_id" id="levelCheckbox1{{ $material->id }}"
                                            value="{{ $material->id }}" class="material"  onchange="this.form.submit()">
                                        <label for="levelCheckbox1{{ $material->id }}">{{ $material->name }}</label>
                                    @endforeach 
                                
                        </div>
                    </form>  
                        @endforeach
                </div> --}}
        <div class="row">
            <div class="col-8"></div>
            <div class="col-2 mt-10">
                <form method="get" class="mb-0">

                    <select name="by_level" class="form-control" onchange="this.form.submit()"
                        style="width: 100%;font-size:1.1rem!important;">
                        <option class="font-10" style="font-size:1.1rem!important;" disabled selected>
                            {{ trans('public.sort_by_level') }}</option>
                        <option class="font-10" style="font-size:1.1rem!important;" value="">
                            {{ trans('public.all') }}</option>
                        @foreach ($levelMaterials as $levelName => $materials)
                            <?php $levelid = DB::table('school_levels')->where('name', $levelName)->pluck('id'); ?>
                            <option style="font-size:1.1rem!important;" class="font-10" value="{{ $levelid[0] }}"
                                @if (request()->get('by_level') == $levelid[0]) selected="selected" @endif>{{ $levelName }}
                            </option>
                        @endforeach
                        {{-- @foreach ($levels as $levelid => $levelname)
                                        <option style="font-size:1.1rem!important;" class="font-10" value="{{ $levelid }}"
                                            @if (request()->get('by_level') == $levelid) selected="selected" @endif>{{ $levelname }}
                                        </option>
                                    @endforeach --}}
                    </select>
                    @if (request()->has('by_matiere'))
                        <input type="hidden" name="by_matiere" value="{{ request()->get('by_matiere') }}">
                    @endif

                </form>
            </div>
            <div class="col-2 mt-10">
                <form method="get" class="mb-0">

                    <select name="by_matiere" class="form-control" onchange="this.form.submit()"
                        style="width: 100%;font-size:1.1rem!important;">
                        <option disabled selected>{{ trans('public.sort_by_matiere') }}</option>
                        <option style="font-size:1.1rem!important;" value="">{{ trans('public.all') }}
                        </option>
                        {{-- @if (!empty($materials))
                            @foreach ($materials as $material)
                                <option style="font-size:1.1rem!important;" value="{{ $material->id }}"
                                    @if (request()->get('by_matiere') == $material->id) selected="selected" @endif>{{ $material->name }}
                                </option>
                            @endforeach
                        @endif --}}
                        {{-- @foreach ($matiereNames as $matiere)
                                            <option style="font-size:1.1rem!important;" value="{{ $matiere }}"
                                                @if (request()->get('by_matiere') == $matiere) selected="selected" @endif>{{ $matiere }}
                                            </option>
                                        @endforeach --}}
                    </select>
                    @if (request()->has('by_level'))
                        <input type="hidden" name="by_level" value="{{ request()->get('by_level') }}">
                    @endif

                </form>
            </div>
        </div>
    @endif
    <section class="live-session">
        <div class="row">
            <div class="col-md-12">
                <div class="position-relative ltr">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            @foreach ($meetings as $index => $ReserveMeeting)
                                <div class="swiper-slide" style="margin:2%;">
                                    <div class="shadow-effect">
                                        <div class="webinar-card">
                                            <figure>
                                                <div class="image-box">
                                                    @if ($ReserveMeeting->material->name == 'رياضيات')
                                                        <a href="">
                                                            <img src="/dd.jpg" class="img-cover" alt="">
                                                        </a>
                                                    @elseif($ReserveMeeting->material->name == 'الإيقاظ العلمي')
                                                        <a href="">
                                                            <img src="/dd1.jpg" class="img-cover" alt="">
                                                        </a>
                                                    @elseif($ReserveMeeting->material->name == 'الإنجليزية')
                                                        <a href="">
                                                            <img src="/eng.jpg" class="img-cover" alt="">
                                                        </a>
                                                    @elseif($ReserveMeeting->material->name == 'الجغرافيا')
                                                        <a href="">
                                                            <img src="/678.jpg" class="img-cover" alt="">
                                                        </a>
                                                    @elseif($ReserveMeeting->material->name == 'الفرنسية')
                                                        <a href="">
                                                            <img src="/images.jpeg" class="img-cover" alt="">
                                                        </a>
                                                    @elseif($ReserveMeeting->material->name == ' التربية التكنولجية')
                                                        <a href="">
                                                            <img src="/6789.jpg" class="img-cover" alt="">
                                                        </a>
                                                    @elseif ($ReserveMeeting->material->name == 'العربية')
                                                        <a href="">
                                                            <img src="/arabic.png" class="img-cover" alt="">
                                                        </a>
                                                    @endif

                                                </div>

                                                <figcaption class="webinar-card-body">
                                                    <div class="webinar-price-box">
                                                        <h3>
                                                            {{ $ReserveMeeting->level->name }}
                                                        </h3>

                                                    </div>
                                                    <div class="webinar-price-box">
                                                        <h3>
                                                            المادة :
                                                            {{ $ReserveMeeting->material->name }}
                                                        </h3>

                                                    </div>
                                                    <a href="/login"
                                                        class="btn btn-primary btn-sm rounded-pill mt-5">{{ trans('public.reserve_a_meeting') }}</a>
                                                    <div class="d-flex justify-content-between mt-20">
                                                        <div class="d-flex align-items-center">
                                                            <img src="/clock.png" style="width:15px;height:15px"
                                                                class="webinar-icon" />

                                                            <span
                                                                class="duration font-12 ml-5">{{ $ReserveMeeting->time }}
                                                            </span>
                                                        </div>

                                                        <div class="vertical-line mx-15"></div>

                                                        <div class="d-flex align-items-center">
                                                            <img src="/calendar.png" style="width:15px;height:15px"
                                                                class="webinar-icon" />
                                                            <span class="date-published font-12 ml-10">
                                                                {{ $ReserveMeeting->meet_date }}</span>
                                                        </div>
                                                    </div>

                                                </figcaption>
                                            </figure>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- If we need pagination -->
                        <div class="swiper-pagination"></div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts_bottom')
        <script src="/assets/vendors/wrunner-html-range-slider-with-2-handles/js/wrunner-jquery.js"></script>
        <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var swiper = new Swiper('.swiper-container', {
                    slidesPerView: 1,
                    spaceBetween: 10,
                    loop: true,
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    breakpoints: {
                        640: {
                            slidesPerView: 2,
                            spaceBetween: 20,
                        },
                        768: {
                            slidesPerView: 3,
                            spaceBetween: 30,
                        },
                        1024: {
                            slidesPerView: 4,
                            spaceBetween: 40,
                        },
                    }
                });
            });
        </script>
    @endpush
@else
    @include(getTemplate() . '.includes.no-result', [
        'file_name' => 'meet.png',
        'title' => trans('site.instructor_not_available'),
        'hint' => '',
    ])
@endif

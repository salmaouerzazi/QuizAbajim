@php
    $socials = getSocials();
    if (!empty($socials) and count($socials)) {
        $socials = collect($socials)->sortBy('order')->toArray();
    }

    $footerColumns = getFooterColumns();
@endphp

<footer id="newsletterFooter" class="footer bg-secondary position-relative user-select-none">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class=" footer-subscribe d-block d-md-flex align-items-center justify-content-between">
                    <div class="flex-grow-1">
                        <strong>{{ trans('footer.join_us_today') }}</strong>
                        <span class="d-block mt-5 text-white">{{ trans('footer.subscribe_content') }}</span>
                    </div>
                    <div class="subscribe-input bg-white p-10 flex-grow-1 mt-30 mt-md-0">
                        <form action="/newsletters" method="post">
                            {{ csrf_field() }}
                            <div class="form-group d-flex align-items-center m-0">
                                <div class="w-100">
                                    <input type="text" name="newsletter_contact"
                                        class="form-control border-0 @error('newsletter_contact') is-invalid @enderror"
                                        placeholder="{{ trans('footer.enter_email_or_phone') }}" />
                                    @error('newsletter_contact')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button style="background-color: #22bec8!important;" type="submit"
                                    class="btn btn-primary rounded-pill">{{ trans('footer.join') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        $columns = ['first_column', 'second_column', 'third_column', 'forth_column'];
    @endphp

    <div class="container">
        <div class="row">
            <div class="col-6 col-md-3">


                <span class="header d-block text-white font-weight-bold"> {{ trans('footer.infos_about_us') }} </span>

                <div class="mt-20">
                    <p>
                        <font color="#ffffff"> {{ trans('footer.informations_about_us') }} </font>
                    </p>
                </div>

            </div>
            <div class="col-6 col-md-3">

                <span class="header d-block text-white font-weight-bold"> {{ trans('footer.additional_links') }} </span>

                <div class="mt-20">
                    <p><a href="/"><span style="color: #ffffff;">- {{ trans('footer.home') }}</span></a></p>

                    <p><a href="/instructors"><span style="color: #ffffff;">- {{ trans('footer.our_teachers') }}
                            </span></a>
                    </p>
                    <p><a href="/manuels"><span style="color: #ffffff;">- {{ trans('footer.scolar_manuels') }}
                            </span></a></p>

                    <p><span style="color: #ffffff;"><a href="/contact"><span style="color: #ffffff;">-
                                    {{ trans('footer.who_we_are') }}
                                </span></a><br></span></p>

                    <p><a href="/contact"><span style="color: #ffffff;">- {{ trans('footer.call_us') }}</span></a></p>
                </div>


            </div>
            <div class="col-6 col-md-3">


                <span class="header d-block text-white font-weight-bold">{{ trans('footer.call_us') }}</span>

                <div class="mt-20">
                    <div class="d-flex align-items-center text-white font-14">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-mail mr-10">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                            </path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                        contact@abajim.com
                    </div>


                    <div class="mt-10 d-flex align-items-center text-white font-14">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-phone mr-10">
                            <path
                                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                            </path>
                        </svg>
                        <span dir="ltr">+216 98 639 953</span>
                    </div>
                    <div class="mt-10 d-flex align-items-center text-white font-14">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-map-pin text-white">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        Tunisie Sousse Novation City
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">

                <div class="mt-20 ml-30">
                    <p><a title="Notnt" href="/store/1/icon.png"><img style="width: 97px;" src="/store/1/icon.png"></a>
                    </p>
                </div>
            </div>
            <!-- <div class="col-6 col-md-3">



                <img src="/store/1/icon.png" style="width:37%;height: 80%!important;" class="img-cover"
                    alt="footer logo">


            </div> -->
            @foreach ($columns as $column)
                <div class="col-6 col-md-3">
                    @if (!empty($footerColumns[$column]))
                        @if (!empty($footerColumns[$column]['title']))
                            <span
                                class="header d-block text-white font-weight-bold">{{ $footerColumns[$column]['title'] }}</span>
                        @endif

                        @if (!empty($footerColumns[$column]['value']))
                            <div class="mt-20">
                                {!! $footerColumns[$column]['value'] !!}
                            </div>
                        @endif
                    @endif
                </div>
            @endforeach

        </div>

        <div class="mt-40 border-blue py-25 d-flex align-items-center justify-content-between">
            <div class="footer-logo">
                <a href="/">
                    @if (!empty($generalSettings['footer_logo']))
                        <img src="/store/1/logo_white.png" style="width: 87%!important;" class="img-cover"
                            alt="footer logo">
                    @endif
                </a>
            </div>
            <div class="ml-50 font-14 text-white">جميع الحقوق محفوظة لمنصة أبجم</div>
            <div class="footer-social">
                @if (!empty($socials) and count($socials))
                    @foreach ($socials as $social)
                        <a href="{{ $social['link'] }}" target="_blank">
                            <img src="{{ $social['image'] }}" alt="{{ $social['title'] }}" class="mr-15">
                        </a>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</footer>

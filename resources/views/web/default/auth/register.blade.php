@extends(getTemplate() . '.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/select2/select2.min.css">
    <style>
        .input-label {
            font-size: 24px !important;
        }

        @media (max-width: 768px) {
            .img-cover {
                width: 100%;
                object-fit: cover;
                border-radius: 10px 10px 0 0 !important;
            }

            .mt-sm-20 {
                margin-top: 0 !important;
            }

            .login-card {
                margin-top: 0px !important;
            }

            .image-container {
                max-height: 300px;
                padding: 0;
            }
        }
    </style>
    <style>
        .password-toggle-icon {
            cursor: pointer;
            z-index: 10;
            color: #a5a5a5;
            align-items: center;
            align-self: flex-end;
            position: absolute;
            left: 30px;
            top: 48px;

        }
    </style>
@endpush

@section('content')
    @php
        $registerMethod = getGeneralSettings('register_method') ?? 'mobile';
        $showOtherRegisterMethod = getFeaturesSettings('show_other_register_method') ?? false;
        $showCertificateAdditionalInRegister = getFeaturesSettings('show_certificate_additional_in_register') ?? false;
    @endphp

    <div class="container">
        <div class="row login-container">
            <div class="col-12 col-md-6 image-container">
                <img id="rotatingImage" src="/store/1/default_images/register1.png" class="img-cover" alt="Login">

            </div>
            <div class="col-12 col-md-6">
                <div class="login-card" style="margin-top:50px">
                    <h1 class="text-center font-weight-bold" style="font-family: 'Tajawal', sans-serif;font-size: 36px ">
                        {{ trans('auth.signup') }}
                        <h6 class="text-center font-weight-bold mb-50"
                            style="font-family: 'Tajawal', sans-serif;font-size: 24px ">
                            ({{ trans('auth.parent_account') }})</h6>
                    </h1>

                    <form method="post" action="/register" class="mt-35">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        @if ($registerMethod == 'mobile')
                            @if ($showOtherRegisterMethod)
                                @include('web.default.auth.register_includes.email_field', [
                                    'optional' => true,
                                ])
                            @endif
                        @endif
                        <div class="row mt-50">
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label style="font-family: 'Tajawal', sans-serif; " class="input-label"
                                        for="full_name">{{ trans('auth.full_name_parent') }}:</label>
                                    <input name="full_name" placeholder="{{ trans('auth.full_name_parent') }}"
                                        type="text" value="{{ old('full_name') }}"
                                        class="font-16 form-control @error('full_name') is-invalid @enderror">
                                    @error('full_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label style="font-family: 'Tajawal', sans-serif; " class="input-label"
                                        for="mobile">{{ trans('auth.phone_number_parent') }}
                                        {{ !empty($optional) ? '(' . trans('public.optional') . ')' : '' }}:</label>
                                    <input name="mobile" type="text"
                                        class="font-16 form-control @error('mobile') is-invalid @enderror"
                                        value="{{ old('mobile') }}" id="mobile" minlength="8" maxlength="8"
                                        aria-describedby="mobileHelp"
                                        placeholder="{{ trans('auth.phone_number_parent') }}">

                                    @error('mobile')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                            </div>
                        </div>

                        <div class="row mt-sm-20">
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label style="font-family: 'Tajawal', sans-serif; " class="input-label"
                                        for="password">{{ trans('auth.password') }}:</label>
                                    <input name="password" type="password"
                                        class="font-16 form-control @error('password') is-invalid @enderror" id="password"
                                        aria-describedby="passwordHelp">
                                    <i onclick="togglePasswordVisibility('password')"
                                        class="fas fa-eye password-toggle-icon"></i>

                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group ">
                                    <label style="font-family: 'Tajawal', sans-serif; " class="input-label"
                                        for="confirm_password">{{ trans('auth.retype_password') }}:</label>
                                    <input name="password_confirmation" type="password"
                                        class="font-16 form-control @error('password_confirmation') is-invalid @enderror"
                                        id="confirm" aria-describedby="confirmPasswordHelp">
                                    <i onclick="togglePasswordVisibility('confirm')"
                                        class="fas fa-eye password-toggle-icon"></i>

                                    @error('password_confirmation')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        @if (!empty($referralSettings) and $referralSettings['status'])
                            <div class="form-group ">
                                <label style="font-family: 'Tajawal', sans-serif; " class="input-label"
                                    for="referral_code">{{ trans('financial.referral_code') }}:</label>
                                <input name="referral_code" type="text"
                                    class="form-control @error('referral_code') is-invalid @enderror" id="referral_code"
                                    value="{{ !empty($referralCode) ? $referralCode : old('referral_code') }}"
                                    aria-describedby="confirmPasswordHelp">
                                @error('referral_code')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        @endif


                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="term" value="1"
                                {{ (!empty(old('term')) and old('term') == '1') ? 'checked' : '' }}
                                class="custom-control-input @error('term') is-invalid @enderror" id="term">
                            <label style="font-family: 'Tajawal', sans-serif; " class="custom-control-label font-14"
                                for="term">{{ trans('auth.i_agree_with') }}
                                <a href="pages/terms" target="_blank"
                                    class="text-secondary font-weight-bold font-14">{{ trans('auth.terms_and_rules') }}</a>
                            </label>

                            @error('term')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        @error('term')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <button style="font-family: 'Tajawal', sans-serif; " type="submit"
                            class="btn btn-primary btn-block mt-20">{{ trans('auth.signup') }}</button>
                    </form>

                    <div class="text-center mt-20">
                        <span class="text-secondary">
                            {{ trans('auth.already_have_an_account') }}
                            <a href="/login" class="text-secondary font-weight-bold">{{ trans('auth.login') }}</a>
                        </span>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/select2/select2.min.js"></script>
    <script>
        const images = [
            "/store/1/default_images/register1.png",
            "/store/1/default_images/register2.png",
        ];
        let index = 0;
        const rotatingImage = document.getElementById('rotatingImage');

        function switchImage() {
            index = (index + 1) % images.length;
            rotatingImage.src = images[index];
        }
        setInterval(switchImage, 5000);
    </script>
    <script>
        function togglePasswordVisibility(elementId) {
            var input = document.getElementById(elementId);
            var icon = input.nextElementSibling;
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = "password";
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
@endpush

@extends(getTemplate() . '.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/select2/select2.min.css">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.6.0/css/fontawesome.min.css" crossorigin="anonymous">
@endpush
<style>
    .password-toggle-icon {
        position: absolute;
        cursor: pointer;
        z-index: 10;
        color: #a5a5a5;
        align-items: center;
        left: 30px;
        top: 47px;

    }

    .input-label {
        font-size: 24px !important;
    }
    
    @media (max-width: 768px) {
            .img-cover {
                width: 100%;
                object-fit: cover;
                /* border radius top only */
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


@section('content')
    @php
        $registerMethod = getGeneralSettings('register_method') ?? 'mobile';
        $showOtherRegisterMethod = getFeaturesSettings('show_other_register_method') ?? false;
        $showCertificateAdditionalInRegister = getFeaturesSettings('show_certificate_additional_in_register') ?? false;
    @endphp

    <div class="container">
        <div class="row login-container">
            <div class="col-12 col-md-6 image-container">
                <img src="/store/1/default_images/sign_up.jpeg" class="img-cover" alt="Login">
            </div>
            <div class="col-12 col-md-6">
                <div class="login-card">
                    <h1 class="font-weight-bold text-center" style="font-family: 'Tajawal', sans-serif;font-size: 36px ">
                        {{ trans('auth.signup') }}
                        <h6 class="font-weight-bold text-center"
                            style="font-family: 'Tajawal', sans-serif;font-size: 24px ">
                            ({{ trans('auth.teacher_account') }})</h6>

                    </h1>
                    <form method="post" action="/Instructor/register" class="mt-35">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label class="input-label" for="full_name">{{ trans('auth.full_name') }}
                            </label>
                            <input name="full_name" type="text" value="{{ old('full_name') }}"
                                class="font-16 form-control @error('full_name') is-invalid @enderror"
                                placeholder="{{ trans('auth.full_name') }}">
                            @error('full_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        @if ($showOtherRegisterMethod)
                            @include('web.default.auth.register_includes.mobile_field', [
                                'optional' => true,
                            ])
                        @endif
                        <style>
                            .password-hint {
                                border: 1px solid #ccc;
                                padding: 10px;
                                margin-top: 5px;
                            }
                            .password-hint-title {
                                font-weight: bold;
                            }
                            .valid {
                                color: green;
                            }
                            .invalid {
                                color: red;
                            }
                        </style>
                        {{-- @endif --}}
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label class="input-label" for="password">{{ trans('auth.password') }}:</label>
                                    <input name="password" type="password"
                                        class="font-16 form-control @error('password') is-invalid @enderror" id="password"
                                        placeholder="{{ trans('auth.password') }}" oninput="validatePassword()">
                                    <i onclick="togglePasswordVisibility('password')"
                                        class="fas fa-eye password-toggle-icon"></i>
                                        {{-- <span class="text-success">
                                            يجب أن تحتوي كلمة المرور على 6 أحرف على الأقل وتحتوي على حرف كبير وحرف صغير ورقم ورمز خاص
                                        </span> --}}
                                       
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label class="input-label"
                                        for="confirm_password">{{ trans('auth.retype_password') }}:</label>
                                    <input name="password_confirmation" type="password"
                                        class="font-16 form-control @error('password_confirmation') is-invalid @enderror"
                                        id="confirm" aria-describedby="confirmPasswordHelp"
                                        placeholder="{{ trans('auth.retype_password') }}">
                                    <i onclick="togglePasswordVisibility('confirm')"
                                        class="fas fa-eye password-toggle-icon"></i>
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div id="passwordHint" class="password-hint">
                                    <div class="password-hint-title">إشارة كلمة السر:</div>
                                    <ul>
                                        <li id="minDigits"> الحد الأدنى 6 أرقام</li>
                                        <li id="upperCase"> على الأقل حرف واحد كبير (A – Z)</li>
                                        <li id="lowerCase"> على الأقل حرف واحد صغير (a - z)</li>
                                        <li id="number"> على الأقل رقم واحد (0 - 9)</li>
                                        <li id="specialChar"> على الأقل رمز واحد (مثلاً '@#$%!')</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        @if (getFeaturesSettings('timezone_in_register'))
                            @php
                                $selectedTimezone = getGeneralSettings('default_time_zone');
                            @endphp

                            <div class="form-group">
                                <!-- <label class="input-label">{{ trans('update.timezone') }}</label> -->
                                <select name="timezone" data-allow-clear="false" hidden>
                                    <option value="" {{ empty($user->timezone) ? 'selected' : '' }} disabled>
                                        {{ trans('public.select') }}</option>
                                    @foreach (getListOfTimezones() as $timezone)
                                        <option value="{{ $timezone }}"
                                            @if ($selectedTimezone == $timezone) selected @endif>{{ $timezone }}</option> @endforeach
                                </select>
                                @error('timezone')
<div class="invalid-feedback">
    {{ $message }}
    </div>
@enderror
</div>
@endif

@if (!empty($referralSettings) and $referralSettings['status'])
    <div class="form-group ">
        <label class="input-label" for="referral_code">{{ trans('financial.referral_code') }}:</label>
        <input name="referral_code" type="text" class="form-control @error('referral_code') is-invalid @enderror"
            id="referral_code" value="{{ !empty($referralCode) ? $referralCode : old('referral_code') }}"
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
    <label class="custom-control-label font-14" for="term">{{ trans('auth.i_agree_with') }}
        <a href="{{ env('APP_ENV_URL') }}pages/terms_instructor" target="_blank"
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
<button type="submit" class="btn btn-primary btn-block mt-20">{{ trans('auth.signup') }}</button>
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
<script>
    function validatePassword() {
        const password = document.getElementById('password').value;
        document.getElementById('minDigits').className = password.length >= 6 ? 'valid' : 'invalid';
        document.getElementById('upperCase').className = /[A-Z]/.test(password) ? 'valid' : 'invalid';
        document.getElementById('lowerCase').className = /[a-z]/.test(password) ? 'valid' : 'invalid';
        document.getElementById('number').className = /[0-9]/.test(password) ? 'valid' : 'invalid';
        document.getElementById('specialChar').className = /[\W_]/.test(password) ? 'valid' : 'invalid';
    }
</script>

@endpush

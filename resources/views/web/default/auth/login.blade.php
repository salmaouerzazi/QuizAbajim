 @extends(getTemplate() . '.layouts.app')


<style>
    .password-toggle-icon {
        cursor: pointer;
        z-index: 10;
        color: #a5a5a5;
        align-items: center;
        align-self: flex-end;
        position: absolute;
        left: 30px;
        top: 47px;

    }

    * {
        font-family: 'Tajawal', sans-serif;
    }

    .input-label {
        font-size: 24px !important;
    }

    /* display img cover on mobile none */
    @media (max-width: 768px) {
        .img-cover {
            display: none;
        }
    }

    /*  image in center and smaller */
    .img-cover {
        object-fit: contain !important;
        height: 70% !important;
        width: 100% !important;

    }
</style>

@section('content')
    <div class="container">
        @if (!empty(session()->has('msg')))
            <div class="alert alert-info alert-dismissible fade show mt-30" role="alert">
                {{ session()->get('msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row login-container">

            <div class="col-12 col-md-6 pl-0">
                <img src="{{ getPageBackgroundSettings('login') }}" class="img-cover" alt="Login">
            </div>
            <div class="col-12 col-md-6">
                <div class="login-card">
                    <h1 class="font-weight-bold text-center" style="font-family: 'Tajawal', sans-serif;font-size:36px; ">
                        {{ trans('auth.login') }}</h1>

                    <form method="Post" action="/login" class="mt-35">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="input-label" style="font-family: 'Tajawal', sans-serif; "
                                    for="username">{{ trans('auth.email_or_mobile') }}:</label>
                                <input name="username" type="text"
                                    class="font-16 form-control @error('username') is-invalid @enderror" id="username"
                                    value="{{ old('username') }}" aria-describedby="emailHelp"   placeholder="البريد الإلكتروني أو الهاتف">
                                @error('username')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label style="font-family: 'Tajawal', sans-serif; " class="input-label"
                                    for="password">{{ trans('auth.password') }}:</label>
                                <input name="password" type="password"
                                    class="font-16 form-control @error('password')  is-invalid @enderror" id="password"
                                    aria-describedby="passwordHelp" placeholder="{{ trans('auth.password') }}">
                                <i onclick="togglePasswordVisibility('password')"
                                    class="fa fa-eye password-toggle-icon"></i>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" style="font-family: 'Tajawal', sans-serif; "
                            class="btn btn-primary btn-block mt-20">{{ trans('auth.login') }}</button>
                    </form>

                    <div class="text-center mt-20">
                        <span
                            class="badge badge-circle-gray300 text-secondary d-inline-flex align-items-center justify-content-center">{{ trans('auth.or') }}</span>
                    </div>

                    {{-- <a href="/google" target="_blank" class="social-login mt-20 p-10 text-center d-flex align-items-center justify-content-center">
                        <img src="/assets/default/img/auth/google.svg" class="mr-auto" alt=" google svg"/>
                        <span class="flex-grow-1">{{ trans('auth.google_login') }}</span>
                    </a> --}}

                    {{-- <a href="{{url('/facebook/redirect')}}" target="_blank" class="social-login mt-20 p-10 text-center d-flex align-items-center justify-content-center ">
                        <img src="/assets/default/img/auth/facebook.svg" class="mr-auto" alt="facebook svg"/>
                        <span class="flex-grow-1">{{ trans('auth.facebook_login') }}</span>
                    </a> --}}

                    <div class="mt-30 text-center">
                        <a href="/forget-password" target="_blank">{{ trans('auth.forget_your_password') }}</a>
                    </div>

                    <div class="mt-20 text-center">
                        <span>{{ trans('auth.dont_have_account') }}</span>
                        <a href="/register" class="text-secondary font-weight-bold">{{ trans('auth.signup') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

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

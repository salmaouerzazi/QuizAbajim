@extends(getTemplate() . '.layouts.app')
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

    .img-cover {
        object-fit: contain !important;

    }
</style>
@section('content')
    <div class="container">
        <div class="row login-container">
            <div class="col-12 col-md-6 pl-0">
                <img src="{{ getPageBackgroundSettings('remember_pass') }}" class="img-cover" alt="Login">
            </div>

            <div class="col-12 col-md-6">
                <div class="login-card">
                    <h1 class="font-weight-bold text-center" style="font-size:36px">
                        {{ trans('auth.reset_password') }}
                    </h1>
                    <form method="post" action="/reset-password" class="mt-35">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label class="input-label" for="email">{{ trans('auth.email') }}:</label>
                            <input type="email" name="email"
                                class="font-16 form-control @error('email') is-invalid @enderror" id="email"
                                value="{{ request()->get('email') }}" aria-describedby="emailHelp">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="input-label" for="password">{{ trans('auth.password') }}:</label>
                            <input name="password" type="password"
                                class="font-16 form-control @error('password') is-invalid @enderror" id="password"
                                aria-describedby="passwordHelp">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="input-label" for="confirm_password">{{ trans('auth.retype_password') }}:</label>
                            <input name="password_confirmation" type="password"
                                class="font-16 form-control @error('password_confirmation') is-invalid @enderror"
                                id="confirm_password" aria-describedby="confirmPasswordHelp">
                            @error('password_confirmation')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <input hidden name="token" placeholder="token" value="{{ $token }}">

                        <button type="submit"
                            class="btn btn-primary btn-block mt-20">{{ trans('auth.reset_password') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

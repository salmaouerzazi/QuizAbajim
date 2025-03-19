@extends(getTemplate() . '.layouts.app')
<style>
    .input-label {
        font-size: 24px !important;
    }
</style>
@section('content')
    <div class="container">
        <div class="row login-container">
            <div class="col-12 col-md-6 pl-0">
                <img src="/assets/default/img/code-img.png" class="img-cover" alt="Login" width="50%">
            </div>
            <div class="col-12 col-md-6">
                <div class="login-card">
                    <h1 class="font-20 font-weight-bold text-center"
                        style="font-family: 'Tajawal', sans-serif;font-size: 36px">{{ trans('auth.account_verification') }}
                    </h1>
                    <h6 class="text-center" style="font-family: 'Tajawal', sans-serif;font-size: 24px ">
                        {{ trans('auth.account_verification_hint', ['username' => $username]) }}</h6>
                    <form method="post" action="/Instructor/verification" class="mt-35">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <input type="hidden" name="username" value="{{ $usernameValue }}">

                        <div class="form-group">
                            <label class="input-label" for="code">{{ trans('auth.code') }}:</label>
                            <input type="tel" name="code"
                                class="font-16 form-control @error('code') is-invalid @enderror" id="code"
                                aria-describedby="codeHelp">
                            @error('code')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <button type="submit"
                            class="btn btn-primary btn-block mt-20">{{ trans('auth.verification') }}</button>
                    </form>

                    <div class="text-center mt-20">
                        <span class="text-secondary">
                            <a href="/verification/resend" class="font-weight-bold">{{ trans('auth.resend_code') }}</a>
                        </span>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

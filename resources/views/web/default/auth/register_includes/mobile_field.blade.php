<div class="row">
    <div class="col-12 col-sm-6">
        <div class="form-group">
            <label class="input-label" for="email">{{ trans('auth.email') }}
            </label>
            <input name="email" type="text" class="font-16 form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}" id="email" aria-describedby="emailHelp"
                placeholder="{{ trans('auth.email') }}">

            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

    </div>

    <div class="col-12 col-sm-6">
        <div class="form-group">
            <label class="input-label" for="mobile">{{ trans('auth.mobile') }}
            </label>
            <input name="mobile" type="text" class="font-16 form-control @error('mobile') is-invalid @enderror"
                value="{{ old('mobile') }}" id="mobile"  aria-describedby="mobileHelp"
                placeholder="{{ trans('auth.mobile') }}">

            @error('mobile')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
</div>

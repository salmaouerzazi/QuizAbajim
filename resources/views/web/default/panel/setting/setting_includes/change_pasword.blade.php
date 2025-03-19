<section class="p-15 panel-shadow bg-white rounded-sm m-20" style="padding:10px">
    <div class="row mt-20">
        <div class="row col-6">
            <div class="col-12">
                <div class="form-group">
                    <label class="input-label">{{ trans('public.current_password') }}</label>
                    <input type="password" name="current_password" id="current" value=""
                        class="form-control @error('current_password')  is-invalid @enderror" placeholder="" />
                    <i onclick="togglePasswordVisibility('current')"
                        class="{{ App::isLocale('ar') ? 'fa fa-eye password-toggle-icon-left' : 'fa fa-eye password-toggle-icon-right' }}"></i>
                    @error('current_password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row col-6">
            <div class="col-12">
                <div class="form-group">
                    <label class="input-label">{{ trans('public.new_password') }}</label>
                    <input type="password" name="password" id="password" value=""
                        class="form-control @error('password')  is-invalid @enderror" placeholder="" />
                    <i onclick="togglePasswordVisibility('password')"
                        class="{{ App::isLocale('ar') ? 'fa fa-eye password-toggle-icon-left' : 'fa fa-eye password-toggle-icon-right' }}"></i>
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row col-6">
            <div class="col-12">
                <div class="form-group">
                    <label class="input-label">{{ trans('public.new_password_confirmation') }}</label>
                    <input type="password" name="password_confirmation" id="confirmation"
                        value="{{ old('password_confirmation') }}"
                        class="form-control @error('password_confirmation')  is-invalid @enderror" placeholder="" />
                    <i onclick="togglePasswordVisibility('confirmation')"
                        class="{{ App::isLocale('ar') ? 'fa fa-eye password-toggle-icon-left' : 'fa fa-eye password-toggle-icon-right' }}"></i>


                    @error('password_confirmation')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts_bottom')
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

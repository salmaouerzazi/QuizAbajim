<style>
    * {
        font-family: 'Tajawal', sans-serif !important;
    }

    .add-square-container-child,
    .child-square-container {
        width: 150px;
        height: 150px;
        background-color: #f7f7f7;
        border: 2px dashed #ccc;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        position: relative;
    }

    .add-square-icon,
    .avatar-child {
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid #7c9bc8;

    }

    .edit-icon {
        position: absolute;
        bottom: 5px;
        right: 5px;
        cursor: pointer;
    }

</style>

<section class="p-15 panel-shadow bg-white rounded-sm m-20">
    <div class="row mt-20">
        @if($user->isOrganization())
        <div class="col-lg-12 mt-5 mb-30">
            <h2 class="font-weight-bold text-secondary">{{trans('panel.personal_informations')}}</h2>
        </div>
        @endif
        @if ($user->isTeacher())
            <div class="col-lg-6">
                <div class="form-group">
                    <label class="input-label">{{ trans('public.email') }}</label>
                    <input type="text" name="email"
                           value="{{ (!empty($user) && empty($new_user)) ? $user->email : old('email') }}"
                           class="form-control @error('email') is-invalid @enderror" placeholder="" />
                    @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        @endif

        <div class="col-lg-6">
            <div class="form-group">
                <label class="input-label">{{ trans('auth.name') }}</label>
                <input type="text" name="full_name"
                       value="{{ (!empty($user) && empty($new_user)) ? $user->full_name : old('full_name') }}"
                       class="form-control @error('full_name') is-invalid @enderror"
                       placeholder="" />
                @error('full_name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            @if ($user->isEnfant())
                <div class="form-group">
                    <label class="input-label">
                        {{ trans('public.gender') }}
                    </label>
                    <select name="sexe" class="form-control">
                        <option value="{{ old('sexe') ?? ($user->sexe ?? '') }}">
                            {{ old('sexe') ?? (!empty($user) ? trans('public.' . $user->sexe) : '') }}
                        </option>
                        @if ($user->sexe == 'Fille')
                            <option value="Garçon">{{ trans('public.Garçon') }}</option>
                        @elseif ($user->sexe == 'Garçon')
                            <option value="Fille">{{ trans('public.Fille') }}</option>
                        @endif
                    </select>
                </div>
            @endif
        </div>

        @if (!$user->isEnfant())
            <div class="col-lg-6">
                <div class="form-group">
                    <label class="input-label">{{ trans('public.mobile') }}</label>
                    <input type="tel" name="mobile"
                           value="{{ (!empty($user) && empty($new_user)) ? $user->mobile : old('mobile') }}"
                           class="form-control @error('mobile') is-invalid @enderror"
                           placeholder="" />
                    @error('mobile')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group">
                    <label class="input-label">{{ trans('auth.language') }}</label>
                    <select name="language" class="form-control">
                        <option value="" disabled>{{ trans('auth.language') }}</option>
                        @foreach ($userLanguages as $lang => $language)
                            <option value="{{ $lang }}"
                                @if(!empty($user) && mb_strtolower($user->language) == mb_strtolower($lang))
                                    selected
                                @endif>
                                {{ $language }}
                            </option>
                        @endforeach
                    </select>
                    @error('language')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        @endif
        @if ($user->isEnfant())
            <div class="col-lg-6 col-md-12 col-sm-12 d-flex align-items-center justify-content-center">
                <div class="form-group">
                    <label class="input-label">{{ trans('auth.profile_image') }}</label>
                    <img src="{{ !empty($user) ? $user->getAvatar(150) : '' }}"
                            alt=""
                            id="profileImagePreview"
                            width="200"
                            height="160"
                            class="d-block ml-5 select-image-cropit"
                            style="border: 4px solid #e9ecef; border-radius: 5px; padding: 10px; object-fit: cover;"
                            data-ref-image="profileImagePreview"
                            data-ref-input="profile_image">
                    <div class="input-group">
                        <input type="hidden" name="profile_image" id="profile_image"
                                class="form-control @error('profile_image') is-invalid @enderror" />
                        @error('profile_image')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
        @endif

        @if ($user->isTeacher())
            <div class="col-lg-6">
                <div class="form-group mt-30 d-flex align-items-center justify-content-between">
                    <label class="cursor-pointer input-label"
                            for="newsletterSwitch">{{ trans('auth.join_newsletter') }}</label>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" name="join_newsletter"
                                class="custom-control-input"
                                id="newsletterSwitch"
                                {{ (!empty($user) && $user->newsletter) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="newsletterSwitch"></label>
                    </div>
                </div>
            </div>
        @endif

        @if ($user->isEnfant())
            <div class="col-lg-12">
                <div class="form-group">
                    <label class="cursor-pointer input-label"
                           style="color:red; font-size:1.5rem; border: 1px solid red; padding: 5px; border-radius: 5px;"
                           for="deleteChildAccount"
                           data-toggle="modal"
                           data-target="#deleteChildAccountModal">
                        {{ trans('panel.delete_account') }}
                    </label>
                </div>
            </div>
        @endif
        </div>
        <div class="row mt-20">
        @if ($user->isOrganization())
            @php
                $maxChildren = 4;
                $userenfantCount = \App\User::where('organ_id', $user->id)->count();
                $userenfant = \App\User::where('organ_id', $user->id)->get();
            @endphp

            <div class="col-lg-12">
                <h2 class="font-weight-bold mb-30 text-secondary">{{ trans('public.children') }}</h2>
            </div>
    
            @if ($userenfantCount == 0)
                <div class="col-12 d-flex justify-content-center mb-4">
                    <div class="add-square-container-child text-center">
                        <span data-toggle="modal" data-target="#exampleModal">
                            <img class="add-square-icon"
                                    src="/assets/default/icons/add-icon.jpeg"
                                    alt="Add"
                                    width="150"
                                    height="150" />
                        </span>
                    </div>
                </div>
            @endif

            @if ($userenfantCount > 0 && $userenfantCount < $maxChildren)
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-2 col-md-6 col-sm-12 mb-4 d-flex justify-content-center">
                        <div class="add-square-container-child text-center">
                            <span data-toggle="modal" data-target="#exampleModalSetting">
                                <img class="add-square-icon"
                                        src="/assets/default/icons/add-icon.jpeg"
                                        alt="Add"
                                        width="150"
                                        height="150"/>
                            </span>
                        </div>  
                    </div>              
                    @foreach ($userenfant as $child)
                        @php
                            $levelenfant = DB::table('school_levels')
                                ->where('id', $child->level_id)
                                ->pluck('name')
                                ->first();
                        @endphp
                        <div class="col-lg-2 col-md-6 col-sm-12 mb-4 d-flex justify-content-center">
                            <div class="text-center position-relative">
                                <a href="/panel/impersonate/user/{{ $child->id }}">
                                    <img class="avatar-child"
                                            src="{{ $child->avatar }}"
                                            alt="Avatar"
                                            width="150"
                                            height="150" />
                                </a>
                                <a href="/panel/impersonate/user/{{ $child->id }}/setting"
                                    class="edit-icon"
                                    style="bottom:30%; right:5px;">
                                    <img src="/store/1/default_images/edit.png"
                                            style="width:40px; background-color: rgba(0,0,0,0.5); border-radius: 50%;"
                                            alt="Edit" />
                                </a>
                                <div>
                                    <span class="text-secondary font-20 d-block">{{ $child->full_name }}</span>
                                    @if(!empty($levelenfant))
                                        <span class="text-secondary font-16 font-weight-bold">{{ $levelenfant }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @elseif ($userenfantCount >= $maxChildren)
                <div class="col-lg-12">

                    <div class="row justify-content-center">
                        @foreach ($userenfant as $child)
                            @php
                                $levelenfant = DB::table('school_levels')
                                    ->where('id', $child->level_id)
                                    ->pluck('name')
                                    ->first();
                            @endphp
                            <div class="col-lg-2 col-md-6 col-sm-12 mb-4 d-flex justify-content-center">
                                <div class="text-center position-relative">
                                    <a href="/panel/impersonate/user/{{ $child->id }}">
                                        <img class="avatar-child"
                                                src="{{ $child->avatar }}"
                                                alt="Avatar"
                                                width="150"
                                                height="150" />
                                    </a>
                                    <a href="/panel/impersonate/user/{{ $child->id }}/setting"
                                        class="edit-icon"
                                        style="bottom:30%; right:5px;">
                                        <img src="/store/1/default_images/edit.png"
                                                style="width:40px; background-color: rgba(0,0,0,0.5); border-radius: 50%;"
                                                alt="Edit" />
                                    </a>
                                    <div>
                                        <span class="text-secondary font-20 d-block">{{ $child->full_name }}</span>
                                        @if(!empty($levelenfant))
                                            <span class="text-secondary font-16 font-weight-bold">{{ $levelenfant }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endif
    </div>
</section>

{{-- MODALS --}}
<div class="modal fade" id="deleteChildAccountModal" tabindex="-1" role="dialog"
     aria-labelledby="deleteChildAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header align-items-center">
                <h5 class="modal-title" id="deleteChildAccountModalLabel">
                    {{ trans('panel.confirm_delete_account') }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{ trans('panel.delete_account_warning') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    {{ trans('panel.cancel') }}
                </button>
                <button type="button" class="btn btn-danger" onclick="deleteAccount()">
                    {{ trans('panel.delete') }}
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="avatarCropModalContainer" tabindex="-1" role="dialog"
     aria-labelledby="avatarCrop">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">
                    {{ trans('public.edit_selected_image') }}
                </h4>
            </div>
            <div class="modal-body">
                <div id="imageCropperContainer">
                    <div class="cropit-preview"></div>
                    <div class="cropit-tools">
                        <div class="d-flex align-items-center justify-content-center">
                            <div class="mr-20">
                                <button type="button" class="btn btn-transparent rotate-cw mr-10">
                                    <i data-feather="rotate-cw" width="18" height="18"></i>
                                </button>
                                <button type="button" class="btn btn-transparent rotate-ccw">
                                    <i data-feather="rotate-ccw" width="18" height="18"></i>
                                </button>
                            </div>
                            <div class="d-flex align-items-center justify-content-center">
                                <span>-</span>
                                <input type="range" class="cropit-image-zoom-input mx-10">
                                <span>+</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <button class="btn btn-transparent" id="cancelAvatarCrop">
                            {{ trans('public.cancel') }}
                        </button>
                        <button class="btn btn-green" id="storeAvatar">
                            {{ trans('public.select') }}
                        </button>
                    </div>
                    <input type="file" class="cropit-image-input">
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts_bottom')
<script>
    function deleteAccount() {
        $.ajax({
            url: "{{ url('/panel/delete-child') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                user_id: {{ $user->id }}
            },
            success: function(response) {
                window.location.href = "{{ url('/panel/enfant') }}";
            },
            error: function(error) {
                console.error("There was an error deleting the account:", error);
            }
        });
    }

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            alert('{{ $error }}');
        @endforeach
    @endif
</script>
@endpush

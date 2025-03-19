@extends(getTemplate() . '.panel.layouts.panel_layout')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/select2/select2.min.css">
    <style>
        * {
            font-family: 'IRANSans', sans-serif !important;
        }

        .form-group {
            position: relative;
        }
        .password-toggle-icon-left {
            cursor: pointer;
            z-index: 10;
            color: #a5a5a5;
            position: absolute;
            left: 10px;
            top: 70%; /* Align vertically */
            transform: translateY(-50%); /* Center icon vertically */
            font-size: 1.2rem; /* Scales better across devices */
        }
        .password-toggle-icon-right {
            cursor: pointer;
            z-index: 10;
            color: #a5a5a5;
            position: absolute;
            right: 10px;
            top: 45px;
            transform: translateY(-50%);
        }

        input[type="password"] {
            padding-right: 35px;
        }
    </style>
@endpush

@section('content')
    @if (empty($new_user))
        @include('web.default.panel.setting.setting_includes.progress')
    @endif

    <form method="post" id="userSettingForm" class="mt-30"
        action="{{ !empty($new_user) ? '/panel/manage/' . $user_type . '/new' : '/panel/setting' }}">
        {{ csrf_field() }}
        <input type="hidden" name="step" value="{{ !empty($currentStep) ? $currentStep : 1 }}">
        <input type="hidden" name="next_step" value="0">

        @if (!empty($organization_id))
            <input type="hidden" name="organization_id" value="{{ $organization_id }}">
            <input type="hidden" id="userId" name="user_id" value="{{ $user->id }}">
        @endif

        @if (!empty($new_user) or !empty($currentStep) and $currentStep == 1)
            @include('web.default.panel.setting.setting_includes.basic_information')
        @endif

        @if (empty($new_user) and !empty($currentStep))
            @switch($currentStep)
                @case(2)
                    @include('web.default.panel.setting.setting_includes.change_pasword')
                @break

                @case(3)
                    @include('web.default.panel.setting.setting_includes.image')
                @break

                @case(4)
                    @include('web.default.panel.setting.setting_includes.about')
                @break

                @case(5)
                    @if ($authUser->isteacher())
                        @include('web.default.panel.setting.setting_includes.education')
                    @endif
                @break

                @case(6)
                    @if ($authUser->isteacher())
                        @include('web.default.panel.setting.setting_includes.experiences')
                    @endif
                @break

                @case(7)
                    @if ($authUser->isteacher())
                        @include('web.default.panel.setting.setting_includes.occupations')
                    @endif
                @break

                @case(8)
                    @if ($authUser->isteacher())
                        @include('web.default.panel.setting.setting_includes.identity_and_financial')
                    @endif
                @break

                @case(9)
                    @if (!$user->isUser())
                        @include('web.default.panel.setting.setting_includes.zoom_api')
                    @endif
                @break
            @endswitch
        @endif
    </form>

    <div id="accessibleSteps" data-steps='@json(array_keys(array_filter($progressSteps, function ($step) {
                return $step['access'];
            })))'
        class="create-webinar-footer d-flex align-items-center justify-content-between mt-20 pt-15 border-top"
        style="padding: 10px">
        <div class="d-flex align-items-center">
            @if (!empty($user) and empty($new_user))
                @if (!empty($currentStep) and $currentStep > 1)
                    <a href="/panel/setting/step/{{ $currentStep - 1 }}"
                        class="btn btn-sm btn-primary">{{ trans('webinars.previous') }}</a>
                @else
                    <a href="" class="btn btn-sm btn-primary disabled d-none">{{ trans('webinars.previous') }}</a>
                @endif
                <input type="hidden" name="current_step" value="{{ $currentStep }}">
                <button type="button" id="getNextStep" class="btn btn-sm btn-primary ml-15 @if ($currentStep == $lastAccessibleStep) d-none @endif"
                    >{{ trans('webinars.next') }}
                </button>
            @endif
        </div>
        <div class="d-flex align-items-center">
            <button type="button" id="saveData" class="btn btn-sm btn-primary ml-15"
                style="width: 200px">{{ trans('public.save') }}</button>
        </div>
    </div>
@endsection

@push('scripts_bottom')
    <script src="/assets/vendors/cropit/jquery.cropit.js"></script>
    <script src="/assets/default/js/parts/img_cropit.min.js"></script>
    <script src="/assets/default/vendors/select2/select2.min.js"></script>

    <script>
        var editEducationLang = '{{ trans('site.edit_education') }}';
        var editExperienceLang = '{{ trans('site.edit_experience') }}';
        var saveSuccessLang = '{{ trans('webinars.success_store') }}';
        var saveErrorLang = '{{ trans('site.store_error_try_again') }}';
        var notAccessToLang = '{{ trans('public.not_access_to_this_content') }}';
    </script>

    <script src="/assets/default/js/panel/user_setting.min.js"></script>
@endpush

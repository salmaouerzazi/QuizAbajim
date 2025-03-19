@extends(getTemplate() . '.panel.layouts.panel_layout')

@push('styles_top')
    <style>
        * {
            font-family: 'Tajawa', sans-serif !important;
        }
    </style>
@endpush

@section('content')
    <div class="">

        <form method="post" action="/panel/webinars/{{ !empty($webinar) ? $webinar->id . '/update' : 'store' }}"
            id="webinarForm" class="webinar-form" enctype="multipart/form-data">

            {{ csrf_field() }}
            <input type="hidden" name="current_step" value="1">
            <input type="hidden" name="draft" value="no" id="forDraft" />
            <input type="hidden" name="get_next" value="no" id="getNext" />
            <input type="hidden" name="get_step" value="0" id="getStep" />
            @include('web.default.panel.webinar.create_includes.step_1')
        </form>
        @if (!empty($webinar))
            <div class="create-webinar-footer d-flex align-items-center justify-content-end p-20">
                <button type="button" id="saveAsDraft"
                    class=" btn btn-sm btn-primary">{{ trans('public.save_as_draft') }}</button>
                <button type="button" id="sendForReview" class="btn btn-primary mr-10"
                    style="font-size:18px">{{ trans('public.publish') }}</button>
            </div>
        @endif
    </div>
@endsection

@push('scripts_bottom')
    <script>
        var saveSuccessLang = '{{ trans('webinars.success_store') }}';
        var zoomJwtTokenInvalid = '{{ trans('webinars.zoom_jwt_token_invalid') }}';
        var hasZoomApiToken = '{{ (!empty($authUser->zoomApi) and $authUser->zoomApi->jwt_token) ? 'true' : 'false' }}';
        var editChapterLang = '{{ trans('public.edit_chapter') }}';
    </script>

    <script src="/assets/default/js/panel/webinar.min.js"></script>
    <script src="/assets/default/js/panel/webinar_content_locale.min.js"></script>
@endpush

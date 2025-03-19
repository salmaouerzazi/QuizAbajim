@extends('admin.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/vendors/summernote/summernote-bs4.min.css">
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $pageTitle }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="/admin/">{{ trans('admin/main.dashboard') }}</a>
                </div>
                <div class="breadcrumb-item">{{ $pageTitle }}</div>
            </div>
        </div>

        <div class="section-body">

            <div class="card">
                <div class="card-body">
                    <div class="section-title ml-0 mt-0 mb-3">
                        <h5>{{ trans('admin/main.tags') }}</h5>
                    </div>
                    <div class="row">
                        @foreach (\App\Models\NotificationTemplate::$templateKeys as $key => $value)
                            <div class="col-6 col-md-4">
                                <p>{{ trans('admin/main.' . $key) }} : {{ $value }} </p>
                                <hr>
                            </div>
                        @endforeach
                    </div>

                    <strong class="mt-4 d-block">{{ trans('admin/main.use_key_in_title_and_message_body') }}</strong>

                    <form method="post"
                        action="/admin/notifications/templates/{{ !empty($template) ? $template->id . '/update' : 'store' }}"
                        class="form-horizontal form-bordered mt-4">
                        {{ csrf_field() }}

                        <div class="form-group d-flex" style="gap:20px;">
                            <!-- Arabic -->
                            <div class="flex-grow-1">
                                <label for="title_ar">{{ trans('admin/main.title') }} (Arabic)</label>
                                <input type="text" name="title_ar"
                                    class="form-control @error('title_ar') is-invalid @enderror"
                                    value="{{ old('title_ar') }}">
                                <div class="invalid-feedback">
                                    @error('title_ar')
                                        {{ $message }}
                                    @enderror
                                </div>

                                <label for="template_ar" class="mt-3">{{ trans('admin/main.message_body') }}
                                    (Arabic)</label>
                                <textarea name="template_ar" class="summernote form-control @error('template_ar') is-invalid @enderror">{{ old('template_ar') }}</textarea>
                                <div class="invalid-feedback">
                                    @error('template_ar')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>

                            <!-- English -->
                            <div class="flex-grow-1">
                                <label for="title_en">{{ trans('admin/main.title') }} (English)</label>
                                <input type="text" name="title_en"
                                    class="form-control @error('title_en') is-invalid @enderror"
                                    value="{{ old('title_en') }}">
                                <div class="invalid-feedback">
                                    @error('title_en')
                                        {{ $message }}
                                    @enderror
                                </div>

                                <label for="template_en" class="mt-3">{{ trans('admin/main.message_body') }}
                                    (English)</label>
                                <textarea name="template_en" class="summernote form-control @error('template_en') is-invalid @enderror">{{ old('template_en') }}</textarea>
                                <div class="invalid-feedback">
                                    @error('template_en')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>

                            <!-- French -->
                            <div class="flex-grow-1">
                                <label for="title_fr">{{ trans('admin/main.title') }} (French)</label>
                                <input type="text" name="title_fr"
                                    class="form-control @error('title_fr') is-invalid @enderror"
                                    value="{{ old('title_fr') }}">
                                <div class="invalid-feedback">
                                    @error('title_fr')
                                        {{ $message }}
                                    @enderror
                                </div>

                                <label for="template_fr" class="mt-3">{{ trans('admin/main.message_body') }}
                                    (French)</label>
                                <textarea name="template_fr" class="summernote form-control @error('template_fr') is-invalid @enderror">{{ old('template_fr') }}</textarea>
                                <div class="invalid-feedback">
                                    @error('template_fr')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <button class="btn btn-primary" type="submit">{{ trans('admin/main.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="card">
        <div class="card-body">
            <div class="section-title ml-0 mt-0 mb-3">
                <h5>{{ trans('admin/main.hints') }}</h5>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="media-body">
                        <div class="text-primary mt-0 mb-1 font-weight-bold">
                            {{ trans('admin/main.new_notification_template_hint_title_1') }}</div>
                        <div class="text-small font-600-bold">
                            {{ trans('admin/main.new_notification_template_hint_description_1') }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="media-body">
                        <div class="text-primary mt-0 mb-1 font-weight-bold">
                            {{ trans('admin/main.new_notification_template_hint_title_1') }}</div>
                        <div class="text-small font-600-bold">
                            {{ trans('admin/main.new_notification_template_hint_description_2') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts_bottom')
    <script src="/assets/vendors/summernote/summernote-bs4.min.js"></script>
@endpush

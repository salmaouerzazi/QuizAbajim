@push('styles_top')
    <style>
        .video-upload-wrapper {
            width: 100%;
            height: 300px;
            border: 1px solid #e0e0e0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            cursor: pointer;
            background-color: #ffffff;
            transition: all 0.3s ease;
            border-radius: 8px;
        }

        .video-upload-wrapper:hover {
            border-color: #0056b3;
            background-color: #f1f1f1;
        }

        .video-placeholder {
            display: flex;
            justify-content: center;
            align-items: center;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #cccccc;
            font-size: 16px;
        }

        .video-preview {
            display: none;
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
        }
    </style>
@endpush

@if (!empty($file) and $file->storage == 'upload_archive')
    @include('web.default.panel.webinar.create_includes.accordions.new_interactive_file', [
        'file' => $file,
    ])
@else
    <li data-id="{{ !empty($chapterItem) ? $chapterItem->id : '' }}"
        class="accordion-row bg-white rounded-sm border border-gray300 mt-20 py-15 py-lg-30 px-10 px-lg-20">
        <div class="d-flex align-items-center justify-content-between " role="tab"
            id="file_{{ !empty($file) ? $file->id : 'record' }}">
            <div class="d-flex align-items-center" href="#collapseFile{{ !empty($file) ? $file->id : 'record' }}"
                aria-controls="collapseFile{{ !empty($file) ? $file->id : 'record' }}"
                data-parent="#chapterContentAccordion{{ !empty($chapter) ? $chapter->id : '' }}" role="button"
                data-toggle="collapse" aria-expanded="true">
                <span class="chapter-icon chapter-content-icon mr-10">
                    <i data-feather="{{ !empty($file) ? $file->getIconByType() : 'file' }}" class=""></i>
                </span>

                <div class="font-weight-bold text-dark-blue d-block">
                    {{ !empty($file) ? $file->title : trans('public.add_new_files') }}
                </div>
            </div>

            <div class="d-flex align-items-center">

                @if (!empty($file) and $file->status != \App\Models\WebinarChapter::$chapterActive)
                    <span class="disabled-content-badge mr-10">{{ trans('public.pending') }}</span>
                @endif

                <i data-feather="move" class="move-icon mr-10 cursor-pointer" height="20"></i>

                @if (!empty($file))
                    <a href="/panel/files/{{ $file->id }}/delete"
                        class="delete-action btn btn-sm btn-transparent text-gray">
                        <i data-feather="trash-2" class="mr-10 cursor-pointer" height="20"></i>
                    </a>
                @endif
                @if (!empty($file))
                    <i class="collapse-chevron-icon" data-feather="chevron-down" height="20"
                        href="#collapseFile{{ !empty($file) ? $file->id : 'record' }}"
                        aria-controls="collapseFile{{ !empty($file) ? $file->id : 'record' }}"
                        data-parent="#chapterContentAccordion{{ !empty($chapter) ? $chapter->id : '' }}" role="button"
                        data-toggle="collapse" aria-expanded="true"></i>
                @else
                    {{-- trash icon here --}}
                    <button type="button" class="btn btn-sm btn-transparent text-gray cancel-accordion">
                        <i data-feather="trash-2" class="mr-10 cursor-pointer" height="20"></i>
                    </button>
                @endif
            </div>
        </div>

        <div id="collapseFile{{ !empty($file) ? $file->id : 'record' }}"
            aria-labelledby="file_{{ !empty($file) ? $file->id : 'record' }}"
            class=" collapse @if (empty($file)) show @endif" role="tabpanel">
            <div class="panel-collapse text-gray">
                <div class="js-content-form file-form"
                    data-action="/panel/files/{{ !empty($file) ? $file->id . '/update' : 'store' }}">
                    <input type="hidden" name="ajax[{{ !empty($file) ? $file->id : 'new' }}][webinar_id]"
                        value="{{ !empty($webinar) ? $webinar->id : '' }}">
                    <input type="hidden" name="ajax[{{ !empty($file) ? $file->id : 'new' }}][chapter_id]"
                        value="{{ !empty($chapter) ? $chapter->id : '' }}" class="chapter-input">

                    <div class="row justify-content-center d-flex">
                        @if (!empty(getGeneralSettings('content_translate')))
                            <div class="form-group">
                                <label class="input-label">{{ trans('auth.language') }}</label>
                                <select name="ajax[{{ !empty($file) ? $file->id : 'new' }}][locale]"
                                    class="form-control {{ !empty($file) ? 'js-webinar-content-locale' : '' }}"
                                    data-webinar-id="{{ !empty($webinar) ? $webinar->id : '' }}"
                                    data-id="{{ !empty($file) ? $file->id : '' }}" data-relation="files"
                                    data-fields="title">
                                    @foreach ($userLanguages as $lang => $language)
                                        <option value="{{ $lang }}"
                                            {{ (!empty($file) and !empty($file->locale)) ? (mb_strtolower($file->locale) == mb_strtolower($lang) ? 'selected' : '') : ($locale == $lang ? 'selected' : '') }}>
                                            {{ $language }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <input type="hidden" name="ajax[{{ !empty($file) ? $file->id : 'new' }}][locale]"
                                value="ar">
                        @endif

                        <div class="col-12 col-lg-7">
                            <div class="form-group js-file-path-input">

                                <label class="input-label">{{ trans('panel.upload_video') }}</label>
                                <div class="video-upload-wrapper" id="videoUploadWrapper_{{ $file->id ?? 'record' }}"
                                    onclick="document.getElementById('file_path_{{ $file->id ?? 'record' }}').click();">
                                    <video id="videoPreview_{{ $file->id ?? 'record' }}" controls class="video-preview"
                                        style="display: {{ !empty($file->file) ? 'block' : 'none' }};"
                                        src="{{ !empty($file->file) ? $file->file : '' }}"></video>
                                    <div id="videoPlaceholder_{{ $file->id ?? 'record' }}" class="video-placeholder"
                                        style="display: {{ !empty($file->file) ? 'none' : 'flex' }};">
                                        <i data-feather="video" width="40" height="40"></i>
                                    </div>
                                </div>
                                <input type="file" name="ajax[{{ $file->id ?? 'new' }}][file_path]"
                                    id="file_path_{{ $file->id ?? 'record' }}" class="d-none js-ajax-file_path"
                                    accept="video/*" onchange="previewVideo(event, '{{ $file->id ?? 'record' }}')">
                                @error('video_path')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label class="input-label">{{ trans('public.title') }}</label>
                                <input type="text" name="ajax[{{ !empty($file) ? $file->id : 'new' }}][title]"
                                    class="js-ajax-title form-control" value="{{ !empty($file) ? $file->title : '' }}"
                                    placeholder="{{ trans('update.maximum_255_characters') }}" />
                                <div class="invalid-feedback"></div>
                            </div>
                            <div id="uploadProgressBar"
                                style="width: 0%; background-color: green; color: white; height: 20px; text-align: center; border-radius:8px">
                            </div>
                            <div id="uploadProgressText" style="text-align: center; margin-top: 5px;"></div>
                            <div class="d-flex align-items-center">
                                <button type="button"
                                    class="js-save-file btn btn-sm btn-primary">{{ trans('public.save') }}</button>
                                @if (empty($file))
                                    <button type="button"
                                        class="btn btn-sm btn-danger ml-10 cancel-accordion">{{ trans('public.close') }}</button>
                                @endif
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </li>
@endif
@push('scripts_bottom')
    <script>
        var filePathPlaceHolderBySource = {
            upload: '{{ trans('update.file_source_upload_placeholder') }}',
            youtube: '{{ trans('update.file_source_youtube_placeholder') }}',
            vimeo: '{{ trans('update.file_source_vimeo_placeholder') }}',
            external_link: '{{ trans('update.file_source_external_link_placeholder') }}',
            google_drive: '{{ trans('update.file_source_google_drive_placeholder') }}',
            dropbox: '{{ trans('update.file_source_dropbox_placeholder') }}',
            iframe: '{{ trans('update.file_source_iframe_placeholder') }}',
            s3: '{{ trans('update.file_source_s3_placeholder') }}',
        }
    </script>
    <script>
        function previewVideo(event, fileId) {
            const file = event.target.files[0];
            const videoPreview = document.getElementById('videoPreview_' + fileId);
            const videoPlaceholder = document.getElementById('videoPlaceholder_' + fileId);

            if (file) {
                const fileURL = URL.createObjectURL(file);
                videoPreview.src = fileURL;
                videoPreview.style.display = 'block';
                videoPlaceholder.style.display = 'none';
            } else {
                videoPreview.style.display = 'none';
                videoPlaceholder.style.display = 'flex';
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            const videoPreview = document.getElementById('videoPreview');
            const videoPlaceholder = document.getElementById('videoPlaceholder');
            if (videoPreview.src) {
                videoPreview.style.display = 'block';
                videoPlaceholder.style.display = 'none';
            }
        });
    </script>
@endpush

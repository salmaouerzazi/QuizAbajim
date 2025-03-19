@push('styles_top')
    <link rel="stylesheet" href="/assets/vendors/summernote/summernote-bs4.min.css">
    <style>
        .image-upload-wrapper {
            width: 100%;
            height: 240px;
            border: 2px dashed #ccc;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            cursor: pointer;
            background-color: #f9f9f9;
            border-radius: 8px;
        }

        .image-placeholder {
            display: flex;
            justify-content: center;
            align-items: center;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #ccc;
        }

        .image-preview {
            display: none;
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
        }

        .toggle-button {
            border-radius: 50%;
            padding: 5px;
            background-color: #f9f9f9;
            widows: 30px;
            border: none;

        }

        .toggle-button:hover {
            background-color: #ccc;

        }

        .edit-button {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 5px;
            background-color: #f9f9f9;
            widows: 30px;
        }


        .form-control {
            font-size: 16px !important;
        }

        .input-label {
            font-size: 18px !important;
        }

        .panel-header {
            transition: background-color 0.3s ease;
        }

        .collapse-content {
            background-color: white;
        }

        .image-upload-wrapper.is-invalid {
            border-color: red;
        }

        .invalid-feedback {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }

        .section-title {
            font-size: 24px;
        }
    </style>
@endpush

<div class="panel-shadow m-20 rounded-sm">

    @if (empty($webinar))
        <h1 class="section-title text-center mb-10 font-30 p-30">
            {{ trans('panel.create_new_webinar') }}
        </h1>
    @endif

    @if (!empty($webinar))
        <div class="p-30 d-flex rounded-sm align-items-center justify-content-between panel-header"
            style="background-color: {{ $materialColors[$webinar->material->name] ?? '#000' }}">
            <h1 class="section-title">
                {{ $webinar->title }}
            </h1>
            <button type="button" class="toggle-button edit-button" style="padding: 10px" data-toggle="collapse"
                data-target="#editWebinarCollapse" aria-expanded="false" aria-controls="editWebinarCollapse">
                <i class="collapse-chevron-icon feather-chevron-down text-gray" height="20"
                    data-feather="chevron-down"></i>
            </button>
        </div>
    @endif
    <div class="collapse @if (empty($webinar)) show collapse-content @endif" id="editWebinarCollapse">
        <div class="row">
            @if (!empty(getGeneralSettings('content_translate')))
                <div class="form-group">
                    <label class="input-label">{{ trans('auth.language') }}</label>
                    <select name="locale" class="custom-select {{ !empty($webinar) ? 'js-edit-content-locale' : '' }}">
                        @foreach ($userLanguages as $lang => $language)
                            <option value="{{ $lang }}" @if (mb_strtolower(request()->get('locale', app()->getLocale())) == mb_strtolower($lang)) selected @endif>
                                {{ $language }}
                                {{ (!empty($definedLanguage) and is_array($definedLanguage) and in_array(mb_strtolower($lang), $definedLanguage)) ? '(' . trans('public.content_defined') . ')' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @else
                <input type="hidden" name="locale" value="{{ getDefaultLocale() }}">
            @endif
            <div class="col-12 col-lg-6">
                <div class="col-12 col-lg-9 mb-30">
                    <div class="form-group mt-15">
                        <label class="input-label">{{ trans('panel.webinar_title') }}</label>
                        <input type="text" name="title" id="webinarTitle"
                            value="{{ (!empty($webinar) and !empty($webinar->translate($locale))) ? $webinar->translate($locale)->title : old('title') }}"
                            class="form-control @error('title')  is-invalid @enderror" placeholder="" />
                        @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-12 col-lg-9 mb-30">
                    <div class="form-group mt-15">
                        <label class="input-label">{{ trans('public.level') }}</label>
                        <select class="form-control @error('level_id') is-invalid @enderror" id="level_id"
                            name="level_id" onchange="fetchMaterials()">
                            <option disabled selected>{{ trans('public.sort_by_level') }}</option>
                            <option value="">{{ trans('public.all') }}</option>
                            @if (!empty($levels))
                                @foreach ($levels as $level)
                                    <option value="{{ $level->id }}"
                                        {{ old('level_id', $webinar->level_id ?? '') == $level->id ? 'selected' : '' }}>
                                        {{ $level->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('level_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-lg-9 mb-30">
                    <div class="form-group mt-15">
                        <label class="input-label">{{ trans('public.material_or_field') }}
                            {{ trans('public.level_then_material') }}
                        </label>
                        <select class="form-control @error('material_id') is-invalid @enderror" id="material_id"
                            name="material_id" disabled>
                            <option value="" disabled selected>{{ trans('public.material') }}</option>
                            <option value="">{{ trans('public.all') }}</option>
                            @if (!empty($materials))
                                @foreach ($materials as $material)
                                    <option value="{{ $material->id }}"
                                        {{ old('matiere_id', $webinar->matiere_id ?? '') == $material->id ? 'selected' : '' }}>
                                        {{ $material->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('material_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div id="subMaterialWrapper"
                    style="display: {{ !empty($webinar) && !empty($webinar->submaterial_id) ? 'block' : 'none' }};"
                    class="col-12 col-lg-9 mb-30">
                    <div class="form-group mt-15">
                        <label class="input-label">{{ trans('public.submaterial') }}</label>
                        <select class="form-control @error('submaterial_id') is-invalid @enderror" id="submaterial_id"
                            name="submaterial_id">
                            <option value="" disabled>{{ trans('public.select_submaterial') }}</option>
                            @if (!empty($submaterials))
                                @foreach ($submaterials as $submaterial)
                                    <option value="{{ $submaterial->id }}"
                                        {{ old('submaterial_id', $webinar->submaterial_id ?? '') == $submaterial->id ? 'selected' : '' }}>
                                        {{ $submaterial->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('submaterial_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="form-group mt-15">
                    <label class="input-label">{{ trans('public.cover_image') }}</label>
                    <div class="image-upload-wrapper @error('image_cover') is-invalid @enderror" id="coverImageWrapper"
                        onclick="document.getElementById('coverImageInput').click();">
                        <img id="coverImagePreview" accept="image/*"
                            src="{{ !empty($webinar->image_cover) ? '/store/' . $webinar->image_cover : '/assets/default/images/default-image.svg' }}"
                            alt="Cover Image" class="image-preview"
                            style="display: {{ !empty($webinar->image_cover) ? 'block' : 'none' }};">
                        <div id="placeholderIcon" class="image-placeholder"
                            style="display: {{ !empty($webinar->image_cover) ? 'none' : 'flex' }};">
                            <i data-feather="image" width="40" height="40"></i>
                        </div>
                    </div>
                    @error('image_cover')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <input type="file" name="image_cover" id="coverImageInput" class="d-none" accept="image/*"
                        onchange="previewCoverImage(event)">
                </div>

            </div>

        </div>
        @if (empty($webinar))
            <div class="create-webinar-footer d-flex align-items-center justify-content-end p-20">
                <button type="button" id="saveAsDraft"
                    class=" btn btn-sm btn-primary">{{ trans('panel.save_and_continue') }}</button>
            </div>
        @endif
    </div>
</div>

@if (!empty($webinar))
    <section class="p-20 panel-shadow bg-white rounded-sm m-20">
        <div class="d-flex m-10" style="justify-content: space-between">
            <button type="button" class="js-add-chapter btn btn-primary btn-sm mt-15"
                data-webinar-id="@if (!empty($webinar)) {{ $webinar->id }} @endif"
                @if (empty($webinar)) disabled @endif
                style="@if (empty($webinar)) cursor: not-allowed; @endif">{{ trans('public.new_course') }}</button>
        </div>
        @include('web.default.panel.webinar.create_includes.accordions.chapter')
    </section>


    <div id="newFileForm" class="d-none">
        @include('web.default.panel.webinar.create_includes.accordions.file')
    </div>

    @if (getFeaturesSettings('new_interactive_file'))
        <div id="newInteractiveFileForm" class="d-none">
            @include('web.default.panel.webinar.create_includes.accordions.new_interactive_file', [])
        </div>
    @endif
    @include('web.default.panel.webinar.create_includes.chapter_modal')
@endif

@push('scripts_bottom')
    <script src="/assets/vendors/summernote/summernote-bs4.min.js"></script>
    <script>
        var videoDemoPathPlaceHolderBySource = {
            upload: '{{ trans('update.file_source_upload_placeholder') }}',
            youtube: '{{ trans('update.file_source_youtube_placeholder') }}',
            vimeo: '{{ trans('update.file_source_vimeo_placeholder') }}',
            external_link: '{{ trans('update.file_source_external_link_placeholder') }}',
        }
    </script>
    <script src="/assets/default/vendors/select2/select2.min.js"></script>
    <script src="/assets/default/vendors/daterangepicker/daterangepicker.min.js"></script>
    <script src="/assets/vendors/summernote/summernote-bs4.min.js"></script>
    <script src="/assets/default/vendors/sortable/jquery-ui.min.js"></script>

    <script>
        var requestFailedLang = '{{ trans('public.request_failed') }}';
        var thisLiveHasEndedLang = '{{ trans('update.this_live_has_been_ended') }}';
        var saveSuccessLang = '{{ trans('webinars.success_store') }}';
        var quizzesSectionLang = '{{ trans('quiz.quizzes_section') }}';
    </script>

    <script src="/assets/default/js/panel/quiz.min.js"></script>
    <script>
        function previewCoverImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('coverImagePreview');
                var placeholderIcon = document.getElementById('placeholderIcon');
                output.src = reader.result;
                output.style.display = 'block';
                placeholderIcon.style.display = 'none';
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        document.addEventListener("DOMContentLoaded", function() {
            const levelSelect = document.getElementById("level_id");
            const materialSelect = document.getElementById("material_id");
            const subMaterialWrapper = document.getElementById("subMaterialWrapper");
            const subMaterialSelect = document.getElementById("submaterial_id");

            const oldLevelId = {!! json_encode(old('level_id', $webinar->level_id ?? '')) !!};
            const oldMaterialId = {!! json_encode(old('matiere_id', $webinar->matiere_id ?? '')) !!};
            const oldSubmaterialId = {!! json_encode(old('submaterial_id', $webinar->submaterial_id ?? '')) !!};
            const hasWebinar = {!! json_encode(!empty($webinar)) !!};

            if (oldLevelId) {
                levelSelect.value = oldLevelId;
                materialSelect.disabled = false;
                fetchMaterials(oldLevelId, oldMaterialId, oldSubmaterialId);
            } else if (hasWebinar) {
                levelSelect.value = {!! json_encode($webinar->level_id ?? '') !!};
                materialSelect.disabled = false;
                const levelId = {!! json_encode($webinar->level_id ?? '') !!};
                if (levelId) {
                    fetchMaterials(levelId, {!! json_encode($webinar->matiere_id ?? '') !!}, {!! json_encode($webinar->submaterial_id ?? '') !!});
                }
            } else {
                materialSelect.disabled = true;
            }

            levelSelect.addEventListener("change", function() {
                const levelId = this.value;
                materialSelect.disabled = levelId === "";
                if (levelId) {
                    fetchMaterials(levelId);
                } else {
                    materialSelect.innerHTML =
                        '<option value="" disabled selected>{{ trans('public.material') }}</option>';
                    subMaterialWrapper.style.display = "none";
                    subMaterialSelect.innerHTML = "";
                }
            });

            function fetchMaterials(levelId, selectedMaterialId = '', selectedSubmaterialId = '') {
                fetch(`/get-materials-by-level/${levelId}`)
                    .then(response => response.json())
                    .then(data => {
                        populateMaterialSelect(data, selectedMaterialId);

                        if (selectedMaterialId) {
                            const selectedMaterialOption = materialSelect.querySelector(
                                `option[value="${selectedMaterialId}"]`);
                            if (selectedMaterialOption) {
                                handleMaterialChange(data, selectedMaterialOption, selectedSubmaterialId);
                            }
                        } else {
                            subMaterialWrapper.style.display = "none";
                            subMaterialSelect.innerHTML = "";
                        }

                        materialSelect.addEventListener("change", materialSelectChangeHandler);

                    })
                    .catch(error => console.error("Error fetching materials:", error));
            }

            function populateMaterialSelect(materials, selectedMaterialId = '') {
                materialSelect.innerHTML =
                    '<option value="" disabled selected>{{ trans('public.material') }}</option>';
                materialSelect.innerHTML += '<option value="">{{ trans('public.all') }}</option>';

                materials.forEach(material => {
                    const isSelected = material.id == selectedMaterialId ? 'selected' : '';
                    materialSelect.innerHTML +=
                        `<option value="${material.id}" data-has-submaterials="${material.submaterials.length > 0}" ${isSelected}>${material.name}</option>`;
                });
            }

            function handleMaterialChange(materials, selectedOption, selectedSubmaterialId = '') {
                const hasSubmaterials = selectedOption.getAttribute("data-has-submaterials") === "true";
                if (hasSubmaterials) {
                    const selectedMaterialId = selectedOption.value;
                    const selectedMaterialData = materials.find(material => material.id == selectedMaterialId);
                    const submaterials = selectedMaterialData.submaterials;
                    populateSubMaterialSelect(submaterials, selectedSubmaterialId);
                } else {
                    subMaterialWrapper.style.display = "none";
                    subMaterialSelect.innerHTML = "";
                }
            }

            function populateSubMaterialSelect(submaterials, selectedSubmaterialId = '') {
                subMaterialWrapper.style.display = "block";
                subMaterialSelect.innerHTML =
                    '<option value="" disabled selected>{{ trans('public.select_submaterial') }}</option>';
                submaterials.forEach(submaterial => {
                    const isSelected = submaterial.id == selectedSubmaterialId ? 'selected' : '';
                    subMaterialSelect.innerHTML +=
                        `<option value="${submaterial.id}" ${isSelected}>${submaterial.name}</option>`;
                });
            }

            function materialSelectChangeHandler() {
                const selectedOption = materialSelect.options[materialSelect.selectedIndex];
                const selectedMaterialId = selectedOption.value;
                const levelId = levelSelect.value;

                fetch(`/get-materials-by-level/${levelId}`)
                    .then(response => response.json())
                    .then(data => {
                        handleMaterialChange(data, selectedOption);
                    })
                    .catch(error => console.error("Error fetching submaterials:", error));
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const editButton = document.querySelector('.toggle-button.edit-button');
            const collapseElement = document.getElementById('editWebinarCollapse');
            const collapseTextShow = editButton.querySelector('.collapse-text-show');
            const collapseTextHide = editButton.querySelector('.collapse-text-hide');
            const chevronIcon = editButton.querySelector('.chevron-icon');

            collapseElement.addEventListener('show.bs.collapse', function() {
                collapseTextShow.classList.add('d-none');
                collapseTextHide.classList.remove('d-none');
                chevronIcon.classList.remove('fa-chevron-down');
                chevronIcon.classList.add('fa-chevron-up');
            });

            collapseElement.addEventListener('hide.bs.collapse', function() {
                collapseTextShow.classList.remove('d-none');
                collapseTextHide.classList.add('d-none');
                chevronIcon.classList.remove('fa-chevron-up');
                chevronIcon.classList.add('fa-chevron-down');
            });

            if (collapseElement.classList.contains('show')) {
                collapseTextShow.classList.add('d-none');
                collapseTextHide.classList.remove('d-none');
                chevronIcon.classList.remove('fa-chevron-down');
                chevronIcon.classList.add('fa-chevron-up');
            } else {
                collapseTextShow.classList.remove('d-none');
                collapseTextHide.classList.add('d-none');
                chevronIcon.classList.remove('fa-chevron-up');
                chevronIcon.classList.add('fa-chevron-down');
            }
        });
    </script>
@endpush

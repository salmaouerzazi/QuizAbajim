@extends(getTemplate().'.panel.layouts.panel_layout')
@section('content')

    <style>
        .disabled-nav {
            pointer-events: none;
            opacity: 0.5;
        }
        .overlay-behind {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1040;
            display: none;
        }
        .overlay-above {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1060;
            display: none;
        }
        .checkbox-button {
            display: inline-block;
            margin-right: 15px;
            margin-top: 10px;
            font-size: 14px!important;
        }
        .checkbox-button label {
            margin-left: 5px;
        }
        .level-section {
            margin-bottom: 20px;
        }
        .level-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .materials-container {
            display: flex;
            flex-wrap: wrap;
        }
    </style>

    <div class="container">
        <div class="row login-container">
            <div class="col-12 col-md-9">
                <div class="login-card">
                    <h1 class="font-20 font-weight-bold">{{ trans('site.become_instructorstep2') }}</h1>
                    <form method="Post" action="/become-instructor" class="mt-15">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label style="font-weight: 600!important;" class="js-instructor-label text-dark-blue {{ !$isInstructorRole ? 'd-none' : '' }}">{{ trans('site.level') }}</label>
                            <label class="js-organization-label font-weight-500 text-dark-blue {{ !$isOrganizationRole ? 'd-none' : '' }}">{{ trans('update.organization_occupations') }}</label>
                            <div class="mt-5">
                                @foreach($levels as $level)
                                    <div class="level-section">
                                        <div class="row align-items-center">
                                            <div class="col-2.8">
                                                <div class="level-title">{{ $level->name }} : </div>
                                                <input type="checkbox" name="levels[]" id="checkbox-level-{{ $level->id }}" value="{{ $level->id }}" hidden>
                                            </div>
                                            <div class="col-9.2 materials-container">
                                                @foreach($level->sectionsmat as $sectionMat)
                                                    @foreach($sectionMat->uniqueMaterials as $material)
                                                        <div class="checkbox-button">
                                                            <input type="checkbox" name="materials[]" class="material-checkbox" data-level-id="{{ $level->id }}" id="checkbox-material-{{ $material->id }}" value="{{ $material->id }}">
                                                            <label for="checkbox-material-{{ $material->id }}">{{ $material->name }}</label>
                                                        </div>
                                                    @endforeach
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block mt-5">{{ (!empty(getRegistrationPackagesGeneralSettings('show_packages_during_registration')) and getRegistrationPackagesGeneralSettings('show_packages_during_registration')) ? trans('webinars.next') : trans('site.send_request') }}</button>
                    </form>
                </div>
            </div>
            <div class="col-12 col-md-3 pl-0">
                <img style="height: 70%!important;" src="{{ getPageBackgroundSettings('become_instructor') }}" class="img-cover" alt="Login">
            </div>
        </div>
    </div>
@endsection

@push('scripts_bottom')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script src="/assets/default/js/parts/become_instructor.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Enable the behind overlay
            var behindOverlay = document.getElementById('overlay-behind');
            behindOverlay.style.display = 'block';
            var container = document.querySelector('.container');
            container.addEventListener('click', function(event) {
                event.stopPropagation();
            });
            var aboveOverlay = document.getElementById('overlay-above');
            document.getElementById('your-button-id').addEventListener('click', function() {
                aboveOverlay.style.display = 'block';
            });
            function disableOverlays() {
                behindOverlay.style.display = 'none';
                aboveOverlay.style.display = 'none';
            }
            document.getElementById('your-submit-button-id').addEventListener('click', disableOverlays);
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.material-checkbox').on('change', function() {
                var levelId = $(this).data('level-id');
                var allMaterialsInLevel = $('.material-checkbox[data-level-id="' + levelId + '"]');
                var isAnyMaterialSelected = allMaterialsInLevel.is(':checked');
                $('#checkbox-level-' + levelId).prop('checked', isAnyMaterialSelected);
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function disableNavigation() {
                var sidebar = document.querySelector('.sidebar');
                var navbar = document.querySelector('.navbar');
                if (sidebar) {
                    sidebar.classList.add('disabled-nav');
                }
                if (navbar) {
                    navbar.classList.add('disabled-nav');
                }
            }
            function enableNavigation() {
                var sidebar = document.querySelector('.sidebar');
                var navbar = document.querySelector('.navbar');
                if (sidebar) {
                    sidebar.classList.remove('disabled-nav');
                }
                if (navbar) {
                    navbar.classList.remove('disabled-nav');
                }
            }
            disableNavigation();
            document.getElementById('your-activation-button-id').addEventListener('click', enableNavigation);
        });
    </script>
@endpush

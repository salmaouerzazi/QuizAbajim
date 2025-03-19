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
        background: rgba(0, 0, 0, 0.5);
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
        display: flex;
        align-items: center;
        margin-right: 15px;
        margin-top: 10px;
        font-size: 14px !important;
    }

    .checkbox-button label {
        margin-left: 5px;
    }

    .level-section {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .level-title {
        font-size: 14px;
        font-weight: bold;
        margin-right: 15px;
        margin-bottom: 0;
    }

    .materials-container {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 15px;
    }
</style>

<section class="mt-30">
    <div class="container">
        <div class="row login-container">
            <div class="col-12 col-md-9">
                <div class="login-card">
                    <form method="POST" id="submitFormButton" class="mt-15">
                        <input type="hidden" name="currentStep" value="{{ $currentStep }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label class="font-weight-600 text-dark-blue">{{ trans('site.level') }}</label>
                            <div class="mt-5">
                                @foreach ($levels as $level)
                                    <div class="level-section">
                                        <input type="checkbox" name="occupationsll[]" hidden
                                            id="checkbox-level-{{ $level->id }}" value="{{ $level->id }}"
                                            {{ in_array($level->id, $selectedLevels) ? 'checked' : '' }}>

                                        <div class="level-title">{{ $level->name }}:</div>

                                        <div class="materials-container">
                                            @foreach ($level->sectionsmat as $sectionMat)
                                                @foreach ($sectionMat->uniqueMaterials as $material)
                                                    <div class="checkbox-button">
                                                        <input type="checkbox" name="occupations[{{ $level->id }}][]"
                                                            id="checkbox-material-{{ $material->id }}"
                                                            value="{{ $material->id }}"
                                                            {{ in_array($material->id, $selectedMaterials) ? 'checked' : '' }}>
                                                        <label
                                                            for="checkbox-material-{{ $material->id }}">{{ $material->name }}</label>
                                                    </div>
                                                @endforeach
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@push('scripts_bottom')
    <script>
        $(document).ready(function() {
            $('input[name="occupationsll[]"]').on('change', function() {
                var selectedLevels = $('input[name="occupationsll[]"]:checked').map(function() {
                    return this.value;
                }).get();

                if (selectedLevels.length > 0) {
                    $('.js-instructor-label').removeClass('d-none').addClass('d-block');
                } else {
                    $('.js-instructor-label').removeClass('d-block').addClass('d-none');
                }

                $.ajax({
                    url: '/get-matieres-by-levels',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        levels: selectedLevels
                    },
                    dataType: 'json',
                    success: function(data) {
                        $('#matiere-container').empty();
                        $.each(data, function(index, matiere) {
                            var checkboxId = 'checkbox-matiere-' + matiere.id;
                            var checkbox = $('<input />', {
                                type: 'checkbox',
                                id: checkboxId,
                                name: 'occupations[]',
                                value: matiere.id
                            });
                            var label = $('<label />', {
                                for: checkboxId,
                                text: matiere.name
                            });
                            var div = $('<div />', {
                                class: 'checkbox-button mr-15 mt-10 font-14'
                            }).append(checkbox).append(label);

                            $('#matiere-container').append(div);
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            var submitBtn = document.getElementById('saveData');
            var form = document.getElementById('userSettingForm');
            var nextBtn = document.getElementById('getNextStep');

            submitBtn.addEventListener('click', function() {
                var shouldChangeAction = true;

                if (shouldChangeAction) {
                    form.action = '/become-instructor/setting';
                }

                form.submit();
            });
        });
    </script>
@endpush

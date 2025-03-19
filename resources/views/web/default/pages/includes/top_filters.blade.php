@php
$materialColors = [
    'العربية' => '#FFB3BA',
    'رياضيات' => '#8EACCD',
    'الإيقاظ العلمي' => '#A0937D',
    'الفرنسية' => '#A6B37D',
    'المواد الاجتماعية' => '#F6D7A7',
    'الإنجليزية' => '#BAABDA',
];
@endphp

<style>
    *{
        font-family: 'Tajawal', sans-serif!important;
    }
    .materials-tabs {
        display: flex;
        gap: 10px;
        overflow-x: auto;
    }

    .material-tab {
        padding: 10px 20px;
        border: none;
        background-color: #f0f0f0;
        cursor: pointer;
        transition: background-color 0.3s, color 0.3s;
        color: #000;
        border-radius: 10px;
        margin: 5px

    }

    .material-tab:hover,
    .material-tab.active {
        color: #fff;
        transform: scale(1.15);
    }
</style>

<style>
    @foreach ($material as $m)
        @php
            $materialClass = 'material-' . \Illuminate\Support\Str::slug($m->name);
            $color = $materialColors[$m->name] ?? '#007bff';
        @endphp

        .{{ $materialClass }}:hover,
        .{{ $materialClass }}.active {
            background-color: {{ $color }};
        }
    @endforeach
</style>

<div id="topFilters" class="row shadow-lg border border-gray300 rounded-sm p-20 mt-sm-50 mt-0">
    <form method="get" class="row" id="filterForm">
        <div class="col-12 col-lg-8 col-md-6">
            <div class="materials-tabs">
                @foreach ($material as $m)
                    @php
                        $materialClass = 'material-' . \Illuminate\Support\Str::slug($m->name);
                    @endphp
                    <button type="button"
                        class="material-tab {{ $materialClass }} {{ request()->get('material_name') == $m->name ? 'active' : '' }}"
                        data-material="{{ $m->name }}">
                        {{ $m->name }}
                    </button>
                @endforeach
            </div>
        </div>
        <input type="hidden" name="material_name" id="material_name" value="{{ request()->get('material_name') }}">
        <div class="col-12 col-lg-4 col-md-12 mt-5">
            <div class="form-group">
                <div class="input-group">
                    <input type="text" style="font-size:16px!important;" class="form-control" placeholder="{{ trans('panel.search_course') }}"
                        name="search" value="{{ request()->get('search') }}">
                    <span class="input-group-text bg-transparent border-0">
                        <i class="fas fa-search text-white"></i>
                    </span>
                </div>
            </div>
        </div>
    </form>
</div>
@push('scripts_bottom')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('input[name="search"]');
            if (searchInput) {
                let debounceTimer;
                searchInput.addEventListener('keyup', function() {
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(() => {
                        const form = this.closest('form');
                        if (form) {
                            form.submit();
                        } else {
                            console.error("Form not found when submitting from search input.");
                        }
                    }, 2000);
                });
            }

            const materialTabs = document.querySelectorAll('.material-tab');
            materialTabs.forEach(tab => {
                tab.addEventListener('click', function(event) {
                    event.preventDefault();
                    const materialNameInput = document.getElementById('material_name');
                    if (materialNameInput) {
                        materialNameInput.value = this.getAttribute('data-material');
                    } else {
                        console.error("Material name input not found.");
                        return;
                    }
                    document.querySelectorAll('.material-tab').forEach(t => t.classList.remove('active'));
                    this.classList.add('active');

                    const form = materialNameInput.closest('form');
                    if (form) {
                        form.submit();
                    } else {
                        console.error("Form not found when submitting from material tab.");
                    }
                });
            });
        });
    </script>
@endpush

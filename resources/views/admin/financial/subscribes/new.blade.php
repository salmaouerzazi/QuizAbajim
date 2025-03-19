@extends('admin.layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ trans('admin/main.new_subscribe') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="/admin/">{{ trans('admin/main.dashboard') }}</a></div>
            <div class="breadcrumb-item">{{ trans('admin/main.subscribes') }}</div>
        </div>
    </div>

    <div class="section-body card">
        <div class="d-flex align-items-center justify-content-between">
            <div class="">
                <h2 class="section-title ml-4">{{ !empty($subscribe) ? trans('admin/main.edit') : trans('admin/main.create') }}</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card-body">
                    <form action="/admin/financial/subscribes/{{ !empty($subscribe) ? $subscribe->id.'/update' : 'store' }}" method="Post">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label>{{ trans('admin/main.title') }}</label>
                            <input type="text" name="title"
                                   class="form-control @error('title') is-invalid @enderror"
                                   value="{{ !empty($subscribe) ? $subscribe->title : old('title') }}"/>
                            @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>{{ trans('admin/main.short_description') }} ({{ trans('admin/main.optional') }})</label>
                            <input type="text" name="description"
                                   class="form-control"
                                   value="{{ !empty($subscribe) ? $subscribe->description : old('description') }}"
                                   placeholder="{{ trans('admin/main.short_description_placeholder') }}"/>
                        </div>

                        <div class="form-group">
                            <label>{{ trans('admin/main.usable_count') }}</label>
                            <input type="text" name="usable_count"
                                   class="form-control @error('usable_count') is-invalid @enderror"
                                   value="{{ !empty($subscribe) ? $subscribe->usable_count : old('usable_count') }}"/>
                            @error('usable_count')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>{{ trans('admin/main.days') }}</label>
                            <input type="text" name="days"
                                   class="form-control @error('days') is-invalid @enderror"
                                   value="{{ !empty($subscribe) ? $subscribe->days : old('days') }}"/>
                            @error('days')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
  <div class="form-group">
        <label for="level_ids">Select Levels</label>
        <select name="level_ids[]" id="level_ids" class="form-control @error('level_ids') is-invalid @enderror" multiple>
            @foreach ($levels as $level)
                <option value="{{ $level->id }}" {{ in_array($level->id, old('level_ids', [])) ? 'selected' : '' }}>
                    {{ $level->name }}
                </option>
            @endforeach
        </select>
        @error('level_ids')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div id="prices-container"></div> <!-- Container for dynamic price inputs -->


                        {{-- <div class="form-group">
                            <label>{{ trans('admin/main.price') }}</label>
                            <input type="text" name="price"
                                class="form-control @error('price') is-invalid @enderror"
                                value="{{ !empty($subscribeLevelByPrice) ? $subscribeLevelByPrice->price : old('price') }}"/>
                            @error('price')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div> --}}

                        <div class="form-group mt-15">
                            <label class="input-label">{{ trans('admin/main.icon') }}</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="button" class="input-group-text admin-file-manager" data-input="icon" data-preview="holder">
                                        <i class="fa fa-chevron-up"></i>
                                    </button>
                                </div>
                                <input type="text" name="icon" id="icon" value="{{ !empty($subscribe->icon) ? $subscribe->icon : old('icon') }}" class="form-control @error('icon') is-invalid @enderror"/>
                                @error('icon')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                                <div class="input-group-append">
                                    <button type="button" class="input-group-text admin-file-view" data-input="icon">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="form-group custom-switches-stacked">
                            <label class="custom-switch pl-0">
                                <input type="hidden" name="is_popular" value="0">
                                <input type="checkbox" name="is_popular" id="isPopular" value="1" {{ (!empty($subscribe) and $subscribe->is_popular) ? 'checked="checked"' : '' }} class="custom-switch-input"/>
                                <span class="custom-switch-indicator"></span>
                                <label class="custom-switch-description mb-0 cursor-pointer" for="isPopular">{{ trans('admin/pages/financial.is_popular') }}</label>
                            </label>
                        </div>

                        <!-- Hidden Field for Access Date -->
                            <div class="form-group">
                                <label for="access_date">{{ trans('admin/main.access_date') }}</label>
                                <input type="date" name="access_date"
                                    class="form-control @error('access_date') is-invalid @enderror"
                                    value="{{ !empty($subscribeAccess) ? $subscribeAccess->access_date : old('access_date') }}"/>
                                @error('access_date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        <div class="mt-4">
                            <button class="btn btn-primary">{{ trans('admin/main.submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('scripts_bottom')
<script>
    // JavaScript to dynamically add price input fields when levels are selected
    const levelSelect = document.getElementById('level_ids');
    const pricesContainer = document.getElementById('prices-container');

    levelSelect.addEventListener('change', function () {
        // Clear any existing price fields
        pricesContainer.innerHTML = '';

        // Create a price input for each selected level
        Array.from(levelSelect.selectedOptions).forEach((option) => {
            const levelId = option.value;
            const levelName = option.textContent;

            // Create a new price field for this level
            const priceField = document.createElement('div');
            priceField.classList.add('form-group');
            priceField.innerHTML = `
                <label for="price_${levelId}">Price for ${levelName}</label>
                <input type="text" name="prices[]" id="price_${levelId}" class="form-control" placeholder="Enter price for ${levelName}" required>
            `;
            pricesContainer.appendChild(priceField);
        });
    });
</script>

@endpush

@extends(getTemplate() . '.panel.layouts.panel_layout')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/daterangepicker/daterangepicker.min.css">
@endpush

@section('content')
    <section class="mt-35">
        <div class="d-flex align-items-start align-items-md-center justify-content-between flex-column flex-md-row">
            <ul class="nav nav-tabs" id="materialTabs" style="margin-bottom: 0;border-bottom:none;">
                @foreach ($materials as $index => $material)
                    <li class="nav-item">
                        <a href="{{ route('panel.meeting.all', ['material_id' => $material->id]) }}"
                            class="nav-link {{ request()->input('material_id') == $material->id ? 'active' : '' }}"
                            style="margin:10px">
                            {{ $material->name }}
                        </a>
                    </li>
                @endforeach
            </ul>

            <div class="d-flex align-items-center mt-20 mt-md-0 p-16">
                <input type="text" id="search_input" class="form-control"
                    placeholder="{{ trans('public.search_meeting') }}"
                    style="background-image: url('/assets/default/img/search-icon.png');background-repeat: no-repeat;background-position: left 10px center;background-size: 20px;margin-left:10px">

                <input type="text"
                    style="background-image: url('/assets/default/img/calendar.png');background-repeat: no-repeat;background-position: left 10px center;background-size: 30px;"
                    placeholder="{{ trans('public.select_date') }}" id="date_range_picker" class="form-control">
            </div>
        </div>

        <div class="row mt-30">
            @if ($reserveMeetings->count() > 0)
                @foreach ($reserveMeetings as $meeting)
                    <div class="col-12 col-md-6 col-lg-4 mt-15">
                        <div class="meeting-card">
                            <img src="{{ $meeting->image }}" alt="{{ $meeting->title }}" class="meeting-image">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    {{-- if avatar not empty --}}
                                    @if (!empty($meeting->creator->avatar))
                                        <img src="{{ $meeting->creator->avatar }}" alt="{{ $meeting->creator->full_name }}"
                                            class="creator-avatar">
                                    @endif
                                    <h3 class="meeting-title">{{ $meeting->title }}</h3>
                                </div>
                                <p class="meeting-time">{{ $meeting->time }}</p>
                                <p class="meeting-date">{{ $meeting->date }}</p>
                                <span class="badge badge-primary">{{ $meeting->stars }} stars</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12">
                    <div class="text-center">
                        <img src="/assets/default/img/coming-soon.gif" style="max-width: 400px;" alt="No Data">
                        <p class="mt-15">
                            {{ trans('public.no_meeting') }}
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/daterangepicker/moment.min.js"></script>
    <script src="/assets/default/vendors/daterangepicker/daterangepicker.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#date_range_picker').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                }
            });

            $('#date_range_picker').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format(
                    'MM/DD/YYYY'));
            });

            $('#date_range_picker').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });

            $('#search_input').on('input', function() {
                var query = $(this).val().toLowerCase();
                $(".meeting-card").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(query) > -1)
                });
            });
        });
    </script>
@endpush

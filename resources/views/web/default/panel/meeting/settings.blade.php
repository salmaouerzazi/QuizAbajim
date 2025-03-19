@extends(getTemplate() . '.panel.layouts.panel_layout')

@push('styles_top')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/assets/default/css/meeting.css">
@endpush

@section('content')
    <section class="mt-20 ml-25">
        <div class="d-flex align-items-center justify-content-between">
            <h2 class="section-title">{{ trans('panel.my_timesheet') }}</h2>
            <button class="btn btn-primary btn-sm add-time webinar-actions" id="openAddEventSwal">
                + {{ trans('public.add_meeting') }}
            </button>
        </div>

        <div class="d-flex align-items-center justify-content-between mt-3">
            <div>
                <button type="button" id="today-button" class="btn btn-sm btn-primary">
                    {{ trans('public.today') }}
                </button>
                <button type="button" id="previous-week-button" class="btn btn-sm btn-outline-secondary ml-2">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button type="button" id="next-week-button" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
            <div>
                <h3 id="month-year" class="text-primary mb-0"></h3>
            </div>
        </div>

        <div class="panel-section-card time-sheet py-20 px-25 mt-20">
            <div class="calendar-container">
                <div class="calendar-grid" id="calendarGrid">

                    @foreach(config('constants.DAYS') as $index => $day)
                        <div class="day-header d-flex flex-column justify-content-center align-items-center"
                             style="grid-column: {{ $index+2 }}; grid-row: 1;">
                            {{ trans('panel.'.$day) }}
                            <span class="text-gray font-12" id="day-header-{{ $index }}"></span>
                        </div>
                    @endforeach

                    @php
                        $startHour = 7;
                        $endHour   =  24;    
                        $totalRows = ($endHour - $startHour);
                    @endphp

                    @for($h = $startHour; $h < $endHour; $h++)
                        <div class="hour-label"
                            style="grid-column: 1; grid-row: {{ $h - $startHour + 2 }};">
                            {{ $h.':00' }}
                        </div>
                    @endfor


                    @foreach(config('constants.DAYS') as $colIndex => $day)
                        @for($rowIndex = 0; $rowIndex < $totalRows; $rowIndex++)
                            <div class="day-cell"
                                 style="grid-column: {{ $colIndex+2 }}; grid-row: {{ $rowIndex+2 }};">
                            </div>
                        @endfor
                    @endforeach
                </div>
            </div>

            <div class="d-flex align-items-center flex-row-reverse flex-md-row justify-content-end justify-content-md-end mt-20">
                <label class="mb-0 mr-10 cursor-pointer font-10 text-gray font-weight-500" for="temporaryDisableMeetingsSwitch">
                    {{ trans('panel.temporary_disable_meetings') }}
                </label>
                <div class="custom-control custom-switch">
                    <input type="checkbox" name="disabled" class="custom-control-input"
                           id="temporaryDisableMeetingsSwitch" {{ $meeting->disabled ? 'checked' : '' }}>
                    <label class="custom-control-label" for="temporaryDisableMeetingsSwitch"></label>
                </div>
            </div>
        </div>
    </section>

    <h4 hidden class="font-16 text-gray font-weight-bold">{{ trans('update.in_person_group_meeting_options') }}</h4>
@endsection

@push('scripts_bottom')
<script src="/assets/default/js/panel/meeting/meeting.js"></script>

<script>
    const materialColors = @json($materialColors);
    window.levels       = @json($levels);
    window.matieres     = @json($matieres);
    window.submaterials = @json($submaterials);

    var saveLang               = '{{ trans('public.save') }}';
    var closeLang              = '{{ trans('public.close') }}';
    var successDeleteTime      = '{{ trans('meeting.success_delete_time') }}';
    var errorDeleteTime        = '{{ trans('meeting.error_delete_time') }}';
    var successSavedTime       = '{{ trans('meeting.success_save_time') }}';
    var errorSavingTime        = '{{ trans('meeting.error_saving_time') }}';
    var noteToTimeMustGreater  = '{{ trans('meeting.note_to_time_must_greater_from_time') }}';
    var requestSuccess         = '{{ trans('public.request_success') }}';
    var requestFailed          = '{{ trans('public.request_failed') }}';
    var saveMeetingSuccessLang = '{{ trans('meeting.save_meeting_setting_success') }}';
    var meetingTypeLang        = '{{ trans('update.meeting_type') }}';
    var inPersonLang           = '{{ trans('update.in_person') }}';
    var onlineLang             = '{{ trans('update.online') }}';
    var bothLang               = '{{ trans('update.both') }}';
    var level                  = '{{ trans('public.level') }}';
    var matiere                = '{{ trans('public.matiere') }}';
    var descriptionLng         = '{{ trans('public.description') }}';
    var min_students           = '{{ trans('public.min_students') }}';
    var max_students           = '{{ trans('public.max_students') }}';
    window.translations = {
        choose_material: "{{ trans('panel.choose_material') }}",
        choose_submaterial: "{{ trans('panel.choose_submaterial') }}",
        choose_level: "{{ trans('panel.choose_level') }}",
        level: "{{ trans('panel.level') }}",
        material: "{{ trans('panel.material') }}",
        submaterial: "{{ trans('panel.submaterial') }}",
        price: "{{ trans('panel.price') }}",
        discount: "{{ trans('panel.discount') }}",
        discount_from_date: "{{ trans('panel.discount_from_date') }}",
        discount_to_date: "{{ trans('panel.discount_to_date') }}",
        from_time: "{{ trans('panel.from_time') }}",
        to_time: "{{ trans('panel.to_time') }}",
        min_puiples: "{{ trans('panel.min_puiples') }}",
        max_puiples: "{{ trans('panel.max_puiples') }}",
        download_files: "{{ trans('panel.download_files') }}",
        for_one_month: "{{ trans('panel.for_one_month') }}",
        saveLang: "{{ trans('public.save') }}",
        closeLang: "{{ trans('public.close') }}",
        deleteAlertSuccess: "{{ trans('meeting.success_delete_time') }}",
        successSavedTime: "{{ trans('meeting.success_save_time') }}",
        errorSavingTime: "{{ trans('meeting.error_saving_time') }}",
        noteToTimeMustGreater: "{{ trans('meeting.note_to_time_must_greater_from_time') }}",
        requestSuccess: "{{ trans('public.request_success') }}",
        requestFailed: "{{ trans('public.request_failed') }}",
        deleteAlertTitle: "{{ trans('public.are_you_sure') }}",
        deleteAlertHint: "{{ trans('public.deleteAlertHint') }}",
        deleteAlertConfirm: "{{ trans('public.deleteAlertConfirm') }}",
        deleteAlertCancel: "{{ trans('public.deleteAlertCancel') }}",
        successDeleteTime: "{{ trans('meeting.success_delete_time') }}",
        errorDeleteTime: "{{ trans('meeting.error_delete_time') }}",
        deleteAlertFail: "{{ trans('public.request_failed') }}",
        saveMeetingSuccessLang: "{{ trans('meeting.save_meeting_setting_success') }}",
        next: "{{ trans('public.next') }}",
        prev: "{{ trans('public.prev')}}",
        savable: "{{ trans('public.savable') }}",
        meet_date: "{{trans('public.meet_date')}}",
        step_one: "{{trans('public.step_one')}}",
        step_two: "{{trans('public.step_two')}}",
        step_three: "{{trans('public.step_three')}}",
    };
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var currentDate    = new Date();
    var currentWeekDay = currentDate.getDay();

    var firstDayWeek = new Date(currentDate.setDate(currentDate.getDate() - ((currentWeekDay + 6) % 7)));
    var lastDayWeek  = new Date(firstDayWeek);
    lastDayWeek.setDate(firstDayWeek.getDate() + 6);

    function formatMonth(month) {
        var monthNames = <?php echo json_encode(config('constants.MONTHS')); ?>;
        return monthNames[month] || month;
    }

    function updateWeekRangeDisplay() {
        var startMonth = formatMonth(firstDayWeek.toLocaleString('en-us', { month: 'long' }));
        var endMonth   = formatMonth(lastDayWeek.toLocaleString('en-us', { month: 'long' }));
        var startDay   = firstDayWeek.getDate();
        var endDay     = lastDayWeek.getDate();
        var year       = firstDayWeek.getFullYear();

        if (startMonth === endMonth) {
            document.getElementById('month-year').innerText = `${startMonth} ${year}`;
        } else {
            document.getElementById('month-year').innerText = `${startMonth} - ${endMonth} ${year}`;
        }
    }

    function updateCalendar(weekDates, meetingTimesData) {
    const calendarGrid = document.getElementById('calendarGrid');
    calendarGrid.querySelectorAll('.calendar-event').forEach(el => el.remove());

    const rowHeight = 60;
    const startHour = 7; 
    const weekDatesArray = Object.keys(weekDates);
    meetingTimesData.forEach(meeting => {
        const meetingDate = new Date(meeting.meet_date * 1000).toISOString().split('T')[0];
        const columnIndex = weekDatesArray.indexOf(meetingDate);

        if (columnIndex === -1) return;

        const startDate = new Date(meeting.start_time * 1000);
        const endDate = new Date(meeting.end_time * 1000);

        const startHour = startDate.getHours();
        const startMin = startDate.getMinutes();
        const endHour = endDate.getHours();
        const endMin = endDate.getMinutes();

        console.log('startHour', startHour);
        console.log('startMin', startMin);
        console.log('endHour', endHour);
        console.log('endMin', endMin);
        
        const startOffsetHours = (startHour + startMin / 60) - 7; 
        const endOffsetHours = (endHour + endMin / 60) - 7;

        console.log('startOffsetHours', startOffsetHours);
        console.log('endOffsetHours', endOffsetHours);


        const topOffsetPx = startOffsetHours * rowHeight + 60;
        const eventHeightPx = (endOffsetHours - startOffsetHours) * rowHeight;

        const eventDiv = document.createElement('div');
        eventDiv.classList.add('calendar-event');
        eventDiv.style.gridColumnStart = columnIndex + 2;
        eventDiv.style.gridColumnEnd = columnIndex + 3;
        eventDiv.style.top = `${topOffsetPx}px`;
        eventDiv.style.height = `${eventHeightPx}px`;
        eventDiv.style.backgroundColor = materialColors[meeting.material.name] || '#1d3b65';

        const eventTitle = document.createElement('div');
        eventTitle.classList.add('event-title');
        eventTitle.textContent = `${meeting.material.name} (${meeting.level.name})`;

        const timeLabel = document.createElement('div');
        timeLabel.classList.add('event-time');
        timeLabel.textContent = `${startDate.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })} - ${endDate.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}`;

        eventDiv.appendChild(eventTitle);
        eventDiv.appendChild(timeLabel);

        calendarGrid.appendChild(eventDiv);
    });
}

    function updateDayHeaders() {
        const dayHeaders = document.querySelectorAll('[id^="day-header-"]');
        const weekStartDate = new Date(firstDayWeek);
        dayHeaders.forEach((header, index) => {
            const currentDate = new Date(weekStartDate);
            currentDate.setDate(firstDayWeek.getDate() + index);
            const formattedDate = currentDate.toLocaleDateString('en-GB', { day: '2-digit', month: '2-digit' });
            header.textContent = formattedDate;
        });
    }

    function fetchAndRenderWeekly() {
    $.ajax({
        url: '{{ route('meeting_setting_weekly') }}',
        method: 'GET',
        data: {
            start_date: firstDayWeek.toISOString().split('T')[0],
            end_date: lastDayWeek.toISOString().split('T')[0]
        },
        success: function (response) {
            const meetingTimes = response.meeting.meeting_times || [];
            updateWeekRangeDisplay();
            updateDayHeaders();
            updateCalendar(response.weekDates, meetingTimes);
        },
        error: function (xhr, status, error) {
            console.error('Error fetching data:', error);
        }
    });
}

    document.getElementById('next-week-button').addEventListener('click', function() {
        firstDayWeek.setDate(firstDayWeek.getDate() + 7);
        lastDayWeek = new Date(firstDayWeek);
        lastDayWeek.setDate(firstDayWeek.getDate() + 6);
        fetchAndRenderWeekly();
    });

    document.getElementById('previous-week-button').addEventListener('click', function() {
        firstDayWeek.setDate(firstDayWeek.getDate() - 7);
        lastDayWeek = new Date(firstDayWeek);
        lastDayWeek.setDate(firstDayWeek.getDate() + 6);
        fetchAndRenderWeekly();
    });

    document.getElementById('today-button').addEventListener('click', function() {
        currentDate    = new Date();
        currentWeekDay = currentDate.getDay();
        firstDayWeek   = new Date(currentDate.setDate(currentDate.getDate() - ((currentWeekDay + 6) % 7)));
        lastDayWeek    = new Date(firstDayWeek);
        lastDayWeek.setDate(firstDayWeek.getDate() + 6);
        fetchAndRenderWeekly();
    });

    updateWeekRangeDisplay();
    updateDayHeaders();
    fetchAndRenderWeekly();


});

</script>
@endpush

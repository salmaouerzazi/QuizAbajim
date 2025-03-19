@php
    $canReserve = false;
    if (
        !empty($instructor->meeting) and
        !$instructor->meeting->disabled and
        !empty($instructor->meeting->meetingTimes) and
        $instructor->meeting->meeting_times_count > 0
    ) {
        $canReserve = true;
    }
@endphp

<div
    class="rounded-lg shadow-sm mt-25 p-20 course-teacher-card instructors-list text-center d-flex align-items-center flex-column position-relative">
    {{-- @if (!empty($instructor->meeting) and $instructor->meeting->disabled)
        <span class="px-15 py-10 bg-gray off-label text-white font-12">{{ trans('public.unavailable') }}</span>
    @endif --}}

    <a href="{{ $instructor->getProfileUrl() }}"
        class="text-center d-flex flex-column align-items-center justify-content-center">
        <div class=" teacher-avatar mt-5 position-relative">
            <img src="{{ $instructor->getAvatar(190) }}" class="img-cover" alt="{{ $instructor->full_name }}">
            @if ($instructor->offline)
                <span class="user-circle-badge unavailable d-flex align-items-center justify-content-center">
                    <i data-feather="slash" width="20" height="20" class="text-white"></i>
                </span>
            @elseif($instructor->verified)
                <span class="user-circle-badge has-verified d-flex align-items-center justify-content-center">
                    <i data-feather="check" width="20" height="20" class="text-white"></i>
                </span>
            @endif
        </div>

        <h3 class="mt-20 font-16 font-weight-bold text-dark-blue text-center">{{ $instructor->full_name }}</h3>
    </a>

    <div class="mt-20 d-flex flex-row align-items-center justify-content-center w-100">
        <a href="{{ $instructor->getProfileUrl() }}" class="btn btn-primary btn-block">
            {{-- @if ($canReserve)
                {{ trans('public.reserve_a_meeting') }}
            @else --}}
                {{ trans('public.view_profile') }}
            {{-- @endif --}}
        </a>
    </div>
</div>

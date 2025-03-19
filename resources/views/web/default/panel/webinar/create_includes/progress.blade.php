@php
    $progressSteps = [
        1 => [
            'name' => 'basic_information',
            'icon' => 'paper',
        ],

        4 => [
            'name' => 'content',
            'icon' => 'folder',
        ],

        5 => [
            'name' => 'prerequisites',
            'icon' => 'video',
        ],
    ];

    $currentStep = empty($currentStep) ? 1 : $currentStep;
@endphp


<div class="webinar-progress d-block d-lg-flex align-items-center p-20 panel-shadow bg-white rounded-sm m-20">
    @foreach ($progressSteps as $key => $step)
        <div class="progress-item d-flex align-items-center">
            <button type="button" data-step="{{ $key }}"
                class="js-get-next-step p-0 border-0 progress-icon p-10 d-flex align-items-center justify-content-center rounded-circle {{ $key == $currentStep ? 'active' : '' }}"
                data-toggle="tooltip" data-placement="top" title="{{ trans('public.' . $step['name']) }}">
                <img src="/assets/default/img/icons/{{ $step['icon'] }}.svg" class="img-cover" alt="">
            </button>

            <div class="ml-10 {{ $key == $currentStep ? '' : 'd-lg-none' }}">
                <span
                    class="font-14 text-gray">{{ trans('webinars.progress_step', ['step' => $key, 'count' => 8]) }}</span>
                <h4 class="font-16 text-secondary font-weight-bold">{{ trans('public.' . $step['name']) }}</h4>
            </div>
        </div>
    @endforeach
</div>

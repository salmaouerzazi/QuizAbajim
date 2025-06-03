@php
    $icon = '';
    $hintText = '';

    if ($type == \App\Models\WebinarChapter::$chapterSession) {
        $icon = 'video';
        $hintText = dateTimeFormat($item->date, 'j M Y  H:i') . ' | ' . $item->duration . ' ' . trans('public.min');
    } elseif ($type == \App\Models\WebinarChapter::$chapterFile) {
        $hintText = $item->file_type . ($item->volume > 0 ? ' | ' . $item->volume : '');

        $icon = $item->getIconByType();
    } elseif ($type == \App\Models\WebinarChapter::$chapterTextLesson) {
        $icon = 'file-text';
        $hintText = $item->study_time . ' ' . trans('public.min');
    }

    $checkSequenceContent = $item->checkSequenceContent();
    $sequenceContentHasError =
        (!empty($checkSequenceContent) and
        (!empty($checkSequenceContent['all_passed_items_error']) or
            !empty($checkSequenceContent['access_after_day_error'])));
@endphp
@php
    $controllerAction = request()->route()->getActionName();
@endphp

<div class=" d-flex align-items-start p-10 cursor-pointer {{ (!empty($checkSequenceContent) and $sequenceContentHasError) ? 'js-sequence-content-error-modal' : 'tab-item' }}"
    data-type="{{ $type }}" data-id="{{ $item->id }}"
    data-passed-error="{{ !empty($checkSequenceContent['all_passed_items_error']) ? $checkSequenceContent['all_passed_items_error'] : '' }}"
    data-access-days-error="{{ !empty($checkSequenceContent['access_after_day_error']) ? $checkSequenceContent['access_after_day_error'] : '' }}">

    <span class="chapter-icon bg-gray300 mr-10">
        <i data-feather="{{ $icon }}" class="text-gray" width="16" height="16"></i>
    </span>

    <div>
        <div class="">
            <span class="font-weight-500 font-14 text-dark-blue d-block">{{ $item->title }}</span>
            <span class="font-12 text-gray d-block">{{ $hintText }}</span>
        </div>


        <div class="tab-item-info mt-15">
            <p class="font-12 text-gray d-block">
                @php
                    $description = !empty($item->description)
                        ? $item->description
                        : (!empty($item->summary)
                            ? $item->summary
                            : '');
                @endphp

                {!! truncate($description, 150) !!}
            </p>

            <div class="d-flex align-items-center justify-content-between mt-15">
                <label class="mb-0 mr-10 cursor-pointer font-weight-normal font-14 text-dark-blue"
                    for="readToggle{{ $type }}{{ $item->id }}">{{ trans('public.i_passed_this_lesson') }}</label>
                <div class="custom-control custom-switch">
                    <input type="checkbox" @if ($sequenceContentHasError) disabled @endif
                        id="readToggle{{ $type }}{{ $item->id }}" data-item-id="{{ $item->id }}"
                        data-item="{{ $type }}_id" value="{{ $item->webinar_id }}"
                        class="js-passed-lesson-toggle custom-control-input"
                        @if (!empty($item->learningStatus)) checked @endif>
                    {{-- {{ $item->learningStatus->user_id }} --}}
                    <label class="custom-control-label"
                        for="readToggle{{ $type }}{{ $item->id }}"></label>
                </div>
            </div>



        </div>
    </div>

</div>
{{-- @foreach ($item->chapter->quiz as $quiz)
    <a href="{{ route('panel.quiz.do', $quiz->id) }}" class="d-flex align-items-start p-10 cursor-pointer text-decoration-none">
        <span class="chapter-icon bg-gray300 mr-10">
            <i data-feather="file-text" class="text-gray" width="16" height="16"></i>
        </span>
        <span class="font-12 text-dark-blue d-block">{{ $quiz->title }}</span>
    </a>
@endforeach --}}
{{-- @foreach ($item->chapter->quiz as $quiz)
    <div class="d-flex align-items-start p-10 cursor-pointer {{ (!empty($checkSequenceContent) and $sequenceContentHasError) ? 'js-sequence-content-error-modal' : 'tab-item' }}"
         data-type="quiz"
         data-id="{{ $quiz->id }}"
         data-passed-error="{{ !empty($checkSequenceContent['all_passed_items_error']) ? $checkSequenceContent['all_passed_items_error'] : '' }}"
         data-access-days-error="{{ !empty($checkSequenceContent['access_after_day_error']) ? $checkSequenceContent['access_after_day_error'] : '' }}">

        <span class="chapter-icon bg-gray300 mr-10">
            <i data-feather="file-text" class="text-gray" width="16" height="16"></i>
        </span>

        <div>
            <span class="font-weight-500 font-14 text-dark-blue d-block">{{ $quiz->title }}</span>
            <span class="font-12 text-gray d-block">{{ $quiz->description ? truncate($quiz->description, 150) : '' }}</span>
        </div>
    </div>
@endforeach --}}
@foreach ($item->chapter->quiz as $quiz)
    @php
        $lastAttempt = \App\Models\QuizAttemptScore::where('quiz_id', $quiz->id)
            ->where('child_id', auth()->id())
            ->latest('attempt_number')
            ->first();
        if ($lastAttempt) {
            $score = $lastAttempt->score;
            $total = $lastAttempt->score_total;
            $noteSur20 = round(($score / $total) * 20, 2);
            $pourcentage = round(($score / $total) * 100);
            $badgeColor = $pourcentage >= 80 ? 'success' : ($pourcentage >= 50 ? 'warning' : 'danger');
        }
    @endphp
    <div class="d-flex align-items-start justify-content-between p-10 cursor-pointer {{ (!empty($checkSequenceContent) and $sequenceContentHasError) ? 'js-sequence-content-error-modal' : 'tab-item' }}"
        data-type="quiz" data-id="{{ $quiz->id }}"
        data-passed-error="{{ !empty($checkSequenceContent['all_passed_items_error']) ? $checkSequenceContent['all_passed_items_error'] : '' }}"
        data-access-days-error="{{ !empty($checkSequenceContent['access_after_day_error']) ? $checkSequenceContent['access_after_day_error'] : '' }}">

        <div class="d-flex align-items-start">
            <span class="chapter-icon bg-gray300 mr-10">
                <i data-feather="file-text" class="text-gray" width="16" height="16"></i>
            </span>

            <div>
                <span class="font-weight-500 font-14 text-dark-blue d-block">{{ $quiz->title }}</span>
                <span
                    class="font-12 text-gray d-block">{{ $quiz->description ? truncate($quiz->description, 150) : '' }}</span>
            </div>
        </div>
        @if ($lastAttempt)
            <div class="d-flex align-items-center">
                <span class="badge badge-{{ $badgeColor }} font-12">
                    {{ $pourcentage }}%
                </span>
                <button type="button" class="btn btn-sm btn-primary ml-auto"
                    onclick="event.stopPropagation(); event.preventDefault();
                fetchLastAttempt({{ $quiz->id }})">
                    عرض النتيجة
                </button>
            </div>
        @endif
    </div>
@endforeach

<div class="modal fade" id="resultModal" tabindex="-1" role="dialog" aria-labelledby="resultModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content" id="modalResultContent">
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function fetchLastAttempt(quizId) {
        fetch(`/panel/child/quiz/${quizId}/last-attempt`)
            .then(response => {
                if (!response.ok) throw new Error('لم يتم العثور على محاولة سابقة.');
                return response.text();
            })
            .then(html => {
                document.getElementById('modalResultContent').innerHTML = html;
                const modal = new bootstrap.Modal(document.getElementById('resultModal'));
                modal.show();
            })
            .catch(error => {
                alert(error.message);
            });
    }
</script>

@forelse ($quizzes as $quiz)
    <div class="col-md-4 mb-4 quiz-card-wrapper" data-level="{{ $quiz->level->name ?? '' }}"
        data-material="{{ $quiz->material->name ?? '' }}">
        <div class="card quiz-card rounded-4 shadow-sm position-relative"
            onclick="window.location.href='{{ route('panel.quiz.edit', $quiz->id) }}'">
            <div class="card-body text-center bg-lightblue rounded-bottom-4">
                <h6 class="quiz-title fw-bold text-dark mb-1" title="انقر لتعديل العنوان"
                    onclick="event.stopPropagation(); enableTitleEdit(this)" data-id="{{ $quiz->id }}">
                    {{ $quiz->title ?: 'تحدي جديد' }}
                </h6>
                <small class="text-muted d-block mb-2">عدد الأسئلة: {{ $quiz->questions->count() ?? 0 }}</small>
                <div class="d-flex flex-column align-items-center gap-1">
                    <span class="badge bg-warning text-dark">{{ $quiz->material->name ?? 'بدون مادة' }}</span>
                    <span class="badge bg-light border">{{ $quiz->level->name ?? 'بدون مستوى' }}</span>
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="col-12 text-center mt-4">
        <div class="alert alert-warning">🔍 لا يوجد أي اختبار يطابق البحث.</div>
    </div>
@endforelse

{{-- Pagination AJAX --}}
<div class="col-12 d-flex justify-content-center mt-4">
    {{ $quizzes->appends(request()->only('search'))->links('vendor.pagination.custom') }}
</div>

<div id="quizWrapper" class="row col-12 mt-4">
    @php
        $colors = [
            'العربية' => '#FFB3BA',
            'رياضيات' => '#8EACCD',
            'الإيقاظ العلمي' => '#A0937D',
            'الفرنسية' => '#A6B37D',
            'المواد الاجتماعية' => '#F6D7A7',
            'الإنجليزية' => '#BAABDA',
        ];
    @endphp

    @forelse ($quizzes as $quiz)
        @php
            $materialName = $quiz->material->name ?? 'بدون مادة';
            $levelName = $quiz->level->name ?? 'بدون مستوى';
            $materialColor = $colors[$materialName] ?? '#ffc107';
        @endphp

        <div class="col-md-4 col-12 mb-4 quiz-card-wrapper" data-level="{{ $levelName }}"
            data-material="{{ $materialName }}" data-statues="{{ $quiz->status }}">
            <div class="card quiz-card rounded-4 shadow-sm position-relative"
                onclick="window.location.href='{{ route('panel.quiz.edit', $quiz->id) }}'">
                <div class="quiz-status-badge {{ $quiz->status === 'published' ? 'published' : 'draft' }}">
                    {{ $quiz->status === 'published' ? 'منشور' : 'مسودة' }}
                </div>
                <div class="card-body text-center bg-lightblue rounded-bottom-4">
                    <h6 class="quiz-title fw-bold text-dark mb-1" title="انقر لتعديل العنوان"
                        onclick="event.stopPropagation(); enableTitleEdit(this)" data-id="{{ $quiz->id }}">
                        {{ $quiz->title ?: 'تحدي جديد' }}
                    </h6>
                    <small class="text-muted d-block mb-2">عدد الأسئلة: {{ $quiz->questions->count() ?? 0 }}</small>
                    <div class="d-flex justify-content-center align-items-center" style="gap: 5px;">
                        <span class="badge text-dark" style="background-color: {{ $materialColor }};">
                            {{ $materialName }}
                        </span>
                        <span class="badge bg-light border">{{ $levelName }}</span>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center mt-4">
            <div class="alert alert-warning">🔍 لا يوجد أي اختبار يطابق البحث.</div>
        </div>
    @endforelse

    <div class="col-12 d-flex justify-content-center mt-4">
        {{ $quizzes->appends(request()->only('search'))->links('vendor.pagination.custom') }}
    </div>
</div>

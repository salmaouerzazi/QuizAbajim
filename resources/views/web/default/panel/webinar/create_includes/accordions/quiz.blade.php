@php
    $colors = [
        'العربية' => '#FFB3BA',
        'رياضيات' => '#8EACCD',
        'الإيقاظ العلمي' => '#A0937D',
        'الفرنسية' => '#A6B37D',
        'المواد الاجتماعية' => '#F6D7A7',
        'الإنجليزية' => '#BAABDA',
    ];

    $materialName = $quizInfo->material->name ?? 'بدون مادة';
    $levelName = $quizInfo->level->name ?? 'بدون مستوى';
    $materialColor = $colors[$materialName] ?? '#ffc107';
@endphp

<div class="col-12 mb-3 quiz-card-wrapper" data-level="{{ $levelName }}"
    data-material="{{ $materialName }}" >

    <div class="card rounded-4 shadow-sm border d-flex flex-row align-items-center justify-content-between p-3"
        style="cursor: pointer; border-color: #eee; transition: 0.3s ease;" 
        onclick="window.location.href='{{ route('panel.quiz.edit', $quizInfo->id) }}'">

        {{-- LEFT SIDE (icon + title + info) --}}
        <div class="d-flex align-items-center" style="gap: 20px;">

            {{-- Icon --}}
            <div class="d-flex align-items-center justify-content-center rounded-circle bg-primary text-white"
                style="width: 50px; height: 50px; font-size: 22px;">
                🎲
            </div>

            {{-- Info --}}
            <div>
                {{-- Title --}}
                <h5 class="fw-bold text-dark mb-2" style="font-size: 18px;" onclick="event.stopPropagation();">
                    {{ $quizInfo->title ?: 'تحدي جديد' }}
                </h5>

                {{-- Questions count --}}
                <small class="text-muted d-block mb-2">عدد الأسئلة: {{ $quizInfo->questions->count() ?? 0 }}</small>

                {{-- Level + Material --}}
                <div class="d-flex align-items-center" style="gap: 7px;">
                    <span class="badge text-dark" style="background-color: {{ $materialColor }};">
                        {{ $materialName }}
                    </span>
                    <span class="badge bg-light border">
                        {{ $levelName }}
                    </span>
                </div>
            </div>
        </div>

        {{-- RIGHT SIDE (status + delete) --}}
        <div class="d-flex flex-column align-items-end" style="gap: 10px;">

            {{-- Status --}}
           

            {{-- Delete Button --}}
            <form action="{{ route('panel.quiz.delete') }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف التحدي؟');" onclick="event.stopPropagation();">
                @csrf
                <input type="hidden" name="quiz_id" value="{{ $quizInfo->id }}">
                <button type="submit" class="btn btn-sm btn-danger rounded-pill d-flex align-items-center justify-content-center px-3 py-1">
                    <i data-feather="trash-2" style="width: 14px; height: 14px; margin-left: 5px;"></i> حذف التحدي
                </button>
            </form>

        </div>
    </div>
</div>

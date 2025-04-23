@extends('web.default.panel.layouts.panel_layout')

@section('content')
<div class="container mt-4" dir="rtl">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">تحدياتي <small class="text-muted fs-6">كل الاختبارات التي قمت بإنشائها</small></h4>
        <a href="{{ route('panel.teacher.quiz.index') }}" class="btn btn-primary px-4">+ إنشاء تحدي جديد</a>

    </div>

    {{-- Alerte si aucun quiz --}}
    @if($quizzes->isEmpty())
        <div class="alert alert-info text-center fw-bold">لا يوجد أي اختبار بعد.</div>
    @endif

    <div class="row">
        @foreach($quizzes as $quiz)
            <div class="col-md-4 mb-4">
                <div class="card quiz-card rounded-4 shadow-sm position-relative"
                    onclick="window.location.href='{{ route('panel.quiz.edit', $quiz->id) }}'">

                

                    {{-- Corps de la carte --}}
                    <div class="card-body text-center bg-lightblue rounded-bottom-4">
                        {{-- Titre modifiable dynamiquement --}}
                        <h6 class="quiz-title fw-bold text-dark mb-3" onclick="event.stopPropagation(); enableTitleEdit(this)">
                            {{ $quiz->title ?? 'تحدي بدون عنوان' }}
                        </h6>

                        {{-- Matière et Niveau --}}
                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                            <span class="badge bg-warning text-dark">{{ $quiz->material->name ?? 'بدون مادة' }}</span>
                            <span class="badge bg-light border">{{ $quiz->level->name ?? 'بدون مستوى' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

{{-- CSS personnalisé --}}
<style>
    .quiz-card {
        background-color: #cce6f7;
        cursor: pointer;
        transition: transform 0.2s ease-in-out;
    }
    .quiz-card:hover {
        transform: scale(1.02);
    }
    .bg-lightblue {
        background-color: #dff1fb;
    }
</style>

{{-- JS : titre modifiable dynamiquement --}}
<script>
    function enableTitleEdit(element) {
        const currentText = element.textContent.trim();
        const input = document.createElement('input');
        input.type = 'text';
        input.value = currentText;
        input.className = 'form-control text-center fw-bold';
        input.style = 'font-size: 1rem; margin-bottom: 10px;';
        element.replaceWith(input);
        input.focus();

        function saveTitle() {
            const newText = input.value.trim() || 'تحدي بدون عنوان';
            const h6 = document.createElement('h6');
            h6.className = 'quiz-title fw-bold text-dark mb-3';
            h6.textContent = newText;
            h6.setAttribute('onclick', 'event.stopPropagation(); enableTitleEdit(this)');
            input.replaceWith(h6);
        }

        input.addEventListener('blur', saveTitle);
        input.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                saveTitle();
            }
        });
    }
</script>
@endsection

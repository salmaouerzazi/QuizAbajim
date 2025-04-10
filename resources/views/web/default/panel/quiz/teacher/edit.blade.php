@extends('web.default.panel.layouts.panel_layout')

@section('content')
<div class="d-flex flex-column flex-md-row gap-3" dir="rtl">

    {{-- Colonne des questions --}}
    <div class="card p-3 w-100 w-md-25">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h5 class="mb-0">الأسئلة ({{ count($questions) }})</h5>
        </div>

        @foreach($questions as $index => $question)
            <div class="card p-2 mb-2 @if($currentQuestion->id === $question->id) border-primary @endif">
                <div class="d-flex justify-content-between">
                    <span>{{ $index + 1 }}. {{ Str::limit($question->title, 30) }}</span>
                    <span class="badge bg-light text-dark">{{ $question->type_label }}</span>
                </div>
            </div>
        @endforeach

        <a href="{{ route('panel.challenges.questions.create', $challenge->id) }}" class="btn btn-outline-primary mt-3 w-100">
            + إضافة سؤال آخر إلى التحدي
        </a>
    </div>

    {{-- Colonne centrale - Détail question --}}
    <div class="card p-4 flex-grow-1">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <span class="badge bg-info text-white">{{ $currentQuestion->type_label }}</span>
                <span class="ms-2 badge bg-secondary">{{ $currentQuestion->duration }} دق</span>
                <span class="ms-2 badge bg-success">{{ $currentQuestion->score }} نقاط</span>
            </div>
            <h5 class="mb-0">سؤال : {{ $currentQuestion->order }}</h5>
        </div>

        <p class="fw-bold">{{ $currentQuestion->title }}</p>

        @if($currentQuestion->type == 'multiple')
            <ul class="list-group">
                @foreach($currentQuestion->answers as $answer)
                    <li class="list-group-item d-flex justify-content-between">
                        <span>{{ $answer->text }}</span>
                        @if($answer->is_correct)
                            <span class="badge bg-success">إجابة صحيحة</span>
                        @endif
                    </li>
                @endforeach
            </ul>
            <a href="#" class="btn btn-link mt-2">+ إضافة إجابة</a>
        @elseif($currentQuestion->type == 'true_false')
            <div class="alert alert-{{ $currentQuestion->correct_answer ? 'success' : 'danger' }}">
                {{ $currentQuestion->correct_answer ? 'صحيح' : 'خطأ' }}
            </div>
        @endif
    </div>

    {{-- Colonne droite - Profil et infos utilisateur --}}
    <div class="w-100 w-md-25">
        {{-- Le contenu est déjà pris en charge par ton layout --}}
    </div>

</div>

{{-- Boutons d’action en bas --}}
<div class="d-flex justify-content-between mt-4">
    <a href="{{ route('panel.challenges.index') }}" class="btn btn-outline-secondary">العودة إلى التحديات</a>
    <button type="submit" class="btn btn-primary">حفظ</button>
</div>
@endsection

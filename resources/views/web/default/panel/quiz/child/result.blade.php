@extends(getTemplate() . '.layouts.app')

@section('content')
@php
    $score = $attempt->score;
    $total = $attempt->score_total;
    $noteSur20 = round(($score / $total) * 20, 2);
    $pourcentage = round(($score / $total) * 100);
    $badgeColor = $pourcentage >= 80 ? 'success' : ($pourcentage >= 50 ? 'warning' : 'danger');
@endphp

<div class="container mt-5" style="max-width: 800px;">
    <div class="text-center mb-4">
        <h3 class="text-primary">📊 نتيجتك</h3>
        <h4>
            <span class="badge bg-{{ $badgeColor }}" style="font-size: 1.5rem;">
                {{ $score }} / {{ $total }} | {{ $noteSur20 }}/20 | {{ $pourcentage }}%
            </span>
        </h4>
    </div>

    @foreach ($submissions as $submission)
        @php
            $question = $submission->question;
            $isCorrect = $submission->is_valid;
        @endphp

        <div class="mb-4 p-3 rounded shadow-sm" style="background-color: {{ $isCorrect ? '#d4edda' : '#f8d7da' }};">
            <h5><strong>السؤال :</strong> {{ $question->question_text }}</h5>

            @if ($question->type === 'binaire')
                <p>✅ الصحيح : <strong>{{ $question->is_valid ? 'صحيح' : 'خطأ' }}</strong></p>
                <p>🧒 إجابتك : <strong>{{ $submission->is_boolean_question ? ($submission->is_valid ? 'صحيح' : 'خطأ') : '' }}</strong>
                    {!! $isCorrect ? '✅' : '❌' !!}
                </p>

            @elseif ($question->type === 'qcm')
                @php
                    $selectedAnswer = $question->answers->firstWhere('id', $submission->answer_id);
                    $correctAnswer = $question->answers->firstWhere('is_valid', 1);
                @endphp
                <p>✅ الصحيح : <strong>{{ $correctAnswer?->answer_text }}</strong></p>
                <p>🧒 إجابتك : <strong>{{ $selectedAnswer?->answer_text }}</strong>
                    {!! $isCorrect ? '✅' : '❌' !!}
                </p>

            @elseif ($question->type === 'arrow')
                @php
                    $correctMap = $question->answers->mapWithKeys(fn($a) => [$a->answer_text => $a->matching])->toArray();
                    $userMap = is_string($submission->arrow_mapping)
                        ? json_decode($submission->arrow_mapping, true)
                        : ($submission->arrow_mapping ?? []);
                @endphp
                <p>✅ التوصيلات الصحيحة :</p>
                <ul>
                    @foreach ($correctMap as $source => $target)
                        <li><strong>{{ $source }}</strong> → {{ $target }}</li>
                    @endforeach
                </ul>
                <p>🧒 إجاباتك :</p>
                <ul>
                    @foreach ($userMap as $source => $target)
                        @php
                            $expected = $correctMap[$source] ?? null;
                            $pairCorrect = $expected === $target;
                        @endphp
                        <li style="color: {{ $pairCorrect ? 'green' : 'red' }};">
                            <strong>{{ $source }}</strong> → {{ $target }}
                            {!! $pairCorrect ? '✅' : '❌' !!}
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    @endforeach

    <div class="text-center mt-4">
        <a href="/" class="btn btn-outline-primary">🏠 العودة إلى الصفحة الرئيسية</a>
    </div>
</div>
@endsection

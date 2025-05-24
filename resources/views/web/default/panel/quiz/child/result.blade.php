@extends(getTemplate() . '.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/learning_page/styles.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" />
    <style>
        html, body {
            background: linear-gradient(135deg, #cbe4f9, #e0ecf6);
            height: auto;
            overflow-y: auto;
            min-height: 100%;
            position: relative;
        }
        
        .result-container {
            background-color: rgba(255, 255, 255, 0.85);
            border-radius: 24px;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.15);
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 30px;
            margin: 40px 0;
            direction: rtl;
            max-height: none;
            overflow: visible;
        }
        
        .result-title {
            color: #2c3e50;
            font-weight: 700;
            font-size: 32px;
            margin-bottom: 25px;
            font-family: 'Tahoma', 'Arial', sans-serif;
        }
        
        .score-badge {
            display: inline-block;
            padding: 15px 30px;
            border-radius: 50px;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            animation: fadeInDown 1s;
            font-family: 'Tahoma', 'Arial', sans-serif;
        }
        
        .score-badge.success {
            background: linear-gradient(45deg, #28a745, #5ad16f);
            color: white;
        }
        
        .score-badge.warning {
            background: linear-gradient(45deg, #ffc107, #ffda74);
            color: #212529;
        }
        
        .score-badge.danger {
            background: linear-gradient(45deg, #dc3545, #ff6b7d);
            color: white;
        }
        
        .question-card {
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            font-family: 'Tahoma', 'Arial', sans-serif;
            border-right: 5px solid;
            animation: fadeIn 0.6s;
        }
        
        .question-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        
        .question-card.correct {
            background-color: #f0fff4;
            border-right-color: #28a745;
        }
        
        .question-card.incorrect {
            background-color: #fff5f5;
            border-right-color: #dc3545;
        }
        
        .question-text {
            font-size: 1.2rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(0,0,0,0.1);
        }
        
        .answer-item {
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 8px;
            font-size: 1.1rem;
        }
        
        .correct-answer {
            background-color: rgba(40, 167, 69, 0.15);
        }
        
        .user-answer {
            background-color: rgba(0, 123, 255, 0.1);
        }
        
        .home-btn {
            background: linear-gradient(45deg, #007bff, #00c6ff);
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
            transition: all 0.3s ease;
            border: none;
            font-family: 'Tahoma', 'Arial', sans-serif;
            font-size: 1.1rem;
            margin-top: 20px;
        }
        
        .home-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 123, 255, 0.4);
        }
        
        .icon-check {
            color: #28a745;
            font-weight: bold;
        }
        
        .icon-wrong {
            color: #dc3545;
            font-weight: bold;
        }
        
        .answer-list {
            list-style-type: none;
            padding-right: 10px;
        }
        
        .answer-list li {
            padding: 8px 5px;
            border-radius: 5px;
            margin-bottom: 5px;
        }
        
        .animated-progress {
            height: 10px;
            border-radius: 5px;
            margin: 20px 0 40px 0;
            overflow: hidden;
            background-color: #e9ecef;
            position: relative;
        }
        
        .animated-progress .progress-bar {
            position: absolute;
            height: 100%;
            border-radius: 5px;
            background: linear-gradient(45deg, #007bff, #00c6ff);
            animation: progress-animation 1.5s ease-in-out;
            transition: width 1.5s ease;
        }
        
        @keyframes progress-animation {
            from { width: 0%; }
        }
        
        @media (max-width: 768px) {
            .result-container {
                padding: 20px 15px;
            }
            
            .score-badge {
                font-size: 1.2rem;
                padding: 10px 20px;
            }
            
            .question-text {
                font-size: 1.1rem;
            }
        }
    </style>
@endpush

@section('content')
@php
    $score = $attempt->score;
    $total = $attempt->score_total;
    $noteSur20 = round(($score / $total) * 20, 2);
    $pourcentage = round(($score / $total) * 100);
    $badgeColor = $pourcentage >= 80 ? 'success' : ($pourcentage >= 50 ? 'warning' : 'danger');
@endphp

<div class="container" style="max-width: 800px;">
    <div class="result-container">
        <div class="text-center">
            <h2 class="result-title animate__animated animate__fadeInDown">📊 نتيجتك في الاختبار</h2>
            <div class="score-badge {{ $badgeColor }}">
                {{ $noteSur20 }}/20 | {{ $pourcentage }}%
            </div>
            
            <div class="animated-progress">
                <div class="progress-bar" style="width: {{ $pourcentage }}%"></div>
            </div>
        </div>

    @foreach ($submissions as $submission)
        @php
            $question = $submission->question;
            $isCorrect = $submission->is_valid;
        @endphp

        <div class="question-card {{ $isCorrect ? 'correct' : 'incorrect' }}">
            <div class="question-text">
                <span class="{{ $isCorrect ? 'icon-check' : 'icon-wrong' }}">{{ $isCorrect ? '✅' : '❌' }}</span> 
                {{ $question->question_text }}
            </div>

            @if ($question->type === 'binaire')
                <div class="answer-item correct-answer">
                    <span class="icon-check">✓</span> الإجابة الصحيحة : <strong>{{ $question->is_valid ? 'صحيح' : 'خطأ' }}</strong>
                </div>
                <div class="answer-item user-answer">
                    <span class="{{ $isCorrect ? 'icon-check' : 'icon-wrong' }}">{{ $isCorrect ? '✓' : '✗' }}</span> 
                    إجابتك : <strong>{{ $submission->is_boolean_question ? ($submission->is_valid ? 'صحيح' : 'خطأ') : '' }}</strong>
                </div>

            @elseif ($question->type === 'qcm')
                @php
                    $selectedAnswer = $question->answers->firstWhere('id', $submission->answer_id);
                    $correctAnswer = $question->answers->firstWhere('is_valid', 1);
                @endphp
                <div class="answer-item correct-answer">
                    <span class="icon-check">✓</span> الإجابة الصحيحة : <strong>{{ $correctAnswer?->answer_text }}</strong>
                </div>
                <div class="answer-item user-answer">
                    <span class="{{ $isCorrect ? 'icon-check' : 'icon-wrong' }}">{{ $isCorrect ? '✓' : '✗' }}</span> 
                    إجابتك : <strong>{{ $selectedAnswer?->answer_text }}</strong>
                </div>

            @elseif ($question->type === 'arrow')
                @php
                    $correctMap = $question->answers->mapWithKeys(fn($a) => [$a->answer_text => $a->matching])->toArray();
                    $userMap = is_string($submission->arrow_mapping)
                        ? json_decode($submission->arrow_mapping, true)
                        : ($submission->arrow_mapping ?? []);
                @endphp
                <div class="answer-item correct-answer mb-3">
                    <span class="icon-check">✓</span> التوصيلات الصحيحة :
                    <ul class="answer-list">
                        @foreach ($correctMap as $source => $target)
                            <li><strong>{{ $source }}</strong> <i class="fas fa-long-arrow-alt-left"></i> {{ $target }}</li>
                        @endforeach
                    </ul>
                </div>
                
                <div class="answer-item user-answer">
                    <span class="icon-check">✓</span> إجاباتك :
                    <ul class="answer-list">
                        @foreach ($userMap as $source => $target)
                            @php
                                $expected = $correctMap[$source] ?? null;
                                $pairCorrect = $expected === $target;
                            @endphp
                            <li class="{{ $pairCorrect ? 'text-success' : 'text-danger' }}">
                            <strong>{{ $source }}</strong> <i class="fas fa-long-arrow-alt-left"></i> {{ $target }}
                            <span class="{{ $pairCorrect ? 'icon-check' : 'icon-wrong' }} ml-2">{{ $pairCorrect ? '✓' : '✗' }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    @endforeach

    <div class="text-center mt-5">
        <a href="{{ route('panel.dashboard') }}" class="home-btn">
            <i class="fas fa-home ml-2"></i> العودة إلى الصفحة الرئيسية
        </a>
    </div>
</div>
@endsection

@push('scripts_bottom')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const pourcentage = {{ $pourcentage }};
        
        // Attendre que la page soit chargée pour afficher la notification
        setTimeout(() => {
            if (pourcentage >= 80) {
                Swal.fire({
                    title: 'ممتاز!',
                    text: 'لقد أتقنت هذا الدرس بشكل رائع. يمكنك الانتقال إلى الدرس التالي!',
                    icon: 'success',
                    confirmButtonText: 'شكراً لك!',
                    confirmButtonColor: '#28a745',
                    timer: 5000
                });
            } else if (pourcentage >= 50) {
                Swal.fire({
                    title: 'تهانينا!',
                    text: 'لقد اجتزت هذا الاختبار بنجاح. واصل العمل الجيد!',
                    icon: 'success',
                    confirmButtonText: 'شكراً!',
                    confirmButtonColor: '#007bff',
                    timer: 4000
                });
            } else if (pourcentage < 20) {
                Swal.fire({
                    title: 'لا تقلق!',
                    text: 'يمكنك التعلم أكثر من خلال العودة إلى محتوى هذا الدرس والمحاولة مرة أخرى.',
                    icon: 'info',
                    confirmButtonText: 'فهمت!',
                    confirmButtonColor: '#17a2b8',
                    timer: 5000
                });
            }
        }, 1000);
    });
</script>
@endpush

@extends(getTemplate() . '.layouts.app')

@push('styles_top')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<link rel="stylesheet" href="/assets/default/learning_page/styles.css" />
<link rel="stylesheet" href="/assets/default/vendors/video/video-js.min.css">
<style>
    body {
        background: linear-gradient(to bottom right, #cbe4f9, #e0ecf6);
    }
    .leader-line {
        z-index: 1000 !important;
        pointer-events: none;
    }
    .swiper-slide {
        min-height: 320px;
        border-radius: 20px;
        background-color: #e9f5ff;
        box-shadow: 0px 10px 25px rgba(0, 0, 0, 0.07);
        padding: 30px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .form-check {
        margin-bottom: 1rem;
    }
    .form-check-input {
        display: none;
    }
    .form-check-label {
        display: block;
        background-color: #d4edff;
        border: 2px solid #90caff;
        color: #0056b3;
        padding: 12px 20px;
        border-radius: 25px;
        text-align: center;
        font-size: 1.2rem;
        font-weight: bold;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .form-check-input:checked + .form-check-label {
        background-color: #007BFF;
        color: #fff;
        border-color: #0056b3;
        transform: scale(1.05);
    }
    button.next-btn, button.prev-btn {
        background-color: #007BFF;
        color: white;
        border-radius: 30px;
        padding: 10px 30px;
        font-weight: bold;
        border: none;
        transition: 0.3s;
    }
    button.next-btn:hover, button.prev-btn:hover {
        background-color: #0056b3;
    }
    .result-slide {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
    }
    .result-slide h4 {
        color: #007BFF;
    }
    .arrow-pair {
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        margin: 15px 0;
    }
    .arrow-source, .arrow-target {
        padding: 12px;
        border: 1px solid #90caff;
        border-radius: 10px;
        background: #d4edff;
        cursor: pointer;
        transition: 0.3s;
        width: 45%;
        text-align: center;
    }
    .arrow-source.selected, .arrow-target.selected {
        background-color: #007BFF;
        color: white;
        border-color: #0056b3;
    }
</style>
@endpush


@section('content')
<div class="container mt-5" style="direction: rtl; max-width: 800px;">
    <h3 class="mb-4 text-primary text-center">📘 {{ $quiz->title }}</h3>
    <form id="quizForm" action="{{ route('panel.quiz.submit', $quiz->id) }}" method="POST">
        @csrf
        <div class="swiper-container">
            <div class="swiper-wrapper">
                @foreach ($quiz->questions as $index => $question)
                    @if ($question->type === 'arrow')
                        <div class="swiper-slide">
                            <h5 class="mb-4 text-center"><strong>السؤال {{ $index + 1 }}:</strong> {{ $question->question_text }}</h5>
                            <div id="arrow-pairs-{{ $question->id }}" style="position: relative;">
                                @foreach ($question->answers as $i => $a)
                                    <div class="arrow-pair">
                                        <div class="arrow-source" id="source-{{ $question->id }}-{{ $i }}" data-question="{{ $question->id }}" data-index="{{ $i }}" data-text="{{ $a->answer_text }}">
                                            {{ $a->answer_text }}
                                        </div>
                                        <div class="arrow-target" id="target-{{ $question->id }}-{{ $i }}" data-question="{{ $question->id }}" data-index="{{ $i }}" data-text="{{ $a->matching }}">
                                            {{ $a->matching }}
                                        </div>
                                    </div>
                                @endforeach
                                <input type="hidden" name="answers[{{ $question->id }}]" id="match-result-{{ $question->id }}">
                            </div>
                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn prev-btn">السابق</button>
                                <button type="button" class="btn next-btn">التالي</button>
                            </div>
                        </div>
                    @else
                        <div class="swiper-slide">
                            <h5><strong>السؤال {{ $index + 1 }}:</strong> {{ $question->question_text }}</h5>
                            <div class="mt-3">
                                @if ($question->type === 'qcm')
                                    @foreach ($question->answers as $a)
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" id="q{{ $question->id }}a{{ $a->id }}" value="{{ $a->id }}">
                                            <label class="form-check-label" for="q{{ $question->id }}a{{ $a->id }}">{{ $a->answer_text }}</label>
                                        </div>
                                    @endforeach
                                @elseif ($question->type === 'binaire')
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" value="true" id="true{{ $question->id }}">
                                        <label class="form-check-label" for="true{{ $question->id }}">صحيح</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" value="false" id="false{{ $question->id }}">
                                        <label class="form-check-label" for="false{{ $question->id }}">خطأ</label>
                                    </div>
                                @endif
                            </div>
                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn prev-btn">السابق</button>
                                <button type="button" class="btn next-btn">التالي</button>
                            </div>
                        </div>
                    @endif
                @endforeach
                <div class="swiper-slide result-slide">
                    <h4>🎉 تم إرسال إجاباتك!</h4>
                    <p>شكراً لك على إتمام التحدي ✅</p>
                    <a href="/" class="btn btn-outline-success mt-3">العودة إلى الصفحة الرئيسية</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts_bottom')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/leader-line-new/leader-line.min.js"></script>
    <script>
        const swiper = new Swiper(".swiper-container", {
            allowTouchMove: false,
            navigation: {
                nextEl: ".next-btn",
                prevEl: ".prev-btn",
            },
        });

        function showResult() {
            document.getElementById('quizForm').submit();
            swiper.slideNext();
        }

        document.addEventListener("DOMContentLoaded", () => {
            let selectedSource = null;
            const lines = [];
            const mappings = {};

            document.querySelectorAll('.arrow-source').forEach(source => {
                source.addEventListener('click', () => {
                    document.querySelectorAll('.arrow-source').forEach(el => el.classList.remove('selected'));
                    source.classList.add('selected');
                    selectedSource = source;
                });
            });

            document.querySelectorAll('.arrow-target').forEach(target => {
                target.addEventListener('click', () => {
                    if (selectedSource) {
                        const questionId = selectedSource.dataset.question;
                        const sourceText = selectedSource.dataset.text;
                        const targetText = target.dataset.text;
                        const resultInput = document.getElementById(`match-result-${questionId}`);

                        const line = new LeaderLine(
                            LeaderLine.areaAnchor(selectedSource, {x: '100%', y: '50%'}),
                            LeaderLine.areaAnchor(target, {x: '0%', y: '50%'}),
                            { color: '#6490ab', size: 4, startPlug: 'disc', endPlug: 'arrow3' }
                        );

                        lines.push(line);
                        mappings[sourceText] = targetText;
                        resultInput.value = JSON.stringify(mappings);

                        selectedSource.classList.remove('selected');
                        target.classList.remove('selected');
                        selectedSource = null;
                    }
                });
            });
        });
    </script>
@endpush
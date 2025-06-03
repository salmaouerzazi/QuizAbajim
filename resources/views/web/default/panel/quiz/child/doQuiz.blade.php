@extends(getTemplate() . '.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/learning_page/styles.css" />
    <link rel="stylesheet" href="/assets/default/vendors/video/video-js.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leader-line-new/leader-line.min.css" />
    <style>
        body {
            background: linear-gradient(to bottom right, #cbe4f9, #e0ecf6);
        }

        .question-slide {
            background-color: #e9f5ff;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0px 10px 25px rgba(0, 0, 0, 0.07);
            margin-bottom: 30px;
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

        .form-check-input:checked+.form-check-label {
            background-color: #007BFF;
            color: #fff;
            border-color: #0056b3;
            transform: scale(1.05);
        }

        button.next-btn,
        button.prev-btn {
            background-color: #007BFF;
            color: white;
            border-radius: 30px;
            padding: 10px 30px;
            font-weight: bold;
            border: none;
            transition: 0.3s;
        }

        button.next-btn:hover,
        button.prev-btn:hover {
            background-color: #0056b3;
        }

        .arrow-source,
        .arrow-target {
            padding: 12px;
            border-radius: 10px;
            background: #d4edff;
            cursor: pointer;
            transition: 0.3s;
            text-align: center;
            position: relative;
        }

        .arrow-source.selected,
        .arrow-target.selected,
        .arrow-source.connected {
            background-color: #007BFF;
            color: white;
        }
    </style>
@endpush

@section('content')
    <div class="container mt-5" style="direction: rtl; max-width: 900px;">
        <h3 class="mb-4 text-primary text-center">📘 {{ $quiz->title }}</h3>

        <form id="quizForm" action="{{ route('panel.quiz.submit', $quiz->id) }}" method="POST">
            @csrf

            @foreach ($quiz->questions as $index => $question)
                <div class="question-slide" id="question-{{ $index }}"
                    style="{{ $index === 0 ? '' : 'display:none;' }}">
                    <h5 class="mb-4 text-center">
                        <strong>السؤال {{ $index + 1 }}:</strong> {{ $question->question_text }}
                    </h5>

                    @if ($question->type === 'arrow')
                        @php
                            $sources = $question->answers;
                            $targets = $question->answers->pluck('matching')->shuffle();
                        @endphp
                        <div class="row justify-content-between" id="arrow-container-{{ $question->id }}"
                            style="position: relative;">
                            <div class="col-5">
                                @foreach ($sources as $i => $a)
                                    <div class="arrow-source mb-2" id="source-{{ $question->id }}-{{ $i }}"
                                        data-question="{{ $question->id }}" data-text="{{ $a->answer_text }}">
                                        {{ $a->answer_text }}
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-5">
                                @foreach ($targets as $j => $t)
                                    <div class="arrow-target mb-2" id="target-{{ $question->id }}-{{ $j }}"
                                        data-question="{{ $question->id }}" data-text="{{ $t }}">
                                        {{ $t }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <input type="hidden" name="answers[{{ $question->id }}]" id="match-result-{{ $question->id }}"
                            value="{}">
                    @elseif ($question->type === 'qcm')
                        @foreach ($question->answers as $a)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]"
                                    id="qcm_{{ $question->id }}_{{ $a->id }}" value="{{ $a->id }}">
                                <label class="form-check-label" for="qcm_{{ $question->id }}_{{ $a->id }}">
                                    {{ $a->answer_text }}
                                </label>
                            </div>
                        @endforeach
                    @elseif ($question->type === 'binaire')
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]"
                                value="true" id="true{{ $question->id }}">
                            <label class="form-check-label" for="true{{ $question->id }}">صحيح</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]"
                                value="false" id="false{{ $question->id }}">
                            <label class="form-check-label" for="false{{ $question->id }}">خطأ</label>
                        </div>
                    @endif

                    <div class="d-flex justify-content-between mt-4">
                        @if ($index > 0)
                            <button type="button" class="btn prev-btn" onclick="prevQuestion()">السابق</button>
                        @endif
                        @if ($index < count($quiz->questions) - 1)
                            <button type="button" class="btn next-btn" onclick="nextQuestion()">التالي</button>
                        @else
                            <button type="submit" class="btn btn-success">📤 إرسال الإجابات</button>
                        @endif
                    </div>
                </div>
            @endforeach
        </form>
    </div>
@endsection


@push('scripts_bottom')
    <script src="https://cdn.jsdelivr.net/npm/leader-line-new/leader-line.min.js"></script>
    <script>
        let currentIndex = 0;
        const slides = document.querySelectorAll('.question-slide');
        const mappings = {};
        const lines = {};
        let selectedSource = null;

        function showQuestion(index) {
            slides.forEach((slide, i) => {
                slide.style.display = (i === index) ? 'block' : 'none';
            });
            hideAllLines();
            const qId = getCurrentQuestionId();
            showLines(qId);
        }

        function nextQuestion() {
            if (currentIndex < slides.length - 1) {
                currentIndex++;
                showQuestion(currentIndex);
            }
        }

        function prevQuestion() {
            if (currentIndex > 0) {
                currentIndex--;
                showQuestion(currentIndex);
            }
        }

        function getCurrentQuestionId() {
            const active = document.querySelector('.question-slide[style*="display: block"] [id^="arrow-container-"]');
            return active ? active.id.replace('arrow-container-', '') : null;
        }

        function hideAllLines() {
            for (const qId in lines) {
                lines[qId]?.forEach(line => line.hide());
            }
        }

        function showLines(qId) {
            lines[qId]?.forEach(line => line.show());
        }

        function clearLinesFromSource(qId, sourceEl) {
            if (!lines[qId]) return;

            const sourceText = sourceEl.dataset.text;
            const targetText = mappings[qId]?.[sourceText];

            const updatedLines = [];

            lines[qId].forEach(line => {
                const sameSource = line.start === sourceEl;

                if (sameSource) {
                    try {
                        line.remove();
                    } catch (err) {
                        console.error("Erreur lors du remove de la ligne :", err);
                    }
                } else {
                    updatedLines.push(line);
                }
            });

            lines[qId] = updatedLines;

            if (mappings[qId]) {
                delete mappings[qId][sourceText];
            }

            sourceEl.classList.remove('connected', 'selected');

            if (targetText) {
                const targetEl = Array.from(document.querySelectorAll(`.arrow-target[data-question="${qId}"]`))
                    .find(t => t.dataset.text === targetText);
                if (targetEl) targetEl.classList.remove('connected');
            }
            const input = document.getElementById(`match-result-${qId}`);
            if (input) {
                input.value = JSON.stringify(mappings[qId] || {});
            }
        }


        function addLine(qId, sourceEl, targetEl) {
            const line = new LeaderLine({
                start: sourceEl,
                end: targetEl,
                color: '#007BFF',
                size: 3,
                path: 'straight',
            });

            if (!lines[qId]) lines[qId] = [];
            lines[qId].push(line);
            line.show();
        }

        function removeLine(qId, sourceEl, targetEl) {
            const line = lines[qId]?.find(l => l.start === sourceEl && l.end === targetEl);
            if (line) {
                line.remove();
                lines[qId] = lines[qId].filter(l => l !== line);
            }
        }

        document.addEventListener("DOMContentLoaded", () => {
            showQuestion(currentIndex);
            document.querySelectorAll('.arrow-source').forEach(source => {
                source.addEventListener('click', () => {
                    const qId = source.dataset.question;
                    //-----> Si déjà connecté, supprimer la flèche
                    if (source.classList.contains('connected')) {
                        clearLinesFromSource(qId, source);
                        selectedSource = null;
                        return;
                    }
                    //-----> Sélection d'une nouvelle source
                    document.querySelectorAll(`.arrow-source[data-question="${qId}"]`)
                        .forEach(el => el.classList.remove('selected'));
                    source.classList.add('selected');
                    selectedSource = source;
                });
            });

            document.querySelectorAll('.arrow-target').forEach(target => {
                target.addEventListener('click', () => {
                    if (!selectedSource) return;

                    const qId = selectedSource.dataset.question;
                    const sourceText = selectedSource.dataset.text;
                    const targetText = target.dataset.text;

                    //-----> Vérifie si la target est déjà utilisée
                    const usedTargets = Object.values(mappings[qId] || {});
                    if (usedTargets.includes(targetText)) {
                        alert("❌ لا يمكن ربط نفس الجواب بأكثر من سؤال.");
                        return;
                    }
                    //-----> Supprimer flèche précédente de la source
                    clearLinesFromSource(qId, selectedSource);

                    //-----> Dessiner la nouvelle flèche
                    const sourceBox = document.getElementById(
                        `source-${qId}-${selectedSource.id.split('-')[2]}`);
                    const targetBox = document.getElementById(
                        `target-${qId}-${target.id.split('-')[2]}`);
                    requestAnimationFrame(() => addLine(qId, sourceBox, targetBox));

                    //-----> Mettre à jour le mapping
                    if (!mappings[qId]) mappings[qId] = {};
                    mappings[qId][sourceText] = targetText;

                    selectedSource.classList.remove('selected');
                    selectedSource.classList.add('connected');
                    target.classList.add('connected');
                    selectedSource = null;
                    document.getElementById(`match-result-${qId}`).value = JSON.stringify(mappings[
                        qId]);
                });
            });
        });
    </script>
@endpush


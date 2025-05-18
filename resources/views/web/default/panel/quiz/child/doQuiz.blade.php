@extends(getTemplate() . '.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/learning_page/styles.css" />
    <link rel="stylesheet" href="/assets/default/vendors/video/video-js.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leader-line-new/leader-line.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" />
    <style>
        body {
            background: linear-gradient(135deg, #cbe4f9, #e0ecf6);
        }

        .quiz-container {
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 24px;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.15);
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 25px;
            transition: all 0.3s ease;
        }

        .quiz-title {
            color: #2c3e50;
            font-weight: 700;
            font-size: 28px;
            margin-bottom: 25px;
            text-shadow: 0px 2px 3px rgba(0, 0, 0, 0.1);
            position: relative;
            display: inline-block;
        }
        
        .quiz-title:after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 70%;
            height: 4px;
            background: linear-gradient(90deg, transparent, #007BFF, transparent);
            border-radius: 2px;
        }

        .progress-container {
            height: 8px;
            width: 100%;
            background-color: #e0ecf6;
            border-radius: 10px;
            margin: 20px 0;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #007BFF, #00c6ff);
            transition: width 0.5s ease;
            border-radius: 10px;
        }
        
        .progress-text {
            font-size: 14px;
            color: #6c757d;
            text-align: right;
            margin-bottom: 10px;
        }

        .question-slide {
            background-color: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0px 10px 25px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            transition: all 0.4s ease;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.5s forwards;
        }
        
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Support for RTL layout */
        body[dir="rtl"] .quiz-container,
        [dir="rtl"] .quiz-container,
        .quiz-container {
            text-align: right;
            font-family: 'Tahoma', 'Arial', sans-serif;
        }
        
        [dir="rtl"] .question-counter {
            left: 15px;
            right: auto;
        }
        
        /* Améliorer l'expérience utilisateur en langue arabe */
        [dir="rtl"] .form-check-label {
            font-family: 'Tahoma', 'Arial', sans-serif;
            font-size: 1.1rem;
            font-weight: 600;
        }
        
        [dir="rtl"] .question-text {
            line-height: 1.8;
            font-family: 'Tahoma', 'Arial', sans-serif;
            font-weight: 700;
            font-size: 1.3rem;
        }
        
        [dir="rtl"] .quiz-title {
            font-family: 'Tahoma', 'Arial', sans-serif;
            font-weight: 800;
        }
        
        [dir="rtl"] .fa-arrow-right {
            transform: rotate(180deg);
        }
        
        [dir="rtl"] .fa-arrow-left {
            transform: rotate(180deg);
        }

        .question-text {
            color: #2c3e50;
            font-weight: 600;
            font-size: 1.25rem;
            line-height: 1.5;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e9ecef;
        }

        .form-check {
            margin-bottom: 1rem;
        }

        .form-check-input {
            display: none;
        }

        .form-check-label {
            display: block;
            background-color: #f8f9fa;
            border: 2px solid #dee2e6;
            color: #495057;
            padding: 15px 20px;
            border-radius: 15px;
            text-align: center;
            font-size: 1.1rem;
            font-weight: 500;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        
        .form-check-label:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 0;
            height: 100%;
            background-color: rgba(0, 123, 255, 0.1);
            transition: width 0.3s ease;
            z-index: -1;
        }
        
        .form-check-label:hover:before {
            width: 100%;
        }

        .form-check-input:checked+.form-check-label {
            background-color: #007BFF;
            color: #fff;
            border-color: #0056b3;
            transform: scale(1.03);
            box-shadow: 0 5px 15px rgba(0, 123, 255, 0.2);
        }

        .quiz-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        
        /* Style pour les questions répondues */
        .question-slide.answered .question-counter {
            background-color: #28a745;
        }
        
        /* Animation d'entrée */
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .pulse {
            animation: pulse 0.5s ease-in-out;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 120px;
            transition: all 0.3s ease;
        }

        button.next-btn,
        button.prev-btn {
            background-color: #007BFF;
            color: white;
            border-radius: 30px;
            padding: 12px 30px;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0, 123, 255, 0.2);
        }

        button.next-btn:hover,
        button.prev-btn:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 123, 255, 0.3);
        }
        
        button.next-btn:active,
        button.prev-btn:active {
            transform: translateY(1px);
            box-shadow: 0 2px 5px rgba(0, 123, 255, 0.2);
        }
        
        .btn-success {
            background-color: #28a745;
            color: white;
            border-radius: 30px;
            padding: 12px 30px;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(40, 167, 69, 0.2);
        }
        
        .btn-success:hover {
            background-color: #218838;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(40, 167, 69, 0.3);
        }
        
        .btn-success:active {
            transform: translateY(1px);
            box-shadow: 0 2px 5px rgba(40, 167, 69, 0.2);
        }

        .arrow-source,
        .arrow-target {
            padding: 14px;
            border-radius: 12px;
            background: #f8f9fa;
            border: 2px solid #dee2e6;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            position: relative;
            margin-bottom: 12px;
        }

        .arrow-source.selected,
        .arrow-target.selected {
            background-color: #e9f5ff;
            border-color: #90caff;
            color: #0056b3;
            transform: scale(1.03);
        }
        
        .arrow-source.connected {
            background-color: #007BFF;
            color: white;
            border-color: #0056b3;
        }
        
        .question-counter {
            position: absolute;
            top: 15px;
            right: 15px;
            background-color: #007BFF;
            color: white;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: bold;
        }
        
        /* Styles pour écrans mobiles */
        @media (max-width: 768px) {
            .quiz-container {
                padding: 15px;
            }
            
            .question-slide {
                padding: 20px;
            }
            
            .arrow-container .col-5 {
                width: 100%;
                margin-bottom: 20px;
            }
            
            .arrow-container {
                flex-direction: column;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container mt-5" style="direction: rtl; max-width: 900px;" dir="rtl">
        <div class="quiz-container">
            <h3 class="quiz-title text-center">📘 {{ $quiz->title }}</h3>
            
            <!-- Barre de progression -->
            <div class="progress-text">{{ count($quiz->questions) > 0 ? '1' : '0' }} من {{ count($quiz->questions) }} سؤال</div>
            <div class="progress-container">
                <div class="progress-bar" id="quiz-progress" style="width: {{ count($quiz->questions) > 0 ? (100 / count($quiz->questions)) : 0 }}%"></div>
            </div>

        <form id="quizForm" action="{{ route('panel.quiz.submit', $quiz->id) }}" method="POST">
            @csrf
            <input type="hidden" name="total_questions" value="{{ count($quiz->questions) }}" />

            @foreach ($quiz->questions as $index => $question)
                <div class="question-slide" id="question-{{ $index }}"
                    style="{{ $index === 0 ? '' : 'display:none;' }}" data-question-index="{{ $index }}">
                    <span class="question-counter">{{ $index + 1 }}</span>
                    <h5 class="mb-4 question-text text-center">
                        {{ $question->question_text }}
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

                        <div class="quiz-buttons mt-4">
                            @if ($index > 0)
                                <button type="button" class="btn prev-btn" onclick="prevQuestion()">السابق <i class="fas fa-arrow-right mr-1"></i></button>
                            @else
                                <div></div>
                            @endif
                            @if ($index < count($quiz->questions) - 1)
                                <button type="button" class="btn next-btn" onclick="nextQuestion()">التالي <i class="fas fa-arrow-left ml-1"></i></button>
                            @else
                                <button type="button" id="submit-btn" class="btn btn-success">إرسال الإجابات <i class="fas fa-paper-plane ml-2"></i></button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </form>
        </div>
    </div>
@endsection


@push('scripts_bottom')
    <script src="https://cdn.jsdelivr.net/npm/leader-line-new/leader-line.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <!-- Sons de notification -->
    <audio id="sound-correct" preload="auto">
        <source src="/assets/default/sounds/correct.mp3" type="audio/mpeg">
    </audio>
    <audio id="sound-success" preload="auto">
        <source src="/assets/default/sounds/success.mp3" type="audio/mpeg">
    </audio>
    <audio id="sound-click" preload="auto">
        <source src="/assets/default/sounds/click.mp3" type="audio/mpeg">
    </audio>
    <audio id="sound-notification" preload="auto">
        <source src="/assets/default/sounds/notification.mp3" type="audio/mpeg">
    </audio>
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
            
            // Mettre à jour la barre de progression
            const progressBar = document.getElementById('quiz-progress');
            const progressText = document.querySelector('.progress-text');
            const totalQuestions = slides.length;
            const currentStep = index + 1;
            
            progressBar.style.width = `${(currentStep / totalQuestions) * 100}%`;
            progressText.textContent = `${currentStep} من ${totalQuestions} سؤال`;
        }

        function nextQuestion() {
            if (currentIndex < slides.length - 1) {
                playSound('sound-click');
                currentIndex++;
                showQuestion(currentIndex);
            }
        }

        function prevQuestion() {
            if (currentIndex > 0) {
                playSound('sound-click');
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

        // Fonction pour jouer un son
        function playSound(soundId) {
            const sound = document.getElementById(soundId);
            if (sound) {
                sound.currentTime = 0;
                sound.play().catch(e => console.log('Erreur audio:', e));
            }
        }
        
        document.addEventListener("DOMContentLoaded", () => {
            // Initialize question display
            showQuestion(currentIndex);
            
            // Modal de confirmation pour la soumission
            const submitBtn = document.getElementById('submit-btn');
            if (submitBtn) {
                submitBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    
                    // Vérifier si toutes les questions ont une réponse
                    const totalQuestions = slides.length;
                    const answeredQuestions = getAnsweredQuestionsCount();
                    
                    if(answeredQuestions < totalQuestions) {
                        Swal.fire({
                            title: 'تنبيه!',
                            text: `لم تجب على جميع الأسئلة (${answeredQuestions} من ${totalQuestions}). هل ترغب في إرسال الإجابات الحالية؟`,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'نعم، إرسال الإجابات',
                            cancelButtonText: 'لا، أريد مراجعة إجاباتي',
                            confirmButtonColor: '#28a745',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                playSound('sound-success');
                                // Ajouter une animation avant soumission
                                document.querySelector('.quiz-container').classList.add('pulse');
                                setTimeout(() => {
                                    document.getElementById('quizForm').submit();
                                }, 800);
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'أحسنت!',
                            text: 'لقد أجبت على جميع الأسئلة. هل أنت مستعد لتقديم الاختبار؟',
                            icon: 'success',
                            showCancelButton: true,
                            confirmButtonText: 'نعم، إرسال الإجابات',
                            cancelButtonText: 'لا، أريد مراجعة إجاباتي',
                            confirmButtonColor: '#28a745',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                playSound('sound-success');
                                // Animation de confetti pour célébrer la réussite
                                document.querySelector('.quiz-container').classList.add('pulse');
                                setTimeout(() => {
                                    document.getElementById('quizForm').submit();
                                }, 800);
                            }
                        });
                    }
                });
            }
            
            // Ajouter un indicateur de question répondue
            document.querySelectorAll('input[type="radio"]').forEach(radio => {
                radio.addEventListener('change', () => {
                    const questionSlide = radio.closest('.question-slide');
                    if (questionSlide) {
                        playSound('sound-correct');
                        questionSlide.classList.add('answered');
                        updateQuestionCounter();
                        
                        // Avancer automatiquement à la question suivante après un délai
                        if (currentIndex < slides.length - 1) {
                            setTimeout(() => {
                                nextQuestion();
                            }, 700);
                        }
                    }
                });
            });
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
                    document.getElementById(`match-result-${qId}`).value = JSON.stringify(mappings[qId]);
                    
                    // Jouer un son et marquer la question comme répondue
                    playSound('sound-correct');
                    const questionSlide = document.querySelector('.question-slide[style*="display: block"]');
                    if (questionSlide) {
                        questionSlide.classList.add('answered');
                        updateQuestionCounter();
                    }
                });
            });
            
            // Fonction pour compter les questions répondues
            function getAnsweredQuestionsCount() {
                let count = 0;
                
                // Vérifier les questions QCM et binaires
                document.querySelectorAll('.question-slide').forEach(slide => {
                    const questionId = slide.dataset.questionIndex;
                    const typeArrow = slide.querySelector('[id^="arrow-container-"]');
                    
                    if (typeArrow) {
                        // Question de type flèche
                        const qId = typeArrow.id.replace('arrow-container-', '');
                        const matchResult = document.getElementById(`match-result-${qId}`).value;
                        const matches = JSON.parse(matchResult || '{}');
                        if (Object.keys(matches).length > 0) count++;
                    } else {
                        // Question QCM ou binaire
                        const radioChecked = slide.querySelector('input[type="radio"]:checked');
                        if (radioChecked) count++;
                    }
                });
                
                return count;
            }
            
            // Mettre à jour le compteur de questions et le style
            function updateQuestionCounter() {
                const totalQuestions = slides.length;
                const answeredQuestions = getAnsweredQuestionsCount();
                document.querySelectorAll('.question-counter').forEach((counter, index) => {
                    const isAnswered = slides[index].classList.contains('answered') || 
                                     (slides[index].querySelector('[id^="arrow-container-"]') && 
                                      Object.keys(mappings[slides[index].querySelector('[id^="arrow-container-"]').id.replace('arrow-container-', '')] || {}).length > 0);
                    
                    if (isAnswered) {
                        counter.innerHTML = '<i class="fas fa-check"></i>';
                        counter.style.backgroundColor = '#28a745';
                    }
                });
                
                // Mettre à jour le texte de progression
                const progressText = document.querySelector('.progress-text');
                if (progressText) {
                    progressText.textContent = `${answeredQuestions} من ${totalQuestions} سؤال`;
                }
                
                // Mettre à jour la barre de progression
                const progressBar = document.getElementById('quiz-progress');
                if (progressBar) {
                    progressBar.style.width = `${(answeredQuestions / totalQuestions) * 100}%`;
                }
            }
        });
    </script>
@endpush


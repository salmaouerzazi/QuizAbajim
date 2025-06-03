@extends('web.default.panel.layouts.panel_layout')

@section('content')
    <style>
        .card.fade-out {
            animation: fadeOutCard 0.3s ease-in-out forwards;
        }

        @keyframes fadeOutCard {
            from {
                opacity: 1;
                transform: scale(1);
            }

            to {
                opacity: 0;
                transform: scale(0.9);
            }
        }

        .card {
            background-color: #ffffff;
            border-radius: 16px;
            border: 1px solid #e0e0e0;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease-in-out;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        input.form-control:focus {
            border-color: #1f3c88;
            box-shadow: 0 0 0 0.2rem rgba(31, 60, 136, 0.25);
        }

        /* Bouton flottant Ajouter */
        #floating-add-btn {
            position: fixed;
            bottom: 24px;
            right: 24px;
            background-color: #1f3c88;
            color: white;
            font-size: 24px;
            padding: 12px 18px;
            border-radius: 50%;
            border: none;
            z-index: 999;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            transition: transform 0.2s ease-in-out;
        }

        #floating-add-btn:hover {
            transform: scale(1.1);
        }

        /* Animation à l'apparition */
        @keyframes fadeInCard {
            0% {
                opacity: 0;
                transform: scale(0.95);
            }

            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        .card.fade-in {
            animation: fadeInCard 0.4s ease-in-out;
        }

        /* Animation à la suppression */
        @keyframes fadeOutCard {
            0% {
                opacity: 1;
                transform: scale(1);
            }

            100% {
                opacity: 0;
                transform: scale(0.9);
            }
        }

        .card.fade-out {
            animation: fadeOutCard 0.3s ease-in forwards;
        }

        /* Ajout d’un petit effet hover aux boutons */
        button:hover,
        .scroll-to:hover {
            transform: scale(1.03);
            transition: all 0.2s ease-in-out;
        }

        .list-group-item.active,
        .list-group-item.active a {
            background-color: #1f3c88;
            border-color: #1f3c88;
            color: #ffffff !important;
            /* texte blanc */
        }

        .list-group-item.active .badge {
            background-color: #ffffff;
            color: #1f3c88;
        }
    </style>
    <style>
        @media (min-width: 768px) {
            .sidebar-question-box {
                position: sticky;
                top: 20px;
                width: 100%;
                max-height: calc(100vh - 100px);
                display: flex;
                flex-direction: column;
            }
            
            .questions-scrollable-area {
                flex-grow: 1;
                overflow-y: auto;
                max-height: calc(60vh - 40px);
            }
            
            .questions-list {
                scrollbar-width: thin;
            }
        }

        @media (max-width: 767.98px) {
            .sidebar-question-box {
                position: static;
                width: 100%;
                max-height: 300px;
                display: flex;
                flex-direction: column;
            }
            
            .questions-scrollable-area {
                max-height: 250px;
                overflow-y: auto;
            }
        }
        
        .fixed-add-btn {
            border-top: 1px solid rgba(0,0,0,.125);
            background-color: #f8f9fa;
            font-weight: bold;
            transition: all 0.2s ease;
        }
        
        .fixed-add-btn:hover {
            background-color: #e9ecef;
        }
        
        /* Styles pour les boutons de navigation haut/bas */
        .scroll-nav-container {
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 15px;
            z-index: 1000;
        }
        
        .scroll-btn {
            width: 45px;
            height: 45px;
            background-color: #1f3c88;
            color: white;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            opacity: 0.9;
        }
        
        .scroll-btn:hover {
            transform: scale(1.1);
            opacity: 1;
        }
        
        /* Styles pour le bouton de sauvegarde */
        .save-btn-container {
            padding: 15px 0;
        }
        
        .btn-save {
            background: linear-gradient(135deg, #1f3c88 0%, #3a5db6 100%);
            color: white;
            padding: 12px 35px;
            font-size: 18px;
            font-weight: bold;
            border: none;
            border-radius: 30px;
            box-shadow: 0 4px 15px rgba(31, 60, 136, 0.3);
            transition: all 0.3s ease;
            min-width: 220px;
            position: relative;
            overflow: hidden;
        }
        
        .btn-save:hover {
            box-shadow: 0 6px 18px rgba(31, 60, 136, 0.4);
            transform: translateY(-2px);
            color: white;
        }
        
        .btn-save:active {
            transform: translateY(1px);
            box-shadow: 0 2px 10px rgba(31, 60, 136, 0.3);
        }
        
        /* Style pour la surbrillance des questions avec erreur */
        @keyframes highlightError {
            0% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.2); }
            70% { box-shadow: 0 0 0 10px rgba(220, 53, 69, 0); }
            100% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); }
        }
        
        .highlight-error {
            animation: highlightError 1.5s ease-in-out infinite;
            border: 2px solid #dc3545 !important;
        }
        
        #scroll-to-top {
            display: none;
        }
        
        /* Style pour la scrollbar */
        .questions-list::-webkit-scrollbar {
            width: 5px;
        }
        
        .questions-list::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .questions-list::-webkit-scrollbar-thumb {
            background: #1f3c88;
            border-radius: 10px;
        }
    </style>


    <div class="container-fluid mt-4" dir="rtl">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center gap-3">
                <div class="title-edit-container">
                    <div class="d-flex align-items-center mb-1">
                        <i class="fas fa-pencil-alt title-icon me-2"></i>
                        <span class="title-label fs-6 text-primary fw-bold">عنوان التحدي</span>
                    </div>
                    <div class="title-input-wrapper position-relative">
                        <input type="text" id="quiz-title" class="form-control form-control-lg fw-bold fs-3 quiz-title-input" 
                               value="{{ $quiz->title }}" 
                               placeholder="عنوان التحدي" 
                               data-quiz-id="{{ $quiz->id }}">
                        <div class="title-highlight"></div>
                    </div>
                    <small class="text-muted fs-6 d-block mt-1">أنشئ تحدياتك بسهولة</small>
                </div>
                <div id="title-save-indicator" class="d-none align-items-center text-success">
                    <i class="fas fa-check-circle me-1"></i>
                    <span class="small">تم الحفظ</span>
                </div>
            </div>
            <a href="{{ route('panel.quiz.drafts') }}" class="btn btn-primary px-4">العودة إلى التحديات</a>
        </div>
        <div class="row">
            <div class="col-12 col-md-3">
                <div class="card shadow-sm rounded-4 sidebar-question-box d-flex flex-column">
                    <div class="card-header bg-white text-center fw-bold">
                        📋 الأسئلة ({{ count($questions) }})
                    </div>
                    <div class="questions-scrollable-area">
                        <ul class="list-group list-group-flush questions-list">
                            @foreach ($questions as $index => $q)
                                <li class="list-group-item d-flex justify-content-between align-items-center question-item"
                                    data-id="question{{ $index }}">
                                    <a href="#" class="text-decoration-none text-dark scroll-to"
                                        data-target="question{{ $index }}">
                                        سؤال {{ $index + 1 }}
                                    </a>
                                    <span class="badge bg-light border">{{ $q['score'] }} نقاط</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div id="add-question-btn" class="list-group-item text-center text-primary mt-auto fixed-add-btn" style="cursor:pointer;"
                        data-id="{{ $quiz->id }}">
                        + إضافة سؤال آخر
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <form method="POST" id="quiz-edit-form" action="{{ route('panel.quiz.update', ['id' => $quiz->id]) }}">
                    @csrf
                    @method('PUT')
                    @foreach ($questions as $index => $q)
                        @php $type = $q['type'] ?? 'qcm'; @endphp
                        <div class="card shadow-sm mb-4 rounded-4 border-0" id="question{{ $index }}">
                            <div class="card-header bg-primary text-white rounded-top-4 d-flex justify-content-between">
                                <span>{{ trans('panel.question') }} {{ $index + 1 }}</span>
                                <button type="button" class="btn btn-sm btn-light text-danger"
                                    onclick="deleteQuestion(this)" data-id="{{ $q->id }}">
                                    🗑️
                                </button>
                            </div>
                            <div class="card-body" style="background: #f9f9f9;">
                                <input type="hidden" name="questions[{{ $index }}][type]"
                                    value="{{ $type }}">
                                <div class="mb-3 d-flex align-items-center gap-2">
                                    <label class="form-label mb-0 fw-bold">النقاط :</label>
                                    <input type="number" class="form-control form-control-sm w-25"
                                        name="questions[{{ $index }}][score]" value="{{ $q['score'] ?? 1 }}">
                                </div>
                                {{-- Matching --}}
                                @if ($type === 'ربط' || $type === 'arrow')
                                    <label class="form-label fw-bold">السؤال</label>
                                    <input type="text" class="form-control mb-3"
                                        name="questions[{{ $index }}][question]"
                                        value="{{ $q['question'] ?? trans('panel.match_question') }}">

                                    <div class="row">
                                        <div class="col-md-12" id="matching-rows-{{ $index }}">
                                            <label class="form-label fw-bold">العناصر والإجابات المطابقة</label>
                                            @foreach ($q['answers'] as $i => $answer)
                                                <div class="d-flex align-items-center gap-2 mb-2 answer-item">
                                                    <input type="text" class="form-control"
                                                        name="questions[{{ $index }}][answers][{{ $i }}][answer_text]"
                                                        value="{{ $answer['answer_text'] ?? '' }}">

                                                    <input type="text" class="form-control"
                                                        name="questions[{{ $index }}][answers][{{ $i }}][matching]"
                                                        value="{{ $answer['matching'] ?? '' }}">

                                                    <button type="button ;" onclick="confirmDeleteAnswer(this)"
                                                        class="btn btn-sm btn-outline-primary delete-matching-row"
                                                        style="height: 40px; width: 40px;">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            @endforeach


                                        </div>
                                        <div class="text-end mt-2">
                                            <button type="button" class="btn btn-sm btn-outline-secondary add-matching-row"
                                                data-index="{{ $index }}">
                                                ➕ إضافة عنصر
                                            </button>
                                        </div>
                                    </div>
                                    {{-- Vrai/Faux --}}
                                @elseif ($type === 'صحيح/خطأ' || $type === 'binaire')
                                    <label class="form-label fw-bold">البيان</label>
                                    <input type="text" name="questions[{{ $index }}][question]"
                                        class="form-control mb-3" value="{{ $q['question_text'] ?? '' }}">
                                    @php
                                        $correct = isset($q['correct'])
                                            ? $q['correct']
                                            : (isset($q['is_valid'])
                                                ? (bool) $q['is_valid']
                                                : null);
                                    @endphp
                                    <div class="d-flex gap-3">
                                        @php
                                            $correct = isset($q['correct'])
                                                ? $q['correct']
                                                : (isset($q['is_valid'])
                                                    ? (bool) $q['is_valid']
                                                    : null);
                                        @endphp

                                        <div role="group">
                                            <label class="btn btn-outline-primary {{ $correct === true ? 'active' : '' }}">
                                                <input type="radio" class="d-none"
                                                    name="questions[{{ $index }}][correct]" value="true"
                                                    {{ $correct === true ? 'checked' : '' }}>
                                                صحيح
                                            </label>

                                            <label
                                                class="btn btn-outline-primary {{ $correct === false ? 'active' : '' }}">
                                                <input type="radio" class="d-none"
                                                    name="questions[{{ $index }}][correct]" value="false"
                                                    {{ $correct === false ? 'checked' : '' }}>
                                                خطأ
                                            </label>
                                        </div>

                                    </div>
                                    {{-- QCM --}}
                                @elseif($type === 'اختيار من متعدد' || $type === 'qcm')
                                    <label class="form-label fw-bold">السؤال</label>
                                    <input type="text" name="questions[{{ $index }}][question]"
                                        class="form-control mb-3" value="{{ $q['question_text'] ?? '' }}">
                                    <label class="form-label fw-bold">الخيارات</label>
                                    <div id="answers-container-{{ $index }}">
                                        {{-- @foreach ($q['answers'] as $i => $a)
                                            <div class="input-group mb-2">
                                                <div class="input-group-text">
                                                    <input type="radio" name="questions[{{ $index }}][correct]" value="{{ $i }}"
                                                        {{ $a['is_valid'] ? 'checked' : '' }}>
                                                </div>
                                                <input type="text" class="form-control"
                                                    name="questions[{{ $index }}][answers][{{ $i }}][answer_text]"
                                                    value="{{ $a['answer_text'] }}">
                                            </div>
                                        @endforeach --}}
                                        @foreach ($q['answers'] as $i => $a)
                                            <div class="input-group mb-2 align-items-center answer-item">
                                                <div class="input-group-text">
                                                    <input type="radio" name="questions[{{ $index }}][correct]"
                                                        value="{{ $i }}" {{ $a['is_valid'] ? 'checked' : '' }}>
                                                </div>

                                                <input type="text" class="form-control"
                                                    name="questions[{{ $index }}][answers][{{ $i }}][answer_text]"
                                                    value="{{ $a['answer_text'] ?? '' }}">

                                                <button type="button" class="btn btn-sm btn-outline-primary"
                                                    style="height: 40px; width: 40px;"
                                                    onclick="confirmDeleteAnswer(this)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        @endforeach

                                    </div>
                                    <div class="input-group mt-2" id="add-answer-group-{{ $index }}">
                                        <input type="text" class="form-control"
                                            id="add-answer-input-{{ $index }}" placeholder="أدخل إجابة جديدة">
                                        <button class="btn btn-outline-info" style="height:100%" type="button"
                                            onclick="addAnswer({{ $index }})">➕</button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    <div class="text-center mt-5 mb-4 save-btn-container">
                        <button class="btn btn-save" type="submit">
                            <i class="fas fa-save me-2"></i>
                            حفظ التحدي
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Boutons de navigation haut/bas -->    
    <div class="scroll-nav-container">
        <button id="scroll-to-bottom" class="scroll-btn" title="التمرير إلى الأسفل">
            <i class="fas fa-arrow-down"></i>
        </button>
        <button id="scroll-to-top" class="scroll-btn" title="التمرير إلى الأعلى">
            <i class="fas fa-arrow-up"></i>
        </button>
    </div>
    <script>
        function confirmDeleteAnswer(button) {
            event.preventDefault();     
            event.stopPropagation(); 

            const answerItem = button.closest('.answer-item');

            if (!answerItem) return;

            // Détecter dynamiquement le conteneur contenant les réponses
            const container = answerItem.parentElement;
            const allAnswers = container.querySelectorAll('.answer-item');

            // Vérification minimum de 2 réponses
            if (allAnswers.length <= 2) {
                Swal.fire({
                    icon: 'warning',
                    title: 'غير ممكن',
                    text: 'يجب أن يحتوي كل سؤال على إجابتين على الأقل.',
                    confirmButtonText: 'موافق'
                });
                return;
            }
            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: "هل تريد حذف هذه الإجابة؟",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'نعم، احذفها',
                cancelButtonText: 'إلغاء'
            }).then((result) => {
                if (result.isConfirmed) {
                    const answerItem = button.closest('.answer-item');
                    if (answerItem) {
                        answerItem.classList.add('fade-out');
                        setTimeout(() => answerItem.remove(), 300);
                    }

                    Swal.fire({
                        icon: 'success',
                        title: 'تم الحذف',
                        showConfirmButton: false,
                        timer: 1000
                    });
                }
            });
        }
    </script>

    <script>
        // Validation du formulaire pour vérifier qu'au moins une réponse est cochée pour chaque question QCM
        document.addEventListener('DOMContentLoaded', function() {
            const quizForm = document.getElementById('quiz-edit-form');
            
            quizForm.addEventListener('submit', function(event) {
                // Trouver toutes les questions de type QCM en utilisant un sélecteur compatible avec tous les navigateurs
                let allValid = true;
                let invalidQuestionId = null;
                
                // Parcourir chaque carte de question
                document.querySelectorAll('.card').forEach(function(card) {
                    // Vérifier si c'est une question QCM en cherchant des boutons radio
                    const cardBody = card.querySelector('.card-body');
                    const radioInputs = cardBody?.querySelectorAll('input[type="radio"][name^="questions"][name$="[correct]"]');
                    
                    if (!radioInputs || radioInputs.length === 0) return; // Pas une question QCM, ignorer
                    
                    // Trouver l'ID de la question (pour le scroll)
                    const questionId = card.id;
                    
                    // Vérifier si au moins un bouton radio est coché
                    let hasChecked = false;
                    radioInputs.forEach(function(radio) {
                        if (radio.checked) {
                            hasChecked = true;
                        }
                    });
                    
                    // Si aucun n'est coché, la validation échoue
                    if (!hasChecked) {
                        allValid = false;
                        if (!invalidQuestionId) {
                            invalidQuestionId = questionId;
                        }
                    }
                });
                
                // Si une validation échoue, afficher une alerte et empêcher l'envoi du formulaire
                if (!allValid) {
                    event.preventDefault();
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ في النموذج',
                        text: 'يجب اختيار إجابة واحدة صحيحة على الأقل لكل سؤال من نوع اختيار من متعدد',
                        confirmButtonText: 'حسنًا',
                        confirmButtonColor: '#1f3c88'
                    }).then(() => {
                        // Faire défiler jusqu'à la première question non valide
                        if (invalidQuestionId) {
                            const element = document.getElementById(invalidQuestionId);
                            if (element) {
                                element.scrollIntoView({ behavior: 'smooth' });
                                // Ajouter un effet de surbrillance temporaire
                                element.classList.add('highlight-error');
                                setTimeout(() => {
                                    element.classList.remove('highlight-error');
                                }, 3000);
                            }
                        }
                    });
                }
            });
        });
        
        // Script pour les boutons de navigation haut/bas
        document.addEventListener('DOMContentLoaded', function() {
            const scrollToTopBtn = document.getElementById('scroll-to-top');
            const scrollToBottomBtn = document.getElementById('scroll-to-bottom');
            
            // Fonction pour faire défiler vers le haut
            scrollToTopBtn.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
            
            // Fonction pour faire défiler vers le bas
            scrollToBottomBtn.addEventListener('click', function() {
                window.scrollTo({
                    top: document.body.scrollHeight,
                    behavior: 'smooth'
                });
            });
            
            // Montrer/cacher les boutons selon la position de défilement
            window.addEventListener('scroll', function() {
                // Hauteur totale de la page moins la hauteur visible
                const maxScroll = document.body.scrollHeight - window.innerHeight;
                const currentScroll = window.pageYOffset;
                
                // Si on est vers le bas de la page, afficher le bouton "haut" et cacher "bas"
                if (currentScroll > maxScroll * 0.7) {
                    scrollToTopBtn.style.display = 'flex';
                    scrollToBottomBtn.style.display = 'none';
                } 
                // Si on est vers le haut de la page, afficher le bouton "bas" et cacher "haut"
                else if (currentScroll < maxScroll * 0.3) {
                    scrollToTopBtn.style.display = 'none';
                    scrollToBottomBtn.style.display = 'flex';
                } 
                // Au milieu, afficher les deux boutons
                else {
                    scrollToTopBtn.style.display = 'flex';
                    scrollToBottomBtn.style.display = 'flex';
                }
            });
            
            // Déclencher l'événement de défilement au chargement pour initialiser l'état des boutons
            window.dispatchEvent(new Event('scroll'));
        });
        
        function addAnswer(index) {
    const input = document.getElementById(`add-answer-input-${index}`);
    const value = input.value.trim();
    if (value === '') return;

    const container = document.getElementById(`answers-container-${index}`);
    const inputs = container.querySelectorAll('input[name^="questions"][name$="[answer_text]"]');
    const newIndex = inputs.length;

    const inputGroup = document.createElement('div');
    inputGroup.className = 'input-group mb-2 align-items-center answer-item'; // ✅ ajoute .answer-item ici

    const radioDiv = document.createElement('div');
    radioDiv.className = 'input-group-text';

    const radio = document.createElement('input');
    radio.type = 'radio';
    radio.name = `questions[${index}][correct]`;
    radio.value = newIndex;
    radioDiv.appendChild(radio);

    const textInput = document.createElement('input');
    textInput.type = 'text';
    textInput.className = 'form-control';
    textInput.name = `questions[${index}][answers][${newIndex}][answer_text]`;
    textInput.value = value;

    const deleteBtn = document.createElement('button');
    deleteBtn.type = 'button';
    deleteBtn.className = 'btn btn-sm btn-outline-primary';
    deleteBtn.style.height = '40px';
    deleteBtn.style.width = '20px';
    deleteBtn.innerHTML = '<i class="fas fa-trash"></i>';
    deleteBtn.onclick = function(e) {
        e.preventDefault();
        e.stopPropagation();
        const answerItems = container.querySelectorAll('.answer-item');
        if (answerItems.length <= 2) {
            Swal.fire({
                icon: 'warning',
                title: 'غير ممكن',
                text: 'يجب أن تحتوي كل سؤال على إجابتين على الأقل.',
                confirmButtonText: 'موافق'
            });
            return;
        }

        Swal.fire({
            title: 'هل أنت متأكد؟',
            text: "هل تريد حذف هذه الإجابة؟",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'نعم، احذفها',
            cancelButtonText: 'إلغاء'
        }).then((result) => {
            if (result.isConfirmed) {
                inputGroup.classList.add('fade-out');
                setTimeout(() => inputGroup.remove(), 300);
            }
        });
    };

    inputGroup.appendChild(radioDiv);
    inputGroup.appendChild(textInput);
    inputGroup.appendChild(deleteBtn);

    container.appendChild(inputGroup);
    input.value = '';
    textInput.focus();
}

    
        document.querySelectorAll('[id^="add-answer-input-"]').forEach(function(input) {
            input.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const index = this.id.split('-').pop();
                    addAnswer(index);
                }
            });
        });

        document.querySelectorAll('div[role="group"]').forEach(group => {
            const labels = group.querySelectorAll('label');
            labels.forEach(label => {
                label.addEventListener('click', () => {
                    labels.forEach(l => l.classList.remove('active'));
                    label.classList.add('active');
                    const radio = label.querySelector('input[type="radio"]');
                    if (radio) {
                        radio.checked = true;
                    }
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Scrolling automatique vers la question ciblée
            document.querySelectorAll('.scroll-to').forEach(function(link) {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.dataset.target;
                    const el = document.getElementById(targetId);
                    if (el) {
                        el.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });


            document.addEventListener('click', function(e) {
                if (e.target.closest('.delete-matching-row')) {
                    const row = e.target.closest('.answer-item');
                    if (row) row.remove();
                }
            });


            // Ajout dynamique de colonnes matching avec bouton de suppression
            document.querySelectorAll('.add-matching-row').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const index = this.dataset.index;
                    const container = document.getElementById('matching-rows-' + index);

                    const count = container.querySelectorAll('.answer-item').length;

                    // Créer le wrapper pour la ligne complète (élément + réponse + bouton 🗑️)
                    const wrapper = document.createElement('div');
                    wrapper.className = 'd-flex align-items-center gap-2 mb-2 answer-item';

                    // Input pour l'élément (gauche)
                    const inputLeft = document.createElement('input');
                    inputLeft.type = 'text';
                    inputLeft.className = 'form-control';
                    inputLeft.name = `questions[${index}][answers][${count}][answer_text]`;

                    // Input pour la réponse correspondante (droite)
                    const inputRight = document.createElement('input');
                    inputRight.type = 'text';
                    inputRight.className = 'form-control';
                    inputRight.name = `questions[${index}][answers][${count}][matching]`;

                    // Bouton de suppression
                    const deleteBtn = document.createElement('button');
                    deleteBtn.type = 'button';
                    deleteBtn.className = 'btn btn-sm btn-outline-primary delete-matching-row';
                    deleteBtn.style.height = '40px';
                    deleteBtn.style.width = '40px';
                    deleteBtn.innerHTML = '<i class="fas fa-trash"></i>';

                    // Supprimer la ligne
                    deleteBtn.onclick = function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        const answerItems = container.querySelectorAll('.answer-item');
                        if (answerItems.length <= 2) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'غير ممكن',
                                text: 'يجب أن تحتوي كل سؤال على إجابتين على الأقل.',
                                confirmButtonText: 'موافق'
                            });
                            return;
                        }

                        Swal.fire({
                            title: 'هل أنت متأكد؟',
                            text: "هل تريد حذف هذه الإجابة؟",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'نعم، احذفها',
                            cancelButtonText: 'إلغاء'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                wrapper.classList.add('fade-out');
                                setTimeout(() => wrapper.remove(), 300);
                            }
                        });
                    };


                    // Ajouter tout dans la ligne
                    wrapper.appendChild(inputLeft);
                    wrapper.appendChild(inputRight);
                    wrapper.appendChild(deleteBtn);

                    // Ajouter la ligne dans le container
                    container.appendChild(wrapper);
                });
            });


        });

        function updateQuestionNumbers() {
            const cards = document.querySelectorAll('.card.shadow-sm.mb-4');
            const listContainer = document.querySelector('.list-group.list-group-flush');

            // Supprimer tous les anciens éléments de la liste sauf le bouton + إضافة سؤال آخر
            listContainer.querySelectorAll('.question-item').forEach(item => item.remove());

            cards.forEach((card, i) => {
                const newId = `question${i}`;
                card.id = newId;

                // Mettre à jour le header du bloc question
                const header = card.querySelector('.card-header span');
                if (header) {
                    header.textContent = `سؤال ${i + 1}`;
                }

                // Mettre à jour le bouton delete
                const deleteBtn = card.querySelector('button[data-id]');
                if (deleteBtn) {
                    deleteBtn.dataset.index = i;
                }

                // Créer l'élément dans la liste de droite
                const li = document.createElement('li');
                li.className = 'list-group-item d-flex justify-content-between align-items-center question-item';
                li.setAttribute('data-id', newId);

                const a = document.createElement('a');
                a.href = '#';
                a.className = 'text-decoration-none text-dark scroll-to';
                a.dataset.target = newId;
                a.textContent = `سؤال ${i + 1}`;

                const scoreInput = card.querySelector('input[name^="questions"][name$="[score]"]');
                const badge = document.createElement('span');
                badge.className = 'badge bg-light border';
                badge.textContent = (scoreInput?.value ?? '0') + ' نقاط';

                li.appendChild(a);
                li.appendChild(badge);

                const addButton = listContainer.querySelector('#add-question-btn');
                listContainer.insertBefore(li, addButton);
            });

            // Rebrancher le scroll-to
            document.querySelectorAll('.scroll-to').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.dataset.target;
                    const el = document.getElementById(targetId);
                    if (el) {
                        el.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Mettre à jour le compteur en haut
            const totalCount = cards.length;
            const counterHeader = document.querySelector('.card-header.bg-white');
            if (counterHeader) {
                counterHeader.innerHTML = `📋 الأسئلة (${totalCount})`;
            }
        }

        document.getElementById('add-question-btn').addEventListener('click', function() {
            Swal.fire({
                title: 'اختر نوع السؤال',
                input: 'select',
                inputOptions: {
                    qcm: 'اختيار من متعدد (QCM)',
                    binaire: 'صح أو خطأ (Vrai/Faux)',
                    arrow: 'ربط بسهم (Relier)'
                },
                inputPlaceholder: 'اختر نوع السؤال',
                showCancelButton: true,
                confirmButtonText: 'تأكيد',
                cancelButtonText: 'إلغاء',
                inputValidator: (value) => {
                    if (!value) {
                        return 'يجب اختيار نوع السؤال';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const quizId = {{ $quiz->id }};
                    const type = result.value;

                    fetch(`/panel/quizzes/add-question/${quizId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                type
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'تمت إضافة السؤال بنجاح',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(() => location.reload());
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'خطأ',
                                    text: data.error || 'حدث خطأ أثناء الإضافة'
                                });
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            Swal.fire({
                                icon: 'error',
                                title: 'خطأ في الاتصال',
                                text: 'تعذر الاتصال بالخادم. الرجاء المحاولة لاحقاً.'
                            });
                        });
                }
            });
        });
    </script>
    <script>
        function deleteQuestion(button) {
            const card = button.closest('.card');
            const cardId = card.id;
            const questionId = button.dataset.id;

            // 🧠 Compter le nombre total de questions visibles dans le DOM
            const allCards = document.querySelectorAll('.card.shadow-sm.mb-4');
            if (allCards.length <= 1) {
                Swal.fire({
                    icon: 'warning',
                    title: 'غير ممكن',
                    text: 'يجب أن يحتوي الاختبار على سؤال واحد على الأقل.',
                    confirmButtonText: 'موافق'
                });
                return;
            }

            const listItem = document.querySelector(`.question-item[data-id="${cardId}"]`);

            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: 'لن تتمكن من التراجع بعد الحذف!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'نعم، احذفه',
                cancelButtonText: 'إلغاء'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/panel/delete-question/${questionId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                            }
                        })
                        .then(async res => {
                            if (!res.ok) throw new Error('Échec de la suppression');
                            card.classList.add('fade-out');
                            setTimeout(() => {
                                card.remove();
                                if (listItem) listItem.remove();
                                updateQuestionNumbers();
                            }, 300);

                            Swal.fire({
                                icon: 'success',
                                title: 'تم الحذف بنجاح',
                                showConfirmButton: false,
                                timer: 1200
                            });
                        })
                        .catch(err => {
                            console.error(err);
                            Swal.fire({
                                icon: 'error',
                                title: 'خطأ',
                                text: 'فشل الاتصال بالخادم'
                            });
                        });
                }
            });
        }
    </script>
    <script>
        // Fonction pour mettre à jour le titre du quiz via AJAX
        document.addEventListener('DOMContentLoaded', function() {
            const titleInput = document.getElementById('quiz-title');
            const saveIndicator = document.getElementById('title-save-indicator');
            const titleBorder = document.querySelector('.title-edit-border');
            
            let typingTimer;
            const doneTypingInterval = 1000; // Délai d'attente après la saisie (1 seconde)
            
            // Afficher la bordure au focus
            titleInput.addEventListener('focus', function() {
                titleBorder.style.width = '100%';
            });
            
            // Masquer la bordure lorsqu'on quitte le champ (sauf si vide)
            titleInput.addEventListener('blur', function() {
                if (this.value.trim() === '') {
                    this.value = 'تحدي بدون عنوان';
                    updateQuizTitle();
                }
                titleBorder.style.width = '0';
            });
            
            // Déclencher la mise à jour après un délai suivant la frappe
            titleInput.addEventListener('keyup', function() {
                clearTimeout(typingTimer);
                if (this.value.trim() !== '') {
                    typingTimer = setTimeout(updateQuizTitle, doneTypingInterval);
                }
            });
            
            // Fonction de mise à jour du titre
            function updateQuizTitle() {
                const quizId = titleInput.dataset.quizId;
                const newTitle = titleInput.value.trim() || 'تحدي بدون عنوان';
                
                fetch('{{ route("panel.quiz.update.title") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        quiz_id: quizId,
                        title: newTitle
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Afficher l'indicateur de sauvegarde
                        saveIndicator.classList.remove('d-none');
                        saveIndicator.classList.add('d-flex');
                        
                        // Masquer l'indicateur après 2 secondes
                        setTimeout(() => {
                            saveIndicator.classList.remove('d-flex');
                            saveIndicator.classList.add('d-none');
                        }, 2000);
                    }
                })
                .catch(error => {
                    console.error('Erreur lors de la mise à jour du titre:', error);
                });
            }
        });
    </script>
    
    <style>
        /* Styles simplifiés et modernes pour le titre du quiz */
        .title-edit-container {
            position: relative;
            min-width: 350px;
            transition: all 0.3s ease;
        }
        
        .title-icon {
            color: #1f3c88;
            font-size: 16px;
            animation: pulseIcon 2s infinite;
        }
        
        @keyframes pulseIcon {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        
        .title-label {
            color: #1f3c88;
        }
        
        .title-input-wrapper {
            position: relative;
            margin-bottom: 5px;
        }
        
        .quiz-title-input {
            border: none;
            border-bottom: 2px solid #e0e0e0;
            border-radius: 0;
            padding: 10px 0 !important;
            transition: all 0.3s ease;
            background-color: transparent;
            font-size: 1.5rem !important;
            color: #333;
        }
        
        .quiz-title-input:focus {
            box-shadow: none;
            border-color: #1f3c88;
            outline: none;
        }
        
        .title-highlight {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 2px;
            width: 0;
            background: linear-gradient(90deg, #1f3c88, #4361ee);
            transition: width 0.3s ease;
        }
        
        .quiz-title-input:focus ~ .title-highlight {
            width: 100%;
        }
        
        /* Effet de hover sur le champ */
        .title-input-wrapper:hover .quiz-title-input {
            border-color: #aaa;
        }
        
        /* Animation de sauvegarde */
        @keyframes saveAnimation {
            0% { opacity: 0; transform: translateY(10px); }
            20% { opacity: 1; transform: translateY(0); }
            80% { opacity: 1; transform: translateY(0); }
            100% { opacity: 0; transform: translateY(-10px); }
        }
        
        #title-save-indicator {
            animation: saveAnimation 2s ease-in-out;
            background-color: rgba(40, 167, 69, 0.1);
            padding: 5px 10px;
            border-radius: 4px;
        }
    </style>
@endsection

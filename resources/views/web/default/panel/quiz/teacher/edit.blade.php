@extends('web.default.panel.layouts.panel_layout')

@section('content')
    <style>
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


    <div class="container-fluid mt-4" dir="rtl">
        <div class="row">
            <div class="col-md-3">
                <div class="card shadow-sm rounded-4">
                    <div class="card-header bg-white text-center fw-bold">📋 الأسئلة ({{ count($questions) }})</div>
                    <ul class="list-group list-group-flush">
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

                        <li id="add-question-btn" class="list-group-item text-center text-primary" style="cursor:pointer;"
                            data-id="{{ $quiz->id }}">
                            + إضافة سؤال آخر
                        </li>

                    </ul>
                </div>
            </div>

            <div class="col-md-9">
                <form method="POST" action="{{ route('panel.quiz.update', ['id' => $quiz->id]) }}">
                    @csrf
                    @method('PUT')
                    @foreach ($questions as $index => $q)
                        <div class="card shadow-sm mb-4 rounded-4 border-0" id="question{{ $index }}">
                            <div class="card-header bg-primary text-white rounded-top-4 d-flex justify-content-between">
                                <span>{{ trans('panel.question') }} {{ $index + 1 }}</span>
                                <button type="button" class="btn btn-sm btn-light text-danger delete-question-btn"
                                    data-index="{{ $index }}">🗑️</button>

                            </div>

                            <div class="card-body" style="background: #f9f9f9;">
                                <div class="mb-3 d-flex align-items-center gap-2">
                                    <label class="form-label mb-0 fw-bold">النقاط :</label>
                                    <input type="number" class="form-control form-control-sm w-25"
                                        name="questions[{{ $index }}][score]" value="{{ $q['score'] ?? 1 }}">
                                </div>
                                {{-- Matching --}}
                                @if ($q['type'] === 'ربط' || $q['type'] === 'arrow')
                                    <label class="form-label fw-bold">السؤال</label>
                                    <input type="text" class="form-control mb-3"
                                        name="questions[{{ $index }}][question]"
                                        value="{{ $q['question'] ?? trans('panel.match_question') }}">

                                    <div class="row">
                                        <div class="col-md-6" id="column-left-{{ $index }}">
                                            <label class="form-label fw-bold">العناصر</label>
                                            @foreach ($q['answers'] as $i => $answer)
                                                <input type="text" class="form-control mb-2"
                                                    name="questions[{{ $index }}][answers][{{ $i }}][answer_text]"
                                                    value="{{ $answer['answer_text'] ?? '' }}">
                                            @endforeach
                                        </div>
                                        <div class="col-md-6" id="column-right-{{ $index }}">
                                            <label class="form-label fw-bold">الإجابات المطابقة</label>
                                            @foreach ($q['answers'] as $i => $answer)
                                                <input type="text" class="form-control mb-2"
                                                    name="questions[{{ $index }}][answers][{{ $i }}][matching]"
                                                    value="{{ $answer['matching'] ?? '' }}">
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
                                @elseif($q['type'] === 'صحيح/خطأ' || $q['type'] === 'binaire')
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
                                @elseif($q['type'] === 'اختيار من متعدد' || $q['type'] === 'qcm')
                                    <label class="form-label fw-bold">السؤال</label>
                                    <input type="text" name="questions[{{ $index }}][question]"
                                        class="form-control mb-3" value="{{ $q['question_text'] ?? '' }}">
                                    <label class="form-label fw-bold">الخيارات</label>
                                    @foreach ($q['answers'] as $i => $a)
                                        @php
                                            $isValid = $a['is_valid'];
                                        @endphp
                                        <div class="input-group mb-2">
                                            <div class="input-group-text">
                                                <input type="radio" name="questions[{{ $index }}][correct]"
                                                    value="{{ $a['answer_text'] }}" {{ $isValid ? 'checked' : '' }}>
                                            </div>
                                            <input type="text"
                                                name="questions[{{ $index }}][answers][{{ $i }}][answer_text]"
                                                class="form-control" value="{{ $a['answer_text'] }}">
                                        </div>
                                    @endforeach
                                    <input type="text" class="form-control mt-2" placeholder="➕ إضافة إجابة جديدة"
                                        name="questions[{{ $index }}][answers][]">
                                @endif
                            </div>
                        </div>
                    @endforeach
                    <div class="text-end mt-4">
                        <button class="btn btn-primary px-5"> حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('input[placeholder="➕ إضافة إجابة جديدة"]').forEach(function(input) {
            input.addEventListener('keypress', function(e) {
                if (e.key === 'Enter' && input.value.trim() !== '') {
                    e.preventDefault();

                    const value = input.value.trim();
                    const parent = input.closest('.card-body');
                    const inputs = parent.querySelectorAll(
                        'input[name^="questions"][name$="[answer_text]"]');
                    const index = inputs.length;

                    const inputGroup = document.createElement('div');
                    inputGroup.className = 'input-group mb-2';

                    const radioDiv = document.createElement('div');
                    radioDiv.className = 'input-group-text';

                    const radio = document.createElement('input');
                    radio.type = 'radio';
                    radio.name = input.name.replace('answers[]', 'correct');
                    radio.value = value;
                    radioDiv.appendChild(radio);

                    const textInput = document.createElement('input');
                    textInput.type = 'text';
                    textInput.className = 'form-control';
                    textInput.name = input.name.replace('[]', `[${index}][answer_text]`);
                    textInput.value = value;

                    const deleteBtn = document.createElement('button');
                    deleteBtn.type = 'button';
                    deleteBtn.className = 'btn btn-sm btn-outline-danger';
                    deleteBtn.innerHTML = '🗑️';
                    deleteBtn.onclick = () => inputGroup.remove();

                    inputGroup.appendChild(radioDiv);
                    inputGroup.appendChild(textInput);
                    inputGroup.appendChild(deleteBtn);

                    input.before(inputGroup);
                    input.value = '';
                }
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

            document.querySelectorAll('.delete-question-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const index = this.dataset.index;
                    const card = document.getElementById('question' + index);
                    const listItem = document.querySelector('.question-item[data-id="question' +
                        index + '"]');

                    if (card && confirm('هل أنت متأكد من حذف هذا السؤال؟')) {
                        card.classList.add('fade-out');
                        setTimeout(() => {
                            card.remove();
                            if (listItem) listItem.remove();
                            updateQuestionNumbers();
                        }, 300); // ⏳ attendre la fin de l'animation
                        // ✅ Supprime la carte principale

                        if (listItem) listItem
                            .remove(); // ✅ Supprime aussi l'entrée dans la liste de droite

                        updateQuestionNumbers(); // 🔁 Met à jour les index et le scroll
                    }
                });
            });


            // Ajout dynamique de colonnes matching avec bouton de suppression
            document.querySelectorAll('.add-matching-row').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const index = this.dataset.index;
                    const leftCol = document.getElementById('column-left-' + index);
                    const rightCol = document.getElementById('column-right-' + index);

                    const count = leftCol.querySelectorAll('.form-control').length;

                    // Créer ligne à gauche (élément)
                    const leftWrapper = document.createElement('div');
                    leftWrapper.className = 'd-flex align-items-center gap-2 mb-2';

                    const inputLeft = document.createElement('input');
                    inputLeft.type = 'text';
                    inputLeft.className = 'form-control';
                    inputLeft.name = `questions[${index}][answers][${count}][answer_text]`;

                    leftWrapper.appendChild(inputLeft);
                    leftCol.appendChild(leftWrapper);

                    // Créer ligne à droite (réponse + bouton 🗑️)
                    const rightWrapper = document.createElement('div');
                    rightWrapper.className = 'd-flex align-items-center gap-2 mb-2';

                    const inputRight = document.createElement('input');
                    inputRight.type = 'text';
                    inputRight.className = 'form-control';
                    inputRight.name = `questions[${index}][answers][${count}][matching]`;

                    const deleteBtn = document.createElement('button');
                    deleteBtn.type = 'button';
                    deleteBtn.className = 'btn btn-sm btn-outline-danger';
                    deleteBtn.innerHTML = '🗑️';

                    // Supprimer les deux lignes (gauche et droite)
                    deleteBtn.onclick = () => {
                        leftCol.removeChild(leftWrapper);
                        rightCol.removeChild(rightWrapper);
                    };

                    rightWrapper.appendChild(inputRight);
                    rightWrapper.appendChild(deleteBtn);
                    rightCol.appendChild(rightWrapper);
                });
            });

        });

        function updateQuestionNumbers() {
            const cards = document.querySelectorAll('.card.shadow-sm.mb-4');
            const listGroup = document.querySelectorAll('.question-item');
            const listContainer = document.querySelector('.list-group.list-group-flush');

            // Supprimer tous les éléments actuels de la liste
            listGroup.forEach(item => item.remove());

            // Re-générer proprement la liste
            cards.forEach((card, i) => {
                const id = 'question' + i;
                card.id = id;

                // Mettre à jour le titre dans le header
                const title = card.querySelector('.card-header span');
                if (title) title.textContent = 'سؤال ' + (i + 1);

                // Mettre à jour l’index du bouton supprimer
                const deleteBtn = card.querySelector('.delete-question-btn');
                if (deleteBtn) deleteBtn.dataset.index = i;

                // Ajouter l’élément dans la liste à droite
                const li = document.createElement('li');
                li.className = 'list-group-item d-flex justify-content-between align-items-center question-item';
                li.setAttribute('data-id', id);

                const a = document.createElement('a');
                a.href = '#';
                a.className = 'text-decoration-none text-dark scroll-to';
                a.dataset.target = id;
                a.textContent = 'سؤال ' + (i + 1);

                const badge = document.createElement('span');
                badge.className = 'badge bg-light border';
                const scoreInput = card.querySelector('input[name^="questions"][name$="[score]"]');
                badge.textContent = (scoreInput?.value ?? '0') + ' نقاط';

                li.appendChild(a);
                li.appendChild(badge);

                // Insère avant le bouton "+ إضافة سؤال آخر"
                const lastItem = listContainer.querySelector('li:last-child');
                listContainer.insertBefore(li, lastItem);
            });

            // ✅ Mettre à jour le total dans le header
            const totalCount = cards.length;
            const header = document.querySelector('.card-header.bg-white');
            if (header) {
                header.innerHTML = `📋 الأسئلة (${totalCount})`;
            }

            // Rebrancher les événements scroll
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
            })
            // Rebrancher les événements de clic pour surligner l'élément actif
            document.querySelectorAll('.question-item').forEach(item => {
                item.addEventListener('click', function() {
                    document.querySelectorAll('.question-item').forEach(i => i.classList.remove('active'));
                    this.classList.add('active');
                });
            });

        }
        document.getElementById('add-question-btn').addEventListener('click', function() {
            const quizId = {{ $quiz->id }};
            fetch(`/panel/quizzes/add-question/${quizId}`,  {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        location.reload(); // ou appeler une fonction JS pour insérer dynamiquement
                    } else {
                        alert(data.error || 'Erreur lors de l’ajout');
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Erreur AJAX');
                }); 
        });
        
    </script>
@endsection

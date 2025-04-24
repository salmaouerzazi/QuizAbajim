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
            const questionId = button.dataset.id;
            const card = button.closest('.card');
            const cardId = card.id;
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
                                updateQuestionNumbers(); // ✅ Maintenant placé au bon endroit
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
@endsection

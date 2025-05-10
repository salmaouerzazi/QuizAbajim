@extends('web.default.panel.layouts.panel_layout')

@section('content')
    <div class="container mt-4" dir="rtl">
        <div class="row align-items-center mb-4 px-2" dir="rtl">
            <div class="col-md-12 mb-5">
                <div class="filter-bar p-3 h-1/2 rounded-4 border-0 d-flex flex-column flex-md-row shadow-sm">
                    <div class="col-12 col-md-3 text-end mb-3 ">
                        <h2 class="fw-bold text-primary mb-1" style="font-size: 1.8rem;">📚 تحدياتي</h2>
                        <h6 class="text-muted">كل الاختبارات التي قمت بإنشائها</h6>
                    </div>

                    <div class="col-12 col-md-9 d-flex p-2 justify-content-center align-items-center"
                        style="flex-wrap: wrap;gap:3px">

                        <input type="text" name="search" id="searchInput" class="filter-input ml-2"
                            placeholder="🔍 ابحث عن تحدي بالعنوان">

                        <select class="filter-select ml-2" id="filterStatues">
                            <option value="">📌حالة التحدي </option>
                            <option value="published">منشور</option>
                            <option value="draft">مسودة</option>
                        </select>

                        <select class="filter-select ml-2" id="filterMaterial">
                            <option value="">📘 كل المواد</option>
                            @foreach ($materials as $material)
                                <option value="{{ $material->name }}">{{ $material->name }}</option>
                            @endforeach
                        </select>

                        <select class="filter-select ml-2" id="filterLevel">
                            <option value="">🎓 كل المستويات</option>
                            @foreach ($levels as $level)
                                <option value="{{ $level->name }}">{{ $level->name }}</option>
                            @endforeach
                        </select>

                    </div>
                </div>
            </div>
            @if ($quizzes->isEmpty())
                <div class="alert alert-info text-center fw-bold">لا يوجد أي اختبار بعد.</div>
            @endif
            @include('web.default.panel.quiz.teacher.partials.quizzes')




            {{-- Pagination --}}
            {{-- <div class="d-flex justify-content-center align-items-center m-auto ">
                {{ $quizzes->links('vendor.pagination.custom') }}
            </div> --}}

            {{-- Floating Button --}}
            <a href="{{ route('panel.teacher.quiz.index') }}" class="btn btn-primary rounded-circle position-fixed"
                style="bottom: 25px; left: 25px; width: 60px; height: 60px; font-size: 26px; z-index: 1050;"
                title="إنشاء تحدي جديد">
                +
            </a>
        </div>

        {{-- 🎨 Styles --}}
        <script>
            const statuesFilter = document.getElementById('filterStatues');

            const searchInput = document.getElementById('searchInput');
            const quizWrapper = document.getElementById('quizWrapper');


            function loadQuizzes(url = null) {
                const query = searchInput.value;
                const fetchUrl = url || `{{ route('panel.quiz.drafts') }}?search=${encodeURIComponent(query)}`;

                fetch(fetchUrl, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(res => res.text())
                    .then(html => {
                        document.getElementById('quizWrapper').innerHTML = html;

                        attachPaginationLinks();
                        applyFilters();
                    })
                    .catch(err => console.error("Erreur AJAX :", err));
            }

            // Recherche instantanée
            searchInput.addEventListener('input', function() {
                loadQuizzes(); // recharge les quiz avec le texte de recherche
            });

            //  Fonction pour intercepter les clics pagination
            function attachPaginationLinks() {
                const links = quizWrapper.querySelectorAll('.pagination a');
                links.forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const url = this.getAttribute('href');
                        if (url) {
                            loadQuizzes(url);
                        }
                    });
                });
            }

            // Initialiser au chargement
            attachPaginationLinks();
        </script>


        <style>
            .filter-bar {
                background-color: #ffffff;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
                border-radius: 16px;

            }

            /*  Style unifié pour les <select> et <input> */
            .filter-select,
            .filter-input {
                background-color: #f4f8fc;
                border: 1px solid #d6dee9;
                border-radius: 12px;
                padding: 8px 18px;
                font-size: 0.95rem;
                font-weight: 500;
                min-width: 160px;
                text-align: right;
                direction: rtl;
                color: #1a1a1a;
                transition: all 0.2s ease-in-out;
            }

            /* Au focus : border et halo */
            .filter-select:focus,
            .filter-input:focus {
                outline: none;
                border-color: #104568;
                box-shadow: 0 0 0 2px rgba(16, 69, 104, 0.2);
            }

            /*  Responsive comportement (wrap automatique) */


            .quiz-status-badge {
                position: absolute;
                top: 10px;
                left: 10px;
                /* en haut à gauche */
                padding: 4px 12px;
                font-size: 0.85rem;
                font-weight: bold;
                border-radius: 20px;
                white-space: nowrap;
                z-index: 2;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
                transition: all 0.3s ease;
            }

            .quiz-status-badge.draft {
                background-color: #f8d7da;
                /* rouge pastel clair */
                color: #842029;
                /* rouge texte doux */
            }


            .quiz-status-badge.published {
                background-color: #28a745;
                /* vert */
                color: #fff;
            }

            .dropdown-menu {
                z-index: 5000 !important;
                border-radius: 12px;
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
                padding: 8px 0;
            }

            .dropdown-menu .dropdown-item {
                font-size: 15px;
                padding: 10px 15px;
                border-bottom: 1px solid #eee;
            }

            .dropdown-menu .dropdown-item:last-child {
                border-bottom: none;
            }


            .custom-select-style {
                border: 1px solid #ccc;
                border-radius: 30px;
                padding: 6px 18px;
                font-size: 0.95rem;
                background-color: #fdfdfd;
                color: #104568;
                transition: all 0.2s ease-in-out;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            }

            .custom-select-style:hover,
            .custom-select-style:focus {
                border-color: #104568;
                box-shadow: 0 0 0 0.15rem rgba(16, 69, 104, 0.25);
                outline: none;
            }

            .custom-select-style option {
                color: #333;
            }

            .form-select {
                min-width: 150px;
            }

            h2.fw-bold {
                color: #104568;
                letter-spacing: -0.5px;
            }

            .quiz-card {
                background-color: #cce6f7;
                cursor: pointer;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .quiz-card:hover {
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
                
            }

            .bg-lightblue {
                background-color: #dff1fb;
            }

            .pagination .page-link {
                border-radius: 50px;
                margin: 0 5px;
                color: #007bff;
                border: 1px solid #dee2e6;
            }

            .pagination .page-item.active .page-link {
                background-color: #104568;
                color: white;
                border-color: #104568;
            }

            .pagination .page-link:hover {
                background-color: #e9f5ff;
            }
        </style>

        {{-- JS: Inline Editing & Filtering --}}
        <script>
            function enableTitleEdit(element) {
                const quizId = element.dataset.id;
                const currentText = element.textContent.trim();
                const input = document.createElement('input');
                input.type = 'text';
                input.value = currentText;
                input.className = 'form-control text-center fw-bold';
                input.style = 'font-size: 1rem; margin-bottom: 10px;';
                element.replaceWith(input);
                input.focus();

                input.addEventListener('blur', saveTitle);
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        saveTitle();
                    }
                });

                function saveTitle() {
                    const newText = input.value.trim() || '✏️ تحدي بدون عنوان';
                    fetch("{{ route('panel.quiz.update.title') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                quiz_id: quizId,
                                title: newText
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            const h6 = document.createElement('h6');
                            h6.className = 'quiz-title fw-bold text-dark mb-1';
                            h6.textContent = data.title;
                            h6.setAttribute('onclick', 'event.stopPropagation(); enableTitleEdit(this)');
                            h6.setAttribute('data-id', quizId);
                            h6.setAttribute('title', 'انقر لتعديل العنوان');
                            input.replaceWith(h6);
                        })
                        .catch(error => {
                            alert("حدث خطأ أثناء حفظ العنوان");
                            console.error(error);
                        });
                }
            }

            //  Client-side filtering
            const levelFilter = document.getElementById('filterLevel');
            const materialFilter = document.getElementById('filterMaterial');
            const cards = document.querySelectorAll('.quiz-card-wrapper');

            function applyFilters() {
                const selectedLevel = levelFilter.value;
                const selectedMaterial = materialFilter.value;
                const selectedStatues = statuesFilter.value;
                const query = searchInput.value.trim().toLowerCase();

                cards.forEach(card => {
                    const level = card.getAttribute('data-level') || '';
                    const material = card.getAttribute('data-material') || '';
                    const statues = card.getAttribute('data-statues') || '';
                    const title = card.querySelector('.quiz-title')?.textContent?.toLowerCase() || '';

                    const match =
                        (!selectedLevel || level === selectedLevel) &&
                        (!selectedMaterial || material === selectedMaterial) &&
                        (!selectedStatues || statues === selectedStatues) &&
                        (!query || title.includes(query));

                    card.style.display = match ? '' : 'none';
                });
            }


            levelFilter.addEventListener('change', applyFilters);
            materialFilter.addEventListener('change', applyFilters);
            statuesFilter.addEventListener('change', applyFilters);
        </script>
        @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'success',
                title: 'نجاح',
                text: '{{ session('success') }}',
                toast: true,
                position: 'bottom-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
        });
    </script>
@endif


    @endsection

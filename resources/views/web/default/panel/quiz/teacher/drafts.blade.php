@extends('web.default.panel.layouts.panel_layout')

@section('content')
    <div class="container mt-4" dir="rtl">
        {{-- 🧠 Modern Title Section --}}
        <div class="row align-items-center mb-4 px-2" dir="rtl">
            {{-- 📚 Title Section --}}
            <div class="col-md-6 text-end mb-3 mb-md-0">
                <h2 class="fw-bold text-primary mb-1" style="font-size: 1.8rem;">📚 تحدياتي</h2>
                <h6 class="text-muted">كل الاختبارات التي قمت بإنشائها</h6>
            </div>

            {{-- 🔍 Filters --}}
            <div class="col-md-6 text-start">
                <div class="d-flex justify-content-start gap-2 flex-wrap">
                    <select class="form-select custom-select-style" id="filterLevel">
                        <option value="">🎓 كل المستويات</option>
                        @foreach ($levels as $level)
                            <option value="{{ $level->name }}">{{ $level->name }}</option>
                        @endforeach
                    </select>

                    <select class="form-select custom-select-style" id="filterMaterial">
                        <option value="">📘 كل المواد</option>
                        @foreach ($materials as $material)
                            <option value="{{ $material->name }}">{{ $material->name }}</option>
                        @endforeach
                    </select>
                    
                </div>
                <form id="searchForm" class="mb-4 d-flex justify-content-end gap-2 flex-wrap">
                    <input type="text" name="search" id="searchInput" class="form-control w-auto" placeholder="🔍 ابحث عن تحدي بالعنوان">
                </form>
            </div>
        </div>

       
        

        {{-- 🔔 No Quiz Alert --}}
        @if ($quizzes->isEmpty())
            <div class="alert alert-info text-center fw-bold">لا يوجد أي اختبار بعد.</div>
        @endif

        {{-- 🧹 Quiz Cards Grid --}}
        <div id="quizContainer" class="row">
            @foreach ($quizzes as $quiz)
                <div class="col-md-4 mb-4 quiz-card-wrapper" data-level="{{ $quiz->level->name ?? '' }}"
                    data-material="{{ $quiz->material->name ?? '' }}">
                    <div class="card quiz-card rounded-4 shadow-sm position-relative"
                        onclick="window.location.href='{{ route('panel.quiz.edit', $quiz->id) }}'">

                        <div class="card-body text-center bg-lightblue rounded-bottom-4">
                            <h6 class="quiz-title fw-bold text-dark mb-1" title="انقر لتعديل العنوان"
                                onclick="event.stopPropagation(); enableTitleEdit(this)" data-id="{{ $quiz->id }}">
                                {{ $quiz->title ?: 'تحدي جديد ' }}
                            </h6>
                            <small class="text-muted d-block mb-2">عدد الأسئلة: {{ $quiz->questions->count() ?? 0 }}</small>
                            <div class="d-flex flex-column align-items-center gap-1">
                                <span class="badge bg-warning text-dark">{{ $quiz->material->name ?? 'بدون مادة' }}</span>
                                <span class="badge bg-light border">{{ $quiz->level->name ?? 'بدون مستوى' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $quizzes->links('vendor.pagination.custom') }}
        </div>

        {{-- Floating Button --}}
        <a href="{{ route('panel.teacher.quiz.index') }}" class="btn btn-primary rounded-circle position-fixed"
            style="bottom: 25px; left: 25px; width: 60px; height: 60px; font-size: 26px; z-index: 1050;"
            title="إنشاء تحدي جديد">
            +
        </a>
    </div>

    {{-- 🎨 Styles --}}
    <script>
        const searchInput = document.getElementById('searchInput');
        const quizContainer = document.getElementById('quizContainer');
    
        searchInput.addEventListener('input', function () {
            const query = this.value;
    
            fetch(`{{ route('panel.quiz.drafts') }}?search=${encodeURIComponent(query)}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.text())
            .then(html => {
                quizContainer.innerHTML = html;
            })
            .catch(err => console.error("Erreur AJAX :", err));
        });
    </script>
    
    <style>
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
            transform: scale(1.03);
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

    {{-- ✏️ JS: Inline Editing & Filtering --}}
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
                const newText = input.value.trim() || 'تحدي بدون عنوان';
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

        // 🔍 Client-side filtering
        const levelFilter = document.getElementById('filterLevel');
        const materialFilter = document.getElementById('filterMaterial');
        const cards = document.querySelectorAll('.quiz-card-wrapper');

        function applyFilters() {
            const selectedLevel = levelFilter.value;
            const selectedMaterial = materialFilter.value;
            cards.forEach(card => {
                const level = card.getAttribute('data-level');
                const material = card.getAttribute('data-material');
                const match = (!selectedLevel || level === selectedLevel) && (!selectedMaterial || material ===
                    selectedMaterial);
                card.style.display = match ? '' : 'none';
            });
        }

        levelFilter.addEventListener('change', applyFilters);
        materialFilter.addEventListener('change', applyFilters);
    </script>
@endsection

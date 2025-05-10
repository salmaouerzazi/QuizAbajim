<div id="quizWrapper" class="row col-12 mt-4">
    @php
        $colors = [
            'العربية' => '#FFB3BA',
            'رياضيات' => '#8EACCD',
            'الإيقاظ العلمي' => '#A0937D',
            'الفرنسية' => '#A6B37D',
            'المواد الاجتماعية' => '#F6D7A7',
            'الإنجليزية' => '#BAABDA',
        ];
    @endphp

    @forelse ($quizzes as $quiz)
        @php
            $materialName = $quiz->material->name ?? 'بدون مادة';
            $levelName = $quiz->level->name ?? 'بدون مستوى';
            $materialColor = $colors[$materialName] ?? '#ffc107';
        @endphp

        <div class="col-md-4 col-12 mb-4 quiz-card-wrapper" data-level="{{ $levelName }}"
            data-material="{{ $materialName }}" data-statues="{{ $quiz->status }}">
            <div class="card quiz-card rounded-4 shadow-sm position-relative"
                >
                <div class="quiz-status-badge {{ $quiz->status === 'published' ? 'published' : 'draft' }}">
                    {{ $quiz->status === 'published' ? 'منشور' : 'مسودة' }}
                </div>
                <div class="position-absolute top-0 end-0 m-2 z-3">
                    <div class="dropdown">
                        <button class="btn btn-sm p-0 text-dark" type="button" id="dropdownMenu{{ $quiz->id }}"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-three-dots-vertical fs-5"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm text-end"
                            aria-labelledby="dropdownMenu{{ $quiz->id }}">
                            <li>
                                <a class="dropdown-item d-flex justify-content-between align-items-center"
                                    href="{{ route('panel.quiz.edit', $quiz->id) }}">
                                    تعديل <i class="bi bi-pencil"></i>
                                </a>
                            </li>
                            <li>
                                <form id="deleteQuizForm{{ $quiz->id }}" action="{{ route('panel.quiz.destroy', $quiz->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete({{ $quiz->id }})"
                                        class="dropdown-item d-flex justify-content-between align-items-center text-danger">
                                        حذف <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </li>
                            
                        </ul>
                    </div>
                </div>
                <div class="card-body text-center bg-lightblue rounded-bottom-4">
                    <h6 class="quiz-title fw-bold text-dark mb-1" title="انقر لتعديل العنوان"
                        onclick="event.stopPropagation(); enableTitleEdit(this)" data-id="{{ $quiz->id }}">
                        {{ $quiz->title ?: 'تحدي جديد' }}
                    </h6>
                    <small class="text-muted d-block mb-2">عدد الأسئلة: {{ $quiz->questions->count() ?? 0 }}</small>
                    <div class="d-flex justify-content-center align-items-center" style="gap: 5px;">
                        <span class="badge text-dark" style="background-color: {{ $materialColor }};">
                            {{ $materialName }}
                        </span>
                        <span class="badge bg-light border">{{ $levelName }}</span>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center mt-4">
            <div class="alert alert-warning">🔍 لا يوجد أي اختبار يطابق البحث.</div>
        </div>
    @endforelse

    <div class="col-12 d-flex justify-content-center mt-4">
        {{ $quizzes->appends(request()->only('search'))->links('vendor.pagination.custom') }}
    </div>
</div>
@push('scripts_bottom')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmDelete(quizId) {
        Swal.fire({
            title: 'هل أنت متأكد؟',
            text: 'هل تريد حقاً حذف هذا التحدي؟',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'نعم، احذفه!',
            cancelButtonText: 'إلغاء',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteQuizForm' + quizId).submit();
            }
        });
    }
</script>

@endpush

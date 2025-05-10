@php
    $materialColors = [
        'العربية' => '#FFB3BA',
        'رياضيات' => '#8EACCD',
        'الإيقاظ العلمي' => '#A0937D',
        'الفرنسية' => '#A6B37D',
        'المواد الاجتماعية' => '#F6D7A7',
        'الإنجليزية' => '#BAABDA',
    ];
@endphp

<div class="row mt-10">
    <div class="col-12">
        <div class="accordion-content-wrapper" style="border: #eee 1px solid;border-radius:15px;"
            id="chapterAccordion{{ !empty($chapter) ? $chapter->id : '' }}" role="tablist" aria-multiselectable="true">
            @if (!empty($webinar->chapters) and count($webinar->chapters))
                <ul class="draggable-content-lists draggable-lists-chapter" data-drag-class="draggable-lists-chapter"
                    data-order-table="webinar_chapters">
                    @foreach ($webinar->chapters as $chapter)
                        <li data-id="{{ !empty($chapter) ? $chapter->id : '' }}"
                            data-chapter-order="{{ $chapter->order }}"
                            class="accordion-row rounded-sm panel-shadow mt-20 py-15 py-lg-30 px-10 px-lg-20"
                            style="background:  rgba(255, 255, 255, 0.5) 100%);">

                            <div class="d-flex align-items-center justify-content-between " role="tab"
                                id="chapter_{{ !empty($chapter) ? $chapter->id : 'record' }}">
                                <div class="d-flex align-items-center"
                                    href="#collapseChapter{{ !empty($chapter) ? $chapter->id : 'record' }}"
                                    aria-controls="collapseChapter{{ !empty($chapter) ? $chapter->id : 'record' }}"
                                    data-parent="#chapterAccordion" role="button" data-toggle="collapse"
                                    aria-expanded="false">
                                    <span class="chapter-icon mr-10">
                                        <i data-feather="grid" class=""></i>
                                    </span>
                                    <div class="">
                                        <span
                                            class="font-weight-bold text-dark-blue d-block">{{ !empty($chapter) ? $chapter->title : trans('public.add_new_chapter') }}</span>
                                        <span class="font-12 text-gray d-flex">
                                            {{ !empty($chapter->chapterItems) ? count($chapter->chapterItems) : 0 }}
                                            {{ trans('public.topic') }}
                                        </span>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center">

                                    @if ($chapter->status != \App\Models\WebinarChapter::$chapterActive)
                                        <span class="disabled-content-badge mr-10">{{ trans('public.pending') }}</span>
                                    @endif
                                    {{-- //ToDO --}}
                                    <div class="dropdown mr-10">
                                        <button class="btn add-course-content-btn dropdown-toggle" type="button"
                                            id="dropdownAddBtn{{ $chapter->id }}" data-bs-toggle="dropdown"
                                            aria-expanded="false"
                                            style="width: 28px; height: 28px; border-radius: 50%; padding: 0;">
                                        </button>

                                        <ul class="dropdown-menu text-center"
                                            aria-labelledby="dropdownAddBtn{{ $chapter->id }}">
                                            {{-- Ajouter une vidéo --}}
                                            <li>
                                                <button type="button" class="dropdown-item js-add-course-content-btn "
                                                    data-webinar-id="{{ $webinar->id }}" data-type="file"
                                                    data-chapter="{{ $chapter->id }}">
                                                    📹 تحميل فيديو
                                                </button>
                                            </li>

                                            {{-- Assigner un quiz --}}
                                            <li>
                                                <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#assignQuizModal{{ $chapter->id }}">
                                                    📘 إضافة تحدي
                                                </button>
                                            </li>
                                        </ul>
                                    </div>



                                    <button type="button" class="js-add-chapter btn-transparent text-gray"
                                        data-webinar-id="{{ $webinar->id }}" data-chapter="{{ $chapter->id }}"
                                        data-locale="{{ mb_strtoupper($chapter->locale) }}">
                                        <i data-feather="edit-3" class="mr-10 cursor-pointer" height="20"></i>
                                    </button>
                                    <form action="/panel/chapters/{{ $chapter->id }}/delete" method="GET"
                                        class="delete-chapter-form">
                                        @csrf
                                        <button type="submit"
                                            class="delete-action btn btn-sm btn-transparent text-gray">
                                            <i data-feather="trash-2" class="mr-10 cursor-pointer" height="20"></i>
                                        </button>
                                    </form>

                                    <i data-feather="move" class="move-icon mr-10 cursor-pointer text-gray"
                                        height="20"></i>

                                    <i class="collapse-chevron-icon feather-chevron-down text-gray"
                                        data-feather="chevron-down" height="20"
                                        href="#collapseChapter{{ !empty($chapter) ? $chapter->id : 'record' }}"
                                        aria-controls="collapseChapter{{ !empty($chapter) ? $chapter->id : 'record' }}"
                                        data-parent="#chapterAccordion" role="button" data-toggle="collapse"
                                        aria-expanded="false"></i>
                                </div>
                            </div>
                            <div id="collapseChapter{{ !empty($chapter) ? $chapter->id : 'record' }}"
                                aria-labelledby="chapter_{{ !empty($chapter) ? $chapter->id : 'record' }}"
                                class=" collapse" role="tabpanel">
                                <div class="panel-collapse text-gray">
                                    <div class="accordion-content-wrapper mt-15"
                                        id="chapterContentAccordion{{ !empty($chapter) ? $chapter->id : '' }}"
                                        role="tablist" aria-multiselectable="true">
                                        @if (!empty($chapter->chapterItems) and count($chapter->chapterItems) or !empty($chapter->quiz))
                                            <ul class="draggable-content-lists draggable-lists-chapter-{{ $chapter->id }}"
                                                data-drag-class="draggable-lists-chapter-{{ $chapter->id }}"
                                                data-order-table="webinar_chapter_items">
                                                @foreach ($chapter->chapterItems as $chapterItem)
                                                    @if ($chapterItem->type == \App\Models\WebinarChapterItem::$chapterFile and !empty($chapterItem->file))
                                                        @include(
                                                            'web.default.panel.webinar.create_includes.accordions.file',
                                                            [
                                                                'file' => $chapterItem->file,
                                                                'chapter' => $chapter,
                                                                'chapterItem' => $chapterItem,
                                                            ]
                                                        )
                                                    @endif
                                                @endforeach
                                                @foreach ($quizmodel as $q)
                                                    @if ($q->model_id == $chapter->id)
                                                        @include(
                                                            'web.default.panel.webinar.create_includes.accordions.quiz',
                                                            [
                                                                'quizInfo' => $q,
                                                                'model_id' => $q->model_id,
                                                            ]
                                                        )
                                                    @endif
                                                @endforeach
                                            </ul>
                                        @else
                                            <h4 class="text-gray mt-20 mb-20">
                                                {{ trans('panel.no_content_yet') }}
                                            </h4>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="d-flex align-items-center justify-content-center flex-column p-10">
                    <div class="d-flex align-items-center flex-column text-center">
                        <h2 class="text-dark">
                            {{ trans('panel.no_chapter_yet') }}
                        </h2>
                        <p class="mt-1 text-center text-gray font-weight-500">
                            {{ trans('panel.no_chapter_yet_hint') }}
                        </p>
                    </div>
            @endif
        </div>
    </div>
</div>
@if (isset($chapter))
    <div class="modal fade" id="assignQuizModal{{ $chapter->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">📘 اختيار تحدي</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                </div>
                <div class="modal-body">
                    <select id="quizSelect{{ $chapter->id }}" class="form-control" required>
                        @foreach ($quizzes as $quiz)
                            <option value="{{ $quiz->id }}">{{ $quiz->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button onclick="assignQuiz({{ $chapter->id }})" class="btn btn-success" type="button">
                        تأكيد الربط
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif
@push('scripts_bottom')
    <script>
        document.addEventListener('click', function(event) {
            const icon = event.target.closest(
                '[id^="plus"]');
            // Find the clicked element with id starting with "plus"
            if (icon) {
                event.preventDefault();
                // Prevent the default behavior
                const targetId = icon.getAttribute('href').replace('#', '');
                // Get the target collapse ID
                const target = document.getElementById(targetId);
                // Check if the collapse is not open
                if (target && !target.classList.contains('show')) {
                    target.classList.add('show'); // Open the collapse
                }
            }
        });
    </script>
    <script>
        function assignQuiz(chapterId) {
            const quizId = document.getElementById('quizSelect' + chapterId).value;

            fetch("{{ route('panel.quiz.assignToChapter') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        chapter_id: chapterId,
                        quiz_id: quizId,
                    })
                })
                .then(response => {
                    if (!response.ok) throw new Error("Request failed");
                    return response.json();
                })
                .then(data => {
                    Swal.fire({
                        icon: "success",
                        title: "تم ربط التحدي بنجاح",
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.reload();
                    });
                })
                .catch(error => {
                    console.error("Error:", error);
                    Swal.fire(error.message, "", "error");
                });
        }
    </script>
@endpush

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
                            style="background: linear-gradient(90deg, rgba(255, 255, 255, 0.5) 0%, rgba(255, 255, 255, 0.5) 100%),
                            {{ $materialColors[$webinar->material->name] ?? '#fff' }};">

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

                                    <button type="button"
                                        class="add-course-content-btn js-add-course-content-btn mr-10"
                                        data-webinar-id="{{ $webinar->id }}" data-type="file"
                                        data-chapter="{{ !empty($chapter) ? $chapter->id : '' }}">
                                        <i data-feather="plus"
                                            id="plus{{ !empty($chapter) ? $chapter->id : 'record' }}"
                                            href="#collapseChapter{{ !empty($chapter) ? $chapter->id : 'record' }}"
                                            aria-controls="collapseChapter{{ !empty($chapter) ? $chapter->id : 'record' }}"
                                            data-parent="#chapterAccordion" role="button"></i>
                                    </button>



                                    <button type="button" class="js-add-chapter btn-transparent text-gray"
                                        data-webinar-id="{{ $webinar->id }}" data-chapter="{{ $chapter->id }}"
                                        data-locale="{{ mb_strtoupper($chapter->locale) }}">
                                        <i data-feather="edit-3" class="mr-10 cursor-pointer" height="20"></i>
                                    </button>

                                    <a href="/panel/chapters/{{ $chapter->id }}/delete"
                                        class="delete-action btn btn-sm btn-transparent text-gray">
                                        <i data-feather="trash-2" class="mr-10 cursor-pointer" height="20"></i>
                                    </a>

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

                                        @if (!empty($chapter->chapterItems) and count($chapter->chapterItems))
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
                                                    @elseif($chapterItem->type == \App\Models\WebinarChapterItem::$chapterQuiz and !empty($chapterItem->quiz))
                                                        @include(
                                                            'web.default.panel.webinar.create_includes.accordions.quiz',
                                                            [
                                                                'quizInfo' => $chapterItem->quiz,
                                                                'chapter' => $chapter,
                                                                'chapterItem' => $chapterItem,
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
@endpush

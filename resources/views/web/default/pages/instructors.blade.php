@extends(getTemplate() . '.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/select2/select2.min.css">
@endpush


@section('content')
    <section class="site-top-banner search-top-banner opacity-04 position-relative">
        <img src="{{ getPageBackgroundSettings($page) }}" class="img-cover" alt="" />

        <div class="container h-100">
            <div class="row h-100 align-items-center justify-content-center text-center">
                <div class="col-12 col-md-9 col-lg-7">
                    <div class="top-search-categories-form">
                         <h1 class="text-white mb-15" style="font-size: 3.3rem">{{ $title }}</h1>
                        <span class="course-count-badge py-5 px-10 text-white rounded">{{ $instructorsCount }}
                            معلم</span>

                        <div class="search-input bg-white p-10 flex-grow-1">
                            <form action="/{{ $page }}" method="get">
                                <div class="form-group d-flex align-items-center m-0">
                                    <input type="text" name="search" class="form-control border-0"
                                        value="{{ request()->get('search') }}"
                                        placeholder="{{ trans('public.search_instructors') }}" />
                                    <button type="submit"
                                        class="btn btn-primary rounded-pill">{{ trans('home.find') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container">

        <form id="filtersForm" action="/{{ $page }}" method="get" onsubmit="return false;">

            <div id="topFilters" class="mt-25 shadow-lg border border-gray300 rounded-sm p-10 p-md-20">
                <div class="row align-items-center">
                    <div class="col-lg-9 d-block d-md-flex align-items-center justify-content-start my-25 my-lg-0">
                        {{-- <div class="d-flex align-items-center justify-content-between justify-content-md-center">
                            <label class="mb-0 mr-10 cursor-pointer"
                                for="available_for_meetings">{{ trans('public.available_for_meetings') }}</label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" name="available_for_meetings" class="custom-control-input"
                                    id="available_for_meetings" @if (request()->get('available_for_meetings', 'off') == 'on') checked="checked" @endif>
                                <label class="custom-control-label" for="available_for_meetings"></label>
                            </div>
                        </div> --}}
                    </div>

                    <div class="col-lg-3 d-flex align-items-center">
                        <select name="sort" class="form-control">
                            <option disabled selected>{{ trans('public.sort_by') }}</option>
                            <option value="all">{{ trans('public.all') }}</option>
                            <option value="top_follow" @if (request()->get('sort', null) == 'top_follow') selected="selected" @endif>
                                {{ trans('site.top_follow') }}</option>
                        </select>
                    </div>

                </div>
            </div>

            <div class="px-20 py-15 rounded-sm shadow-lg border border-gray300 d-flex align-items-center">
                <h3 class="category-filter-title font-20 font-weight-bold">{{ trans('home.levels') }}:</h3>
                <div class="p-10 mt-20 d-flex flex-wrap">
                    @foreach ($levels as $level)
                        <div class="checkbox-button bordered-200 mt-5 mr-15">
                            <input type="checkbox" name="levels[]" id="levelCheckbox{{ $level->id }}"
                                value="{{ $level->id }}" class="level-filter">
                            <label for="levelCheckbox{{ $level->id }}">{{ $level->name }}</label>

                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-30 px-20 py-15 rounded-sm shadow-lg border border-gray300 materials-container"
                style="display:none;">
                <h3 class="category-filter-title font-20 font-weight-bold">{{ trans('home.materials') }}</h3>
                <div class="p-10 mt-20 d-flex flex-wrap">
                    @foreach ($matieres as $matiere)
                        <div class="checkbox-button bordered-200 mt-5 mr-15 material"
                            data-level="{{ $matiere->level_id }}">
                            <input type="checkbox" name="materials[]" id="matiereCheckbox{{ $matiere->id }}"
                                value="{{ $matiere->id }}">
                            <label for="matiereCheckbox{{ $matiere->id }}">{{ $matiere->name }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
        </form>


        <section>
            <div class="instructorslist row mt-20" id="instructorsList">

                @foreach ($instructors as $instructor)

                    <div class="col-12 col-md-6 col-lg-4"> @include('web.default.pages.instructor_card', ['instructor' => $instructor])
                    </div>
                @endforeach

            </div>

            <div class="text-center">
                @if ($instructors->lastPage() > $instructors->currentPage())
                    <button type="button" id="loadMoreInstructors"
                        data-page="{{ $page == 'instructors' ? \App\Models\Role::$teacher : \App\Models\Role::$organization }}"
                        class="btn btn-border-white mt-50">
                        {{ trans('site.load_more_instructors') }}
                    </button>
                @endif
            </div>
        </section>



        @if (
            !empty($bestFollowersInstructors) and
                !$bestFollowersInstructors->isEmpty() and
                (empty(request()->get('sort')) or !in_array(request()->get('sort'), ['top_follow'])))
            <section class="mt-50 pt-50">
                <div class="d-flex justify-content-between">
                    <div>
                        <h2 class="font-24 text-dark-blue">{{ trans('site.top_follow') }}</h2>
                        <span class="font-14 text-gray">{{ trans('site.top_follow_subtitle') }}</span>
                    </div>

                    <a href="/{{ $page }}?sort=top_follow"
                        class="btn btn-border-white">{{ trans('home.view_all') }}</a>
                </div>

                <div class="position-relative mt-20">
                    <div id="topSaleInstructorsSwiper" class="swiper-container px-12">
                        <div class="swiper-wrapper pb-20">

                            @foreach ($bestFollowersInstructors as $bestFollowersInstructor)
                            
                                <div class="swiper-slide">
                                    @include('web.default.pages.instructor_card', [
                                        'instructor' => $bestFollowersInstructor,
                                    ])
                                </div>
                            @endforeach

                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <div class="swiper-pagination best-sale-swiper-pagination"></div>
                    </div>
                </div>

            </section>
        @endif
    </div>

@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/select2/select2.min.js"></script>
    <script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>

    <script src="/assets/default/js/parts/instructors.min.js"></script>
    <script>
        // document.addEventListener('DOMContentLoaded', function() {
        //     const levelCheckboxes = document.querySelectorAll('.level-filter');
        //     const materialsContainer = document.querySelector('.materials-container');

        //     levelCheckboxes.forEach(levelCheckbox => {
        //         levelCheckbox.addEventListener('change', function() {
        //             levelCheckboxes.forEach(box => {
        //                 if (box !== this) box.checked = false;
        //             });

        //             if (this.checked) {
        //                 fetchMaterialsForLevel(this.value);
        //             } else {
        //                 materialsContainer.style.display = 'none';
        //                 materialsContainer.innerHTML = '';
        //             }
        //         });
        //     });

        //     function fetchMaterialsForLevel(levelId) {
        //         const url = `/get-materials-by-level?level_id=${levelId}`;
        //         fetch(url)
        //             .then(response => response.json())
        //             .then(matieres => updateMaterialsContainer(matieres))
        //             .catch(error => {
        //                 console.error('Error fetching materials:', error);
        //                 alert('Failed to load materials. Please try again.');
        //             });
        //     }

        //     function updateMaterialsContainer(matieres) {
        //         materialsContainer.innerHTML = '';

        //         if (matieres.length > 0) {
        //             matieres.forEach(mat => {
        //                 const div = document.createElement('div');
        //                 div.className = 'checkbox-button bordered-200 mt-5 mr-15 material';
        //                 div.innerHTML = `<input type="checkbox" name="materials[]" id="matiereCheckbox${mat.id}" value="${mat.id}">
    //                          <label for="matiereCheckbox${mat.id}">${mat.name}</label>`;
        //                 materialsContainer.appendChild(div);
        //             });

        //             materialsContainer.style.display = 'block';
        //         } else {
        //             materialsContainer.style.display = 'none';
        //         }
        //     }
        // });
        // document.addEventListener('DOMContentLoaded', function() {
        //     const levelCheckboxes = document.querySelectorAll('.level-filter');
        //     const materialsContainer = document.querySelector('.materials-container');



        //     levelCheckboxes.forEach(levelCheckbox => {
        //         levelCheckbox.addEventListener('change', function() {
        //             levelCheckboxes.forEach(box => {
        //                 if (box !== this) box.checked = false;
        //             });

        //             if (this.checked) {
        //                 fetchMaterialsForLevel(this.value);
        //             } else {
        //                 materialsContainer.style.display = 'none';
        //                 materialsContainer.innerHTML = '';
        //             }
        //         });
        //     });

        //     function fetchMaterialsForLevel(levelId) {
        //         const url = `instructors/get-materials-by-level?level_id=${levelId}`;
        //         fetch(url)
        //             .then(response => {
        //                 if (!response.ok) {
        //                     throw new Error('Network response was not ok');
        //                 }
        //                 return response.json();
        //             })
        //             .then(matieres => updateMaterialsContainer(matieres))
        //             .catch(error => {
        //                 console.error('Error fetching materials:', error);
        //                 alert('Failed to load materials. Please try again.');
        //             });
        //     }

        //     function updateMaterialsContainer(matieres) {
        //         materialsContainer.innerHTML = '';

        //         if (matieres.length > 0) {
        //             matieres.forEach(mat => {
        //                 const div = document.createElement('div');
        //                 div.className = 'checkbox-button bordered-200 mt-5 mr-15 material';
        //                 div.innerHTML = `<input type="checkbox" name="materials[]" id="matiereCheckbox${mat.id}" value="${mat.id}" class="material-filter">
    //                      <label for="matiereCheckbox${mat.id}">${mat.name}</label>`;
        //                 materialsContainer.appendChild(div);
        //             });

        //             materialsContainer.style.display = 'flex';

        //             const materialCheckboxes = document.querySelectorAll('.material-filter');
        //             materialCheckboxes.forEach(materialCheckbox => {
        //                 materialCheckbox.addEventListener('change', function() {
        //                     materialCheckboxes.forEach(box => {
        //                         if (box !== this) box.checked = false;
        //                     });

        //                     if (this.checked) {
        //                         selectedMaterial = this.value;
        //                     } else {
        //                         selectedMaterial = null;
        //                     }

        //                     searchInstructors(selectedLevel, selectedMaterial);
        //                 });
        //             });
        //         } else {
        //             materialsContainer.style.display = 'none';
        //         }
        //     }

        //     function searchInstructors(level, material) {
        //         const url = `/instructors/search?level=${level || ''}&material=${material || ''}`;
        //         fetch(url)
        //             .then(response => {
        //                 if (!response.ok) {
        //                     throw new Error('Network response was not ok');
        //                 }
        //                 return response.json();
        //             })
        //             .then(instructors => updateInstructorsList(instructors))
        //             .catch(error => {
        //                 console.error('Error searching instructors:', error);
        //                 alert('Failed to search instructors. Please try again.');
        //             });
        //     }

        //     function updateInstructorsList(instructors) {
        //         const instructorsList = document.getElementById('instructorsList');
        //         instructorsList.innerHTML = html;
        //     }
        // });








        // document.addEventListener('DOMContentLoaded', function() {
        //     const levelCheckboxes = document.querySelectorAll('.level-filter');
        //     const materialsContainer = document.querySelector('.materials-container');

        //     let selectedLevel = null;
        //     let selectedMaterial = null;

        //     levelCheckboxes.forEach(levelCheckbox => {
        //         levelCheckbox.addEventListener('change', function() {
        //             levelCheckboxes.forEach(box => {
        //                 if (box !== this) box.checked = false;
        //             });

        //             if (this.checked) {
        //                 selectedLevel = this.value;
        //                 fetchMaterialsForLevel(selectedLevel);
        //             } else {
        //                 materialsContainer.style.display = 'none';
        //                 materialsContainer.innerHTML = '';
        //             }
        //         });
        //     });

        //     function fetchMaterialsForLevel(levelId) {
        //         const url = `instructors/get-materials-by-level?level_id=${levelId}`;
        //         fetch(url)
        //             .then(response => {
        //                 if (!response.ok) {
        //                     throw new Error('Network response was not ok');
        //                 }
        //                 return response.json();
        //             })
        //             .then(matieres => updateMaterialsContainer(matieres))
        //             .catch(error => {
        //                 console.error('Error fetching materials:', error);
        //                 alert('Failed to load materials. Please try again.');
        //             });
        //     }

        //     function updateMaterialsContainer(matieres) {
        //         // Clear the container first
        //         materialsContainer.innerHTML = '';

        //         if (matieres.length > 0) {
        //             const title = document.createElement('h5');
        //             title.textContent = "{{ trans('home.materials') }}:";
        //             title.className = 'category-filter-title font-20 font-weight-bold';
        //             materialsContainer.appendChild(title);

        //             matieres.forEach(mat => {
        //                 const div = document.createElement('div');
        //                 div.className = 'checkbox-button bordered-200 mt-5 mr-15 material';
        //                 div.innerHTML = `
    //     <input type="checkbox" name="materials[]" id="matiereCheckbox${mat.id}" value="${mat.id}" class="material-filter">
    //     <label for="matiereCheckbox${mat.id}">${mat.name}</label>`;
        //                 materialsContainer.appendChild(div);
        //             });

        //             // Make sure the container is displayed as flex
        //             materialsContainer.style.display = 'flex';

        //             // Add event listeners to checkboxes
        //             const materialCheckboxes = document.querySelectorAll('.material-filter');
        //             materialCheckboxes.forEach(materialCheckbox => {
        //                 materialCheckbox.addEventListener('change', function() {
        //                     materialCheckboxes.forEach(box => {
        //                         if (box !== this) box.checked = false;
        //                     });

        //                     if (this.checked) {
        //                         selectedMaterial = this.value;
        //                     } else {
        //                         selectedMaterial = null;
        //                     }

        //                     // Call searchInstructors when a material is selected/deselected
        //                     searchInstructors(selectedLevel, selectedMaterial);
        //                 });
        //             });
        //         } else {
        //             // If there are no materials, hide the container
        //             materialsContainer.style.display = 'none';
        //         }
        //     }





        document.addEventListener('DOMContentLoaded', function() {
            const levelCheckboxes = document.querySelectorAll('.level-filter');
            const materialsContainer = document.querySelector('.materials-container');

            let selectedLevel = null;
            let selectedMaterial = null;

            // Handle level selection
            levelCheckboxes.forEach(levelCheckbox => {
                levelCheckbox.addEventListener('change', function() {
                    levelCheckboxes.forEach(box => {
                        if (box !== this) box.checked = false;
                    });

                    if (this.checked) {
                        selectedLevel = this.value;
                        fetchMaterialsForLevel(
                            selectedLevel);
                        searchInstructors(selectedLevel,
                            selectedMaterial);
                    } else {
                        selectedLevel = null;
                        materialsContainer.style.display = 'none';
                        materialsContainer.innerHTML = '';
                        searchInstructors();
                    }
                });
            });

            function fetchMaterialsForLevel(levelId) {
                const url = `instructors/get-materials-by-level?level_id=${levelId}`;
                fetch(url)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(matieres => updateMaterialsContainer(matieres))
                    .catch(error => {
                        console.error('Error fetching materials:', error);
                        alert('Failed to load materials. Please try again.');
                    });
            }

            function updateMaterialsContainer(matieres) {
                materialsContainer.innerHTML = '';

                if (matieres.length > 0) {
                    const title = document.createElement('h5');
                    title.textContent = "{{ trans('home.materials') }}:";
                    title.className = 'category-filter-title font-20 font-weight-bold';
                    materialsContainer.appendChild(title);

                    matieres.forEach(mat => {
                        const div = document.createElement('div');
                        div.className = 'checkbox-button bordered-200 mt-5 mr-15 material';
                        div.innerHTML = `
                <input type="checkbox" name="materials[]" id="matiereCheckbox${mat.id}" value="${mat.id}" class="material-filter">
                <label for="matiereCheckbox${mat.id}">${mat.name}</label>`;
                        materialsContainer.appendChild(div);
                    });

                    materialsContainer.style.display = 'flex';

                    const materialCheckboxes = document.querySelectorAll('.material-filter');
                    materialCheckboxes.forEach(materialCheckbox => {
                        materialCheckbox.addEventListener('change', function() {
                            materialCheckboxes.forEach(box => {
                                if (box !== this) box.checked =
                                    false;
                            });

                            if (this.checked) {
                                selectedMaterial = this.value;
                            } else {
                                selectedMaterial = null;
                            }

                            searchInstructors(selectedLevel, selectedMaterial);
                        });
                    });
                } else {
                    materialsContainer.style.display = 'none';
                }
            }

            function searchInstructors(level = null, material = null) {
                let url = `/instructors/search?`;
                if (level) {
                    url += `level=${level}`;
                }

                if (material) {
                    url += `&material=${material}`;
                }

                fetch(url)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(response => {
                        updateInstructorsList(response.html);
                    })
                    .catch(error => {
                        alert('Failed to search instructors. Please try again.');
                    });
            }

            function updateInstructorsList(html) {
                const instructorsList = document.querySelector('.instructorslist');
                if (instructorsList) {
                    instructorsList.innerHTML = '';

                    const parentDiv = document.createElement('div');
                    parentDiv.className = 'row'; // Ensure parent is a Bootstrap row

                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = html;

                    const instructorCards = tempDiv.querySelectorAll('.course-teacher-card');

                    if (instructorCards.length > 0) {
                        instructorCards.forEach(card => {
                            const wrapperDiv = document.createElement('div');
                            wrapperDiv.style.margin = '10px';
                            wrapperDiv.style.width = '400px';
                            wrapperDiv.appendChild(card);
                            parentDiv.appendChild(wrapperDiv);
                        });
                    } else {
                        parentDiv.innerHTML =
                        `<h3>{{ trans('home.no_instructors_found') }}</h3>`;
                    }

                    instructorsList.appendChild(parentDiv);
                }
            }



        });
    </script>
@endpush

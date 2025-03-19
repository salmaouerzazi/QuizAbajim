@php
    if (empty($authUser) and auth()->check()) {
        $authUser = auth()->user();
    }

    $navBtnUrl = null;
    $navBtnText = null;

    if (request()->is('forums*')) {
        $navBtnUrl = '/forums/create-topic';
        $navBtnText = trans('update.create_new_topic');
    } else {
        $navbarButton = getNavbarButton(!empty($authUser) ? $authUser->role_id : null);

        if (!empty($navbarButton)) {
            $navBtnUrl = $navbarButton->url;
            $navBtnText = $navbarButton->title;
        }
    }
@endphp

<link rel="stylesheet" href="/assets/vendors/fontawesome/css/all.css">

<style type="text/css">
    .top-navbar .dropdown .badge {
        width: 15px;
        height: 15px !important;
    }

    .logoA {
        width: 82%;
        height: 120% !important;
    }

    @media (max-width: 768px) {
        .img-cover .logoA {
            width: 82%;
            height: 63% !important;
        }
    }

    ul.avatars {
        display: flex;
        /* Causes LI items to display in row. */
        list-style-type: none;
        margin: auto;
        /* Centers vertically / horizontally in flex container. */
        padding: 0px 7px 0px 0px;
        z-index: 1;
        /* Sets up new stack-container. */
    }

    li.avatars__item {
        height: 49px;
        margin: 0px 0px 0px 0px;
        padding: 0px 0px 0px 0px;
        position: relative;
        width: 42px;
        /* Forces flex items to be smaller than their contents. */
    }

    /*
    These zIndex values will only be relative to the contents of the UL element,
    which sets up its own stack container. As such, these will only be relevant
    to each other, not to the page at large.
    --
    NOTE: We could theoretically get around having to set explicit zIndex values
    by using "flex-direction: row-reverse" and using the natural stacking order
    of the DOM; however, to do that, we'd have to reverse the order of the HTML
    elements, which feels janky and unnatural.
*/
    li.avatars__item:nth-child(1) {
        z-index: 9;
    }

    li.avatars__item:nth-child(2) {
        z-index: 8;
    }

    li.avatars__item:nth-child(3) {
        z-index: 7;
    }

    li.avatars__item:nth-child(4) {
        z-index: 6;
    }

    li.avatars__item:nth-child(5) {
        z-index: 5;
    }

    li.avatars__item:nth-child(6) {
        z-index: 4;
    }

    li.avatars__item:nth-child(7) {
        z-index: 3;
    }

    li.avatars__item:nth-child(8) {
        z-index: 2;
    }

    li.avatars__item:nth-child(9) {
        z-index: 1;
    }

    /*
    These items are all 49px wide while the flex-item (in which they live) is
    only 42px wide. As such, there will be several pixels of overflow content,
    which will be displayed in a reverse-stacking order based on above zIndex.
*/
    img.avatars__img,
    span.avatars__initials,
    span.avatars__others {
        background-color: #596376;
        border: 2px solid #1F2532;
        border-radius: 100px 100px 100px 100px;
        color: #FFFFFF;
        display: block;
        font-family: "Tajawal, sans-serif";
        font-size: 31px;
        font-weight: 100;
        height: 45px;
        line-height: 35px;
        text-align: center;
        width: 45px;
    }

    span.avatars__others {
        background-color: #1E8FE1;
    }
img.avatars__img,
    span.avatars__initials,
    span.avatars__others1 {
        background-color: #596376;
        border: 2px solid #1F2532;
        border-radius: 100px 100px 100px 100px;
        color:rgb(7, 0, 0);
        display: block;
        font-family: "Tajawal, sans-serif";
        font-size: 31px;
        font-weight: 100;
        height: 45px;
        line-height: 35px;
        text-align: center;
        width: 45px;
    }

    span.avatars__others1 {
        background-color: #FFFFFF;
    }
    @media (max-width: 992px) {
        #navbar {
            display: none;
        }

        #navbarVacuum {
            display: block;
        }
    }
</style>


<div id="navbarVacuum"></div>
<nav id="navbar" class="navbar navbar-expand-lg navbar-light">
    <div class="{{ (!empty($isPanel) and $isPanel) ? 'container-fluid' : 'container' }}">
        <div class="d-flex align-items-center justify-content-between w-100">
            <a class="navbar-brand navbar-order d-flex align-items-center justify-content-center mr-0 {{ (empty($navBtnUrl) and empty($navBtnText)) ? 'ml-auto' : '' }}"
                href="/panel">
                @if (!empty($generalSettings['logo']))
                    <img src="{{ $generalSettings['logo'] }}" class="img-cover logoA" class="img-cover" alt="site logo">
                @endif
            </a>



            <div class="mx-lg-30 d-none d-lg-flex flex-grow-1 navbar-toggle-content " id="navbarContent">
                <div class="navbar-toggle-header text-right d-lg-none">
                    <button class="btn-transparent" id="navbarClose">
                        <i data-feather="x" width="32" height="32"></i>
                    </button>
                </div>


                @if (!empty($authUser->role_name == 'user'))
                    <ul class="navbar-nav mr-auto d-flex align-items-center">
                        @if (!empty($categories) and count($categories))
                            <li class="mr-lg-25 " style="margin-left:20px">
                                <div class="menu-category">
                                    <ul>
                                        <li class="cursor-pointer user-select-none d-flex xs-categories-toggle">
                                            <i data-feather="grid" width="20" height="20"
                                                class="mr-10 d-none d-lg-block"></i>
                                            <!-- {{ trans('categories.categories') }} -->
                                            Matières
                                            <ul class="cat-dropdown-menu">
                                                @foreach ($categories as $category)
                                                    <li>
                                                        <a
                                                            href="{{ (!empty($category->subCategories) and count($category->subCategories)) ? '#!' : $category->getUrl() }}">
                                                            <div class="d-flex align-items-center">
                                                                <img src="/{{ $category->icon }}"
                                                                    class="cat-dropdown-menu-icon mr-10"
                                                                    alt="{{ $category->title }} icon">
                                                                {{ $category->title }}
                                                            </div>

                                                            @if (!empty($category->subCategories) and count($category->subCategories))
                                                                <i data-feather="chevron-right" width="20"
                                                                    height="20"
                                                                    class="d-none d-lg-inline-block ml-10"></i>
                                                                <i data-feather="chevron-down" width="20"
                                                                    height="20" class="d-inline-block d-lg-none"></i>
                                                            @endif
                                                        </a>

                                                        @if (!empty($category->subCategories) and count($category->subCategories))
                                                            <ul class="sub-menu">
                                                                @foreach ($category->subCategories as $subCategory)
                                                                    <li>
                                                                        <a href="{{ $subCategory->getUrl() }}">
                                                                            @if (!empty($subCategory->icon))
                                                                                <img src="{{ $subCategory->icon }}"
                                                                                    class="cat-dropdown-menu-icon mr-10"
                                                                                    alt="{{ $subCategory->title }} icon">
                                                                            @endif

                                                                            {{ $subCategory->title }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        @endif
                        <li class="mr-lg-55" style=" width: 660px!important;">
                            <form action="/search" method="get"
                                class="form-inline my-2  my-lg-0 navbar-search position-relative"
                                style="margin-left:50px;width: 600px!important;">
                                <input style="margin-left:50px;width: 500px!important;"
                                    class="form-control mr-5 rounded" type="text" name="search"
                                    placeholder=" Courses , Instructors {{ trans('navbar.search_anything') }} "
                                    aria-label="Search">
                                <button type="submit"
                                    class="btn-transparent d-flex align-items-center justify-content-center search-icon">
                                    <i data-feather="search" width="20" height="20" class="mr-10"></i>
                                </button>
                            </form>
                        </li>
                    </ul>
            </div>
            @endif
        </div>
        @if ($authUser->isOrganization())
            <ul class="avatars">
                @if (!empty($enfants))
                
                    @foreach ($enfants as $enf)
                        <a href="/panel/enfant/{{ $enf->id }}">
                            <li class="avatars__item">
                                <a href="/panel/enfant/{{ $enf->id }}">
                                    <img src="/{{ $enf->path }}" class="avatars__img" />
                                </a>
                            </li>
                        </a>
                    @endforeach
                @endif
                <li class="avatars__item">
                    <span class="avatars__others" data-toggle="modal" data-target="#exampleModal">
                        +
                    </span>
                </li>
            </ul>
        @endif
        <div style="width: 50px; height: 50px; display: flex; justify-content: center; align-items: center;">
            <a href="/panel/meetings/settings">
                <svg width="100%" height="100%" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                    <rect x="0" y="0" width="40" height="40" fill="#f5f5f5" stroke="#e0e0e0" stroke-width="1"
                        rx="5" ry="5">
                    </rect>
                    <text x="20" y="15" font-size="13" font-weight="600" text-anchor="middle" fill="#333">
                        {{ date('D') }}
                    </text>
                    <text x="20" y="30" font-size="16" font-weight="bolder" text-anchor="middle" fill="red">
                        {{ date('d') }}
                    </text>
                </svg>
            </a>
        </div>
        {{-- <div class="border-left mx-15 d-none d-lg-block"></div>

        <a style="justify-content: center">
            <a href="/panel/financial/summary">
                <img src="/assets/default/img/activity/36.svg" class="account-balance-icon" width="40%"
                    alt="">
                <h3 class="font-14 font-weight-500 text-gray mr-15">
                    {{ addCurrencyToPrice($authUser->getAccountingBalance()) }} {{ trans('update.dt') }}
                </h3>
            </a>
        </a> --}}

        <!-- border vertical -->
        <div class="border-left mx-15 d-none d-lg-block"></div>
        <!-- border vertical -->

        <div class="nav-icons-or-start-live navbar-order">
            <div class="d-none nav-notify-cart-dropdown top-navbar ">
                @include(getTemplate() . '.includes.notification-dropdown')
            </div>
        </div>



    </div>
</nav>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="margin-top: 90px;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Enfant</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <img src="/17c29bb894f41aad54d8ddb08b40e753.jpg" alt="Example Image" width="50%" height="50%"
                    style="margin-left: 120px;">
                <form method="post" action="/panel/enfant/post">
                    {{ csrf_field() }}
                    <label for="email">Nom enfant:</label><br>
                    <input type="text" name="nom" class="form-control" placeholder="Nom enfant" />
                    <br>
                    <label for="email">Prenom enfant:</label><br>
                    <input type="text" name="prenom" class="form-control" placeholder="Prenom enfant" />
                    <br>



                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text text-white font-16">Sexe</span>
                        </div>



                        <select name="sexe" id="cars"
                            class="form-control {{ !empty($post) ? 'js-edit-content-locale' : '' }}">
                            <option value="Garçon">Garçon</option>
                            <option value="Fille">Fille</option>
                        </select>


                    </div>
                    <br>
                    <div class="form-group">
                        <label class="input-label">Level :</label>
                        <?php
                        $leveeeel = DB::table('school_levels')->where('id', '>', 5)->get();
                        ?>

                        <select name="level_id"
                            class="form-control {{ !empty($post) ? 'js-edit-content-locale' : '' }}">
                            @foreach ($leveeeel as $lang)
                                <option value="{{ $lang->id }}">{{ $lang->name }}</option>
                            @endforeach


                        </select>
                        @error('locale')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Ajouter Enfant</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

@push('scripts_bottom')
    <script src="/assets/default/js/parts/navbar.min.js"></script>
@endpush

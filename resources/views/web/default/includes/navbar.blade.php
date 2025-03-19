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
<link href="/assets/default/css/font.css" rel="stylesheet">
<link rel="stylesheet" href="/assets/vendors/fontawesome/css/all.min.css" />



<style>
    .nav-elements {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        font-weight: bolder;
        font-family: Tajawal, sans-serif;
    }

    #search-form {
        position: relative;
        width: 100%;
        height: 100%;
    }

    #search-input {
        position: absolute;
        left: 100%;
        top: 0;
        display: inline-block;
        overflow: hidden;
        background-color: #fff;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        animation: close 0.5s forwards;
        z-index: 2;

    }

    @keyframes close {
        from {
            width: 200px;
        }

        to {
            width: 0;
        }
    }

    #search-input.show {
        width: 200px;
        padding: 0.375rem 0.75rem;
        display: block;
        animation: shrink 0.5s forwards;

    }

    .search-btn {
        border: 2px solid #22bec8;
        border-radius: 5px;
        background: none;
        color: #22bec8;
        width: 70px;
    }

    /* when open the search with animation */
    @keyframes shrink {
        from {
            width: 0;
        }

        to {
            width: 200px;
        }
    }

    /* when on mobile open the search below */
    @media (max-width: 991px) {
        #search-input {
            left: 0;
            top: 100%;
            display: inline-block;
            overflow: hidden;
        }

        #search-input.show {
            width: 200px;
            padding: 0.375rem 0.75rem;
            display: block;
            animation: shrink 0.5s forwards;

        }

        @keyframes close {
            from {
                width: 200px;
            }

            to {
                width: 0;
            }
        }

        @keyframes shrink {
            from {
                width: 0;
            }

            to {
                width: 200px;
            }
        }

        .search-btn {
            width: 100%;

        }
    }

    .nav-link.topbar:hover {
        color: #22bec8;
        background-color: rgba(34, 190, 200, 0.1);
        border-radius: 5px;
    }

    .nav-link.topbar.active {
        color: #22bec8 !important;
    }

    .drawer-logo {
        position: absolute;
        bottom: 20px;
        left: 0;
        right: 0;
        padding: 10px;
        width: 100%
    }

    .drawer-logo img {
        max-width: 120px;
        margin: auto;
    }

    * {
        font-family: 'Tajawal', sans-serif !important;
    }
</style>
<div class="navbar-overlay" id="navbarOverlay"></div>
<div id="navbarVacuum"></div>
<nav id="navbar" class="navbar navbar-expand-lg navbar-light">
    <div class="{{ (!empty($isPanel) and $isPanel) ? 'container-fluid' : 'nav-elements' }}">
        <div class="d-flex align-items-center justify-content-between w-100">

            <button class="navbar-toggler navbar-order" type="button" id="navbarToggle" aria-label="Navbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand navbar-order d-lg-block d-none" href="/">
                @if (!empty($generalSettings['logo']))
                    <img src="{{ $generalSettings['logo'] }}" style="width: 82%;height: 123%!important;"
                        class="img-cover" alt="الشبكة التعليمية أبجيم">
                @else
                    <img src="/store/1/abajim.png" style="width: 82%;height: 123%!important;" class="img-cover"
                        alt="الشبكة التعليمية أبجيم">
                @endif
            </a>


            <div class="mx-lg-30 d-none d-lg-flex flex-grow-1 navbar-toggle-content" id="navbarContent"
                style="align-items: center;justify-content:center">
                <div class="navbar-toggle-header text-right d-lg-none">
                    <button class="btn-transparent" id="navbarClose" aria-label="Close">
                        <i data-feather="x" width="32" height="32"></i>
                    </button>
                </div>
                @if (empty($authUser))
                    <ul class="navbar-nav mr-auto d-flex align-items-center">
                        @if (!empty($navbarPages) && count($navbarPages))
                            @foreach ($navbarPages as $navbarPage)
                                <li class="nav-item">
                                    <a class="nav-link topbar 
                                    {{ request()->is('/') && $navbarPage['link'] == '/' ? 'active' : '' }} 
                                    {{ request()->is(ltrim($navbarPage['link'], '/')) && $navbarPage['link'] != '/' ? 'active' : '' }}"
                                        style="font-size: 18px !important; margin-left: 5px; font-weight: 500;"
                                        href="{{ $navbarPage['link'] }}">
                                        {{ $navbarPage['title'] }}
                                    </a>
                                </li>
                            @endforeach
                        @else
                            {{-- <li class="nav-item">
                                <a class="nav-link topbar 
                                     
                                    " style="font-size: 18px !important; margin-left: 5px; font-weight: 500;" href="/contact">
                                    اتصال
                                </a>
                            </li>
                             <li class="nav-item">
                                <a class="nav-link topbar 
                                     
                                    " style="font-size: 18px !important; margin-left: 5px; font-weight: 500;" href="/contact">
                                    من نحن؟
                                </a>
                            </li>
                             <li class="nav-item">
                                <a class="nav-link topbar 
                                     
                                    active" style="font-size: 18px !important; margin-left: 5px; font-weight: 500;" href="/manuels">
                                    الكتب المدرسيّة
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link topbar 
                                     
                                    " style="font-size: 18px !important; margin-left: 5px; font-weight: 500;" href="/instructors">
                                    معلّمينا
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link topbar 
                                     
                                    " style="font-size: 18px !important; margin-left: 5px; font-weight: 500;" href="/">
                                    الرئيسية
                                </a>
                            </li> --}}
                        @endif

                    </ul>

                    <ul class="navbar-nav ml-auto d-lg-none">
                        <li class="nav-item">
                            <a href="/login" class="nav-link py-5 px-10 mr-10 text-dark-blue font-16 font-weight-bold"
                                style="border: 2px solid #22bec8;width:fit-content;font-family: 'Tajawal', sans-serif; ">{{ trans('auth.login') }}</a>
                        </li>
                        <li class="nav-item">
                            <a href="/register"
                                class="nav-link py-5 px-10 d-lg-flex btn btn-sm text-white btn-primary nav-start-a-live-btn"
                                style="background-color: #22bec8;font-size: 16px;font-family: 'Tajawal', sans-serif; ">سجل
                                مجانا</a>
                            <a href="{{ empty($authUser) ? '/Instructor/register' : ($authUser->isAdmin() ? '/admin/webinars/create' : ($authUser->isVisiteur() ? '/become_instructor' : '/panel/webinars/new')) }}"
                                class="nav-link py-5 px-10 d-lg-flex btn btn-sm btn-primary text-white nav-start-a-live-btn ml-5"
                                style="font-family: 'Tajawal', sans-serif; ">
                                كن مدرسًا
                            </a>
                        </li>
                    </ul>
                    <div class="d-lg-none text-center drawer-logo mt-auto">
                        <a href="/">
                            @if (!empty($generalSettings['logo']))
                                <img src="{{ $generalSettings['logo'] }}" class="img-fluid" alt="Site Logo">
                            @endif
                        </a>
                    </div>

            </div>

            <div class="nav-icons-or-start-live navbar-order">
                <div class="xs-w-100 d-flex align-items-center justify-content-between ">
                    <div class="d-flex align-items-center">
                        <div class="search-bar d-none d-lg-flex align-items-center">
                            <form action="/search" method="get" class="d-inline-flex" id="search-form">
                                <input type="text" class="form-control" id="search-input" name="search"
                                    placeholder="{{ trans('public.search') }}" style="display: none; width: 0;">
                                <button id="search-btn" type="button" aria-label="Search"
                                    class="py-5 px-10 btn btn-sm btn-primary search-btn">
                                    <i class="fas fa-search"></i>
                                </button>
                            </form>
                        </div>
                        <a class="d-lg-none" href="/">
                            <img src="/assets/default/icons/logo_min.png" alt="Site Logo" style="width: 40px;">
                        </a>


                        <div class="d-none d-lg-flex align-items-center">
                            <a href="/login"
                                class="py-5 px-10 d-lg-flex btn btn-sm btn-primary nav-start-a-live-btn ml-10">{{ trans('auth.login') }}</a>
                            <a href="/register"
                                class="py-5 px-10 d-lg-flex btn btn-sm btn-primary nav-start-a-live-btn  ml-10"
                                style="background-color: #22bec8;font-size: 16px">سجل مجانا</a>

                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

</nav>

@push('scripts_bottom')
    <script src="/assets/default/js/parts/navbar.min.js"></script>
    <script src="/assets/vendors/fontawesome/js/all.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchBtn = document.getElementById('search-btn');
            const searchInput = document.getElementById('search-input');
            const searchForm = document.getElementById('search-form');

            searchBtn.addEventListener('click', function() {
                if (searchInput.style.width === '0px' || searchInput.style.width === '') {
                    searchInput.classList.add('show');
                    searchInput.style.width = '300px';
                    searchInput.style.display = 'inline-block';
                    searchInput.focus();
                } else if (searchInput.value.trim() !== '') {
                    searchForm.submit();
                } else {
                    searchInput.classList.remove('show');
                    searchInput.style.width = '0';
                    setTimeout(() => searchInput.style.display = 'none',
                        500);
                }
            });

            searchInput.addEventListener('keypress', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    if (searchInput.value.trim() !== '') {
                        searchForm.submit();
                    }
                }
            });
        });
    </script>
@endpush

@php
    $getPanelSidebarSettings = getPanelSidebarSettings();

    $socials = getSocials();
    if (!empty($socials) and count($socials)) {
        $socials = collect($socials)->sortBy('order')->toArray();
    }

    $footerColumns = getFooterColumns();

    $userLanguages = !empty($generalSettings['site_language'])
        ? [$generalSettings['site_language'] => getLanguages($generalSettings['site_language'])]
        : [];

    if (!empty($generalSettings['user_languages']) and is_array($generalSettings['user_languages'])) {
        $userLanguages = getLanguages($generalSettings['user_languages']);
    }

    $localLanguage = [];

    foreach ($userLanguages as $key => $userLanguage) {
        $localLanguage[localeToCountryCode($key)] = $userLanguage;
    }

@endphp
<style>
    .font-14 {
        font-size: 1rem !important;
        font-weight: 600;
        line-height: 1.4;
    }

    * {
        font-family: Tajawal, sans-serif;
    }

    .xs-panel-nav {
        top: 0;
    }
    .gray-placeholder {
        display: inline-block;
        width: 100px;
        height: 100px;
        background-color: #e0e0e0;
        border-radius: 50%;
    }

</style>

<div class="xs-panel-nav d-flex d-lg-none py-5 px-15" style="justify-content: space-between">
    <div class="d-flex justify-content-start">
        <button
            class="sidebar-toggler btn-transparent d-flex flex-column-reverse justify-content-center align-items-center p-16 rounded-sm sidebarNavToggle"
            type="button">
            <span style="padding: 8px;font-color:black">{{ trans('navbar.menu') }}</span>
            <i data-feather="menu" width="16" height="16"></i>
        </button>
    </div>
    <div class="d-flex justify-content-end">
        <img src="/assets/default/icons/logo_min.png" alt="logo" style="width: 40px;height:50px">
    </div>

</div>

<div class="panel-sidebar-overlay" id="panel-sidebar-overlay"></div>

<div class="panel-sidebar pt-50 pb-25 px-25" id="panelSidebar">
    <button class="btn-transparent panel-sidebar-close sidebarNavToggle">
        <i data-feather="x" width="24" height="24"></i>
    </button>

    <div class="user-info d-flex align-items-center flex-row flex-lg-column justify-content-lg-center">
        <a href="/panel/enfant" id ="ava" class="user-avatar bg-gray200">
            <img class="img-cover gray-placeholder" id="pathpath">
        </a>

        <div class="d-flex flex-row align-items-center justify-content-center mt-15">

            <a href="#" class="user-name">
                <h3 class="font-16 font-weight-bold text-center" id="newChildName"></h3>
            </a>
            <span class="vertical-separator mx-2"></span>
            <div class="sidebar-user-stat-item d-flex flex-column text-center">
                <span style="background: none; border: none; color: inherit; cursor: pointer;">
                    <strong>0</strong>
                    <span class="font-12">{{ trans('panel.following') }}</span>
                </span>
            </div>
        </div>
    </div>

    <ul id="panel-sidebar-scroll"
        class="sidebar-menu pt-10" @if (!empty($isRtl) and $isRtl) data-simplebar-direction="rtl" @endif>
        <li class="sidenav-item">
            <a href="#" class="d-flex align-items-center">
                <span class="sidenav-item-icon mr-10">
                    @include('web.default.panel.includes.sidebar_icons.books')
                </span>
                <span class="font-14 text-dark-blue font-weight-500">{{ trans('panel.books') }}</span>
            </a>
        </li>

        <li
            class="sidenav-item">
            <a class="d-flex align-items-center" href="#">
                <span class="sidenav-item-icon mr-10">
                    @include('web.default.panel.includes.sidebar_icons.webinars')
                </span>
                <span class="font-14 text-dark-blue font-weight-500">{{ trans('panel.webinars') }}</span>
            </a>
        </li>

        <li class="sidenav-item">
            <a href="#" class="d-flex align-items-center">
                <span class="sidenav-setting-icon sidenav-item-icon mr-10">
                    @include('web.default.panel.includes.sidebar_icons.setting')
                </span>
                <span class="font-14 text-dark-blue font-weight-500">{{ trans('panel.settings') }}</span>
            </a>
        </li>
    </ul>

</div>


@push('scripts_bottom')
    <link href="/assets/default/vendors/flagstrap/css/flags.css" rel="stylesheet">
    <script>
        var appTranslations = {
            changeLanguage: "{{ __('languages.change_language') }}",
        };
    </script>
    <script src="/assets/default/vendors/flagstrap/js/jquery.flagstrap.min.js"></script>
    <script src="/assets/default/js/parts/top_nav_flags.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get all elements with the child-name class
            var childNames = document.querySelectorAll('.child-name');

            // Add click event to each child name
            childNames.forEach(function(childName) {
                childName.addEventListener('click', function() {
                    var container = document.querySelector('.wgh-slider__container');
                    container.innerHTML = '';

                    // Get the full name from the data attribute
                    var fullName = childName.getAttribute('data-full-name');
                    var level_id = childName.getAttribute('data-level-id');
                    var namelavel = childName.getAttribute('data-level-name');
                    var imgE = childName.getAttribute('data-level-path');

                    document.getElementById('useruser').textContent = fullName;

                    var emaaa = document.getElementById('emaaa');
                    var path = document.getElementById('pathpath');

                    var ava = document.getElementById('ava');
                    emaaa.textContent = "المستوى:" + namelavel;
                    path.src = '/' + imgE;

                    path.alt = fullName;
                    ava.style.width = '40%';

                })
            });

        });
    </script>
@endpush

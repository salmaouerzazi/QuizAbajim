

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

@php
    $rtlLanguages = !empty($generalSettings['rtl_languages']) ? $generalSettings['rtl_languages'] : [];

    $isRtl =
        (in_array(mb_strtoupper(app()->getLocale()), $rtlLanguages) or
        !empty($generalSettings['rtl_layout']) and $generalSettings['rtl_layout'] == 1);
@endphp

<head>
    @include(getTemplate() . '.includes.metas')
    <title>
        {{ $pageTitle ?? '' }}
    </title>
    
    <!-- General CSS File -->
    <link href="/assets/default/css/font.css" rel="stylesheet">

    <link rel="stylesheet" href="/assets/default/vendors/sweetalert2/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/toast/jquery.toast.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/simplebar/simplebar.css">
    <link rel="stylesheet" href="/assets/default/css/app.css">
    <link rel="stylesheet" href="/assets/default/css/panel.css">
    <link rel="stylesheet" href="/assets/vendors/fontawesome/css/all.min.css" />
<link rel="stylesheet" href="assets/css/starcode2.css">
    <link ref="stylesheet" href="/assets/default/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/default/css/lisr_free_parser.css">
    <link rel="stylesheet" href="/store/style.css">
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>  
    @if ($isRtl)
        <link rel="stylesheet" href="/assets/default/css/rtl-app.css">
    @endif

    @stack('styles_top')
    @stack('scripts_top')

    <style>
        {!! !empty(getCustomCssAndJs('css')) ? getCustomCssAndJs('css') : '' !!} {!! getThemeFontsSettings() !!} {!! getThemeColorsSettings() !!}
    </style>

    @if (!empty($generalSettings['preloading']) and $generalSettings['preloading'] == '1')
        @include('admin.includes.preloading')
    @endif
    <!-- Meta Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '1135292328173964');
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=1135292328173964&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Meta Pixel Code -->
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-MLJC5849');</script>
    <!-- End Google Tag Manager -->
</head>

<body class="@if ($isRtl) rtl @endif">

    @php
        $isPanel = true;
    @endphp
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MLJC5849"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <div id="panel_app">
        <div style="z-index:99!important">
            @if ($authUser->isTeacher())
                @include(getTemplate() . '.includes.navbarPannel')
            @else
                @include(getTemplate() . '.includes.navbarPannelEnfant')
            @endif
        </div>
        <div class="d-flex @if ($authUser->isOrganization() && Request::is('panel/setting*')) justify-content-center @else justify-content-between @endif">
            @if ($authUser->isTeacher())
                @include(getTemplate() . '.panel.includes.sidebar')
            @elseif ($authUser->isEnfant())
                @include(getTemplate() . '.panel.includes.sidebarEnfant')   
            @elseif($authUser->isOrganization() && !Request::is('panel/setting*'))
                @include(getTemplate() . '.panel.includes.sidebarParent')
            @endif
            <div class="panel-content" style="padding-right: 0px!important;">
                @yield('content')
            </div>
            @include('web.default.includes.advertise_modal.index')
        </div>
    

        <!-- Template JS File -->
        <script src="/assets/default/js/app.js"></script>
        <script src="/assets/default/vendors/moment.min.js"></script>
        <script src="/assets/default/vendors/feather-icons/dist/feather.min.js"></script>
        <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
        <script src="/assets/default/vendors/sweetalert2/dist/sweetalert2.min.js"></script>
        <script src="/assets/default/vendors/toast/jquery.toast.min.js"></script>
        <script type="text/javascript" src="/assets/default/vendors/simplebar/simplebar.min.js"></script>
        <script src="/assets/vendors/fontawesome/js/all.min.js"></script>
        <script>
        const followersText = "{{ trans('panel.followers') }}";
        const isEnfant = "{{ $authUser->isEnfant() }}";
        const next = "{{ trans('panel.next') }}";
        const followedText = "{{ trans('panel.followed') }}";
        const followText = "{{ trans('panel.followed') }}";
        const updateGuideProgressUrl = "{{ route('update.guide.progress') }}";
        const fetchProgressUrl = "{{ route('fetch.progress') }}";
        const description1 = "{{ trans('panel.step_1_child_manuel_description_part_1') }}";
        const description2 = "{{ trans('panel.step_1_child_manuel_description_part_2') }}";
        const description3 = "{{ trans('panel.step_1_child_manuel_description_part_3') }}";
        const description4 = "{{ trans('panel.step_1_child_manuel_description_part_4') }}";
        const descriptionStep2 = "{{ trans('panel.step_2_child_manuel_description') }}";
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js'></script>
        <script src='https://unpkg.com/vue-the-mask@0.11.1/dist/vue-the-mask.js'></script>
        <script src="/store/script.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                fetch('{{ route('clear-session') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    cache: 'no-cache',
                    body: JSON.stringify({})
                })
                .then(response => response.json())
                .then(data => console.log(data.success))
                .catch(error => console.error('Fetch error:', error));
            });
        </script>
        <script>
            var deleteAlertTitle = '{{ trans('public.are_you_sure') }}';
            var deleteAlertHint = '{{ trans('public.deleteAlertHint') }}';
            var deleteAlertConfirm = '{{ trans('public.deleteAlertConfirm') }}';
            var deleteAlertCancel = '{{ trans('public.cancel') }}';
            var deleteAlertSuccess = '{{ trans('public.success') }}';
            var deleteAlertFail = '{{ trans('public.fail') }}';
            var deleteAlertFailHint = '{{ trans('public.deleteAlertFailHint') }}';
            var deleteAlertSuccessHint = '{{ trans('public.deleteAlertSuccessHint') }}';
            var forbiddenRequestToastTitleLang = '{{ trans('public.forbidden_request_toast_lang') }}';
            var forbiddenRequestToastMsgLang = '{{ trans('public.forbidden_request_toast_msg_lang') }}';
        </script>

        @if (session()->has('toast'))
            <script>
                (function() {
                    "use strict";

                    $.toast({
                        heading: '{{ session()->get('toast')['title'] ?? '' }}',
                        text: '{{ session()->get('toast')['msg'] ?? '' }}',
                        bgColor: '@if (session()->get('toast')['status'] == 'success') #43d477 @else #f63c3c @endif',
                        textColor: 'white',
                        hideAfter: 10000,
                        position: 'bottom-right',
                        icon: '{{ session()->get('toast')['status'] }}'
                    });
                })(jQuery)
            </script>
        @endif

        @stack('styles_bottom')
        @stack('scripts_bottom')
        <script src="/assets/default/js//parts/main.min.js"></script>

        <script src="/assets/default/js/panel/public.min.js"></script>

        <script>
            @if (session()->has('registration_package_limited'))
                (function() {
                    "use strict";

                    handleLimitedAccountModal('{!! session()->get('registration_package_limited') !!}')
                })(jQuery)

                {{ session()->forget('registration_package_limited') }}
            @endif

            {!! !empty(getCustomCssAndJs('js')) ? getCustomCssAndJs('js') : '' !!}
        </script>
    </div>
    
</body>

</html>

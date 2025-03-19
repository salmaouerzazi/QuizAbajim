@extends(getTemplate() . '.panel.layouts.panel_layout')

@push('styles_top')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/assets/default/vendors/daterangepicker/daterangepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="/assets/default/css/listviewteacher.css">
    <link rel="stylesheet" href="/assets/default/vendors/toast/jquery.toast.min.css">
@endpush
<style>
    .row {
        margin-left: 0 !important;
        margin-right: 0 !important;
    }
</style>
@section('content')
    <div class="row">
        <div class="col-lg-9 d-none d-sm-block">
            <div class="scroll-menu-wrapper">
                <div class="scroll-left" id="scroll-left1">&#9664;</div>

                <div class="scroll-right" id="scroll-right1">&#9654;</div>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-lg-12 d-none d-sm-block">
            @if (!empty($concour->tree_d_path_enfant))
                <a href="{{ $concour->tree_d_path_enfant }}{{ $page }}" class="fp-embed" data-fp-width="100%"
                    data-fp-height="80vh" data-options='{"LinkTarget": "none"}'></a>

                <script async defer src="https://abajim.com/assets/default/js/panel/flowpaper.min.js"></script>
            @else
                <div style="padding:10px">
                    <object data="{{ $concour->pdf_path_url }}#zoom=auto&page={{ $page }}" type="application/pdf"
                        width="100%" height="860px">
                        <p>Unable to display PDF file. <a href="{{ $concour->pdf_path_url }}">Download</a> instead.
                        </p>
                    </object>
                </div>
            @endif
        </div>



    </div>
@endsection

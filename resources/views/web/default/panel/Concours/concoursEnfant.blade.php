@extends(getTemplate() . '.panel.layouts.panel_layout')

@push('styles_top')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/assets/default/vendors/daterangepicker/daterangepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="/assets/default/css/listviewteacher.css">
    <link rel="stylesheet" href="/assets/default/vendors/toast/jquery.toast.min.css">
@endpush
@section('content')
    @include('web.default.panel.concours_section_child')
@endsection
@push('scripts_bottom')
    <script src="/assets/default/vendors/toast/jquery.toast.min.js"></script>
@endpush

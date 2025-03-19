@extends(getTemplate() . '.layouts.app')

@section('content')
    @php
        $get404ErrorPageSettings = get404ErrorPageSettings();
    @endphp

    <section class="my-50 container text-center">
        <div class="row justify-content-md-center">
            <div class="col col-md-6">
                <img src="{{ $get404ErrorPageSettings['error_image'] ?? '' }}" class="img-cover " alt="">
            </div>
        </div>

        <h2 class="font-36 mb-20">{{ $get404ErrorPageSettings['error_title'] ?? '' }}</h2>
        <a href="{{ url('/') }}" class="btn btn-primary">{{ trans('public.back_home') }}</a>
    </section>
@endsection

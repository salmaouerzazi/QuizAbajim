@extends(getTemplate() . '.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/select2/select2.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/owl-carousel2/owl.carousel.min.css">
@endpush

<style>
    .position-relative {
        position: relative;
    }

    .play-icon {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: rgb(255, 255, 255);
        font-size: 3rem;
        opacity: 0.9;
        cursor: pointer;
        animation: beat 1.5s infinite;
    }

    .play-icon i {
        color: rgba(37, 190, 200, 1);
        font-size: 3rem;
    }

    .manual-image {
        width: 100%;
        height: 90%;
        border-radius: 10px;
    }

    .manuels-bloc {
        position: relative;
        width: auto;
        height: auto;
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
    }

    .manuels-container {
        margin-left: auto;
        margin-right: auto;
        position: relative;
    }
</style>

@section('content')
    <section class="site-top-banner search-top-banner opacity-04 position-relative">
        <img src="{{ getPageBackgroundSettings($page) }}" class="img-cover" alt="" />
        <div class="container h-100">
            <div class="row h-100 align-items-center justify-content-center text-center">
                <div class="col-12 col-md-9 col-lg-7">
                    <div class="top-search-categories-form">
                        <h1 class="text-white mb-15" style="font-size: 3rem">{{ $title }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{--  TABS --}}
    <section class="home-sections home-sections-swiper container position-relative">
        <div class="mt-30 px-20 py-15 rounded-sm shadow-lg border border-gray300">

            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist"
                style="justify-content: center;align-items:center;align-self:center;justify-self:center">
                <li class="nav-item" role="presentation">
                    <a class="nav-link tab-link active" id="pills-first-tab" data-toggle="pill" href="#pills-first"
                        role="tab" aria-controls="pills-first" aria-selected="true"
                        data-level="6">{{ trans('home.first_level') }}</a>
                </li>

                <li class="nav-item" role="presentation">
                    <a class="nav-link tab-link" id="pills-second-tab" data-toggle="pill" href="#pills-second"
                        role="tab" aria-controls="pills-second" aria-selected="false"
                        data-level="7">{{ trans('home.second_level') }}</a>
                </li>

                <li class="nav-item" role="presentation">

                    <a class="nav-link tab-link" id="pills-third-tab" data-toggle="pill" href="#pills-third" role="tab"
                        aria-controls="pills-third" aria-selected="false" data-level="8">{{ trans('home.third_level') }}</a>

                </li>

                <li class="nav-item" role="presentation">

                    <a class="nav-link tab-link" id="pills-fourth-tab" data-toggle="pill" href="#pills-fourth"
                        role="tab" aria-controls="pills-fourth" aria-selected="false"
                        data-level="9">{{ trans('home.fourth_level') }}</a>

                </li>

                <li class="nav-item" role="presentation">
                    <a class="nav-link tab-link" id="pills-fifth-tab" data-toggle="pill" href="#pills-fifth" role="tab"
                        aria-controls="pills-fifth" aria-selected="false"
                        data-level="10">{{ trans('home.fifth_level') }}</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link tab-link" id="pills-sixth-tab" data-toggle="pill" href="#pills-sixth" role="tab"
                        aria-controls="pills-sixth" aria-selected="false"
                        data-level="11">{{ trans('home.sixth_level') }}</a>

                </li>

            </ul>

            @php

                $manuels_1 = App\Models\Manuels::whereHas('matiere.section', function ($query) {
                    $query->where('level_id', 6);
                })->get();

                $manuels_2 = App\Models\Manuels::whereHas('matiere.section', function ($query) {
                    $query->where('level_id', 7);
                })->get();

                $manuels_3 = App\Models\Manuels::whereHas('matiere.section', function ($query) {
                    $query->where('level_id', 8);
                })->get();

                $manuels_4 = App\Models\Manuels::whereHas('matiere.section', function ($query) {
                    $query->where('level_id', 9);
                })->get();

                $manuels_5 = App\Models\Manuels::whereHas('matiere.section', function ($query) {
                    $query->where('level_id', 10);
                })->get();

                $manuels_6 = App\Models\Manuels::whereHas('matiere.section', function ($query) {
                    $query->where('level_id', 11);
                })->get();

            @endphp

            <div class="tab-content" id="pills-tabContent"
                style="justify-content: center;align-items:center;justify-self:center; border-radius:10px;padding:20px;">
                @foreach (['first' => $manuels_1, 'second' => $manuels_2, 'third' => $manuels_3, 'fourth' => $manuels_4, 'fifth' => $manuels_5, 'sixth' => $manuels_6] as $tab => $manuels)
                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="pills-{{ $tab }}"
                        role="tabpanel" aria-labelledby="pills-{{ $tab }}-tab">
                        <div class="manuels-container">
                            <div class="manuels-bloc">
                                @foreach ($manuels as $manuel)
                                    <div class="col-6 col-md-2">
                                        <a href="#" data-toggle="modal"
                                            data-target="#manuelModal{{ $manuel->id }}">
                                            <img src="{{ $manuel->logo }}" alt="{{ $manuel->title }}" class="manual-image"
                                                style="width:100%; height:90%; border-radius:10px;">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>
    <!-- Modals for each manuel -->
    @foreach ([$manuels_1, $manuels_2, $manuels_3, $manuels_4, $manuels_5, $manuels_6] as $manuels)
        @foreach ($manuels as $manuel)
            <div class="modal fade" id="manuelModal{{ $manuel->id }}" tabindex="-1"
                aria-labelledby="manuelModalLabel{{ $manuel->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title" style="font-size: 35px;" id="manuelModalLabel{{ $manuel->id }}">
                                {{ $manuel->title }}
                            </h1>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" style="height: 800px;">
                            @php
                                $documents = json_decode($manuel->documents);
                            @endphp

                            @if ($documents && count($documents) > 0)
                                @foreach ($documents as $document)
                                    @if (!empty($document->{'3d_path_enfant'}))
                                        <a href="{{ $document->{'3d_path_enfant'} }}" class="fp-embed"
                                            data-fp-width="100%" data-fp-height="100%" style="max-width: 100%"></a>
                                    @else
                                        <span>{{ $document->name }} (No 3D path available)</span>
                                    @endif
                                @endforeach
                            @else
                                <p>No documents available.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endforeach


    <section class="home-sections home-sections-swiper container position-relative">
        <div class="text-center">
            <h2 id="dynamicTitle" class="font-weight-bold text-secondary font-30" style="margin-bottom:30px">
                {{ trans('home.example_title_with_level', ['level' => trans('home.first_level')]) }}
            </h2>
        </div>

        <!-- Video Container -->
        <div class="row justify-content-center align-items-center" id="videos-container">
            @include('web.default.pages.partials.videos', ['videos' => $videos])
        </div>
    </section>
@endsection

@push('scripts_bottom')
    {{-- <script async defer src="https://cdn-online.flowpaper.com/zine/3.8.4/js/embed.min.js"></script> --}}
@endpush

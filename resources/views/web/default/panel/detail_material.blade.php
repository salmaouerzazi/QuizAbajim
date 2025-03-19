@extends(getTemplate() . '.panel.layouts.panel_layout')

@push('styles_top')
@endpush



@section('content')
    <div class="row">
        <div class="col-md-5">
            <div class="image-box">

                @if ($material->section->level->id == 10)
                    <a href="/panel/material/{{ $material->id }}">
                        @if ($material->name == 'رياضيات')
                            <img src="/6.png" class="img-cover" alt="">
                        @elseif($material->name == 'العربية')
                            <img src="/9.png" class="img-cover" alt="">
                        @elseif($material->name == 'الإيقاظ العلمي')
                            <img src="/7.png" class="img-cover" alt="">
                        @else
                            <img src="/7.png" class="img-cover" alt="">
                        @endif
                    </a>
                @endif
                @if ($material->section->level->id == 9)
                    <a href="/panel/material/{{ $material->id }}">
                        @if ($material->name == 'رياضيات')
                            <img src="/44el/6.png" class="img-cover" alt="">
                        @elseif($material->name == 'العربية')
                            <img src="/44el/8.png" class="img-cover" alt="">
                        @elseif($material->name == 'الإيقاظ العلمي')
                            <img src="/44el/7.png" class="img-cover" alt="">
                        @else
                            <img src="/44el/7.png" class="img-cover" alt="">
                        @endif
                    </a>
                @endif
                @if ($material->section->level->id == 8)
                    <a href="/panel/material/{{ $material->id }}">
                        @if ($material->name == 'رياضيات')
                            <img src="/33el/6.png" class="img-cover" alt="">
                        @elseif($material->name == 'العربية')
                            <img src="/33el/8.png" class="img-cover" alt="">
                        @elseif($material->name == 'الإيقاظ العلمي')
                            <img src="/33el/7.png" class="img-cover" alt="">
                        @else
                            <img src="/33el/7.png" class="img-cover" alt="">
                        @endif
                    </a>
                @endif
                @if ($material->section->level->id == 7)
                    <a href="/panel/material/{{ $material->id }}">
                        @if ($material->name == 'رياضيات')
                            <img src="/22el/6.png" class="img-cover" alt="">
                        @elseif($material->name == 'العربية')
                            <img src="/22el/8.png" class="img-cover" alt="">
                        @elseif($material->name == 'الإيقاظ العلمي')
                            <img src="/22el/7.png" class="img-cover" alt="">
                        @else
                            <img src="/22el/7.png" class="img-cover" alt="">
                        @endif
                    </a>
                @endif
                @if ($material->section->level->id == 6)
                    <a href="/panel/material/{{ $material->id }}">
                        @if ($material->name == 'رياضيات')
                            <img src="/11el/6.png" class="img-cover" alt="">
                        @elseif($material->name == 'العربية')
                            <img src="/11el/8.png" class="img-cover" alt="">
                        @elseif($material->name == 'الإيقاظ العلمي')
                            <img src="/11el/7.png" class="img-cover" alt="">
                        @else
                            <img src="/11el/7.png" class="img-cover" alt="">
                        @endif
                    </a>
                @endif
            </div>

        </div>
        <div class="col-md-6">
        <h1 class="dashboard-title">  الكتب المدرسية:  (  في  مادة    {{$material->name}}  )</h1>
<h3 class="dashboard-subtitle mt-5"> </h3>
            <div class="row">
                {{-- <h1> المادة {{$material->name}} :</h1> --}}
                @foreach ($material->manuels as $manuel)
                    <div class="col-md-6">
                        <img class="logo" src="{{ asset($manuel->logo) }}" alt="Video Icon" style="width: 75%;height: 83%;border-radius:5%;margin-top: 12px;">
                    </div>
                @endforeach
            </div>

        </div>
    </div>

 <div class="panel-section-card py-20 px-25">
                <div class="d-flex justify-content-between align-items-center mb-10">
                    <h1 class="dashboard-title">{{ trans('panel.webinars') }}</h1>
                    <!-- <a href="/panel/webinars" class="view-all">{{ trans('panel.view_all') }}</a> -->
                </div>
                <div id="webinars-content">
                    <div class="container-fluid">
                        <div class="row">
                            @if (!empty($webinars))
                                @foreach ($webinars as $webinar)
                                    <div class="col-md-4 col-sm-6 col-12 mb-4">
                                        <div class="webinar-card webinar-list">
                                            <div class="image-box">
                                                <a href="{{ $webinar->getLearningPageUrl() }}">
                                                    <img src="/store/{{ $webinar->image_cover }}" class="img-cover" alt="">
                                                </a>
                                                @switch($webinar->status)
                                                    @case(\App\Models\Webinar::$active)
                                                        @if ($webinar->isWebinar())
                                                            @if ($webinar->start_date > time())
                                                                <span class="badge badge-primary">{{ trans('panel.not_conducted') }}</span>
                                                            @elseif($webinar->isProgressing())
                                                                <span class="badge badge-secondary">{{ trans('webinars.in_progress') }}</span>
                                                            @else
                                                                <span class="badge badge-secondary">{{ trans('public.finished') }}</span>
                                                            @endif
                                                        @else
                                                            <span class="badge badge-secondary">{{ trans('webinars.' . $webinar->type) }}</span>
                                                        @endif
                                                    @break

                                                    @case(\App\Models\Webinar::$isDraft)
                                                        <span class="badge badge-danger">{{ trans('public.draft') }}</span>
                                                    @break

                                                    @case(\App\Models\Webinar::$pending)
                                                        <span class="badge badge-warning">{{ trans('public.waiting') }}</span>
                                                    @break

                                                    @case(\App\Models\Webinar::$inactive)
                                                        <span class="badge badge-danger">{{ trans('public.rejected') }}</span>
                                                    @break
                                                @endswitch
                                            </div>

                                            <div class="webinar-card-body w-100 d-flex flex-column">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <h2 class="font-16 text-dark-blue font-weight-bold">
                                                        <a href="{{ $webinar->getLearningPageUrl() }}">{{ $webinar->title }}</a>
                                                    </h2>

                                                    @if ($webinar->isOwner($authUser->id) or $webinar->isPartnerTeacher($authUser->id))
                                                        <div class="btn-group dropdown table-actions">
                                                            <button type="button" class="btn-transparent dropdown-toggle"
                                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i data-feather="more-vertical" height="20"></i>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                @if (!empty($webinar->start_date))
                                                                    <button type="button"
                                                                            data-webinar-id="{{ $webinar->id }}"
                                                                            class="js-webinar-next-session webinar-actions btn-transparent d-block">
                                                                        {{ trans('public.create_join_link') }}
                                                                    </button>
                                                                @endif
                                                                <a href="{{ $webinar->getLearningPageUrl() }}"
                                                                target="_blank"
                                                                class="webinar-actions d-block mt-10">
                                                                    {{ trans('update.learning_page') }}
                                                                </a>
                                                                <a href="/panel/webinars/{{ $webinar->id }}/edit"
                                                                class="webinar-actions d-block mt-10">
                                                                    {{ trans('public.edit') }}
                                                                </a>
                                                                @if ($webinar->isWebinar())
                                                                    <a href="/panel/webinars/{{ $webinar->id }}/step/4"
                                                                    class="webinar-actions d-block mt-10">
                                                                        {{ trans('public.sessions') }}
                                                                    </a>
                                                                @endif
                                                                @if ($authUser->id == $webinar->creator_id)
                                                                    <a href="/panel/webinars/{{ $webinar->id }}/duplicate"
                                                                    class="webinar-actions d-block mt-10">
                                                                        {{ trans('public.duplicate') }}
                                                                    </a>
                                                                @endif
                                                                @if ($webinar->creator_id == $authUser->id)
                                                                    <a href="/panel/webinars/{{ $webinar->id }}/delete"
                                                                    class="webinar-actions d-block mt-10 text-danger delete-action">
                                                                        {{ trans('public.delete') }}
                                                                    </a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="d-flex align-items-center justify-content-between flex-wrap mt-auto">
                                                    <figcaption class="mt-10">
                                                        <div class="user-inline-avatar d-flex align-items-center">
                                                            @if ($authUser && $authUser->id != $webinar->teacher_id and $authUser->id != $webinar->creator_id)
                                                                <a href="/users/{{ $webinar->teacher->id }}/profile" class="d-flex align-items-center mr-15">
                                                                    <div class="d-flex align-items-center mr-15">
                                                                        <img src="{{ $webinar->teacher->getAvatar() }}" class="rounded-circle mr-10" width="40"
                                                                            height="40" alt="">
                                                                        <div class="d-flex flex-column">
                                                                            <span class="stat-value">{{ $webinar->teacher->full_name }}</span>
                                                                            <span class="stat-value text-muted">
                                                                                {{ trans('panel.followers') }} :
                                                                                {{ $webinar->teacher->followers->count() }}
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </figcaption>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span class="badge badge-primary">
                                                            {{ !empty($webinar->matiere_id) ? $webinar->material->name : '' }}
                                                        </span>
                                                    </div>
                                                    <div class="d-flex align-items-start mt-5 mr-15">
                                                        <i class="fas fa-video primary mr-5"></i>
                                                        <span class="stat-value">{{ $webinar->files->count() }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-12 justify-content-center">
                                    @include(getTemplate() . '.includes.no-result', [
                                        'file_name' => 'webinar.png',
                                        'title' => trans('panel.you_not_have_any_webinar'),
                                        'hint' => trans('panel.no_result_hint'),
                                        'btn' => [
                                            'url' => '/panel/webinars/new',
                                            'text' => trans('panel.create_a_webinar'),
                                        ],
                                    ])
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
</div>  
@endsection


@push('scripts_bottom')
@endpush

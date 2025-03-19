@extends(getTemplate() . '.panel.layouts.panel_layout')
<style>
    .truncated-title {
        width: 300px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        cursor: pointer;
    }
</style>
@section('content')

    <section class="pl-20 pr-20">
        <form action="/panel/webinars/allcourses" method="get" id="filtersForm">
            @include('web.default.pages.includes.top_filters')
            <div class="panel-section-card py-20 px-25 mt-20">
                @if (!empty($webinars) and !$webinars->isEmpty())
                    <div class="row">
                        @foreach ($webinars as $webinar)
                            @php
                                $lastSession = $webinar->lastSession();
                                $nextSession = $webinar->nextSession();
                                $isProgressing = false;

                                if (
                                    $webinar->start_date <= time() and
                                    !empty($lastSession) and
                                    $lastSession->date > time()
                                ) {
                                    $isProgressing = true;
                                }
                            @endphp
                            <div class="col-12 col-lg-4 col-md-6 mb-10">
                                <div class="webinar-card webinar-list">
                                    <a href="{{ $webinar->getUrl() }}" target="_blank">
                                        <div class="image-box">

                                            <img src="/store/{{ $webinar->image_cover }}" class="img-cover"
                                                alt="">
                                        </div>

                                        <div class="webinar-card-body w-100 d-flex flex-column">
                                            <div
                                                class="d-flex align-items-center justify-content-between flex-wrap mt-auto">
                                                <h3 class="font-16 text-dark-blue font-weight-bold mb-10 truncated-title"
                                                    title="{{ $webinar->title }}">
                                                    {{ $webinar->title }}
                                                </h3>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="row">                              
                                        <div class="col-12 col-lg-8">
                                            @if ($authUser->id != $webinar->teacher_id and $authUser->id != $webinar->creator_id)
                                                <a href="/users/{{ $webinar->teacher->id }}/profile"
                                                    class="d-flex align-items-center mr-15">
                                                    <div class="d-flex align-items-center mr-15">
                                                        <img src="{{ $webinar->teacher->getAvatar() }}" class="rounded-circle mr-10"
                                                            width="40" height="40" alt="">
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
                                        <div class="col-12 col-lg-4 mt-10">
                                            <span class="stat-value "
                                                            style="border: 1px solid {{ $materialColors[$webinar->material->name] ?? '#ccc' }};
                                                            color: {{ $materialColors[$webinar->material->name] ?? '#ccc' }};
                                                            border-radius: 5px; padding: 5px 10px;">
                                                            {{ !empty($webinar->matiere_id) ? $webinar->material->name : '' }}
                                                        </span>
                                        </div>
                                    </div>  
                                </div>
                            </div>
                        @endforeach
                    </div>
            
            <div class="my-30">
                {{ $webinars->appends(request()->input())->links('vendor.pagination.panel') }}
            </div>
        @else
            @include(getTemplate() . '.includes.no-result', [
                'file_name' => 'no-result-course.png',
                'title' => trans('panel.you_not_have_any_webinar_child'),
                'hint' => trans('panel.no_result_hint_webinar_child'),
            ])
            @endif
            </div>
        </form>
    </section>

    @include('web.default.panel.webinar.make_next_session_modal')
@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/daterangepicker/daterangepicker.min.js"></script>

    <script>
        var undefinedActiveSessionLang = '{{ trans('webinars.undefined_active_session') }}';
        var saveSuccessLang = '{{ trans('webinars.success_store') }}';
    </script>

    <script src="/assets/default/js/panel/make_next_session.min.js"></script>
@endpush

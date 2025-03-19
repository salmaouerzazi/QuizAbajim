 @extends(getTemplate() . '.panel.layouts.panel_layout')

 @push('styles_top')
     <link rel="stylesheet" href="/assets/default/vendors/daterangepicker/daterangepicker.min.css" />

     <style>
         * {
             font-family: 'Tajawal', sans-serif;
         }

         .activities-container {
             padding: 10px;
             margin: auto;
         }

         .activities-container .row {
             display: flex;
             justify-content: space-around;
             flex-wrap: wrap;
         }

         .activities-container .col-md-3 {
             display: flex;
             justify-content: center;
             align-items: center;
             margin-top: 30px;
         }

         .activities-container .col-md-3 div {
             background-color: #f0f4f7;
             border-radius: 12px;
             padding: 15px;
             width: 100%;
             transition: transform 0.3s;
         }

         .activities-container .col-md-3:hover div {
             transform: translateY(-5px);
         }

         .stats-icon {
             width: 80px;
             height: 70px;
         }

         @media (max-width: 767px) {
             .stats-icon {
                 width: 70px;
                 height: 70px;
             }
         }

         .activities-container .col-md-3:nth-child(1) div {
             background-color: #e9f5ff;
         }

         .activities-container .col-md-3:nth-child(2) div {
             background-color: #e9ffe9;
         }

         .activities-container .col-md-3:nth-child(3) div {
             background-color: #ffe9e9;
         }

         .activities-container .btn-create-webinar {
             font-family: 'Tajawal', sans-serif !important;
             font-size: 16px;
             font-weight: 600;
             color: #90cb57;
             padding: 15px;
             display: inline-flex;
             align-items: center;
             justify-content: center;
             height: 100%;
             background-color: transparent;
             text-decoration: none;
             transition: all 0.3s ease;
             box-sizing: border-box;
         }

         .add-webinar-icon {
             animation: zoomInOut 1.5s infinite;
         }

         @keyframes zoomInOut {
             0% {
                 transform: scale(1);
             }

             50% {
                 transform: scale(1.1);
             }

             100% {
                 transform: scale(1);
             }
         }

         .activities-container .btn-create-webinar i {
             margin-right: 8px;
             font-size: 18px;
             color: #004b96;
         }


         .stats-icon {
             width: 80px;
             height: 70px;
         }

         .form-control {
             font-size: 16px !important
         }


         .panel-section-card {
             background-color: #ffffff;
             border-radius: 12px;
             box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
             width: 100%;
             transition: transform 0.3s;
             margin: auto;
         }

         .section-title {
             font-size: 16px;
             color: #333;
             padding: 10px
         }
     </style>
 @endpush
 @section('content')
     <section class="pl-20 pr-20">
         <div class="panel-section-card activities-container">
             <div class="row">
                 <div class="col-6 col-md-3 mt-md-0 d-flex align-items-center justify-content-center">
                     <div class="d-flex flex-column align-items-center text-center">
                         <img src="/assets/default/icons/e-book.png" width="64" height="64" alt="">
                         <strong
                             class="font-30 text-dark-blue font-weight-bold mt-5">{{ !empty($webinars) ? $webinarsCount : 0 }}</strong>
                         <span class="font-16 text-gray font-weight-500">{{ trans('panel.classes') }}</span>
                     </div>
                 </div>

                 <div class="col-6 col-md-3 mt-md-0 d-flex align-items-center justify-content-center">
                     <div class="d-flex flex-column align-items-center text-center">
                         <img src="/assets/default/icons/like-icon.png" alt="" class="stats-icon">
                         <strong class="font-30 text-dark-blue font-weight-bold mt-5">{{ 0 }}</strong>
                         <span class="font-16 text-gray font-weight-500">{{ trans('panel.number_likes') }}</span>
                     </div>
                 </div>
                 <div class="col-6 col-md-3 mt-md-0 d-flex align-items-center justify-content-center">
                     <div class="d-flex flex-column align-items-center text-center">
                         <img src="/assets/default/icons/click-icon.png" width="64" height="64" alt="">
                         <strong class="font-30 text-dark-blue font-weight-bold mt-5">{{ 0 }}</strong>
                         <span class="font-16 text-gray font-weight-500">{{ trans('panel.visits') }}</span>
                     </div>
                 </div>

                 <div class="col-6 col-md-2  mt-md-0 d-flex align-items-center justify-content-center">
                     <a href="/panel/webinars/new/">
                         <div class="d-flex flex-column align-items-center text-center btn-create-webinar">
                             <img src="/assets/default/icons/add-icon.png" class="add-webinar-icon" width="80"
                                 height="80" alt="">
                             <span class="font-16 text-gray font-weight-500">{{ trans('panel.create_webinar') }}</span>
                         </div>
                     </a>
                 </div>
             </div>
         </div>

     </section>

     <section class="pl-20 pr-20">
         <div class="panel-section-card py-20 px-25 mt-10">
             <form method="get" class="row justify-content-center">
                 <div class="col-12 col-lg-3">
                     <h2 class="section-title"> {{ trans('panel.search_specific_webinar') }} </h2>
                 </div>
                 <div class="col-12 col-lg-3">
                     <div class="form-group mb-20 mb-lg-0">
                         <select class="form-control" style="font-family: 'Tajawal', sans-serif;" id="level_id"
                             name="level_id" onchange="this.form.submit()">
                             <option disabled selected>{{ trans('public.sort_by_level') }}</option>
                             <option value="">{{ trans('public.all') }}</option>
                             @foreach ($level as $lvl)
                                 <option value="{{ $lvl->id }}"
                                     {{ request()->get('level_id') == $lvl->id ? 'selected' : '' }}>
                                     {{ $lvl->name }}
                                 </option>
                             @endforeach
                         </select>
                     </div>
                 </div>
                 <div class="col-12 col-lg-3">
                     <div class="form-group mb-20 mb-lg-0">
                         <select class="form-control" style="font-family: 'Tajawal', sans-serif;" id="material_name"
                             name="material_name" onchange="this.form.submit()">
                             <option disabled selected>{{ trans('public.sort_by_matiere') }}</option>
                             <option value="">{{ trans('public.all') }}</option>
                             @foreach ($material as $m)
                                 <option value="{{ $m->name }}"
                                     {{ request()->get('material_name') == $m->name ? 'selected' : '' }}>
                                     {{ $m->name }}
                                 </option>
                             @endforeach
                         </select>
                     </div>
                 </div>
                 <div class="col-12 col-lg-3">
                     <div class="form-group mb-20 mb-lg-0">
                         <select id="webinar_status" style="font-family: 'Tajawal', sans-serif;" name="webinar_status"
                             onchange="this.form.submit()" class="form-control select2">
                             <option disabled selected>{{ trans('panel.webinar_status') }}</option>
                             <option value="all">{{ trans('public.all') }}</option>
                             <option value="active" {{ request()->get('webinar_status') == 'active' ? 'selected' : '' }}>
                                 {{ trans('panel.active') }}
                             </option>
                             <option value="inactive"
                                 {{ request()->get('webinar_status') == 'inactive' ? 'selected' : '' }}>
                                 {{ trans('panel.inactive') }}
                             </option>
                             <option value="is_draft"
                                 {{ request()->get('webinar_status') == 'is_draft' ? 'selected' : '' }}>
                                 {{ trans('panel.is_draft') }}
                             </option>
                             <option value="pending" {{ request()->get('webinar_status') == 'pending' ? 'selected' : '' }}>
                                 {{ trans('panel.pending') }}
                             </option>
                         </select>
                     </div>
                 </div>

             </form>
         </div>
     </section>

     <section class="pl-20 pr-20">
         <div class="panel-section-card py-20 px-25 mt-20">
             <div class="row">
                 @if (!empty($webinars) and !$webinars->isEmpty())
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
                                 <div class="image-box">
                                     <img src="/store/{{ $webinar->image_cover }}" class="img-cover" alt="">
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
                                                 <span
                                                     class="badge badge-secondary">{{ trans('webinars.' . $webinar->type) }}</span>
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
                                         <h3 class="font-16 text-dark-blue font-weight-bold">{{ $webinar->title }}</h3>

                                         @if ($webinar->isOwner($authUser->id) or $webinar->isPartnerTeacher($authUser->id))
                                             <div class="btn-group dropdown table-actions">
                                                 <button type="button" class="btn-transparent dropdown-toggle"
                                                     data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                     <i data-feather="more-vertical" height="20"></i>
                                                 </button>
                                                 <div class="dropdown-menu ">
                                                     @if (!empty($webinar->start_date))
                                                         <button type="button" data-webinar-id="{{ $webinar->id }}"
                                                             class="js-webinar-next-session webinar-actions btn-transparent d-block">{{ trans('public.create_join_link') }}</button>
                                                     @endif
                                                     {{-- @if ($authUser->id == $webinar->creator_id) --}}
                                                     <a href="{{ $webinar->getLearningPageUrl() }}" target="_blank"
                                                         class="webinar-actions d-block mt-10">{{ trans('update.learning_page') }}</a>
                                                     {{-- @endif --}}
                                                     <a href="/panel/webinars/{{ $webinar->id }}/edit"
                                                         class="webinar-actions d-block mt-10">{{ trans('public.edit') }}</a>

                                                     @if ($webinar->isWebinar())
                                                         <a href="/panel/webinars/{{ $webinar->id }}/step/4"
                                                             class="webinar-actions d-block mt-10">{{ trans('public.sessions') }}</a>
                                                     @endif


                                                     @if ($authUser->id == $webinar->creator_id)
                                                         <a href="/panel/webinars/{{ $webinar->id }}/duplicate"
                                                             class="webinar-actions d-block mt-10">{{ trans('public.duplicate') }}</a>
                                                     @endif

                                                     @if ($webinar->creator_id == $authUser->id)
                                                         <a href="/panel/webinars/{{ $webinar->id }}/delete"
                                                             class="webinar-actions d-block mt-10 text-danger delete-action">{{ trans('public.delete') }}</a>
                                                     @endif
                                                 </div>
                                             </div>
                                         @endif
                                     </div>

                                     <div class="d-flex align-items-center justify-content-between flex-wrap mt-auto">
                                         <div class="d-flex align-items-start flex-column mt-20 mr-15">
                                             <span class="stat-title">{{ trans('public.item_id') }}:</span>
                                             <span class="stat-value">#{{ $webinar->id }}</span>
                                         </div>

                                         <div class="d-flex align-items-start flex-column mt-20 mr-15">
                                             <span class="stat-title">{{ trans('public.level') }}:</span>
                                             <span
                                                 class="stat-value">{{ !empty($webinar->level_id) ? $webinar->level->name : '' }}</span>
                                         </div>
                                         <div class="d-flex align-items-start flex-column mt-20 mr-15">
                                             <span class="stat-title">{{ trans('public.material_or_field') }}:</span>
                                             <span
                                                 class="stat-value">{{ !empty($webinar->matiere_id) ? $webinar->material->name : '' }}</span>
                                         </div>
                                         @if (!empty($webinar->submaterial_id))
                                             <div class="d-flex align-items-start flex-column mt-20 mr-15">
                                                 <span class="stat-title">{{ trans('public.material') }}:</span>
                                                 <span
                                                     class="stat-value">{{ !empty($webinar->submaterial_id) ? $webinar->submaterial->name : '' }}</span>
                                             </div>
                                         @endif

                                         @if (
                                             !empty($webinar->partner_instructor) and
                                                 $webinar->partner_instructor and
                                                 $authUser->id != $webinar->teacher_id and
                                                 $authUser->id != $webinar->creator_id)
                                             <div class="d-flex align-items-start flex-column mt-20 mr-15">
                                                 <span class="stat-title">{{ trans('panel.invited_by') }}:</span>
                                                 <span class="stat-value">{{ $webinar->teacher->full_name }}</span>
                                             </div>
                                         @elseif($authUser->id != $webinar->teacher_id and $authUser->id != $webinar->creator_id)
                                             <div class="d-flex align-items-start flex-column mt-20 mr-15">
                                                 <span class="stat-title">{{ trans('webinars.teacher_name') }}:</span>
                                                 <span class="stat-value">{{ $webinar->teacher->full_name }}</span>
                                             </div>
                                         @elseif(
                                             $authUser->id == $webinar->teacher_id and
                                                 $authUser->id != $webinar->creator_id and
                                                 $webinar->creator->isOrganization())
                                             <div class="d-flex align-items-start flex-column mt-20 mr-15">
                                                 <span
                                                     class="stat-title">{{ trans('webinars.organization_name') }}:</span>
                                                 <span class="stat-value">{{ $webinar->creator->full_name }}</span>
                                             </div>
                                         @endif
                                     </div>
                                     <div class="d-flex align-items-center justify-content-between flex-wrap mt-auto">
                                         {{-- <div class="d-flex align-items-start mt-20 mr-15">
                                             <i class="fas fa-clock mr-5" style="color: #c0c5c9"></i>
                                             <span
                                                 class="stat-value">{{ convertMinutesToHourAndMinute($webinar->duration) }}
                                             </span>
                                         </div> --}}

                                         <div class="d-flex align-items-start flex-column mt-20 mr-15">
                                             <span class="stat-title"> {{ trans('public.chapter_number') }} :</span>
                                             <span class="stat-value">{{ $webinar->chapters->count() }}</span>
                                         </div>
                                         <div class="d-flex align-items-start mt-20 mr-15">
                                             {{-- <span class="stat-title"> {{ trans('public.videos_files_number') }} :</span> --}}
                                             <i class="fas fa-video mr-5" style="color: #c0c5c9"></i>
                                             <span class="stat-value">{{ $webinar->files->count() }}</span>
                                         </div>
                                         @if ($webinar->status === \App\Models\Webinar::$active)
                                             <div class="d-flex align-items-start mt-20 mr-15">
                                                 <i class="fas fa-heart mr-5" style="color: red"></i>
                                                 <span class="stat-value">
                                                     {{ 0 }}
                                                 </span>
                                             </div>
                                             <div class="d-flex align-items-start mt-20 mr-15">
                                                 <i class="fas fa-eye mr-5" style="color: blue"></i>
                                                 <span class="stat-value">
                                                     {{ 0 }}</span>
                                             </div>
                                         @endif

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
             <div class="col-12 justify-content-center">
                 @include(getTemplate() . '.includes.no-result', [
                     'file_name' => 'webinar.png',
                     'title' => trans('panel.you_not_have_any_webinar'),
                     'hint' => trans('panel.no_result_hint'),
                     'btn' => ['url' => '/panel/webinars/new', 'text' => trans('panel.create_a_webinar')],
                 ])
                 @endif
             </div>
         </div>

     </section>

     @include('web.default.panel.webinar.make_next_session_modal')
     <!-- Modal -->
     <div class="modal fade" id="verificationModal" tabindex="-1" role="dialog"
         aria-labelledby="verificationModalLabel" aria-hidden="true">
         <div class="modal-dialog" role="document">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="verificationModalLabel">{{ trans('public.confirm_update') }}</h5>
                     <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
                 <div class="modal-body">
                     {{ trans('public.request_under_verification') }}
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary"
                         data-bs-dismiss="modal">{{ trans('public.ok') }}</button>
                 </div>
             </div>
         </div>
     </div>

 @endsection

 @push('scripts_bottom')
     <script src="/assets/default/vendors/daterangepicker/daterangepicker.min.js"></script>
     @if (session('show_modal'))
         <script>
             document.addEventListener('DOMContentLoaded', function() {
                 $('#verificationModal').modal('show');
             });
         </script>
     @endif
     <script>
         var undefinedActiveSessionLang = '{{ trans('webinars.undefined_active_session') }}';
         var saveSuccessLang = '{{ trans('webinars.success_store') }}';
     </script>

     <script src="/assets/default/js/panel/make_next_session.min.js"></script>
 @endpush

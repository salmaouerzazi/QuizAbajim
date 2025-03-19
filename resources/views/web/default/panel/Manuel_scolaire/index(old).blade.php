@extends(getTemplate() .'.panel.layouts.panel_layout')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/daterangepicker/daterangepicker.min.css">
<link rel="stylesheet" href="/assets/default/vendors/video/video-js.min.css">


@endpush

@section('content')
<style>
   

@media (max-width: 1600px) {
    .webinar-card.webinar-list {
        flex-direction: column;
    }
    
    .webinar-card.webinar-list.webinar-list-2 .image-box {
        width: 240px;
        min-width: 235px;
        height: 210px !important;
    }
}

/* The Close Button */
.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}

    .webinar-card.webinar-list.webinar-list-2 .image-box {
        width: 100%;
        min-width: 235px;
        height: 210px !important;
    }

    .course-content-sidebar .course-img.has-video .course-video-icon {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        box-shadow: 0 20px 12px 0 rgba(0, 0, 0, 0.1);
        background-color: #ffffff;
        width: 96px;
        height: 96px;
        border-radius: 50%;
        z-index: 2;
    }
    .pdf-icon {
        margin-right: 87%;
    font-size: 24%;
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
  display: block;
  position: relative;
  width: 6em;
  height: 8.5em;
  background-color: #eee;
  background-image: url("");
  background-repeat: no-repeat;
  -webkit-background-size: 85% auto;
  -moz-background-size: 85% auto;
  background-size: 85% auto;
  background-position: center 2em;
  border-radius: 1px 2em 1px 1px;
  border: 1px solid #ddd;
}
.pdf-icon:after {
  content: 'PDF';
  font-family: Arial;
  font-weight: bold;
  font-size: 1.2em;
  text-align: center;
  padding: 0.2em 0 0.1em;
  color: #fff;
  display: block;
  position: absolute;
  top: 0.7em;
  left: -1.5em;
  width: 3.4em;
  height: auto;
  background: #da2525;
  border-radius: 2px;
}
.modal {
    display: none; 
    position: fixed;
    z-index: 9;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0, 0, 0); 
    background-color: rgba(0, 0, 0, 0.4); 
}


.modal-content {
    top: 30%;
    position: relative;
    margin: auto;
    padding: 20px;
    width: 100%;
    max-width: 757px;
    background-color: white;
    border-radius: 10px;
}

.close {
    position: absolute;
    top: 10px;
    right: 25px;
    color: #aaa;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

</style>
<section>
    <h2 class="section-title">قناتي</h2>

    <div class="activities-container  p-lg-10">
        <div class="row">
            <div class="col-6 col-md-3 mt-30 mt-md-0 d-flex align-items-center justify-content-center">
                <div class="d-flex flex-column align-items-center text-center">
                    <img src="/assets/default/img/activity/webinars.svg" width="64" height="64" alt="">
                    <strong class="font-30 text-dark-blue font-weight-bold mt-5">{{ !empty($videocount) ? $videocount : 0}}</strong>
                    <span class="font-16 text-gray font-weight-500">عدد الفيديوهات</span>
                </div>
            </div>

            <div class="col-6 col-md-3 mt-30 mt-md-0 d-flex align-items-center justify-content-center">
                <div class="d-flex flex-column align-items-center text-center">
                    <img src="/assets/default/img/activity/hours.svg" width="64" height="64" alt="">
                    {{-- <strong class="font-30 text-dark-blue font-weight-bold mt-5">{{ convertMinutesToHourAndMinute($webinarHours) }}</strong>--}}
                    <strong class="font-30 text-dark-blue font-weight-bold mt-5">00:00</strong>
                    <span class="font-16 text-gray font-weight-500">عدد الساعات</span>
                </div>
            </div>

            <div class="col-6 col-md-3 mt-30 mt-md-0 d-flex align-items-center justify-content-center mt-5 mt-md-0">
                <div class="d-flex flex-column align-items-center text-center">
                    <img src="/assets/default/img/activity/upcoming.svg" width="64" height="64" alt="">
                    {{-- <strong class="font-30 text-dark-blue font-weight-bold mt-5">{{ addCurrencyToPrice($webinarSalesAmount) }}</strong>--}}
                    <strong class="font-30 text-dark-blue font-weight-bold mt-5">0</strong>
                    <span class="font-16 text-gray font-weight-500">مجموع المشاهدات</span>
                </div>
            </div>

            <div class="col-6 col-md-3 mt-30 mt-md-0 d-flex align-items-center justify-content-center mt-5 mt-md-0">
                <div class="d-flex flex-column align-items-center text-center">
                    <img src="/assets/default/img/activity/icons8.png" width="64" height="64" alt="">
                    {{-- <strong class="font-30 text-dark-blue font-weight-bold mt-5">{{ addCurrencyToPrice($courseSalesAmount) }}</strong> --}}
                    <strong class="font-30 text-dark-blue font-weight-bold mt-5">0</strong>
                    <span class="font-16 text-gray font-weight-500">عدد اللايكات</span>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="mt-10">
    <h2 class="section-title">تصفيةالفيديوتي </h2>

    <div class="panel-section-card py-20 px-25 mt-20">
        <form  method="get" class="row">
            <div class="col-12 col-lg-3">
                <div class="col-12 col-lg-12">
                   
                            <div class="form-group">
                                <label class="input-label">{{ trans('public.sort_by_level') }}</label>
                                <select class="form-control" id="level_id" name="level_id" onchange="this.form.submit()">
                                    <option disabled selected>{{ trans('public.sort_by_level') }}</option>
                                    <option value="">{{ trans('public.all') }}</option>
                                    @foreach ($level as $level)          
                                            <option value="{{$level->id }}" @if (request()->get('level_id') == $level->id) selected="selected" @endif>{{ $level->name }}</option>
                                    @endforeach
                                    </select>
                                
                                    
                                              
                            </div>       
                </div>      
                
            </div>
            <div class="col-12 col-lg-6">
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            
                            <label class="input-label">الكتاب المدرسي</label>
                            <select  id="matiere_id" name="matiere_id" onchange="this.form.submit()" class="form-control select2" data-placeholder="{{ trans('public.all') }}" >
                                <option value="all">{{ trans('public.all') }}</option>
                                
                                @foreach ($matierefiltre as $m)
                               
                             
                                <option value="">{{  $m  }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="row">
                            <div class="col-12 col-lg-12">
                                <div class="form-group">
                                    <label class="input-label">درس</label>
                                    <input type="text" name="total_mark" class="form-control" value="{{ request()->get('total_mark','') }}" />
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
           
        </form>
    </div>
</section>
<section class="mt-25">
    <div class="d-flex align-items-start align-items-md-center justify-content-between flex-column flex-md-row">
        <h2 class="section-title">الفيديوتي</h2>

        {{-- <form action="" method="get">
                <div class="d-flex align-items-center flex-row-reverse flex-md-row justify-content-start justify-content-md-center mt-20 mt-md-0">
                    <label class="cursor-pointer mb-0 mr-10 font-weight-500 font-14 text-gray" for="conductedSwitch">{{ trans('panel.only_not_conducted_webinars') }}</label>
        <div class="custom-control custom-switch">
            <input type="checkbox" name="not_conducted" @if(request()->get('not_conducted','') == 'on') checked @endif class="custom-control-input" id="conductedSwitch">
            <label class="custom-control-label" for="conductedSwitch"></label>
        </div>
    </div>
    </form> --}}
    </div>

    @if(!empty($video) and !$video->isEmpty())
    {{-- @foreach($webinars as $webinar)
                @php
                    $lastSession = $webinar->lastSession();
                    $nextSession = $webinar->nextSession();
                    $isProgressing = false;

                    if($webinar->start_date <= time() and !empty($lastSession) and $lastSession->date > time()) {
                        $isProgressing=true;
                    }
                @endphp --}}
    @if($video !="[]")

    <div class="scrollable-div" style="margin-top:10px" id="scrollable-div">
    <div class="row">
            @foreach($video as $video)
      
                            <div id="videoPopupModal{{ $video->id }}" class="modal" style="display: none;">
                                <div class="modal-content">
                                    <span class="close">&times;</span>
                                    <video controls>
                                        <source id="videoSource{{ $video->id }}"   >
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                            </div>
                <div class="col-md-4">
                <div class="webinar-card webinar-list webinar-list-2 d-flex mt-30">
                    <div class="image-box">

                        <div class="rounded-lg shadow-sm">
                            <div class="course-img">
                                <div id="webinarDemoVideoBtn{{ $video->id }}"
                                data-video-source="{{ $video->video }}"
                                 style=" position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);box-shadow: 0 20px 12px 0 rgba(0, 0, 0, 0.1);background-color: #ffffff;width: 96px;height: 96px;border-radius: 50%;z-index: 2;" 
       
                                 class="course-video-icon cursor-pointer d-flex align-items-center justify-content-center">
                                    <i data-feather="play" width="25" height="25"></i>
                                </div>
                            </div>
                           

                        </div>
                        
                        <video class="img-cover" onclick="playInMainPlayer('{{ asset($video->video) }}','{{ $video->titre }}','{{ $video->teachers->full_name }}','{{ $video->user_id }}','{{ $video->teachers->avatar }}'); storeTeacherId('{{ $video->teachers->id }}');">
                            <source src="{{ $video->video }}" type="video/mp4">
                            <source src="{{ $video->video }}" type="video/webm">
                        </video>


                        <span class="badge badge-primary">مقبول </span>



                        <div class="progress">
                            <span class="progress-bar" style="width:20%"></span>
                        </div>

                    </div>
                    <!-- Popup Modal -->
                    <div class="webinar-card-body w-100 d-flex flex-column">
                        <div class="d-flex align-items-center justify-content-between mb-10">
                            <a href="" target="_blank">
                                <h3 class="font-16 text-dark-blue font-weight-bold">{{ $video->titleAll }}
                                    <span class="badge badge-dark ml-10 status-badge-dark">الفيديو</span>
                                </h3>
                            </a>
                            <div class="btn-group dropdown table-actions">
                                <button type="button" class="btn-transparent dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i data-feather="more-vertical" height="20"></i>
                                </button>
                                <div class="dropdown-menu ">
                                    <a href="/panel/scolaire/view/teacher/{{ $video->manuel_id }}?icon={{ $video->numero }}&page={{ $video->page }}"  class="webinar-actions d-block mt-10" id="myBtn">{{ trans('public.edit') }}</a>
                                    <a href="/panel/video/{{ $video->id }}/delete"  class="webinar-actions d-block mt-10 text-danger delete-action">{{ trans('public.delete') }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="user-inline-avatar d-flex align-items-center">
                                @php 
                                $materialsname = DB::table('materials')->where('id', $video->manuel->material_id)->pluck('name');

                                $materialssection = DB::table('materials')->where('id', $video->manuel->material_id)->pluck('section_id');

                                $materialsnamesection= DB::table('sectionsmat')->where('id', $materialssection[0])->pluck('level_id');
                                $materiallevel = DB::table('school_levels')->where('id',  $materialsnamesection[0])->pluck('name');
                                @endphp
                                <div class="user-inline-avatar d-flex align-items-center">
                                        <div class="avatar bg-gray200">
                                            <img src="/{{ $video->manuel->logo }}" class="img-cover" alt="">
                                        </div>
                                        <a href="" target="_blank" class="user-name ml-5 font-14"> كتاب {{ $video->manuel->name }}  مادة   {{ $materialsname[0]}}</a>
                                </div>
                        </div> 
                        <a href="" target="_blank" class="user-name mt-20 ml-5 font-14">السنة {{  $materiallevel[0]}}</a>
                                <div class="d-flex align-items-center justify-content-between">
                                    <a onclick="playInMainPlayer('{{ asset($video->video) }}','{{ $video->titre }}','{{ $video->teachers->full_name }}','{{ $video->user_id }}','{{ $video->teachers->avatar }}')">
                                </div>
                                @if(!empty( $manuelsname[0]))
                                    <span class="d-block font-14 mt-10">في <a target="_blank" class="text-decoration-underline">{{ $manuelsname[0] }}</a></span>
                                @endif 
                                <div class="row">
                                    <div class="col-md-6" style="    margin-top: 10%;">                     
                                        <div class="mt-10 d-flex justify-content-between ">

                                            <div class="d-flex align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <img width="20" height="20" src="/oeil.png" class="webinar-icon" />
                                                    <span style="font-size: small;" class="duration ml-5 font-8">{{ $video->vues }} </span>
                                                </div>

                                                <div class="vertical-line h-25 mx-15"></div>

                                                <div class="d-flex align-items-center">
                                                    <img width="15" height="15" src="/heart1.png" class="webinar-icon" />
                                                    <span style="font-size: small;" class="date-published ml-5">{{ $video->likes }} </span>
                                                </div>
                                            </div>

                                            <div class="webinar-price-box d-flex flex-column justify-content-center align-items-center">

                                                <span class="real"></span>


                                            </div>
                                        </div>
                                        <div class="webinar-price-box d-flex flex-column justify-content-center align-items-center">
                                            <span class="real"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6" style="    margin-top: 10%;">                     
                                        <a  class="" href="/panel/scolaire/view/teacher/{{ $video->manuel_id }}?icon={{ $video->numero }}&page="{{ $video->page }}>
                                        <span class="pdf-icon">
                                        
                                        <div class="d-flex align-items-center ">
                                                <div class="d-flex align-items-center">
                                                    <span style="font-size: small;" class="duration ml-5 font-8 mt-10">{{ $video->page }} </span>
                                                </div>
                                        </div>
                                        </span>
                                        </a>
                                    </div>
                                </div>
                    </div>    
              
                </div>

               


            </div>
            @endforeach
</div>
    </div>
    @endif
    {{--
            <div class="scrollable-div" style="margin-top:10px" id="scrollable-div">
                @foreach($video as $video)
                    <div class="row mt-5">
                    <div class="col-md-6">
                        <div class="webinar-card webinar-list d-flex">
                            <div class="image-box">
                                <img src="{{ $webinar->getImage() }}" class="img-cover" alt="">

            @switch($webinar->status)
            @case(\App\Models\Webinar::$active)
            @if($webinar->isWebinar())
            @if($webinar->start_date > time())
            <span class="badge badge-primary">{{ trans('panel.not_conducted') }}</span>
            @elseif($webinar->isProgressing())
            <span class="badge badge-secondary">{{ trans('webinars.in_progress') }}</span>
            @else
            <span class="badge badge-secondary">{{ trans('public.finished') }}</span>
            @endif
            @else
            <span class="badge badge-secondary">{{ trans('webinars.'.$webinar->type) }}</span>
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

    @if($webinar->isWebinar())
    <div class="progress">
        <span class="progress-bar" style="width: {{ $webinar->getProgress() }}%"></span>
    </div>
    @endif
    </div>

    <div class="webinar-card-body w-100 d-flex flex-column">
        <div class="d-flex align-items-center justify-content-between">
            <a href="{{ $webinar->getUrl() }}" target="_blank">
                <h3 class="font-16 text-dark-blue font-weight-bold">{{ $webinar->title }}
                    <span class="badge badge-dark ml-10 status-badge-dark">{{ trans('webinars.'.$webinar->type) }}</span>
                </h3>
            </a>

            @if($webinar->isOwner($authUser->id) or $webinar->isPartnerTeacher($authUser->id))
            <div class="btn-group dropdown table-actions">
                <button type="button" class="btn-transparent dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i data-feather="more-vertical" height="20"></i>
                </button>
                <div class="dropdown-menu ">
                    @if(!empty($webinar->start_date))
                    <button type="button" data-webinar-id="{{ $webinar->id }}" class="js-webinar-next-session webinar-actions btn-transparent d-block">{{ trans('public.create_join_link') }}</button>
                    @endif

                    <a href="{{ $webinar->getLearningPageUrl() }}" target="_blank" class="webinar-actions d-block mt-10">{{ trans('update.learning_page') }}</a>

                    <a href="/panel/webinars/{{ $webinar->id }}/edit" class="webinar-actions d-block mt-10">{{ trans('public.edit') }}</a>

                    @if($webinar->isWebinar())
                    <a href="/panel/webinars/{{ $webinar->id }}/step/4" class="webinar-actions d-block mt-10">{{ trans('public.sessions') }}</a>
                    @endif

                    <a href="/panel/webinars/{{ $webinar->id }}/step/4" class="webinar-actions d-block mt-10">{{ trans('public.files') }}</a>

                    <a href="/panel/webinars/{{ $webinar->id }}/export-students-list" class="webinar-actions d-block mt-10">{{ trans('public.export_list') }}</a>

                    @if($authUser->id == $webinar->creator_id)
                    <a href="/panel/webinars/{{ $webinar->id }}/duplicate" class="webinar-actions d-block mt-10">{{ trans('public.duplicate') }}</a>
                    @endif


                    <a href="/panel/webinars/{{ $webinar->id }}/statistics" class="webinar-actions d-block mt-10">{{ trans('update.statistics') }}</a>

                    @if($webinar->creator_id == $authUser->id)
                    <a href="/panel/webinars/{{ $webinar->id }}/delete" class="webinar-actions d-block mt-10 text-danger delete-action">{{ trans('public.delete') }}</a>
                    @endif
                </div>
            </div>
            @endif
        </div>

        @include(getTemplate() . '.includes.webinar.rate',['rate' => $webinar->getRate()])

        <div class="webinar-price-box mt-15">
            @if($webinar->price > 0)
            @if($webinar->bestTicket() < $webinar->price)
                <span class="real">{{ handlePrice($webinar->bestTicket()) }}</span>
                <span class="off ml-10">{{ handlePrice($webinar->price) }}</span>
                @else
                <span class="real">{{ handlePrice($webinar->price) }}</span>
                @endif
                @else
                <span class="real">{{ trans('public.free') }}</span>
                @endif
        </div>

        <div class="d-flex align-items-center justify-content-between flex-wrap mt-auto">
            <div class="d-flex align-items-start flex-column mt-20 mr-15">
                <span class="stat-title">{{ trans('public.item_id') }}:</span>
                <span class="stat-value">{{ $webinar->id }}</span>
            </div>

            <div class="d-flex align-items-start flex-column mt-20 mr-15">
                <span class="stat-title">{{ trans('public.category') }}:</span>
                <span class="stat-value">{{ !empty($webinar->category_id) ? $webinar->category->title : '' }}</span>
            </div>

            @if($webinar->isProgressing() and !empty($nextSession))
            <div class="d-flex align-items-start flex-column mt-20 mr-15">
                <span class="stat-title">{{ trans('webinars.next_session_duration') }}:</span>
                <span class="stat-value">{{ convertMinutesToHourAndMinute($nextSession->duration) }} Hrs</span>
            </div>

            @if($webinar->isWebinar())
            <div class="d-flex align-items-start flex-column mt-20 mr-15">
                <span class="stat-title">{{ trans('webinars.next_session_start_date') }}:</span>
                <span class="stat-value">{{ dateTimeFormat($nextSession->date,'j M Y') }}</span>
            </div>
            @endif
            @else
            <div class="d-flex align-items-start flex-column mt-20 mr-15">
                <span class="stat-title">{{ trans('public.duration') }}:</span>
                <span class="stat-value">{{ convertMinutesToHourAndMinute($webinar->duration) }} Hrs</span>
            </div>

            @if($webinar->isWebinar())
            <div class="d-flex align-items-start flex-column mt-20 mr-15">
                <span class="stat-title">{{ trans('public.start_date') }}:</span>
                <span class="stat-value">{{ dateTimeFormat($webinar->start_date,'j M Y') }}</span>
            </div>
            @endif
            @endif

            @if($webinar->isTextCourse() or $webinar->isCourse())
            <div class="d-flex align-items-start flex-column mt-20 mr-15">
                <span class="stat-title">{{ trans('public.files') }}:</span>
                <span class="stat-value">{{ $webinar->files->count() }}</span>
            </div>
            @endif

            @if($webinar->isTextCourse())
            <div class="d-flex align-items-start flex-column mt-20 mr-15">
                <span class="stat-title">{{ trans('webinars.text_lessons') }}:</span>
                <span class="stat-value">{{ $webinar->textLessons->count() }}</span>
            </div>
            @endif

            @if($webinar->isCourse())
            <div class="d-flex align-items-start flex-column mt-20 mr-15">
                <span class="stat-title">{{ trans('home.downloadable') }}:</span>
                <span class="stat-value">{{ ($webinar->downloadable) ? trans('public.yes') : trans('public.no') }}</span>
            </div>
            @endif

            <div class="d-flex align-items-start flex-column mt-20 mr-15">
                <span class="stat-title">{{ trans('panel.sales') }}:</span>
                <span class="stat-value">{{ count($webinar->sales) }} ({{ (!empty($webinar->sales) and count($webinar->sales)) ? addCurrencyToPrice($webinar->sales->sum('amount')) : 0 }})</span>
            </div>

            @if(!empty($webinar->partner_instructor) and $webinar->partner_instructor and $authUser->id != $webinar->teacher_id and $authUser->id != $webinar->creator_id)
            <div class="d-flex align-items-start flex-column mt-20 mr-15">
                <span class="stat-title">{{ trans('panel.invited_by') }}:</span>
                <span class="stat-value">{{ $webinar->teacher->full_name }}</span>
            </div>
            @elseif($authUser->id != $webinar->teacher_id and $authUser->id != $webinar->creator_id)
            <div class="d-flex align-items-start flex-column mt-20 mr-15">
                <span class="stat-title">{{ trans('webinars.teacher_name') }}:</span>
                <span class="stat-value">{{ $webinar->teacher->full_name }}</span>
            </div>
            @elseif($authUser->id == $webinar->teacher_id and $authUser->id != $webinar->creator_id and $webinar->creator->isOrganization())
            <div class="d-flex align-items-start flex-column mt-20 mr-15">
                <span class="stat-title">{{ trans('webinars.organization_name') }}:</span>
                <span class="stat-value">{{ $webinar->creator->full_name }}</span>
            </div>
            @endif
        </div>
    </div>
    </div>
    </div>
    </div>
    @endforeach
    </div>
    <div class="my-30">
        {{ $webinars->appends(request()->input())->links('vendor.pagination.panel') }}
    </div> --}}

    @else
    @include(getTemplate() . '.includes.no-result',[
    'file_name' => 'webinar.png',
    'title' => 'لا توجد فديوهات !',
    'hint' => 'ابدأ بصناعة محتواك في الكتاب المدرسي' ,
    ])
    @endif

</section>

@include('web.default.panel.webinar.make_next_session_modal')
@endsection

@push('scripts_bottom')
<script src="/assets/default/vendors/daterangepicker/daterangepicker.min.js"></script>

<script>
    var undefinedActiveSessionLang = '{{ trans('webinars.undefined_active_session ') }}';
    var saveSuccessLang = '{{ trans('webinars.success_store ') }}';
</script>

<script src="/assets/default/js/panel/make_next_session.min.js"></script>
<script src="/assets/default/vendors/video/video.min.js"></script>
    <script src="/assets/default/vendors/video/youtube.min.js"></script>
    <script src="/assets/default/vendors/video/vimeo.js"></script>
    <script src="/assets/default/js/parts/video_player_helpers.min.js"></script>
<script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
document.querySelectorAll('.course-video-icon').forEach(button => {
    button.addEventListener('click', function() {
        // Get the video ID and source from data attributes
        const videoId = this.id.replace('webinarDemoVideoBtn', '');
        const videoSource = this.getAttribute('data-video-source');
        const mainPlayer = document.getElementById(`videoSource${videoId}`);

        // Set the video source in the corresponding video element
        mainPlayer.src = videoSource;

        // Get the video element and play the video
        const videoElement = mainPlayer.closest('video');
        if (videoElement) {
            videoElement.load(); // Load the new video source
            videoElement.play(); // Play the video
        } else {
            console.error("Video element not found.");
        }

        // Display the corresponding modal
        document.getElementById(`videoPopupModal${videoId}`).style.display = "block";
    });
});
// Add event listeners to all close buttons
document.querySelectorAll('.close').forEach(closeButton => {
    closeButton.addEventListener('click', function() {
        // Hide the parent modal of the clicked close button
        this.closest('.modal').style.display = "none";
    });
});

// Close the modal when the user clicks anywhere outside of it
window.addEventListener('click', function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = "none";
    }
});




    </script>
    
@endpush
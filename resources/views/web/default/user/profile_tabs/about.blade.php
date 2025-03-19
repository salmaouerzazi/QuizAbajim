@if ($user->offline)
    <div class="user-offline-alert d-flex mt-40">
        <div class="p-15">
            <h3 class="font-16 text-dark-blue">{{ trans('public.instructor_is_not_available') }}</h3>
            <p class="font-14 font-weight-500 text-gray mt-15">{{ $user->offline_message }}</p>
        </div>

        <div class="offline-icon offline-icon-right ml-auto d-flex align-items-stretch">
            <div class="d-flex align-items-center">
                <img src="/assets/default/img/profile/time-icon.png" alt="offline">
            </div>
        </div>
    </div>
@endif
   <style>  
        .video-container {  
            width: 90%;
    height: 100%;
                   overflow: hidden;  

            position: relative;  
            background-color: black;
        }  

        .video-container video {  
            transform: rotate(90deg);  
            left: 50%;  
            top: 50%;  
            
            transform: translate(0%, 0%); /* Centrer la vidéo */  
        }  
    </style>  
@if (
    !empty($educations) and !$educations->isEmpty() or
        !empty($experiences) and !$experiences->isEmpty() or
        !empty($occupations) and !$occupations->isEmpty() or
        !empty($user->about))
   <div class="row"> 
   <div class="col-md-8">
        @if (!empty($educations) and !$educations->isEmpty())
            <div class="mt-40">
                <h3 class="font-16 text-dark-blue font-weight-bold">{{ trans('site.education') }}</h3>
                <ul class="list-group-custom">
                    @foreach ($educations as $education)
                        <li class="mt-15 text-gray">{{ $education->value }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    @if (!empty($experiences) and !$experiences->isEmpty())
        <div class="mt-40">
            <h3 class="font-16 text-dark-blue font-weight-bold">{{ trans('site.experiences') }}</h3>

            <ul class="list-group-custom">
                @foreach ($experiences as $experience)
                    <li class="mt-15 text-gray">{{ $experience->value }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (!empty($user->about))
        <div class="mt-40">
            <h3 class="font-16 text-dark-blue font-weight-bold">{{ trans('site.about') }}</h3>

            <div class="mt-30">
                {!! nl2br($user->about) !!}
            </div>
        </div>
    @endif
</div>
{{-- TODO: add video in user's table and get it dynamically --}}
   <div class="col-md-4 mt-20"> 
    @if (!empty($user))
         @if($user->id==1316)
            <div class="video-container">  
                <video width="100%" height="100%" controls>  
                    <source  src="https://www.abajim.com/VideoProfileTeacher/exporttp4.mp4" type="video/mp4">  
                    Votre navigateur ne supporte pas la vidéo.  
                </video>  
            </div>  
        @elseif($user->id ==1426)
             <div class="video-container">  
                <video width="100%" height="100%" controls>  
                    <source  src="https://www.abajim.com/VideoProfileTeacher/exporttp2.mp4" type="video/mp4">  
                    Votre navigateur ne supporte pas la vidéo.  
                </video>  
            </div> 
            @elseif($user->id ==1318)
             <div class="video-container">  
                <video width="100%" height="100%" controls>  
                    <source  src="https://www.abajim.com/VideoProfileTeacher/exporttp3.mp4" type="video/mp4">  
                    Votre navigateur ne supporte pas la vidéo.  
                </video>  
            </div>  
            @elseif($user->id ==1396)
             <div class="video-container">  
                <video width="100%" height="100%" controls>  
                    <source  src="https://www.abajim.com/VideoProfileTeacher/exporrrtttp10.mp4" type="video/mp4">  
                    Votre navigateur ne supporte pas la vidéo.  
                </video>  
            </div>  
            @elseif($user->id ==1396)
             <div class="video-container">  
                <video width="100%" height="100%" controls>  
                    <source  src="https://www.abajim.com/VideoProfileTeacher/exporttp5.mp4" type="video/mp4">  
                    Votre navigateur ne supporte pas la vidéo.  
                </video> 
            </div>   
            @elseif($user->id ==1665)
             <div class="video-container">  
                <video width="100%" height="100%" controls>  
                    <source  src="https://www.abajim.com/VideoProfileTeacher/exporttp5.mp4" type="video/mp4">  
                    Votre navigateur ne supporte pas la vidéo.  
                </video> 
            </div>  
             @elseif($user->id ==1530)
             <div class="video-container">  
                <video width="100%" height="100%" controls>  
                    <source  src="https://www.abajim.com/VideoProfileTeacher/exporttp6.mp4" type="video/mp4">  
                    Votre navigateur ne supporte pas la vidéo.  
                </video> 
            </div>
            @elseif($user->id ==2115)
             <div class="video-container">  
                <video width="100%" height="100%" controls>  
                    <source  src="https://www.abajim.com/VideoProfileTeacher/exportttttp8.mp4" type="video/mp4">  
                    Votre navigateur ne supporte pas la vidéo.  
                </video> 
            </div>    
        @endif
        @endif
   </div>  
</div>    
    {{-- @if (!empty($materials) and !$materials->isEmpty())
        <div class="mt-40">
            <h3 class="font-16 text-dark-blue font-weight-bold">{{ trans('site.materials') }}</h3>

            <div class="d-flex flex-wrap align-items-center pt-10">
                @foreach ($materials as $material)
                    <div class="bg-gray200 font-14 rounded mt-10 px-10 py-5 text-gray mr-15">{{ $material->name }}</div>
                @endforeach
            </div>
        </div>
    @endif --}}
@else
   <div class="row"> 
  
     <div class="col-md-4 mt-20"> 
        @if (!empty($user))
         @if($user->id==1316)
            <div class="video-container">  
                <video width="100%" height="100%" controls>  
                    <source  src="https://www.abajim.com/VideoProfileTeacher/exporttp4.mp4" type="video/mp4">  
                    Votre navigateur ne supporte pas la vidéo.  
                </video>  
            </div>  
        @elseif($user->id ==1426)
             <div class="video-container">  
                <video width="100%" height="100%" controls>  
                    <source  src="https://www.abajim.com/VideoProfileTeacher/exporttp2.mp4" type="video/mp4">  
                    Votre navigateur ne supporte pas la vidéo.  
                </video>  
            </div> 
            @elseif($user->id ==1318)
             <div class="video-container">  
                <video width="100%" height="100%" controls>  
                    <source  src="https://www.abajim.com/VideoProfileTeacher/exporttp3.mp4" type="video/mp4">  
                    Votre navigateur ne supporte pas la vidéo.  
                </video>  
            </div>  
            @elseif($user->id ==1396)
             <div class="video-container">  
                <video width="100%" height="100%" controls>  
                    <source  src="https://www.abajim.com/VideoProfileTeacher/exporrrtttp10.mp4" type="video/mp4">  
                    Votre navigateur ne supporte pas la vidéo.  
                </video> 
            </div>
             @elseif($user->id ==1665)
             <div class="video-container">  
                <video width="100%" height="100%" controls>  
                    <source  src="https://www.abajim.com/VideoProfileTeacher/exporttp5.mp4" type="video/mp4">  
                    Votre navigateur ne supporte pas la vidéo.  
                </video> 
            </div>  
             @elseif($user->id ==1530)
             <div class="video-container">  
                <video width="100%" height="100%" controls>  
                    <source  src="https://www.abajim.com/VideoProfileTeacher/exporttp6.mp4" type="video/mp4">  
                    Votre navigateur ne supporte pas la vidéo.  
                </video> 
            </div>
             @elseif($user->id ==2115)
             <div class="video-container">  
                <video width="100%" height="100%" controls>  
                    <source  src="https://www.abajim.com/VideoProfileTeacher/exportttttp8.mp4" type="video/mp4">  
                    Votre navigateur ne supporte pas la vidéo.  
                </video> 
            </div>    
        @endif
        @endif
   </div> 
   </div> 

@endif

@extends(getTemplate() . '.panel.layouts.panel_layoutEnfant')

@push('styles_top')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="/assets/default/vendors/daterangepicker/daterangepicker.min.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
@endpush

<style>
    .row {
        margin-right: 0px;
        margin-left: 0px;
        justify-content: center;
    }

    .manuel-image {
        border-radius: 15px;
        width: 100%;
        height: 100px;
        padding: 10% !important;
    }

    @media (max-width: 768px) {
        .manuel-image {
            height: 33%;
            width: 44%;
        }
    }

    @media (max-width: 576px) {
        .manuel-image {
            height: 35%;
            width: 100%;
        }
    }
</style>

@section('content')
    <div class="row">
        @if (request()->has(['icon', 'page']))
            <div class="col-12">
                @foreach ($videos as $video)
                    <div class="webinar-card webinar-list webinar-list-2 d-flex m-30">
                        <div class="image-box" style="min-width: 48%;margin-top: -88px!important"
                            onclick="playInMainPlayer('{{ asset($video->video) }}','{{ $video->titre }}','{{ $video->teachers->full_name }}','{{ $video->user_id }}','{{ $video->teachers->avatar }}','{{ $video->likes }}')">

                            <video width="100%" height="128%"
                                onclick="playInMainPlayer('{{ asset($video->video) }}','{{ $video->titre }}','{{ $video->teachers->full_name }}','{{ $video->user_id }}','{{ $video->teachers->avatar }}'); storeTeacherId('{{ $video->teachers->id }}');">
                                <source src="{{ $video->video }}" type="video/mp4">
                                <source src="{{ $video->video }}" type="video/webm">
                            </video>

                            <div class="progress-and-bell d-flex align-items-center"
                                style="    margin-bottom: -7px ;padding: 0px 6px!important">

                                <a href="" target="_blank"
                                    class="webinar-notify d-flex align-items-center justify-content-center"
                                    style="width: 30px;height: 28px!important">
                                    <i data-feather="bell" width="20" height="20" class="webinar-icon"></i>
                                </a>

                                <div class="progress ml-10">
                                    <span class="progress-bar" style="width: 30%"></span>
                                </div>

                            </div>
                        </div>
                        <div class="webinar-card-body w-100 d-flex flex-column">
                            <div class="d-flex align-items-center justify-content-between">
                                <a
                                    onclick="playInMainPlayer('{{ asset($video->video) }}','{{ $video->titre }}','{{ $video->teachers->full_name }}','{{ $video->user_id }}','{{ $video->teachers->avatar }}')">

                                </a>
                            </div>
                            <div class="user-inline-avatar d-flex align-items-center">
                                <div class="avatar bg-gray100">
                                    <img src="{{ $video->teachers->avatar }}" class="img-cover" alt="">
                                </div>
                                <a href="" target="_blank" class="user-name ml-5 font-14">
                                    {{ $video->teachers->full_name }}</a>
                            </div>
                            <div class="mt-10 d-flex justify-content-between ">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex align-items-center">
                                        <img width="20" height="20" src="/oeil.png" class="webinar-icon" />
                                        <span style="font-size: small;" class="duration ml-5 font-8">{{ $video->vues }}
                                        </span>
                                    </div>

                                    <div class="vertical-line h-25 mx-15"></div>

                                    <div class="d-flex align-items-center">
                                        <img width="15" height="15" src="/heart1.png" class="webinar-icon" />
                                        <span style="font-size: small;" class="date-published ml-5">{{ $video->likes }}
                                        </span>
                                    </div>
                                </div>

                                <div class="webinar-price-box d-flex flex-column justify-content-center align-items-center">
                                    <span class="real"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="col-sm-11">
                @if (!empty($t3DPathManuels[0]))
                    <a href="{{ $t3DPathManuels[0] }}{{ $page }}" class="fp-embed" data-fp-width="100%"
                        data-fp-height="90vh"></a>
                    <script async defer src="https://cdn-online.flowpaper.com/zine/3.8.4/js/embed.min.js"></script>
                @else
                    <object data="{{ asset($pdfPath) }}#toolbar=0&page={{ $page }}&zoom=auto"
                        type="application/pdf" width="100%" height="100%">
                        <p>Unable to display PDF file. <a href="{{ $pdfPath }}">Download</a> instead.</p>
                    </object>
                @endif
            </div>

            <div class="col-lg-1 d-flex d-sm-block d-md-block">
                @php
                    $currentManuelId = request()->segment(3);
                @endphp
                @foreach ($Manuels as $manuel)
                    @if ($manuel->id != $currentManuelId)
                        <a href="/panel/scolaire/{{ $manuel->id }}">
                            <img class="manuel-image" src="{{ asset($manuel->logo) }}" alt="{{ $manuel->name }}">
                        </a>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
@endsection

@push('scripts_bottom')

    <script>
        function hideMainPlayer() {
            var mainPlayer = document.getElementById('mainVideoPlayer');
            var title = document.getElementById('title');
            var toprow = document.getElementById('top-row');

            mainPlayer.style.display = 'none'; // Hide the main player
            title.style.display = 'none';
            toprow.style.display = 'none';
        }

        function showMainPlayer() {
            var mainPlayer = document.getElementById('mainVideoPlayer');
            var title = document.getElementById('title');
            var toprow = document.getElementById('top-row');
            var scrollablediv = document.getElementById('scrollable-div');

            mainPlayer.style.display = 'block'; // Show the main player
            title.style.display = 'block';
            toprow.style.display = 'block';
            scrollablediv.style.height = '400px';
        }

        function playInMainPlayer(url, title, nameteac, user_idd, imgteac, likes) {

            var mainPlayer = document.getElementById('mainVideoPlayer');
            //   var titleshoww = document.getElementById('titleshoww');
            var hrefnameteacher = document.getElementById('hrefnameteacher');

            var nameteacher = document.getElementById('nameteacher');
            var user_iddteacher = document.getElementById('user_iddteacher');
            var scrollablediv = document.getElementById(' scrollable-div');
            var likesCount = document.getElementById('likesCount');

            //var user_iddteacher1 = document.getElementById('user_iddteacher1');

            var imgteacher = document.getElementById('img');

            // Update the source and load the video
            mainPlayer.src = url;

            mainPlayer.style.top = '0';
            mainPlayer.style.left = '0';
            mainPlayer.style.marginLeft = '30px';
            mainPlayer.style.width = '92%';
            mainPlayer.style.height = '92%';
            imgteacher.src = imgteac;
            hrefnameteacher.href = 'nameteac';

            nameteacher.textContent = nameteac;
            likesCount.textContent = likes;

            user_iddteacher.value = user_idd;
            // titleshoww.style.marginLeft = '30px';

            //  user_iddteacher1.value = user_idd;

            // titleshoww.textContent = title;

            mainPlayer.load();
            showMainPlayer();
            // Play the video
            mainPlayer.play();
        }
        window.onload = function() {
            hideMainPlayer();
        };
        document.getElementById('likeButton1').addEventListener('click', function() {
            const icon = document.getElementById('likeIcon');
            icon.classList.toggle('bi-hand-thumbs-up');
            icon.classList.toggle('bi-hand-thumbs-up-fill');
            icon.classList.toggle('animated');
        });
    </script>


    <script>
        function storeTeacherId(teacherId) {
            fetch('/store-teacher-id', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Add CSRF token for Laravel
                },
                body: JSON.stringify({
                    teacher_id: teacherId
                })
            }).then(response => {
                // Handle the response, navigate to the show page or do something else
                //  window.location.href = '/show';
            });
        }
    </script>
    <script>
        let lv = 0;
        $("#likeButton").on("click", function() {
            let videoId = $(this).data('video-id');

            $.ajax({
                url: '/panel/video/' + videoId + '/like',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    $('#likesCount').text(data.likes);

                    if (lv == 0) {
                        $('#likeIcon').removeClass('fa-regular fa-heart').addClass('fa-solid fa-heart')
                            .css('color', '#f52e4b');
                        lv = 1;
                    } else {
                        $('#likeIcon').removeClass('fa-solid fa-heart').addClass('fa-regular fa-heart')
                            .css('color', '');
                        lv = 0;
                    }

                }
            });
        });
    </script>
    @if (empty($justMobileApp) and checkShowCookieSecurityDialog())
        @include('web.default.includes.cookie-security')
    @endif
    <script src="/assets/default/js/parts/main.min.js"></script>

@endpush

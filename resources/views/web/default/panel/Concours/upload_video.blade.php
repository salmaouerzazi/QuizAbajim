{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Concours PDF</title>
</head>
<body>
    <h1>Concours PDF</h1>
    <iframe src="{{ $concour->pdf_path_url }}" width="100%" height="900px"></iframe>
</body>
</html> --}}
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
  
        <div class="col-lg-9 d-none d-sm-block">
            @if (!empty($concour->tree_d_path ))
                <a href="{{ $concour->tree_d_path }}{{ $page }}" class="fp-embed" data-fp-width="100%" data-fp-height="80vh"
                    data-options='{"LinkTarget": "none"}'></a>

                <script async defer src="https://abajim.com/assets/default/js/panel/flowpaper.min.js"></script>
            @else
                <div style="padding:10px">
                    <object data="{{ $concour->pdf_path_url }}#zoom=auto&page={{ $page }}" type="application/pdf"
                        width="100%" height="860px">
                        <p>Unable to display PDF file. <a href="{{ $concour->pdf_path_url }}">Download</a> instead.</p>
                    </object>
                </div>
            @endif
        </div>

        <div class="col-lg-3 col-sm-12">
            <div class="container">
                <div class="wrapper" id="upload-wrapper">
                    @csrf
                    @php
                        $parameterValue = request()->segment(4);
                    @endphp
                    <div class="content d-flex flex-column justify-content-center align-items-center" id="upload-content">
                        <div class="icon">
                            <i onclick="defaultBtnActive({{ $video->id ?? 'null' }})" id="custom-btn"
                                class="fas fa-cloud-upload-alt" style="cursor:pointer;"></i>

                        </div>
                        <span class="title font-14 text-secondary" id="custom-text" style="color: grey">قم بتحميل
                            الفيديو</span>
                    </div>
                    <div id="cancel-btn" style="display:none;">
                        <i class="fas fa-times" style="cursor:pointer; color:red; font-size: 25px;"></i>
                    </div>
                    <span id="percentage" style="display:none; font-size: 16px; margin-top: 10px;"></span>
                    <video id="video-preview" controls hidden style="width: 100%; margin-top: 40px;"></video>

                    <div class="file-name"></div>
                    <input id="default-btn" name="video" type="file" hidden accept="video/*">
                    <input placeholder="enter concour id" name="concour" value="{{ $parameterValue }}" hidden>
                    <input name="numero" value="{{ $icon }}" hidden>
                    <input name="page" value="{{ $page }}" hidden>
                </div>
            </div>
        </div>

    </div>
    <!-- Confirmation Modal -->
    {{-- <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">{{ trans('panel.confirm_delete') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ trans('panel.confirm_delete_video') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">{{ trans('panel.cancel') }}</button>
                    <button type="button" class="btn btn-danger"
                        id="confirmDeleteBtn">{{ trans('panel.delete') }}</button>
                </div>
            </div>
        </div>
    </div> --}}
@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/toast/jquery.toast.min.js"></script>

    <script>
        let isUploading = false;
        let videoIdToDelete = null;

        const wrapper = document.querySelector(".wrapper");
        const defaultBtn = document.querySelector("#default-btn");
        const cancelBtn = document.getElementById("cancel-btn");
        const videoPreview = document.getElementById("video-preview");
        const percentageText = document.getElementById('percentage');
        const uploadContent = document.getElementById('upload-content');
        const concourInput = document.querySelector('input[name="concour"]');
        const numeroInput = document.querySelector('input[name="numero"]');
        const pageInput = document.querySelector('input[name="page"]');

        window.addEventListener("beforeunload", function(e) {
            if (isUploading) {
                e.preventDefault();
                e.returnValue = "الفيديو ما زال قيد التحميل. هل تريد مغادرة الصفحة؟";
            }
        });

        function defaultBtnActive(videoId = null) {
            if (videoId) {
                videoIdToDelete = videoId;
            }
            defaultBtn.click();
        }


        defaultBtn.addEventListener("change", function() {
            const file = this.files[0];
            if (file && file.type.startsWith('video/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    wrapper.classList.add("active");
                    videoPreview.src = e.target.result;
                    videoPreview.hidden = false;
                    document.getElementById('custom-btn').style.display = "none";
                    document.getElementById('custom-text').style.display = "none";
                    document.getElementById('upload-content').style.display =
                        "none";
                    document.getElementById('cancel-btn').style.display = "block";
                    percentageText.style.display = "block";
                }
                reader.readAsDataURL(file);
                startUpload(file);
            } else {
                displayJqueryToast("{{ trans('public.request_failed') }}",
                    "{{ trans('panel.select_video_file') }}", "error");

                resetUploadState();
            }
        });

        cancelBtn.addEventListener("click", function() {
            $('#deleteModal').modal('show');
        });

        function resetUploadState() {
            videoPreview.hidden = true;
            cancelBtn.style.display = "none";
            videoPreview.src = "";
            percentageText.textContent = "";
            percentageText.style.display = "none";
            document.getElementById('upload-content').style.display = "flex";
            document.getElementById('custom-btn').style.display = "block";
            document.getElementById('custom-text').style.display = "block";
            wrapper.classList.remove("active");
            isUploading = false;
        }



        function startUpload(file) {
            isUploading = true;
            const formData = new FormData();
            formData.append("video", file);
            formData.append("concour", concourInput.value);
            formData.append("numero", numeroInput.value);
            formData.append("page", pageInput.value);
            formData.append("_token", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "{{ route('add.videos.concours') }}", true);

            xhr.upload.onprogress = function(event) {
                if (event.lengthComputable) {
                    const percentage = (event.loaded / event.total) * 100;
                    percentageText.textContent = "تحميل الفيديو: " + percentage.toFixed(0) + "%";

                    if (percentage < 50) {
                        percentageText.style.color = "red";
                    } else if (percentage < 80) {
                        percentageText.style.color = "orange";
                    } else {
                        percentageText.style.color = "green";
                    }

                    percentageText.style.display = "block";
                    if (percentage === 100) {
                        isUploading = false;
                    }
                }
            };

            xhr.onload = function() {
                if (xhr.status === 200) {
                    isUploading = false;
                    const response = JSON.parse(xhr.responseText);
                    console.log(response.toast);

                    displayJqueryToast(response.toast.title, response.toast.msg, response.toast.status);

                    videoIdToDelete = response.videoId;
                    console.log("Upload successful:", xhr.responseText);
                } else {
                    console.error("Upload failed:", xhr.responseText);
                    const response = JSON.parse(xhr.responseText);
                    displayJqueryToast(response.toast.title, response.toast.msg, response.toast.status);

                }
            };

            xhr.send(formData);
        }
        document.getElementById("confirmDeleteBtn").addEventListener("click", function() {
            if (videoIdToDelete) {
                deleteVideoFromDatabase(videoIdToDelete);
            } else {}
        });

        function deleteVideoFromDatabase(videoId) {
            const xhr = new XMLHttpRequest();
            xhr.open("DELETE", `/panel/delete/video/${videoId}`, true);
            xhr.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

            xhr.onload = function() {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    displayJqueryToast(response.toast.title, response.toast.msg, response.toast.status);
                    resetUploadState();
                    $('#deleteModal').modal('hide');
                } else {
                    displayJqueryToast("Error", "An unexpected error occurred.", "error");
                }
            };
            xhr.send();
        }
    </script>
    <script>
        function displayJqueryToast(title, message, status) {
            $.toast({
                heading: title,
                text: message,
                showHideTransition: 'slide',
                icon: status,
                position: 'bottom-left',
                loaderBg: '#f2a654',
                hideAfter: 5000,
                stack: 6
            });
        }
    </script>
@endpush

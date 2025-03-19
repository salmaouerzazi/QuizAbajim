<!DOCTYPE html>
<html>
<head>
    <title>Laravel </title>
    <!-- PWA  -->
<meta name="theme-color" content="#6777ef"/>
<link rel="apple-touch-icon" href="{{ asset('logo.PNG') }}">
<link rel="manifest" href="{{ asset('/manifest.json') }}">
</head>
<body>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');
*{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Poppins", sans-serif;
}


::selection{
  color: #fff;
  background: #6990F2;
}
.wrapper{
  width: 100%;
  background: #fff;
  border-radius: 5px;
  padding: 30px;
  box-shadow: 7px 7px 12px rgba(0,0,0,0.05);
}
.wrapper header{
  color: #6990F2;
  font-size: 27px;
  font-weight: 600;
  text-align: center;

}
.wrapper form{
  height: 167px;
  display: flex;
  cursor: pointer;
  margin: 30px 0;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  border-radius: 5px;
  border: 2px dashed #6990F2;
}
form :where(i, p){
  color: #6990F2;
}   
form i{
  font-size: 50px;
}
form p{
  margin-top: 15px;
  font-size: 16px;
}

section .row{
  margin-bottom: 10px;
  background: #E9F0FF;
  list-style: none;
  padding: 15px 20px;
  border-radius: 5px;
  display: flex;
  align-items: center;
  justify-content: space-between;
}
section .row i{
  color: #6990F2;
  font-size: 30px;
}
section .details span{
  font-size: 14px;
}
.progress-area .row .content{
  width: 100%;
  margin-left: 15px;
}
.progress-area .details{
  display: flex;
  align-items: center;
  margin-bottom: 7px;
  justify-content: space-between;
}
.progress-area .content .progress-bar{
  height: 6px;
  width: 100%;
  margin-bottom: 4px;
  background: #fff;
  border-radius: 30px;
}
.content .progress-bar .progress{
  height: 100%;
  width: 0%;
  background: #6990F2;
  border-radius: inherit;
}
.uploaded-area{
  max-height: 232px;
  overflow-y: scroll;
}
.uploaded-area.onprogress{
  max-height: 150px;
}
.uploaded-area::-webkit-scrollbar{
  width: 0px;
}
.uploaded-area .row .content{
  display: flex;
  align-items: center;
}
.uploaded-area .row .details{
  display: flex;
  margin-left: 15px;
  flex-direction: column;
}
.uploaded-area .row .details .size{
  color: #404040;
  font-size: 11px;
}
.uploaded-area i.fa-check{
  font-size: 16px;
}
body{
    margin-top:20px;
    background:#DCDCDC;
}
.card-box {
    padding: 20px;
    border-radius: 3px;
    margin-bottom: 30px;
    background-color: #fff;
}

.file-man-box {
    padding: 20px;
    border: 1px solid #e3eaef;
    border-radius: 5px;
    position: relative;
    margin-bottom: 20px
}

.file-man-box .file-close {
    color: #f1556c;
    position: absolute;
    line-height: 24px;
    font-size: 24px;
    right: 10px;
    top: 10px;
    visibility: hidden
}

.file-man-box .file-img-box {
    line-height: 120px;
    text-align: center
}

.file-man-box .file-img-box img {
    height: 64px
}

.file-man-box .file-download {
    font-size: 32px;
    color: #98a6ad;
    position: absolute;
    right: 10px
}

.file-man-box .file-download:hover {
    color: #313a46
}

.file-man-box .file-man-title {
    padding-right: 25px
}

.file-man-box:hover {
    -webkit-box-shadow: 0 0 24px 0 rgba(0, 0, 0, .06), 0 1px 0 0 rgba(0, 0, 0, .02);
    box-shadow: 0 0 24px 0 rgba(0, 0, 0, .06), 0 1px 0 0 rgba(0, 0, 0, .02)
}

.file-man-box:hover .file-close {
    visibility: visible
}
.text-overflow {
    text-overflow: ellipsis;
    white-space: nowrap;
    display: block;
    width: 100%;
    overflow: hidden;
}
h5 {
    font-size: 15px;
}
</style>

<div class="">
    <div class="">
        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <div class="row">
                        <div class="col-lg-6 col-xl-6">
                            <h4 class="header-title m-b-30">My Document</h4>
                        </div>
                    </div>
                    <div class="wrapper">
                        <header> Uploader Document</header>
                        <form action="#" enctype="multipart/form-data">
                        
                        <input class="file-input" type="file" name="file">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <p>Browse File to Upload</p>
                        </form>
                        <section class="progress-area"></section>
                        <section class="uploaded-area"></section>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-xl-2">
                            <div class="file-man-box"><a href="" class="file-close"><i class="fa fa-times-circle"></i></a>
                                <div class="file-img-box"><img src="https://coderthemes.com/highdmin/layouts/assets/images/file_icons/pdf.svg" alt="icon"></div><a href="#" class="file-download"><i class="fa fa-download"></i></a>
                                <div class="file-man-title">
                                    <h5 class="mb-0 text-overflow">invoice_project.pdf</h5>
                                    <p class="mb-0"><small>568.8 kb</small></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-2">
                            <div class="file-man-box"><a href="" class="file-close"><i class="fa fa-times-circle"></i></a>
                                <div class="file-img-box"><img src="https://coderthemes.com/highdmin/layouts/assets/images/file_icons/bmp.svg" alt="icon"></div><a href="#" class="file-download"><i class="fa fa-download"></i></a>
                                <div class="file-man-title">
                                    <h5 class="mb-0 text-overflow">Bmpfile.bmp</h5>
                                    <p class="mb-0"><small>845.8 mb</small></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-2">
                            <div class="file-man-box"><a href="" class="file-close"><i class="fa fa-times-circle"></i></a>
                                <div class="file-img-box"><img src="https://coderthemes.com/highdmin/layouts/assets/images/file_icons/psd.svg" alt="icon"></div><a href="#" class="file-download"><i class="fa fa-download"></i></a>
                                <div class="file-man-title">
                                    <h5 class="mb-0 text-overflow">Photoshop_file.ps</h5>
                                    <p class="mb-0"><small>684.8 kb</small></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-2">
                            <div class="file-man-box"><a href="" class="file-close"><i class="fa fa-times-circle"></i></a>
                                <div class="file-img-box"><img src="https://coderthemes.com/highdmin/layouts/assets/images/file_icons/avi.svg" alt="icon"></div><a href="#" class="file-download"><i class="fa fa-download"></i></a>
                                <div class="file-man-title">
                                    <h5 class="mb-0 text-overflow">Avifile.avi</h5>
                                    <p class="mb-0"><small>5.9 mb</small></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-2">
                            <div class="file-man-box"><a href="" class="file-close"><i class="fa fa-times-circle"></i></a>
                                <div class="file-img-box"><img src="https://coderthemes.com/highdmin/layouts/assets/images/file_icons/cad.svg" alt="icon"></div><a href="#" class="file-download"><i class="fa fa-download"></i></a>
                                <div class="file-man-title">
                                    <h5 class="mb-0 text-overflow">Cadfile.cad</h5>
                                    <p class="mb-0"><small>95.8 mb</small></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-2">
                            <div class="file-man-box"><a href="" class="file-close"><i class="fa fa-times-circle"></i></a>
                                <div class="file-img-box"><img src="https://coderthemes.com/highdmin/layouts/assets/images/file_icons/txt.svg" alt="icon"></div><a href="#" class="file-download"><i class="fa fa-download"></i></a>
                                <div class="file-man-title">
                                    <h5 class="mb-0 text-overflow">Mytextfile.txt</h5>
                                    <p class="mb-0"><small>568.8 kb</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-xl-2">
                            <div class="file-man-box"><a href="" class="file-close"><i class="fa fa-times-circle"></i></a>
                                <div class="file-img-box"><img src="https://coderthemes.com/highdmin/layouts/assets/images/file_icons/eps.svg" alt="icon"></div><a href="#" class="file-download"><i class="fa fa-download"></i></a>
                                <div class="file-man-title">
                                    <h5 class="mb-0 text-overflow">Epsfile.eps</h5>
                                    <p class="mb-0"><small>568.8 kb</small></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-2">
                            <div class="file-man-box"><a href="" class="file-close"><i class="fa fa-times-circle"></i></a>
                                <div class="file-img-box"><img src="https://coderthemes.com/highdmin/layouts/assets/images/file_icons/dll.svg" alt="icon"></div><a href="#" class="file-download"><i class="fa fa-download"></i></a>
                                <div class="file-man-title">
                                    <h5 class="mb-0 text-overflow">Project_file.dll</h5>
                                    <p class="mb-0"><small>684.3 kb</small></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-2">
                            <div class="file-man-box"><a href="" class="file-close"><i class="fa fa-times-circle"></i></a>
                                <div class="file-img-box"><img src="https://coderthemes.com/highdmin/layouts/assets/images/file_icons/sql.svg" alt="icon"></div><a href="#" class="file-download"><i class="fa fa-download"></i></a>
                                <div class="file-man-title">
                                    <h5 class="mb-0 text-overflow">Website_file.sql</h5>
                                    <p class="mb-0"><small>457.8 kb</small></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-2">
                            <div class="file-man-box"><a href="" class="file-close"><i class="fa fa-times-circle"></i></a>
                                <div class="file-img-box"><img src="https://coderthemes.com/highdmin/layouts/assets/images/file_icons/zip.svg" alt="icon"></div><a href="#" class="file-download"><i class="fa fa-download"></i></a>
                                <div class="file-man-title">
                                    <h5 class="mb-0 text-overflow">invoice_project.pdf</h5>
                                    <p class="mb-0"><small>568.8 kb</small></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-2">
                            <div class="file-man-box"><a href="" class="file-close"><i class="fa fa-times-circle"></i></a>
                                <div class="file-img-box"><img src="https://coderthemes.com/highdmin/layouts/assets/images/file_icons/ps.svg" alt="icon"></div><a href="#" class="file-download"><i class="fa fa-download"></i></a>
                                <div class="file-man-title">
                                    <h5 class="mb-0 text-overflow">invoice_project.pdf</h5>
                                    <p class="mb-0"><small>568.8 kb</small></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-2">
                            <div class="file-man-box"><a href="" class="file-close"><i class="fa fa-times-circle"></i></a>
                                <div class="file-img-box"><img src="https://coderthemes.com/highdmin/layouts/assets/images/file_icons/png.svg" alt="icon"></div><a href="#" class="file-download"><i class="fa fa-download"></i></a>
                                <div class="file-man-title">
                                    <h5 class="mb-0 text-overflow">invoice_project.pdf</h5>
                                    <p class="mb-0"><small>568.8 kb</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <button type="button" class="btn btn-outline-danger w-md waves-effect waves-light"><i class="mdi mdi-refresh"></i> Load More Files</button>
                    </div>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- container -->
</div>

<script>
const form = document.querySelector("form"),
fileInput = document.querySelector(".file-input"),
progressArea = document.querySelector(".progress-area"),
uploadedArea = document.querySelector(".uploaded-area");

// Set up the CSRF token
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

form.addEventListener("click", () => {
  fileInput.click();
});

fileInput.onchange = ({target}) => {
  let file = target.files[0];
  if (file) {
    let fileName = file.name;
    if (fileName.length >= 12) {
      let splitName = fileName.split('.');
      fileName = splitName[0].substring(0, 13) + "... ." + splitName[1];
    }
    uploadFile(fileName);
  }
}

function uploadFile(name) {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "/panel/upload");
  xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken); // Include CSRF token
  xhr.upload.addEventListener("progress", ({ loaded, total }) => {
    let fileLoaded = Math.floor((loaded / total) * 100);
    let fileTotal = Math.floor(total / 1000);
    let fileSize;
    (fileTotal < 1024) ? fileSize = fileTotal + " KB" : fileSize = (loaded / (1024 * 1024)).toFixed(2) + " MB";
    let progressHTML = `<li class="row">
                          <i class="fas fa-file-alt"></i>
                          <div class="content">
                            <div class="details">
                              <span class="name">${name} • Uploading</span>
                              <span class="percent">${fileLoaded}%</span>
                            </div>
                            <div class="progress-bar">
                              <div class="progress" style="width: ${fileLoaded}%"></div>
                            </div>
                          </div>
                        </li>`;
    uploadedArea.classList.add("onprogress");
    progressArea.innerHTML = progressHTML;
    if (loaded == total) {
      progressArea.innerHTML = "";
      let uploadedHTML = `<li class="row">
                            <div class="content upload">
                              <i class="fas fa-file-alt"></i>
                              <div class="details">
                                <span class="name">${name} • Uploaded</span>
                                <span class="size">${fileSize}</span>
                              </div>
                            </div>
                            <i class="fas fa-check"></i>
                          </li>`;
      uploadedArea.classList.remove("onprogress");
      uploadedArea.insertAdjacentHTML("afterbegin", uploadedHTML);
    }
  });
  let data = new FormData(form);
  xhr.send(data);
}

</script>
</body>
</html>
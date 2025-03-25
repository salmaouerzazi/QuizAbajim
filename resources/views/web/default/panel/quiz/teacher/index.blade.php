@extends('web.default.panel.layouts.panel_layout')

@section('content')
<div class="container mt-4">
    <div class="mb-4 text-left">
        <h3 class="font-20 text-dark-blue fw-bold">تحديك الجديد</h3>
        <p class="text-gray font-14 mb-0">أنشئ تحديات ممتعة واختبر مهارات طلابك بأسئلة دقيقة</p>
    </div>

    <form method="POST" enctype="multipart/form-data" action="{{ route('panel.quiz.upload') }}">
        @csrf
        <div class="rounded" style="max-width: 750px; margin: auto; background: #f2f9fc; border: 2px dashed #6490ab; padding: 50px 30px;">

            <!-- Zone Upload -->
            <div id="dropzone"
                 class="text-center mb-5 p-5 rounded"
                 style="background-color: #f2f9fc; border: 2px dashed #6490ab; cursor: pointer;"
                 ondragover="handleDragOver(event)"
                 ondragleave="handleDragLeave(event)"
                 ondrop="handleDrop(event)"
                 onclick="document.getElementById('fileInput').click()">

                <i class="fas fa-cloud-upload-alt fa-4x mb-4" style="color: #6490ab;"></i>
                <p class="mb-1 text-dark font-16">اختر ملفاً أو اسحبه إلى هنا لإضافته</p>
                <p class="text-muted mb-3">ملف .PDF، بحجم لا يتجاوز 10MB</p>

                <input type="file" name="pdf" id="fileInput" accept="application/pdf" class="d-none" onchange="updateFileName(this)">
                <div id="fileName" class="mt-3 text-success fw-bold"></div>
            </div>

            <!-- Preview Block -->
            <div id="uploadedFilePreview" class="mt-4" style="display: none;">
                <label class="d-block mb-2 font-weight-bold text-right">الملفات المضافة</label>

                <div class="d-flex align-items-center justify-content-between p-3 rounded" style="background-color: #f5f5f5;">
                    <div class="d-flex align-items-center">
                        <img src="/assets/icons/pdf-icon.png" alt="PDF" style="width: 30px; height: auto; margin-left: 10px;">
                        <span id="uploadedFileName" class="mr-2">document.pdf</span>
                    </div>
                    <div>
                        <span id="uploadedFileSize" class="text-muted mx-2">5.7MB</span>
                        <a href="#" class="text-primary" onclick="showPdfPreview(event)">عرض</a>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary px-5 rounded-pill">إنشاء تحدي</button>
                </div>

                <div id="pdfViewer" class="mt-4 text-center" style="display: none; position: relative;">
                    <button onclick="confirmClosePdfPreview()" style="position: absolute; top: -10px; left: -10px; background: red; color: white; border: none; border-radius: 50%; width: 30px; height: 30px; font-size: 16px; cursor: pointer;">&times;</button>
                    <iframe id="pdfIframe" src="" width="100%" height="600px" style="border: 1px solid #ddd; border-radius: 10px;"></iframe>
                </div>
            </div>

            <!-- Section des paramètres -->
            <div class="d-flex justify-content-between align-items-end text-center mt-4 pt-4 border-top" style="border-color: #a5d6e8; flex-wrap: wrap; gap: 20px;">
                <div class="flex-fill">
                    <label class="d-block mb-2" style="color: #004c70;">عدد الأسئلة</label>
                    <div class="d-flex align-items-center justify-content-center">
                        <button type="button" class="btn btn-sm text-white" style="background-color: #1ec9d9; border-radius: 8px; width: 38px; height: 38px; font-weight: bold;" onclick="changeCount(-1)">-</button>
                        <input type="number" id="questionCount" name="question_count" class="form-control text-center mx-2" style="width: 70px; height: 38px; border-radius: 8px; border: 1px solid #1ec9d9; font-weight: bold;" value="4" min="1">
                        <button type="button" class="btn btn-sm text-white" style="background-color: #1ec9d9; border-radius: 8px; width: 38px; height: 38px; font-weight: bold;" onclick="changeCount(1)">+</button>
                    </div>
                </div>

                <div class="flex-fill">
                    <label class="d-block mb-2" style="color: #004c70;">المستوى الدراسي</label>
                    <select name="level" class="form-control text-right" style="background-color: #e6f4fa; border: 1px solid #1ec9d9; border-radius: 12px; font-weight: bold;">
                        <option value="">-- اختر --</option>
                        <option value="3eme">الثالثة ابتدائي</option>
                        <option value="4eme">الرابعة ابتدائي</option>
                    </select>
                </div>

                <div class="flex-fill">
                    <label class="d-block mb-2" style="color: #004c70;">المادة الدراسية</label>
                    <select name="subject" class="form-control text-right" style="background-color: #e6f4fa; border: 1px solid #1ec9d9; border-radius: 12px; font-weight: bold;">
                        <option value="">-- اختر --</option>
                        <option value="math">الرياضيات</option>
                        <option value="science">العلوم</option>
                    </select>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function updateFileName(input) {
        const file = input.files[0];
        if (file && file.type === "application/pdf") {
            document.getElementById('dropzone').style.display = 'none';
            document.getElementById('uploadedFilePreview').style.display = 'block';
            document.getElementById('uploadedFileName').innerText = file.name;
            document.getElementById('uploadedFileSize').innerText = formatBytes(file.size);
        }
    }

    function handleDragOver(e) {
        e.preventDefault();
        const dropzone = document.getElementById('dropzone');
        dropzone.style.borderColor = '#1ec9d9';
        dropzone.style.backgroundColor = '#e0f7fa';
    }

    function handleDragLeave(e) {
        e.preventDefault();
        const dropzone = document.getElementById('dropzone');
        dropzone.style.borderColor = '#6490ab';
        dropzone.style.backgroundColor = '#f2f9fc';
    }

    function handleDrop(e) {
        e.preventDefault();
        const file = e.dataTransfer.files[0];
        if (file && file.type === "application/pdf") {
            document.getElementById('fileInput').files = e.dataTransfer.files;
            updateFileName(document.getElementById('fileInput'));
        } else {
            alert("يرجى تحميل ملف PDF فقط.");
        }
        handleDragLeave(e);
    }

    function showPdfPreview(e) {
        e.preventDefault();
        const fileInput = document.getElementById('fileInput');
        const file = fileInput.files[0];
        if (file) {
            const fileURL = URL.createObjectURL(file);
            const iframe = document.getElementById('pdfIframe');
            iframe.src = fileURL;
            document.getElementById('pdfViewer').style.display = 'block';
        }
    }

    function confirmClosePdfPreview() {
        const confirmDelete = confirm("هل أنت متأكد من حذف الملف؟");
        if (confirmDelete) {
            closePdfPreview();
        }
    }

    function closePdfPreview() {
        document.getElementById('pdfViewer').style.display = 'none';
        document.getElementById('pdfIframe').src = '';
    }

    function formatBytes(bytes, decimals = 1) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const dm = decimals < 0 ? 0 : decimals;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + sizes[i];
    }

    function changeCount(delta) {
        const input = document.getElementById('questionCount');
        let value = parseInt(input.value) + delta;
        if (value < 1) value = 1;
        input.value = value;
    }
</script>
@endsection

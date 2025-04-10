@extends('web.default.panel.layouts.panel_layout')

@section('content')
<div class="container mt-4">
    <div class="mb-4 text-left">
        <h3 class="font-20 text-dark-blue fw-bold">{{ trans('quiz.title') }}</h3>
        <p class="text-gray font-14 mb-0">أنشئ تحديات ممتعة واختبر مهارات طلابك بأسئلة دقيقة</p>
    </div>

    <form method="POST" enctype="multipart/form-data" action="{{ route('panel.quiz.upload') }}">
        @csrf
        <div class="rounded" style="max-width: 750px; margin: auto; background: #f2f9fc; border: 2px dashed #6490ab; padding: 50px 30px;">

            <!-- Zone Upload -->
            <div id="dropzone"
                 class="text-center mb-5 p-5 rounded"
                 style="background-color: #f2f9fc; border: 2px dashed #6490ab; cursor: pointer; transition: all 0.3s;"
                 ondragover="handleDragOver(event)"
                 ondragleave="handleDragLeave(event)"
                 ondrop="handleDrop(event)"
                 onclick="triggerFileInput()">

                <i class="fas fa-cloud-upload-alt fa-4x mb-4" style="color: #6490ab;"></i>
                <p class="mb-1 text-dark font-16">اختر ملفاً أو اسحبه إلى هنا لإضافته</p>
                <p class="text-muted mb-3">ملف .PDF، بحجم لا يتجاوز 10MB</p>

                <input type="file" name="pdf" id="fileInput" accept="application/pdf" class="d-none" onchange="updateFileName(this)">
                <div id="fileName" class="mt-3 text-success fw-bold"></div>
            </div>

            <!-- Paramètres -->
            <div class="d-flex justify-content-between align-items-end text-center mt-4 pt-4 border-top" style="border-color: #a5d6e8; flex-wrap: wrap; gap: 20px;">
                <div class="flex-fill">
                    <label class="d-block mb-2" style="color: #004c70;">عدد الأسئلة</label>
                    <input type="number" id="questionCount" name="num_questions" class="form-control text-center" value="5" min="1" required>
                </div>

                <div class="flex-fill">
                    <label class="d-block mb-2" style="color: #004c70;">المستوى الدراسي</label>
                    <select name="level" class="form-control text-right" required>
                        <option value="">-- اختر --</option>
                        @foreach($levels as $level)
                            <option value="{{ $level->id }}">{{ $level->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex-fill">
                    <label class="d-block mb-2" style="color: #004c70;">المادة الدراسية</label>
                    <select name="subject" class="form-control text-right" required>
                        <option value="">-- اختر --</option>
                        @foreach($materials as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Bouton de soumission -->
            <div class="text-center mt-4">
                <button type="submit" id="submitButton"
                    class="btn btn-primary px-5 rounded-pill"
                    style="background-color: #6490ab; border: none; transition: all 0.3s;" disabled>
                    🚀 إنشاء تحدي
                </button>
            </div>
        </div>
    </form>
    <form action="{{ route('panel.quiz.edit') }}" method="GET">
    <button type="submit" class="btn btn-primary">Modifier les questions générées</button>
</form>
</div>

<!-- JS de gestion upload -->
<script>
    function triggerFileInput() {
        document.getElementById('fileInput').click();
    }

    function handleDragOver(e) {
        e.preventDefault();
        document.getElementById('dropzone').style.borderColor = '#1ec9d9';
        document.getElementById('dropzone').style.backgroundColor = '#e0f7fa';
    }

    function handleDragLeave(e) {
        e.preventDefault();
        document.getElementById('dropzone').style.borderColor = '#6490ab';
        document.getElementById('dropzone').style.backgroundColor = '#f2f9fc';
    }

    function handleDrop(e) {
        e.preventDefault();
        const file = e.dataTransfer.files[0];
        if (file && file.type === 'application/pdf') {
            document.getElementById('fileInput').files = e.dataTransfer.files;
            updateFileName(document.getElementById('fileInput'));
        } else {
            alert('يرجى تحميل ملف PDF فقط.');
        }
        handleDragLeave(e);
    }

    function updateFileName(input) {
        const file = input.files[0];
        if (file && file.type === 'application/pdf') {
            document.getElementById('fileName').innerText = file.name;
            document.getElementById('submitButton').disabled = false;
        } else {
            document.getElementById('fileName').innerText = '';
            document.getElementById('submitButton').disabled = true;
        }
    }
</script>
@endsection

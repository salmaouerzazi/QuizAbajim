@extends('web.default.panel.layouts.panel_layout')

@section('content')
    <style>
        .card-header.bg-primary {
            background-color: #1f3c88 !important;
        }

        .btn.btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn.btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .list-group-item.active {
            background-color: #1f3c88;
            border-color: #1f3c88;
            color: #fff;
        }

        .badge.bg-light.border {
            background-color: #f0f4f8;
            color: #333;
        }

        .form-control,
        .form-select {
            background-color: #f4f8fc;
            border: 1px solid #d0d7e2;
        }
    </style>
    <div class="container-fluid mt-4" dir="rtl">
        <div class="row">
            <div class="col-md-3">
                <div class="card shadow-sm rounded-4">
                    <div class="card-header bg-white text-center fw-bold">📋 الأسئلة ({{ count($questions) }})</div>
                    <ul class="list-group list-group-flush">
                        @foreach ($questions as $index => $q)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <a href="#" class="text-decoration-none text-dark scroll-to"
                                    data-target="question{{ $index }}">سؤال {{ $index + 1 }}</a>
                                <span class="badge bg-light border">{{ $q['score'] }} نقاط</span>
                            </li>
                        @endforeach
                        <li class="list-group-item text-center text-primary" style="cursor:pointer;">
                            + إضافة سؤال آخر
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-md-9">
                <form method="POST" action="#">
                    @csrf
                    @foreach ($questions as $index => $q)
                        <div class="card shadow-sm mb-4 rounded-4 border-0" id="question{{ $index }}">
                            <div class="card-header bg-primary text-white rounded-top-4 d-flex justify-content-between">
                                <span>سؤال {{ $index + 1 }}</span>
                                <button type="button" class="btn btn-sm btn-light text-danger">🗑️</button>
                            </div>

                            <div class="card-body" style="background: #f9f9f9;">
                                <div class="mb-3 d-flex align-items-center gap-2">
                                    <label class="form-label mb-0 fw-bold">النقاط :</label>
                                    <input type="number" class="form-control form-control-sm w-25"
                                        name="questions[{{ $index }}][score]" value="{{ $q['score'] ?? 1 }}">
                                </div>

                                {{-- Matching --}}
                                @if ($q['type'] === 'ربط' || $q['type'] === 'arrow')
                                    <label class="form-label fw-bold">السؤال</label>
                                    <input type="text" class="form-control mb-3"
                                        name="questions[{{ $index }}][question]"
                                        value="{{ $q['question'] ?? trans('panel.match_question') }}">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">العناصر</label>
                                            @foreach ($q['answers'] as $i => $answer)
                                                <input type="text" class="form-control mb-2"
                                                    name="questions[{{ $index }}][answers][{{ $i }}][answer_text]"
                                                    value="{{ $answer['answer_text'] ?? '' }}">
                                            @endforeach
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">الإجابات المطابقة</label>
                                            @foreach ($q['answers'] as $i => $answer)
                                                <input type="text" class="form-control mb-2"
                                                    name="questions[{{ $index }}][answers][{{ $i }}][matching]"
                                                    value="{{ $answer['matching'] ?? '' }}">
                                            @endforeach
                                        </div>
                                    </div>

                                    {{-- Vrai/Faux --}}
                                @elseif($q['type'] === 'صحيح/خطأ' || $q['type'] === 'binaire')
                                    <label class="form-label fw-bold">البيان</label>
                                    <input type="text" name="questions[{{ $index }}][question]"
                                        class="form-control mb-3" value="{{ $q['question_text'] ?? '' }}">

                                    <div class="d-flex gap-3">
                                        @php
                                            $correct = isset($q['correct'])
                                                ? $q['correct']
                                                : (isset($q['is_valid'])
                                                    ? (bool) $q['is_valid']
                                                    : null);
                                        @endphp

                                        <div role="group">
                                            <label class="btn btn-outline-primary {{ $correct === true ? 'active' : '' }}">
                                                <input type="radio" class="d-none"
                                                    name="questions[{{ $index }}][correct]" value="true"
                                                    {{ $correct === true ? 'checked' : '' }}>
                                                صحيح
                                            </label>

                                            <label
                                                class="btn btn-outline-primary {{ $correct === false ? 'active' : '' }}">
                                                <input type="radio" class="d-none"
                                                    name="questions[{{ $index }}][correct]" value="false"
                                                    {{ $correct === false ? 'checked' : '' }}>
                                                خطأ
                                            </label>
                                        </div>
                                    </div>

                                    {{-- QCM --}}
                                @elseif($q['type'] === 'اختيار من متعدد' || $q['type'] === 'qcm')
                                    <label class="form-label fw-bold">السؤال</label>
                                    <input type="text" name="questions[{{ $index }}][question]"
                                        class="form-control mb-3" value="{{ $q['question_text'] ?? '' }}">

                                    <label class="form-label fw-bold">الخيارات</label>
                                    @foreach ($q['answers'] as $i => $a)
                                        @php
                                            $isValid =  $a['is_valid'] 
                                        @endphp

                                        <div class="input-group mb-2">
                                            <div class="input-group-text">
                                                <input type="radio" name="questions[{{ $index }}][correct]"
                                                     value="{{ $a['answer_text'] }}" {{ $isValid ? 'checked' : '' }}>
                                            </div>
                                            <input type="text"
                                                name="questions[{{ $index }}][answers][{{ $i }}][answer_text]"
                                                class="form-control" value="{{ $a['answer_text'] }}">
                                        </div>
                                    @endforeach
                                    <input type="text" class="form-control mt-2" placeholder="➕ إضافة إجابة جديدة"
                                        name="questions[{{ $index }}][answers][]">
                                @endif
                            </div>
                        </div>
                    @endforeach

                    <div class="text-end mt-4">
                        <button class="btn btn-primary px-5">💾 حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.scroll-to').forEach(function(link) {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.dataset.target;
                    const el = document.getElementById(targetId);
                    if (el) el.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                });
            });
        });
    </script>
@endsection

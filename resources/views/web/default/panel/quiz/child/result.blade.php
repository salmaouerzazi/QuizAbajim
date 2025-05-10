@extends('layouts.app')
@section('content')
<div class="container mt-5 text-center" style="direction: rtl;">
    <h3 class="text-success">✅ نتيجتك : {{ $score }} / {{ $quiz->questions->count() }}</h3>

    <a href="{{ url('/') }}" class="btn btn-primary mt-4">🏠 العودة إلى الصفحة الرئيسية</a>
</div>
@endsection

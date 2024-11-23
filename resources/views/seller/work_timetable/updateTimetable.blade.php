@extends('seller.mainComponents')

@section('title', 'تعديل جدول المواعيد')

@section('link_one', 'جدول المواعيد')
@section('link_two', 'تعديل جدول المواعيد')

@section('content')
@if (Session::has('success'))
    <div class="alert alert-success">{{ Session::get('success') }}</div>
@elseif (Session::has('error'))
    <div class="alert alert-danger">{{ Session::get('error') }}</div>
@endif

<div class="container mt-4">
    <!-- Card Title -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h3 class="my-0"><i class="fas fa-pen mx-2"></i> تعديل  الموعد رقم: {{ $timetable->id }}</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('seller.timetable.update', $timetable->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Timetable Day -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="day" class="form-label">اليوم</label>
                                <select name="day" id="day" class="form-control" required>
                                    <option value="Saturday" @if($timetable->day == 'Saturday') selected @endif>السبت</option>
                                    <option value="Sunday" @if($timetable->day == 'Sunday') selected @endif>الأحد</option>
                                    <option value="Monday" @if($timetable->day == 'Monday') selected @endif>الإثنين</option>
                                    <option value="Tuesday" @if($timetable->day == 'Tuesday') selected @endif>الثلاثاء</option>
                                    <option value="Wednesday" @if($timetable->day == 'Wednesday') selected @endif>الأربعاء</option>
                                    <option value="Thursday" @if($timetable->day == 'Thursday') selected @endif>الخميس</option>
                                    <option value="Friday" @if($timetable->day == 'Friday') selected @endif>الجمعة</option>
                                </select>
                            </div>
                        </div>

                        <!-- Timetable Start Time -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="start_time" class="form-label">وقت البداية</label>
                                <input type="time" class="form-control" name="start_time" id="start_time" value="{{ $timetable->start_time }}" required>
                            </div>
                        </div>

                        <!-- Timetable End Time -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="end_time" class="form-label">وقت النهاية</label>
                                <input type="time" class="form-control" name="end_time" id="end_time" value="{{ $timetable->end_time }}" required>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="row mt-3">
                            <div class="col-md-12 text-center">
                                <a href="{{ route('seller.timetables') }}" class="btn btn-outline-secondary">رجوع</a>
                                <button type="submit" class="btn btn-outline-success mx-2">حفظ التعديلات</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

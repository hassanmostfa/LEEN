@extends('seller.mainComponents')

@section('title', 'مواعيد العمل')


@section('content')
@if (Session::has('success'))
    <div class="alert alert-success">{{ Session::get('success') }}</div>
@elseif (Session::has('error'))
    <div class="alert alert-danger">{{ Session::get('error') }}</div>
@endif

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header py-2 bg-success text-white d-flex align-items-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-3">
                    <i class="fa-solid fa-clock-rotate-left" style="font-size: 25px;"></i>
                    <h4 class="my-0 flex-grow-1" style="font-size: 20px; font-weight: 400;">جميع ايام العمل</h4>
                </div>
                <div>
                    <button type="button" class="btn btn-sm text-white" style="font-size: 15px; font-weight: 600; border-radius: 5px; border: 2px solid white;" data-toggle="modal" data-target="#exampleModalCenter">
                        <i class="fa-solid fa-plus mx-2"></i>
                        اضافة موعد جديد
                    </button>
                </div>
            </div>
            <div class="card-body">
                @if($timetables->isEmpty())
                <div class="alert alert-warning text-center m-0 text-bold" style="font-size: 18px;" role="alert">
                    لا يوجد مواعيد حتي الان
                </div>
                @else
                    <table class="table table-bordered table-striped table-hover text-center">
                        <thead class="bg-light">
                            <tr>
                                <th>رقم الموعد</th>
                                <th>اليوم</th>
                                <th>وقت البدا</th>
                                <th>وقت الانتهاء</th>
                                <th>اجراء</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($timetables as $timetable)
                                <tr>
                                    <td>{{ $timetable->id }}</td>
                                    <td>
                                        @switch($timetable->day)
                                            @case('Saturday')
                                                السبت
                                            @break
                                            @case('Sunday')
                                                الاحد 
                                            @break  
                                            @case('Monday')
                                                الاثنين 
                                            @break
                                            @case('Tuesday')
                                                الثلاثاء
                                            @break
                                            @case('Wednesday')
                                                الاربعاء
                                            @break
                                            @case('Thursday')
                                                الخميس
                                            @break
                                            @case('Friday')
                                                الجمعة
                                            @break
                                            @default
                                                {{ $timetable->day }}
                                        @endswitch
                                    </td>
                                    <td>{{ $timetable->start_time }}</td>
                                    <td>{{ $timetable->end_time }}</td>
                                    <td>
                                        <a href="{{ route('seller.timetable.edit', $timetable->id) }}" class="btn btn-sm btn-outline-success mx-2 border-2" style="font-weight: 600 !important;">تعديل</a>
                                        <form action="{{ route('seller.timetable.destroy', $timetable->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger border-2" style="font-weight: 600 !important;">حذف</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>




<!-- Modal For Add Work Schedule -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header p-0 text-center bg-success text-white">
                <h5 class="modal-title text-center p-2 m-0 w-100" style="font-size: 20px; font-weight: 400;" id="exampleModalLongTitle"><i class="fa-solid fa-plus me-3 mx-2"></i>اضافة موعد جديد</h5>
            </div>
            <div class="modal-body">
                <form action="{{ route('seller.timetable.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="day">اليوم</label>
                        <select name="day" id="day" class="form-control" required>
                            <option value="Saturday">السبت</option>
                            <option value="Sunday">الأحد</option>
                            <option value="Monday">الإثنين</option>
                            <option value="Tuesday">الثلاثاء</option>
                            <option value="Wednesday">الأربعاء</option>
                            <option value="Thursday">الخميس</option>
                            <option value="Friday">الجمعة</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="start_time">وقت البداية</label>
                        <input type="time" name="start_time" id="start_time" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="end_time">وقت النهاية</label>
                        <input type="time" name="end_time" id="end_time" class="form-control" required>
                    </div>

                    <div class="d-flex justify-content-center mt-4 gap-2">
                        <button type="submit" class="btn btn-outline-success">حفظ</button>
                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">اغلاق</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endSection
@extends('seller.mainComponents')

@section('title', 'طلبات الحجز المرفوضة')


@section('link_one', 'الحجوزات المنزلية')
@section('link_two', 'الطلبات المرفوضة')

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
                    <i class="fa-solid fa-clipboard-list" style="font-size: 25px;"></i>
                    <h4 class="my-0 flex-grow-1" style="font-size: 20px; font-weight: 400;">كل طلبات الحجز المرفوضة </h4>
                </div>
                <!-- <div>
                    <button type="button" class="btn btn-sm text-white" style="font-size: 15px; font-weight: 600; border-radius: 5px; border: 2px solid white;" data-toggle="modal" data-target="#exampleModalCenter">
                        <i class="fa-solid fa-plus mx-2"></i>
                        اضافة موظف جديد
                    </button>
                </div> -->
            </div>
            <div class="card-body">
                @if($studioBookings->isEmpty())
                <div class="alert alert-warning text-center m-0 text-bold" style="font-size: 18px;" role="alert">
                    لا يوجد حجوزات حتي الان
                </div>
                @else
                    <table class="table table-bordered table-striped table-hover text-center">
                        <thead class="bg-light">
                            <tr>
                                <th>رقم الحجز</th>
                                <th>الخدمة</th>
                                <th>اسم العميل</th>
                                <th>الموظف</th>
                                <th>التاريخ</th>
                                <th>وقت البدا</th>
                                <th>وقت الانتهاء</th>
                                <th>السعر الاجمالي</th>
                                <th>حالة الدفع</th>
                                <th>المبلغ المدفوع</th>
                                <th>الحالة</th>
                                <th>اجراء</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($studioBookings as $studioBooking)
                                <tr>
                                    <td>{{ $studioBooking->id }}</td>
                                    <td>{{ $studioBooking->studioService->name }}</td>
                                    <td>{{ $studioBooking->customer->first_name }} {{ $studioBooking->customer->last_name }}</td>
                                    <td>{{ $studioBooking->employee->name }}</td>
                                    <td>{{ $studioBooking->date }}</td>
                                    <td>{{ $studioBooking->start_time }}</td>
                                    <td>{{ $studioBooking->end_time }}</td>
                                    <td>{{ $studioBooking->studioService->price }}</td>
                                    <td>{{ $studioBooking->payment_status }}</td>
                                    <td>{{ $studioBooking->paid_amount }}</td>
                                    <td>
                                        @if ($studioBooking->booking_status == 'pending')
                                            <span class="badge bg-secondary">قيد الانتظار</span>
                                        @elseif($studioBooking->booking_status == 'accepted')
                                            <span class="badge bg-success">مقبول</span>
                                        @elseif($studioBooking->booking_status == 'rejected')
                                            <span class="badge bg-danger">مرفوض</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('seller.studioBookings.show', $studioBooking->id) }}" class="btn btn-sm btn-outline-success mx-2 border-2" style="font-weight: 600 !important;">عرض</a>
                                        
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

@endsection

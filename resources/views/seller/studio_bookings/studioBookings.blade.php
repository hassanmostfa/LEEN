@extends('seller.mainComponents')

@section('title', 'كل الحجوزات')


@section('link_one', 'الحجوزات')
@section('link_two', 'الكل')

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
                    <i class="fa-solid fa-user-check" style="font-size: 25px;"></i>
                    <h4 class="my-0 flex-grow-1" style="font-size: 20px; font-weight: 400;">كل الحجوزات المقبولة</h4>
                </div>
                <!-- <div>
                    <button type="button" class="btn btn-sm text-white" style="font-size: 15px; font-weight: 600; border-radius: 5px; border: 2px solid white;" data-toggle="modal" data-target="#exampleModalCenter">
                        <i class="fa-solid fa-plus mx-2"></i>
                        اضافة موظف جديد
                    </button>
                </div> -->
            </div>
            <div class="card-body">
                @if($studioBookings ->isEmpty())
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
                            @foreach ($studioBookings  as $studioBooking)
                                <tr>
                                    <td>{{ $studioBooking->id }}</td>
                                    <td>
                                        {{ $studioBooking->studioService->name }} <!-- Main Service Name -->
                                        @if($studioBooking->studioServiceBookingItems->isNotEmpty())
                                            <ul style=" list-style: none; padding: 0; margin: 0;">
                                                @foreach ($studioBooking->studioServiceBookingItems as $item)
                                                    <li>{{ $item->service->name }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </td>
                                    <td>{{ $studioBooking->customer->first_name }} {{ $studioBooking->customer->last_name }}</td>
                                    <td>
                                        {{ $studioBooking->employee->name }} <!-- Main Employee Name -->
                                        @if($studioBooking->studioServiceBookingItems->isNotEmpty())
                                            <ul style="list-style: none; padding: 0; margin: 0;">
                                                @foreach ($studioBooking->studioServiceBookingItems as $item)
                                                    <li style="padding: 4px;">
                                                        {{ $item->employee->name }} <!-- Additional Employee Name -->
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </td>
                                    <td>{{ $studioBooking->date }}</td>
                                    <td>{{ $studioBooking->start_time }}</td>
                                    <td>{{ $studioBooking->end_time }}</td>
                                    <td>
                                        {{ number_format($studioBooking->studioService->price, 2) }} SAR <!-- Main Service Price -->
                                        @if($studioBooking->studioServiceBookingItems->isNotEmpty())
                                            <ul style="list-style: none; padding: 0; margin: 0;">
                                                @foreach ($studioBooking->studioServiceBookingItems as $item)
                                                    <li style="padding: 4px;">
                                                        {{ number_format($item->service->price, 2) }} SAR <!-- Additional Service Price -->
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </td>
                                    <td>{{ $studioBooking->payment_status }}</td>
                                    <td>{{ $studioBooking->paid_amount }}</td>
                                    <td>
                                        @if ($studioBooking->booking_status == 'pending')
                                            <span class="badge bg-secondary">قيد الانتظار</span>
                                        @elseif($studioBooking->booking_status == 'accepted')
                                            <span class="badge bg-success">مقبول</span>
                                        @elseif($studioBooking->booking_status == 'rejected')
                                            <span class="badge bg-danger">مرفوض</span>
                                        @elseif($studioBooking->booking_status == 'cancelled')
                                            <span class="badge bg-danger">ملغي</span>
                                        @elseif($studioBooking->booking_status == 'done')
                                            <span class="badge bg-success">مكتمل</span>

                                        @endif
                                    </td>
                                    <td>
                                        @if ($studioBooking->booking_status == 'done')
                                            <span class="badge bg-success">تمت</span>
                                        @else
                                        <form action="{{ route('seller.studioBookings.serviceIsDone', $studioBooking->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-outline-success mx-2 border-2" style="font-weight: 600 !important;">تمت</button>
                                        </form>
                                        @endif
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
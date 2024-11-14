@extends('seller.mainComponents')

@section('title', 'طلبات الحجز الجديدة')


@section('link_one', 'الحجوزات المنزلية')
@section('link_two', 'الطلبات الجديدة')

@section('content')
@if (Session::has('success'))
    <div class="alert alert-success">{{ Session::get('success') }}</div>
@elseif (Session::has('error'))
    <div class="alert alert-danger">{{ Session::get('error') }}</div>
@endif

<div class="container mt-2">
    <div class="row">
        <div class="col-md-12 offset-md-2">
            <div class="card">
                <div class="card-header p-3 text-white bg-success">
                    <h3 class="my-0"> بيانات الحجز رقم :  {{ $homeBooking->id }}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Left side: Table for Unit Details -->
                        <div class="col-md-12">
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>رقم الحجز</th>
                                    <td>{{ $homeBooking->id }}</td>
                                </tr>

                                <tr>
                                    <th>الخدمة</th>
                                    <td>
                                        <li>{{ $homeBooking->homeService->name }}</li> <!-- Main Service Name -->
                                        @if($homeBooking->homeServiceBookingItems->isNotEmpty())
                                            <ul style="margin: 0; padding-right: 13px;">
                                                @foreach ($homeBooking->homeServiceBookingItems as $item)
                                                    <li>
                                                        {{ $item->service->name }} <!-- Additional Service Name with Price -->
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th>اسم العميل</th>
                                    <td>{{ $homeBooking->customer->first_name }} {{ $homeBooking->customer->last_name }}</td>
                                </tr>

                                <tr>
                                    <th>العنوان المحدد من العميل</th>
                                    <td>{{ $homeBooking->location}}</td>
                                </tr>


                                <tr>
                                    <th>الموظف</th>
                                    <td>
                                        <li>{{ $homeBooking->employee->name }}</li> <!-- Main Employee Name -->
                                        @if($homeBooking->homeServiceBookingItems->isNotEmpty())
                                            <ul style="padding-right: 13px; margin: 0;">
                                                @foreach ($homeBooking->homeServiceBookingItems as $item)
                                                    <li>
                                                        {{ $item->employee->name }} <!-- Additional Employee Name -->
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th>التاريخ</th>
                                    <td>{{ $homeBooking->date }}</td>
                                </tr>

                                <tr>
                                    <th>وقت البدا</th>
                                    <td>{{ $homeBooking->start_time }}</td>
                                </tr>

                                <tr>
                                    <th>وقت الانتهاء</th>
                                    <td>{{ $homeBooking->end_time }}</td>
                                </tr>

                                <tr>
                                    <th>حالة الدفع</th>
                                    <td>
                                        @if ($homeBooking->payment_status == 'unpaid')
                                            <span class="badge bg-dark">غير مدفوع</span>
                                        @elseif ($homeBooking->payment_status == 'paid')
                                            <span class="badge bg-success">مدفوع</span>
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th>المبلغ المدفوع</th>
                                    <td>{{ $homeBooking->paid_amount }}</td>
                                </tr>

                                <tr>
                                    <th>السعر الاجمالي</th>
                                    <td>
                                        <li>{{ number_format($homeBooking->homeService->price, 2) }} SAR</li> <!-- Main Service Price -->
                                        @if($homeBooking->homeServiceBookingItems->isNotEmpty())
                                            <ul style="padding-right: 13px; margin: 0;">
                                                @foreach ($homeBooking->homeServiceBookingItems as $item)
                                                    <li>
                                                        {{ number_format($item->service->price, 2) }} SAR <!-- Additional Service Price -->
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th>حالة الطلب</th>
                                    <td>
                                        @if ($homeBooking->booking_status == 'pending')
                                            <span class="badge bg-secondary">قيد الانتظار</span>
                                        @elseif ($homeBooking->booking_status == 'accepted')
                                            <span class="badge bg-success">مقبول</span>
                                        @elseif ($homeBooking->booking_status == 'rejected')
                                            <span class="badge bg-danger">مرفوض</span>
                                        @elseif ($homeBooking->booking_status == 'cancelled')
                                            <span class="badge bg-danger">ملغي</span>
                                        @elseif ($homeBooking->booking_status == 'completed')
                                            <span class="badge bg-success">مكتمل</span>
                                        @endif
                                    </td>
                                </tr>

                            </table>
                        </div>

                            <div class="d-flex justify-content-start mt-3 gap-2">
                            
                                <a href="{{ route('seller.homeBookings.newRequests') }}" class="btn btn-outline-secondary mt-3">عودة إلى قائمة الطلبات</a>
                        
                        <form action="{{ route('seller.homeBookings.accept', $homeBooking->id) }}" method="POST" class="mt-3">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-outline-success">قبول</button>
                        </form>
                        <button type="button" class="btn btn-outline-danger mt-3" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        رفض
                        </button>
                    </div>

                     <!-- Modal -->
                     <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 800px;">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header justify-content-start bg-danger text-white">
                <i class="fa-solid fa-triangle-exclamation me-3" style="font-size: 30px; margin-left: 10px;"></i>
                <h1 class="modal-title fs-5 m-0" id="staticBackdropLabel">هل أنت متأكد من رفض هذا الطلب ؟</h1>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <div class="alert alert-warning d-flex align-items-center" role="alert">
                    <i class="fas fa-exclamation-circle me-3" style="font-size: 24px;"></i>
                    <div class="mx-2">
                        <strong>تحذير:</strong> سيتم رفض هذا الطلب وسيتم اشعار العميل بذلك. يرجى كتابة سبب الرفض بعناية.
                    </div>
                </div>

                <!-- Rejection Form -->
                <form action="{{ route('seller.homeBookings.reject', $homeBooking->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="reason" class="form-label" style="font-weight: bold;">سبب الرفض</label>
                        <textarea class="form-control border-danger" id="reason" name="request_rejection_reason" rows="3" placeholder="اكتب سبب الرفض هنا..." required></textarea>
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex gap-2 justify-content-end mt-4">
                        <button type="submit" class="btn btn-outline-danger me-2">
                            إرسال الرفض
                        </button>
                        <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">اغلاق</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
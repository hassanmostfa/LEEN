@extends('customer.mainComponents')

@section('title', 'طلباتي')

@section('link_one', 'طلباتي')
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
                    <i class="fa-solid fa-shopping-cart" style="font-size: 25px;"></i>
                    <h4 class="my-0 flex-grow-1" style="font-size: 20px; font-weight: 400;">كل الطلبات</h4>
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
                    لا يوجد طلبات حتي الان
                </div>
                @else
                    <table class="table table-bordered table-striped table-hover text-center">
                        <thead class="bg-light">
                            <tr>
                                <th>رقم الحجز</th>
                                <th>الخدمة</th>
                                <th>مقدم الخدمة</th>
                                <th>الموظف</th>
                                <th>التاريخ</th>
                                <th>وقت البدا</th>
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
                                    <td>{{ $studioBooking->seller->first_name }} {{ $studioBooking->seller->last_name }}</td>
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
                                        @elseif($studioBooking->booking_status == 'done')
                                            <span class="badge bg-success">مكتمل</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($studioBooking->booking_status == 'rejected')
                                        <a href="{{ route('customer.bookStudioService.edit', $studioBooking->id) }}" class="btn btn-sm btn-outline-danger mx-2 border-2" style="font-weight: 600 !important;">السبب</a>
                                        @elseif($studioBooking->booking_status == 'done')
                                        <button type="button" class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#ratingModal">
                                            تقييم الخدمة
                                        </button>
                                        @else
                                        <a href="{{ route('customer.bookStudioService.edit', $studioBooking->id) }}" class="btn btn-sm btn-outline-success mx-2 border-2" style="font-weight: 600 !important;">تعديل</a>
                                        <button type="button" class="btn btn-sm btn-outline-primary" style ="font-weight: 600 !important;" data-toggle="modal" data-target="#exampleModalCenter">
                                            اضافة
                                        </button>
                                        @endif
                                    </td>

                                     <!-- Modal For Add Service For this currnt booking -->
                                     <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header p-0 text-center bg-success text-white">
                                                    <h5 class="modal-title text-center p-2 m-0 w-100" style="font-size: 20px; font-weight: 400;" id="exampleModalLongTitle">اضافة خدمة جديدة</h5>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('customer.bookStudioService.addServiceToExistingBooking') }}" enctype="multipart/form-data" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="studio_service_booking_id" value="{{ $studioBooking->id }}">
                                                        <input type="hidden" name="service_type" value="studio">

                                                        <!-- Seller Home Services -->
                                                        <div class="mb-3">
                                                            <label for="services" class="form-label">الخدمات المتاحة</label>
                                                            <select class="form-select" id="services" name="service_id" required>
                                                                <option value="">اختر خدمة</option>
                                                                @foreach ($studioServices as $studioService)
                                                                    <option value="{{ $studioService->id }}">{{ $studioService->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <!-- Select Employee -->
                                                        <div class="mb-3">
                                                            <label for="employee" class="form-label">الموظف</label>
                                                            <select class="form-select" id="employee" name="employee_id" required>
                                                                <!-- Employees will be loaded here dynamically -->
                                                            </select>
                                                        </div>

                                                        <!-- Submit Button -->
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline-danger" data-dismiss="modal">اغلاق</button>
                                                            <button type="submit" class="btn btn-outline-success">حفظ</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Modal -->

                                     <!-- Modal For Rating the Completed Booking -->
                                     <div class="modal fade" id="ratingModal" tabindex="-1" role="dialog" aria-labelledby="ratingModalTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header p-0 text-center bg-success text-white">
                                                    <h5 class="modal-title text-center p-2 m-0 w-100" style="font-size: 20px; font-weight: 400;" id="ratingModalTitle">تقييم الخدمة</h5>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('ratings.store') }}" method="POST">
                                                        @csrf
                                                        <!-- Set service_id and service_type based on the context -->
                                                        <input type="hidden" name="service_id" value="{{ $studioBooking->studio_service_id }}">
                                                        <input type="hidden" name="service_type" value="studio">
                                                        <input type="hidden" name="seller_id" value="{{ $studioBooking->seller_id }}">

                                                        <!-- Rating Selection -->
                                                        <div class="mb-3">
                                                            <label for="rating" class="form-label">اختر التقييم:</label>
                                                            <select class="form-select" id="rating" name="rating" required>
                                                                <option value="">اختر</option>
                                                                <option value="1">1 - سيئ جدا</option>
                                                                <option value="2">2 - سيئ</option>
                                                                <option value="3">3 - مقبول</option>
                                                                <option value="4">4 - جيد</option>
                                                                <option value="5">5 - ممتاز</option>
                                                            </select>
                                                        </div>

                                                        <!-- Review Text Area -->
                                                        <div class="mb-3">
                                                            <label for="review" class="form-label">مراجعة (اختياري):</label>
                                                            <textarea class="form-control" id="review" name="review" rows="3" placeholder="أضف تعليقك هنا..."></textarea>
                                                        </div>

                                                        <!-- Submit Button -->
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline-danger" data-dismiss="modal">اغلاق</button>
                                                            <button type="submit" class="btn btn-outline-success">ارسال التقييم</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Rating Modal -->

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>


<script>
    document.getElementById('services').addEventListener('change', function () {
        const serviceId = this.value;

        if (serviceId) {
            fetch(`/get-studio-employees/${serviceId}`)
                .then(response => response.json())
                .then(data => {
                    let employeeSelect = document.getElementById('employee');
                    employeeSelect.innerHTML = '';

                    data.forEach(employee => {
                        let option = document.createElement('option');
                        option.value = employee.id;
                        option.textContent = employee.name;
                        employeeSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching employees:', error));
        } else {
            // Clear employees if no service selected
            document.getElementById('employee').innerHTML = '';
        }
    });
</script>

@endsection
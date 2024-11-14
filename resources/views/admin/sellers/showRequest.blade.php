@extends('admin.mainComponents')

@section('title', 'عرض الطلب')


@section('link_one', 'الطلبات الجديدة')
@section('link_two', 'عرض')


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
                    <h3 class="my-0"> بيانات طلب انضمام بائع جديد رقم :  {{ $seller->id}}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Left side: Table for Unit Details -->
                        <div class="col-md-8">
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>اسم البائع</th>
                                    <td>{{ $seller->first_name }} {{ $seller->last_name }}</td>
                                </tr>

                                <tr>
                                    <th>البريد الالكتروني  </th>
                                    <td>{{ $seller->email }}</td>
                                </tr>

                                </tr>

                                <tr>
                                    <th>العنوان</th>
                                    <td>{{ $seller->location }}</td>
                                </tr>


                                <tr>
                                    <th>الهاتف</th>
                                    <td>{{ $seller->phone}}</td>
                                </tr>

                                <tr>
                                    <th>نوع الخدمة</th>
                                    <td>
                                        @if ($seller->service_type == 'at_headquarters')
                                            <span>في المقر الخاص بمقدم الخدمة</span>
                                        @else
                                            <span>خدمات منزلية</span>
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th>الحالة</th>
                                    <td>
                                        @if ($seller->status == 'active')
                                            <span class="badge bg-success">نشط</span>
                                        @else
                                            <span class="badge bg-danger">غير مصرح لهذا البائع بالدخول</span>
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th>حالة الطلب</th>
                                    <td>
                                        @if ($seller->request_status == 'pending')
                                            <span class="badge bg-dark">قيد الانتظار</span>
                                            @elseif ($seller->request_status == 'approved')
                                            <span class="badge bg-success">موافق</span>
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th>يوجد تصريح</th>
                                    <td>
                                        @if ($seller->license)
                                            <span class="badge bg-success">نعم</span>
                                        @else
                                            <span class="badge bg-danger">لا</span>
                                        @endif
                                    </td>
                                </tr>

                            </table>
                        </div>

                        <div class="col-md-4 text-center text-dark text-bold">
                            <img src="{{ asset($seller->seller_logo) }}" alt="Seller Logo" style="width: 100%; height: 300px;">
                            <h3 class="my-0">صورة رمزية</h3>
                        </div>
                            <!-- Show seller_banner -->
                            <div class="text-center text-dark text-bold">
                                <h1>البانر</h1>
                                @if ($seller->seller_banner)
                                    <img src="{{ asset($seller->seller_banner) }}" alt="Seller Banner" style="width: 100%; height: 300px;">
                                @else
                                    <span class="badge bg-danger">لا يوجد صورة بنر</span>
                                @endif
                            </div>
                            <div class="d-flex justify-content-start mt-3 gap-2">
                            
                                <a href="#" class="btn btn-outline-secondary mt-3">عودة إلى قائمة الطلبات</a>
                        
                        <form action="{{ route('admin.sellers.requests.approve', $seller->id) }}" method="POST" class="mt-3">
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
                <h1 class="modal-title fs-5 m-0" id="staticBackdropLabel">هل أنت متأكد من رفض هذا البائع ؟</h1>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <div class="alert alert-warning d-flex align-items-center" role="alert">
                    <i class="fas fa-exclamation-circle me-3" style="font-size: 24px;"></i>
                    <div class="mx-2">
                        <strong>تحذير:</strong> سيتم رفض هذا البائع ولن يتمكن من استخدام منصتك . يرجى كتابة سبب الرفض بعناية.
                    </div>
                </div>

                <!-- Rejection Form -->
                <form action="{{ route('admin.sellers.requests.reject', $seller->id) }}" method="POST">
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
                    </div>
                        </div>
                    </div>
                    <!-- Include FontAwesome CDN (for icons) -->
                    @endsection
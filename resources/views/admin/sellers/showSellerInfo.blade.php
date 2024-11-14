@extends('admin.mainComponents')

@section('title', 'عرض بيانات بائع')


@section('link_one', 'البائعين')
@section('link_two', ' التفاصيل')


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
                    <h3 class="my-0"> بيانات البائع رقم :  {{ $seller->id}}</h3>
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
                                            <span class="badge bg-success">مقبول</span>
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
                                <h3>البانر</h3>
                                @if ($seller->seller_banner)
                                    <img src="{{ asset($seller->seller_banner) }}" alt="Seller Banner" style="width: 100%; height: 300px;">
                                @else
                                    <span class="badge bg-danger">لا يوجد صورة بنر</span>
                                @endif
                            </div>
                            <div class="d-flex justify-content-start mt-3 gap-2">
                            
                                <a href="{{ route('admin.sellers.approved') }}" class="btn btn-outline-secondary btn-sm mt-3 border-2"  style="font-weight: 600 !important;">عودة</a>
                                <a href="{{ route('admin.sellers.edit' , $seller->id) }}" class="btn btn-outline-success btn-sm mt-3 border-2"  style="font-weight: 600 !important;">تعديل</a>
                      
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
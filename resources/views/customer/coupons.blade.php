@extends('customer.mainComponents')

@section('title', 'بطاقات الولاء')

@section('link_one', 'بطاقات الولاء')
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
                    <i class="fa-solid fa-ticket" style="font-size: 25px;"></i>
                    <h4 class="my-0 flex-grow-1" style="font-size: 20px; font-weight: 400;">كل الكوبونات</h4>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover text-center">
                    <thead class="bg-light">
                        <tr>
                            <th>الصورة الرمزية</th>
                            <th>مقدم الخدمة</th>
                            <th>رمز الكوبون</th>
                            <th>قيمة الخصم</th>
                            <th>تاريخ الانتهاء</th>
                            <th>حد الاستخدام</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($coupons as $coupon)
                        <tr>
                            <td><img src="{{ asset($coupon->seller->seller_logo) }}" alt="Coupon Image" style="max-width: 70px; max-height: 70px;"></td>
                            <td>{{ $coupon->seller->first_name . ' ' . $coupon->seller->last_name }}</td>
                            <td>{{ $coupon->code }}</td>
                            <td>{{ $coupon->discount_value }} %</td>
                            <td>{{ $coupon->expires_at ? \Carbon\Carbon::parse($coupon->expires_at)->format('Y-m-d') : 'غير محدد' }}</td>
                            <td>{{ $coupon->usage_limit ?? 'غير محدود' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

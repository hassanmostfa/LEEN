@extends('seller.mainComponents')

@section('title', 'إدارة الكوبونات')

@section('link_one', 'الكوبونات')
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
                <div>
                    <button type="button" class="btn btn-sm text-white" style="font-size: 15px; font-weight: 600; border-radius: 5px; border: 2px solid white;" data-toggle="modal" data-target="#addCouponModal">
                        <i class="fa-solid fa-plus mx-2"></i>
                        إضافة كوبون
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover text-center">
                    <thead class="bg-light">
                        <tr>
                            <th>رمز الكوبون</th>
                            <th>قيمة الخصم</th>
                            <th>تاريخ الانتهاء</th>
                            <th>حد الاستخدام</th>
                            <th>عدد الاستخدامات</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($coupons as $coupon)
                        <tr>
                            <td>{{ $coupon->code }}</td>
                            <td>{{ $coupon->discount_value }} %</td>
                            <td>{{ $coupon->expires_at ? \Carbon\Carbon::parse($coupon->expires_at)->format('Y-m-d') : 'غير محدد' }}</td>
                            <td>{{ $coupon->usage_limit ?? 'غير محدود' }}</td>
                            <td>{{ $coupon->usage_count }}</td>
                            <td>
                                <a href="{{ route('seller.coupons.edit', $coupon->id) }}" class="btn btn-sm btn-outline-success mx-2 border-2" style="font-weight: 600 !important;">تعديل</a>
                                <form action="{{ route('seller.coupons.destroy', $coupon->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger border-2" style="font-weight: 600 !important;">حذف</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Adding Coupon -->
<div class="modal fade" id="addCouponModal" tabindex="-1" role="dialog" aria-labelledby="addCouponModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header p-0 text-center bg-success text-white">
                <h5 class="modal-title text-center p-2 m-0 w-100" style="font-size: 20px; font-weight: 400;" id="addCouponModalLabel">إضافة كوبون جديد</h5>
            </div>
            <div class="modal-body">
                <form action="{{ route('seller.coupons.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="code" style="font-weight: 600; font-size: 18px" class="form-label">رمز الكوبون</label>
                        <input type="text" class="form-control" id="code" name="code" placeholder="ادخل رمز الكوبون" required>
                    </div>

                    <div class="mb-3">
                        <label for="discount_value" style="font-weight: 600; font-size: 18px" class="form-label">قيمة الخصم %</label>
                        <input type="number" class="form-control" id="discount_value" name="discount_value" placeholder="ادخل قيمة الخصم" step="0.01" required>
                    </div>

                    <div class="mb-3">
                        <label for="expires_at" style="font-weight: 600; font-size: 18px" class="form-label">تاريخ انتهاء الصلاحية</label>
                        <input type="date" class="form-control" id="expires_at" name="expires_at">
                    </div>

                    <div class="mb-3">
                        <label for="usage_limit" style="font-weight: 600; font-size: 18px" class="form-label">حد الاستخدام</label>
                        <input type="number" class="form-control" id="usage_limit" name="usage_limit" placeholder="ادخل حد الاستخدام">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">إغلاق</button>
                        <button type="submit" class="btn btn-outline-success">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

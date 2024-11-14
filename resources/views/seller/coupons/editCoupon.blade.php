@extends('seller.mainComponents')

@section('title', 'تعديل الكوبون')

@section('link_one', 'الكوبونات')
@section('link_two', 'تعديل')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header py-3 bg-success text-white">
                    <h4 class="my-0" style="font-size: 20px; font-weight: 400;">تعديل الكوبون</h4>
                </div>
                <div class="card-body">
                    <!-- Display success or error messages -->
                    @if (Session::has('success'))
                        <div class="alert alert-success">{{ Session::get('success') }}</div>
                    @elseif (Session::has('error'))
                        <div class="alert alert-danger">{{ Session::get('error') }}</div>
                    @endif

                    <form action="{{ route('seller.coupons.update', $coupon->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Coupon Code -->
                        <div class="mb-3">
                            <label for="code" class="form-label" style="font-weight: 600;">رمز الكوبون</label>
                            <input type="text" name="code" id="code" class="form-control" value="{{ $coupon->code }}" required maxlength="10">
                        </div>


                        <!-- Discount Value -->
                        <div class="mb-3">
                            <label for="discount_value" class="form-label" style="font-weight: 600;">قيمة الخصم %</label>
                            <input type="number" name="discount_value" id="discount_value" class="form-control" value="{{ $coupon->discount_value }}" required min="1">
                        </div>

                        <!-- Expiration Date -->
                        <div class="mb-3">
                            <label for="expires_at" class="form-label" style="font-weight: 600;">تاريخ الانتهاء</label>
                            <input type="date" name="expires_at" id="expires_at" class="form-control" value="{{ $coupon->expires_at ? \Carbon\Carbon::parse($coupon->expires_at)->format('Y-m-d') : '' }}">
                        </div>

                        <!-- Usage Limit -->
                        <div class="mb-3">
                            <label for="usage_limit" class="form-label" style="font-weight: 600;">حد الاستخدام</label>
                            <input type="number" name="usage_limit" id="usage_limit" class="form-control" value="{{ $coupon->usage_limit }}" min="1">
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-success w-100">تحديث الكوبون</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

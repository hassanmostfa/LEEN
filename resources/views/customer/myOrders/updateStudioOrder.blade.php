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
<div class="container mt-4">
    <!-- Card Title -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h3 class="my-0">بيانات الحجز رقم: {{ $studioBooking->id }}</h3>
                </div>
                <div class="card-body">
                        <!-- Request Rejection Reason Alert -->
                        @if ($studioBooking->request_rejection_reason != null)
                        <div class="alert alert-danger" style="font-size: 18px;" role="alert">
                            تم الرفض بسبب ان : {{ $studioBooking->request_rejection_reason }}   
                        </div>
                    @endif

                    <form action="{{ route('customer.bookStudioService.update', $studioBooking->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Seller Details Card Row 1: Two input fields side by side -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="date" class="form-label">التاريخ</label>
                                <input type="date" class="form-control" name="date" value="{{ $studioBooking->date }}" required>
                            </div>
                        </div>

                        <!-- Seller Details Card Row 2: Two input fields side by side -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="start_time" class="form-label">وقت البدا</label>
                                <input type="time" class="form-control" name="start_time" value="{{ $studioBooking->start_time }}" required>
                            </div>
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="row">
                            <div class="col-md-12 text-center mt-3">
                                <a href="{{ route('customer.studioBookings') }}" class="btn btn-outline-secondary">رجوع</a>
                                <button type="submit" class="btn btn-outline-success mx-2">{{ $studioBooking->booking_status == 'rejected' ? 'اعادة الطلب' : 'حفظ التعديلات' }}</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
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
                    <h3 class="my-0">بيانات الحجز رقم: {{ $homeBooking->id }}</h3>
                </div>
                <div class="card-body">

                    <!-- Request Rejection Reason Alert -->
                    @if ($homeBooking->request_rejection_reason != null)
                        <div class="alert alert-danger" style="font-size: 18px;" role="alert">
                            تم الرفض بسبب ان : {{ $homeBooking->request_rejection_reason }}   
                        </div>
                    @endif

                    <form action="{{ route('customer.bookHomeService.update', $homeBooking->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        
                        <!-- Seller Details Card Row 2: Two input fields side by side -->
                        <div class="row col-md-12">

                                <div class="col-md-6">
                                    <label for="date" class="form-label">التاريخ</label>
                                    <input type="date" class="form-control" name="date" value="{{ $homeBooking->date }}" required>
                                </div>
    
                                <div class="col-md-6">
                                    <label for="start_time" class="form-label">وقت البدا</label>
                                    <input type="time" class="form-control" name="start_time" value="{{ $homeBooking->start_time }}" required>
                                </div>
                        </div>

                        
                        

                        <!-- Image Row: Two images side by side with "Change" buttons -->
                        <div class="container">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="address" class="form-label w-100 text-right" style="font-weight: 600; font-size: 18px">
                                        اختر موقعك من الخريطة او ابحث عنه
                                    </label>
                                    <div class="input-group">
                                        <input type="text" value="{{ $homeBooking->location }}" class="form-control" id="address" name="location" placeholder="مثال : الرياض" required>
                                        <button class="btn btn-primary" id="find-location">بحث</button>
                                        <button class="btn btn-secondary" id="get-current-location">موقعي الحالي</button>
                                    </div>
                                </div>
                            </div>
                            <div id="map" style="height: 400px; width: 100%;"></div>
                        </div>

                        <!-- Submit Button -->
                        <div class="row">
                            <div class="col-md-12 text-center mt-3">
                                <a href="{{ route('customer.homeBookings') }}" class="btn btn-outline-secondary">رجوع</a>
                                <button type="submit" class="btn btn-outline-success mx-2">{{ $homeBooking->booking_status == 'rejected' ? 'اعادة الطلب' : 'حفظ التعديلات' }}</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
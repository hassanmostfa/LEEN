@extends('customer.mainComponents')

@section('title', 'البيانات الشخصية')

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
                    <h3 class="my-0">بيانات الحساب</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('customer.profile.update', $customer->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <!-- Inputs Section: 8 Columns -->
                            <div class="col-md-8">
                                <!-- Row 1: First and Last Name -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="first_name" class="form-label">الاسم الأول</label>
                                        <input type="text" class="form-control" name="first_name" value="{{ $customer->first_name }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="last_name" class="form-label">الاسم الأخير</label>
                                        <input type="text" class="form-control" name="last_name" value="{{ $customer->last_name }}" required>
                                    </div>
                                </div>

                                <!-- Row 2: Email and Phone -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">البريد الإلكتروني</label>
                                        <input type="email" class="form-control" name="email" value="{{ $customer->email }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">الهاتف</label>
                                        <input type="text" class="form-control" name="phone" value="{{ $customer->phone }}" required>
                                    </div>
                                </div>

                                <!-- Row 3: Location -->
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="location" class="form-label">العنوان</label>
                                        <input type="text" class="form-control" name="location" value="{{ $customer->location }}" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Image Section: 4 Columns -->
                            <div class="col-md-4 text-center">
                                <!-- Image Preview -->
                                <img id="image-preview" src="{{ asset($customer->image ? $customer->image : 'https://th.bing.com/th/id/OIP.iPvPGJG166ivZnAII4ZS8gHaHa?rs=1&pid=ImgDetMain') }}" alt="Customer Image" class="img-fluid mb-2 rounded" style="width: 100%; height: 250px; object-fit: contain;">
                                <h4>الصورة الشخصية</h4>
                                
                                <!-- Hidden file input for image upload -->
                                <input type="file" name="image" class="form-control mt-2" id="customer_image" style="display: none;" onchange="previewLogo(event)">
                                
                                <!-- Button to trigger file input -->
                                <button type="button" class="btn btn-outline-primary mt-2" onclick="document.getElementById('customer_image').click()">تغيير الصورة</button>
                            </div>
                        </div>

                        <!-- Submit Button Row -->
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-outline-success mx-2">حفظ التعديلات</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
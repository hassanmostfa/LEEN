@extends('admin.mainComponents')

@section('title', 'تعديل بيانات بائع')


@section('link_one', 'البائعين')
@section('link_two', ' تعديل')


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
                    <h3 class="my-0">بيانات البائع رقم: {{ $seller->id }}</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.sellers.update', $seller->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Seller Details Card Row 1: Two input fields side by side -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="first_name" class="form-label">الاسم الأول</label>
                                <input type="text" class="form-control" name="first_name" value="{{ $seller->first_name }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="last_name" class="form-label">الاسم الأخير</label>
                                <input type="text" class="form-control" name="last_name" value="{{ $seller->last_name }}" required>
                            </div>
                        </div>

                        <!-- Seller Details Card Row 2: Two input fields side by side -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label">البريد الإلكتروني</label>
                                <input type="email" class="form-control" name="email" value="{{ $seller->email }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">الهاتف</label>
                                <input type="text" class="form-control" name="phone" value="{{ $seller->phone }}" required>
                            </div>
                        </div>

                        <div class="col-md-12">
                                <div class="form-group">
                                    <label for="service_type" class="form-label" style="text-align: right; display: block;">نوع الخدمة : اختر نوع الخدمة التي تقدمها</label>
                                    <div class="btn-group d-flex gap-3" role="group" aria-label="Service Type">
                                        
                                        <input type="radio" class="btn-check" name="service_type" id="in_house" value="in_house" 
                                            {{ $seller->service_type == 'in_house' ? 'checked' : '' }}>
                                        <label class="btn btn-outline-success flex-fill" for="in_house">في المنزل</label>

                                        <input type="radio" class="btn-check" name="service_type" id="at_headquarters" value="at_headquarters" 
                                            {{ $seller->service_type == 'at_headquarters' ? 'checked' : '' }}>
                                        <label class="btn btn-outline-success flex-fill" for="at_headquarters">في المقر الخاص بك</label>
                                    </div>
                                </div>
                            </div>

                        <!-- Seller Details Card Row 3: Two input fields side by side -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                            <label for="status" class="form-label">الحالة</label>
                            <div class="form-check form-switch form-control">
                                <input class="form-check-input" style="margin-left: -20px;" type="checkbox" id="status" name="status" 
                                    @if ($seller->status == 'active') checked @endif 
                                    onchange="document.getElementById('status_hidden').value = this.checked ? 'active' : 'inactive';">
                                <label class="form-check-label" for="status">
                                    @if ($seller->status == 'active') مفعل @else غير مفعل @endif
                                </label>
                            </div>
                            <!-- Hidden input to store the status value -->
                            <input type="hidden" id="status_hidden" name="status" value="{{ $seller->status }}">
                        </div>



                            <div class="col-md-6">
                                <label for="location" class="form-label">العنوان</label>
                                <input type="text" class="form-control" name="location" value="{{ $seller->location }}" required>
                            </div>
                        </div>

                        <!-- Image Row: Two images side by side with "Change" buttons -->
                        <div class="row mb-3">
                            <div class="col-md-6 text-center">
                                <h4>الشعار</h4>
                                <!-- Show existing seller logo -->
                                <img src="{{ asset($seller->seller_logo) }}" alt="Seller Logo" class="img-fluid mb-2" style="width: 100%; height: 250px; object-fit: contain;" id="logo-preview">
                                
                                <!-- Hidden file input -->
                                <input type="file" name="seller_logo" class="form-control mt-2" id="logo-input" style="display: none;" onchange="previewLogo(event)">
                                
                                <!-- Button to trigger file input -->
                                <button type="button" class="btn btn-outline-primary" onclick="document.getElementById('logo-input').click()">تغيير الشعار</button>
                            </div>

                            <div class="col-md-6 text-center">
                                <h4>البانر</h4>
                                @if ($seller->seller_banner)
                                    <!-- Show existing seller banner -->
                                    <img src="{{ asset($seller->seller_banner) }}" alt="Seller Banner" class="img-fluid mb-2" style="width: 100%; height: 250px; object-fit: cover;" id="banner-preview">
                                @else
                                    <span class="badge bg-danger">لا يوجد بانر</span>
                                @endif

                                <!-- Hidden file input -->
                                <input type="file" name="seller_banner" class="form-control mt-2" id="banner-input" style="display: none;" onchange="previewBanner(event)">
                                
                                <!-- Button to trigger file input -->
                                <button type="button" class="btn btn-outline-primary" onclick="document.getElementById('banner-input').click()">تغيير البانر</button>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <a href="{{ route('admin.sellers.approved') }}" class="btn btn-outline-secondary">رجوع</a>
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
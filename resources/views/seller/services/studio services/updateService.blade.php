@extends('seller.mainComponents')

@section('title', 'عرض بيانات خدمة منزلية')


@section('link_one', 'خدماتي')
@section('link_two', 'عرض الخدمة')


@section('content')
@if (Session::has('success'))
    <div class="alert alert-success">{{ Session::get('success') }}</div>
@elseif (Session::has('error'))
    <div class="alert alert-danger">{{ Session::get('error') }}</div>
@endif

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header py-2 bg-success text-white">
                <h4 class="my-0 text-center">تعديل الخدمة المنزلية</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('seller.studioServices.update', $studioService->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <!-- Row 1 -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">اسم الخدمة</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $studioService->name }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">هذه الخدمة خاصة ب</label>
                            <select class="form-select" name="gender" required>
                                <option value="men" {{ $studioService->gender == 'men' ? 'selected' : '' }}>الرجال</option>
                                <option value="women" {{ $studioService->gender == 'women' ? 'selected' : '' }}>النساء</option>
                            </select>
                        </div>
                    </div>

                    <!-- Row 2 -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="category_id" class="form-label">التصنيف الاساسي</label>
                            <select class="form-select" id="category_id" name="category_id" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ $studioService->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                      
                        <div class="col-md-6 mb-3">
                        <label for="subcategory" class="form-label">التصنيف الفرعي</label>
                        <select class="form-select" id="subcategory" name="sub_category_id" required>
                            <!-- Display the current subcategory -->
                            <option value="{{ $studioService->sub_category_id }}" selected>اختر التصنيف الفرعي</option>
                        </select>
                    </div>
                
                    </div>

                    <!-- Row 3 -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="discount" class="form-label">هل يوجد خصم ؟</label>
                            <select class="form-select" id="discount" name="discount" required>
                                <option selected  value="{{ $studioService->discount }}">{{ $studioService->discount == 1 ? 'نعم' : 'لا' }}</option>
                                <option value="1">نعم</option>
                                <option value="0">لا</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="percentage" class="form-label">نسبة الخصم</label>
                            <input type="number" class="form-control" id="percentage" name="percentage" value="{{ $studioService->percentage }}">
                        </div>
                    </div>

                        <!-- Points -->
                        <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="points" class="form-label" style="font-weight: 600; font-size: 18px">نقاط الولاء ؟</label>
                            <input type="number" class="form-control" id="points" name="points" value="{{ $studioService->points }}">
                        </div>
                    </div>


                    <!-- Row 4 -->
                    <div class="row">
                        <div class="col-md-12">
                            <label for="service_details" style="font-weight: 600; font-size: 18px" class="form-label">تفاصيل الخدمة</label>
                            <div id="array-items-container">
                                @foreach (json_decode($studioService->service_details) as $detail)
                                    <div class="array-item d-flex align-items-center my-2">
                                        <input type="text" class="form-control" name="service_details[]" value="{{ $detail }}" placeholder="أدخل عنصر" required>
                                        <button type="button" class="btn btn-danger btn-sm ms-2 remove-item">ازالة</button>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" id="add-item" class="btn btn-primary mt-2">أضف عنصر</button>
                        </div>
                    </div>



                    <!-- Row 4 -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label">السعر</label>
                            <input type="number" class="form-control" id="price" name="price" value="{{ $studioService->price }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="booking_status" class="form-label">نوع الحجز</label>
                            <select class="form-select" id="booking_status" name="booking_status" required>
                                <option value="immediate" {{ $studioService->booking_status == 'immediate' ? 'selected' : '' }}>فوري</option>
                                <option value="previous_date" {{ $studioService->booking_status == 'previous_date' ? 'selected' : '' }}>بموعد مسبق</option>
                            </select>
                        </div>
                    </div>

                    <!-- Row 5 -->
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">الموظفين</label>
                                <div id="employees-container">
                                    @foreach ($employees as $employee)
                                        <div class="form-check">
                                            <input 
                                                type="checkbox" 
                                                value="{{ $employee->id }}" 
                                                class="form-check-input" 
                                                id="employee_{{ $employee->id }}" 
                                                name="employees[]" 
                                                {{ in_array($employee->id, json_decode($studioService->employees, true)) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="employee_{{ $employee->id }}">{{ $employee->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-flex justify-content-center mt-4">
                        <button type="submit" class="btn btn-outline-success">تحديث الخدمة</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // When a new category is selected, load the related subcategories
    document.getElementById('category_id').addEventListener('change', function() {
        const categoryId = this.value;
        loadSubcategories(categoryId);
    });

    // Automatically load subcategories for the pre-selected category (if available) when the page loads
    window.addEventListener('load', function() {
        const preSelectedCategoryId = document.getElementById('category_id').value;
        if (preSelectedCategoryId) {
            loadSubcategories(preSelectedCategoryId);
        }
    });

    // get Related Sub category
    function loadSubcategories(categoryId) {
        const subcategorySelect = document.getElementById('subcategory');
        if (!categoryId) {
            console.log('No category selected');
            return; // Exit if no category is selected
        }
    }
</script>

@endsection
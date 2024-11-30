@extends('seller.mainComponents')

@section('title', 'اضافة خدمة جديدة')


@section('link_one', 'خدماتي')
@section('link_two', 'اضافة')

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
                <div class="d-flex align-items-center justify-content-center gap-3">
                    <i class="fa-solid fa-shop" style="font-size: 25px;"></i>
                    <h4 class="my-0" style="font-size: 20px; font-weight: 400;">اضافة خدمة جديدة بالمقر الخاص بي</h4>
                </div>
            </div>
            <div class="card-body">
                <form id="multiStepForm" action="{{ route('seller.studioServices.store') }}" method="POST">
                    @csrf
                    <div class="steps-content">
                        <!-- Step 1 -->
                        <div class="step step-1">
                            <div class="d-flex align-items-center justify-content-center gap-3">
                                <i class="fa-solid fa-angle-double-left"></i>
                                <h3 class="mt-0">الخطوة الاولي</h3>
                                <i class="fa-solid fa-angle-double-right"></i>
                            </div>
                            <!-- Form fields for Step 1 -->
                            <div class="mb-3">
                                <label for="name" style="font-weight: 600; font-size: 18px" class="form-label">اسم الخدمة</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="مثال: كي الشعر باحدث الادوات " required>
                            </div>

                            <div class="mb-3">
                                <label for="name" style="font-weight: 600; font-size: 18px" class="form-label">هذه الخدمة خاصة ب :</label>
                                <div class="row justify-content-center m-3">
                                    <div class="col-md-4">
                                        <div class="card text-center option-card" id="option-men" onclick="selectOption('men')">
                                            <div class="p-3">
                                                <i class="fa-solid fa-person" style="font-size: 40px;"></i>
                                                <h3 class="mt-3">الرجال</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card text-center option-card" id="option-women" onclick="selectOption('women')">
                                            <div class="p-3">
                                                <i class="fa-solid fa-person-dress" style="font-size: 40px;"></i>
                                                <h3 class="mt-3">النساء</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Hidden input to store the selected gender -->
                                <input type="hidden" id="selectedGender" name="gender">
                            </div>
                        </div>


                        <!-- Step 2 -->
                        <div class="step step-2 d-none">
                            <div class="d-flex align-items-center justify-content-center gap-3">
                                <i class="fa-solid fa-angle-double-left"></i>
                                <h3 class="mt-0">الخطوة الثانية</h3>
                                <i class="fa-solid fa-angle-double-right"></i>
                            </div>  
                            <!-- Form fields for Step 2 -->
                            
                            <div class="row mb-3">
                                <!-- Show All Categories -->
                                <div class="col-md-6">
                                    <label for="category_id" style="font-weight: 600; font-size: 18px" class="form-label">التصنيف الاساسي</label>
                                    <select class="form-select" id="category_id" name="category_id" required onchange="loadSubcategories(this.value)">
                                        <option selected disabled>اختر التصنيف الاساسي</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="subcategory" style="font-weight: 600; font-size: 18px" class="form-label">3 - التصنيف الفرعي</label>
                                    <select id="subcategory" name="sub_category_id" class="form-control" required>
                                        <option value="" disabled selected>اختر التصنيف الفرعي</option>
                                        <!-- <option>Subcategories will be loaded dynamically based on the selected category.</option> -->
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="has_points" style="font-weight: 600; font-size: 18px" class="form-label">هل يوجد نقاط ولاء ؟</label>
                                    <select id="has_points" class="form-select" onchange="togglePointsInput()">
                                        <option value="no">لا</option>
                                        <option value="yes">نعم</option>
                                    </select>
                                </div>

                                <!-- Points Input Field -->
                                <div class="col-md-6" id="points_input" style="display: none;">
                                    <label for="points" style="font-weight: 600; font-size: 18px" class="form-label"> عدد النقاط:</label>
                                    <input type="number" name="points" id="points" class="form-control" min="0">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label for="service_details" style="font-weight: 600; font-size: 18px" class="form-label">تفاصيل الخدمة</label>
                                <div id="array-items-container">
                                    <div class="array-item">
                                        <input type="text" class="form-control" name="service_details[]" placeholder="أدخل عنصر" required>
                                    </div>
                                </div>
                                <button type="button" id="add-item" class="btn btn-primary mt-2">أضف عنصر</button>
                            </div>


                        </div>

                        <!-- Step 3 -->
                        <div class="step step-3 d-none">
                            <div class="d-flex align-items-center justify-content-center gap-3">
                                <i class="fa-solid fa-angle-double-left"></i>
                                <h3 class="mt-0">الخطوة الثالثة</h3>
                                <i class="fa-solid fa-angle-double-right"></i>
                            </div>
                            <!-- Form fields for Step 3 -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="price" style="font-weight: 600; font-size: 18px" class="form-label">السعر</label>
                                    <input type="number" class="form-control" id="price" name="price" placeholder="ادخل السعر" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="booking_status" style="font-weight: 600; font-size: 18px" class="form-label">نوع الحجز</label>
                                    <select class="form-select" id="booking_status" name="booking_status" required>
                                        <option selected disabled>اختر نوع الحجز</option>
                                        <option value="immediate">فوري</option>
                                        <option value="previous_date">بموعد مسبق</option>
                                    </select>
                                </div>
                            </div>

                             <!-- Discount -->
                             <div class="row">
                                <div class="col-md-6">
                                    <label for="discount" style="font-weight: 600; font-size: 18px" class="form-label">هل يوجد خصم ؟ </label>
                                    <select class="form-select" id="discount" name="discount" required>
                                        <option selected disabled>اختر خيار</option>
                                        <option value="1">نعم</option>
                                        <option value="0">لا</option>
                                    </select>
                                </div>
                                <div class="col-md-6" id="percentageContainer" style="display: none;">
                                    <label for="percentage" style="font-weight: 600; font-size: 18px" class="form-label">نسبة الخصم (%) ان وجد</label>
                                    <input type="number" class="form-control" id="percentage" name="percentage" placeholder="ادخل نسبة الخصم">
                                </div>
                            </div>

                            <div class="col-md-12 my-3">
                                <label for="employees" style="font-weight: 600; font-size: 18px" class="form-label">الموظفين(يمكنك اختيار اكثر من موظف)</label>
                                <div id="employees-container">
                                    @foreach ($employees as $employee)
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="employee_{{ $employee->id }}" name="employees[]" value="{{ $employee->id }}">
                                            <label class="form-check-label" for="employee_{{ $employee->id }}"><ul>
                                                <li>{{ $employee->name }}</li>
                                            </ul></label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            
                        </div>
                    <!-- Navigation buttons -->
                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-outline-secondary" id="prevStep" disabled>السابق</button>
                        <button type="button" class="btn btn-outline-success" id="nextStep">التالي</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    document.getElementById('discount').addEventListener('change', function() {
        var percentageContainer = document.getElementById('percentageContainer');
        if (this.value === '1') {
            percentageContainer.style.display = 'block'; // Show percentage input
        } else {
            percentageContainer.style.display = 'none'; // Hide percentage input
            document.getElementById('percentage').value = ''; // Clear the input when hidden
        }
    });
</script>


<script>
function togglePointsInput() {
    var select = document.getElementById("has_points");
    var pointsInput = document.getElementById("points_input");
    pointsInput.style.display = select.value === "yes" ? "block" : "none";
}
</script>
@endsection


<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

<title>تسجيل حساب بائع جديد</title>
<meta name="author" content="Sayed Khattab">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Fav Icon -->
<link rel="icon" href="user-assets/images/favicon.png" type="image/png">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Barlow:wght@300;400;600;700;800&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.css') }}" />


<!-- Stylesheets -->
<link href="{{ asset('user-assets/css/font-awesome-all.css') }}" rel="stylesheet">
<link href="{{ asset('user-assets/css/flaticon.css') }}" rel="stylesheet">
<link href="{{ asset('user-assets/css/owl.css') }}" rel="stylesheet">
<link href="{{ asset('user-assets/css/bootstrap.css') }}" rel="stylesheet">
<link href="{{ asset('user-assets/css/jquery.fancybox.min.css') }}" rel="stylesheet">
<link href="{{ asset('user-assets/css/animate.css') }}" rel="stylesheet">
<link href="{{ asset('user-assets/css/nice-select.css') }}" rel="stylesheet">
<link href="{{ asset('user-assets/css/color.css') }}" rel="stylesheet">
<link href="{{ asset('user-assets/css/style.css') }}" rel="stylesheet">
<link href="{{ asset('user-assets/css/responsive.css') }}" rel="stylesheet">


<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&display=swap" rel="stylesheet">

<!-- My CSS Files -->
<link rel="stylesheet" href="{{ asset('Styling/categories.css') }}">

<!-- Include Google Maps JS API -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAL0mf-wYCEO4N6xNkiJaau55bfRxdB4yk&libraries=places"></script>


</head>
<!-- page wrapper -->
<body>
    <div class="boxed_wrapper">
        <!-- preloader -->
        <div class="preloader"></div>
        <!-- preloader -->

       

       <!-- Mobile Menu  -->
        <div class="mobile-menu">
            <div class="menu-backdrop"></div>
            <div class="close-btn"><i class="fas fa-times"></i></div>
            
            <nav class="menu-box">
                <div class="menu-outer"></div>
                
                <div class="btn-box" style="margin-top: 40px;">
                    <a href="#" class="theme-btn-one"><span class="btn-shape"></span>انضم الينا</a>
                </div>
            </nav>
        </div>
        <!-- End Mobile Menu -->

        <!-- Registration Form -->
        <div class="container">
            <div class="row justify-content-center" style="margin-top: 100px; margin-bottom: 50px;">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header text-center bg-primary text-white" style="color: #2f3e3b;">تسجيل بائع جديد</div>
                        <div class="card-body py-2">
                            <form method="POST" id="phone-form" dir="rtl">
                                @csrf
                                <div class="form-group">
                                    <label for="phone_input" style="text-align: right; display: block;">رقم الهاتف</label>
                                    <div class="input-group" style="direction: ltr;">
                                        <span class="input-group-text">966</span>
                                        <input type="text" class="form-control" id="phone_input" name="phone" placeholder="5XXXXXXXX" required oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 9);">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-3 w-100">إرسال كود التحقق</button>
                            </form>

                            <div id="otp-section" style="display:none;" dir="ltr">
                                <form method="POST" id="otp-form">
                                    @csrf
                                    <input type="text" class="form-control mt-3" name="otp" placeholder="أدخل كود التحقق" required>
                                    <div class="row">
                                        <button type="submit" class="btn btn-primary mt-3 w-100">تحقق من OTP</button>
                                </form>

                                    <!-- Resend OTP -->
                                    <!-- <form method="POST" id="resend-otp-form">
                                        @csrf
                                        <button type="submit" class="btn btn-primary mt-3 w-100" id="resend-otp-btn">اعادة ارسال كود التحقق</button>
                                    </form> -->
                                </div>
                            </div>
                            <div id="owner-section" class="container" style="display:none;"  dir="rtl">
                                <form enctype="multipart/form-data" action="{{ route('seller.register') }}" method="POST" id="owner-form">
                                    @csrf
                                    <!-- Step 1: Personal Information -->
                                    <div class="step" id="step-1">
                                        <h5 class="text-center mb-4">الخطوة الاولي</h5>
                                        <div class="form-group row text-right">
                                            <!-- First Name -->
                                            <div class="col-md-6">
                                                <label for="first_name" class="form-label">الاسم الأول</label>
                                                <input type="text" name="first_name" id="first_name" class="form-control" placeholder="الاسم الأول" required>
                                                @error('first_name')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            
                                            <!-- Last Name -->
                                            <div class="col-md-6">
                                                <label for="last_name" class="form-label">اسم العائلة</label>
                                                <input type="text" name="last_name" id="last_name" class="form-control" placeholder="الاسم الأخير" required>
                                                @error('last_name')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Email -->
                                        <div class="form-group">
                                            <label for="email" style="text-align: right; display: block;">البريد الالكتروني</label>
                                            <input type="email" name="email" id="email" class="form-control text-left" placeholder="name@company.com" required>
                                            @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <!-- Password -->
                                        <div class="form-group">
                                            <label for="password" style="text-align: right; display: block;">كلمة المرور</label>
                                            <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
                                            @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="password_confirmation" style="text-align: right; display: block;">تأكيد كلمة المرور</label>
                                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="••••••••" required>
                                            @error('password_confirmation')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <button type="button" class="btn btn-primary mb-3" onclick="nextStep()">التالي</button>
                                    </div>

                                    <!-- Step 2: Contact Information -->
                                    <div class="step" id="step-2" style="display:none;">
                                        <h5 class="text-center mb-4">الخطوة الثانية</h5>

                                        <!-- Logo Image -->
                                        <div class="mb-3">
                                            <label for="seller_logo" style="font-weight: 600; font-size: 18px" class="form-label w-100 text-right">الصورة الرمزية</label>
                                            <div id="drop-area-logo" class="drop-area">
                                                <i class="fas fa-cloud-upload-alt"></i>
                                                <p>قم بسحب وإفلات صورتك هنا أو <span id="browse-button-logo" class="browse-text">تصفح</span></p>
                                                <input type="file" id="seller_logo" name="seller_logo" class="form-control" accept="image/*" style="display: none;">
                                                <div id="preview-logo" class="logo-image-preview d-flex justify-content-center align-items-center"></div>
                                            </div>
                                        </div>

                                        <!-- Banner Image -->
                                        <div class="mb-3">
                                            <label for="seller_banner" style="font-weight: 600; font-size: 18px" class="form-label w-100 text-right">البانر الرئيسي</label>
                                            <div id="drop-area-banner" class="drop-area">
                                                <i class="fas fa-cloud-upload-alt"></i>
                                                <p>قم بسحب وإفلات صورتك هنا أو <span id="browse-button-banner" class="browse-text">تصفح</span></p>
                                                <input type="file" id="seller_banner" name="seller_banner" class="form-control" accept="image/*" style="display: none;">
                                                <div id="preview-banner" class="banner-image-preview d-flex justify-content-center align-items-center"></div>
                                            </div>
                                        </div>


                                         <!-- License -->
                                        <div class="mb-3 form-group">
                                            <label for="license" style="font-weight: 600; font-size: 18px" class="form-label w-100 text-right">السجل التجاري (الوثيقة)</label>
                                            <input type="file" name="license" id="license" class="form-control">
                                            @error('license')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                    </div>


                                        <div class="d-flex gap-2 align-items-center mb-3 justify-content-end">
                                            <button type="button" class="btn btn-info" onclick="prevStep()">السابق</button>
                                            <button type="button" class="btn btn-primary" onclick="nextStep()">التالي</button>
                                        </div>
                                    </div>

                                    <!-- Step 3: Password Setup -->
                                    <div class="step" id="step-3" style="display: none;">
                                        <h5 class="text-center mb-4">الخطوة الثالثة</h5>

                                        <!-- Service Type -->
                                        <div class="form-group">
                                            <label for="service_type" class="form-label" style="text-align: right; display: block;"> اين تقدم خدمتك ؟ <small>(من فضلك اختر نوع الخدمة التي تقدمها)</small></label>
                                            
                                            <div class="btn-group d-flex gap-3" role="group" aria-label="Service Type">
                                                <input type="radio" class="btn-check" name="service_type" id="in_house" value="in_house">
                                                <label class="btn btn-outline-success flex-fill" for="in_house">خدمات منزلية</label>

                                                <input type="radio" class="btn-check" name="service_type" id="at_headquarters" value="at_headquarters">
                                                <label class="btn btn-outline-success flex-fill" for="at_headquarters">في المقر الخاص بي</label>
                                            </div>
                                        </div>


                                        <div class=" mb-3 mt-0 bg-white">
                                            <div class="container">
                                                <div class="row mb-3">
                                                    <div class="col-md-12">
                                                        <label for="address" style="font-weight: 600; font-size: 18px" class="form-label w-100 text-right">اختر موقعك من الخريطة او ابحث عنه</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" id="address" name="location" placeholder="مثال : الرياض" required>
                                                            <button class="btn btn-primary" id="find-location">بحث</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="map" style="height: 400px; width: 100%;"></div>
                                            </div>
                                        </div>

                                        <div class="form-group form-check" style="margin-right: 20px !important; margin-top: 20px !important;">
                                            <input type="checkbox" class="form-check-input" id="terms" required style="text-align: right; display: block;">
                                            <label class="form-check-label" style="text-align: right; display: block;" for="terms">لقد وافقت علي <a href="#">السياسات والشروط</a></label>
                                        </div>

                                        <button type="button" class="btn btn-secondary" onclick="prevStep()">السابق</button>
                                        <button type="submit" class="btn btn-success" style="background-color: #2f3e3b; border-color: #2f3e3b;">انشاء حساب</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

            <!-- Modal -->
            <div class="modal fade text-center" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="successModalLabel">تم التسجيل بنجاح</h5>
                    </div>
                    <div class="modal-body">
                    تم التسجبل بنجاح , سيتم مراجعة طلبكم من قبل المسؤول والان يمكنك الدخول الي صفحتك الشخصية   
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="window.location.href='{{ route('seller.loginPage') }}'">ادخل الان</button>
                    </div>
                </div>
            </div>
        </div>


        <!--Scroll to top-->
        <button class="scroll-top scroll-to-target" data-target="html">
            <span class="far fa-long-arrow-up"></span>
        </button>
    </div>


    
    <script>
$(document).ready(function() {
    // Phone form submission
    $('#phone-form').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "{{ route('send.otp') }}",
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    $('#otp-section').show();
                    $('#phone-form').hide();
                } else {
                    alert(response.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // Properly display the error message
                var errorMessage = jqXHR.responseJSON?.message || 'Unknown error';
                alert('Error: ' + errorMessage);
            }
        });
    });

    // OTP form submission
    $('#otp-form').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "{{ route('verify.otp') }}",
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    $('#otp-section').hide();
                    $('#owner-section').show();
                } else {
                    alert(response.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // Properly display the error message
                var errorMessage = jqXHR.responseJSON?.message || 'Unknown error';
                alert('Error: ' + errorMessage);
            }
        });
    });

    // Owner form submission
    $('#owner-form').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: "{{ route('seller.register') }}",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status === 'success') {
                    $('#successModal').modal('show');
                } else {
                    alert(response.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
            console.log('Full error response:', jqXHR); // Log the full error object
            var errorMessage = jqXHR.responseJSON?.message || 'Unknown error';
            alert('Error: ' + errorMessage);
            }
        });
    });
});

</script>


   <!-- jQuery plugins -->
<script src="{{ asset('user-assets/js/jquery.js') }}"></script>
<script src="{{ asset('user-assets/js/popper.min.js') }}"></script>
<script src="{{ asset('user-assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('user-assets/js/owl.js') }}"></script>
<script src="{{ asset('user-assets/js/wow.js') }}"></script>
<script src="{{ asset('user-assets/js/validation.js') }}"></script>
<script src="{{ asset('user-assets/js/jquery.fancybox.js') }}"></script>
<script src="{{ asset('user-assets/js/appear.js') }}"></script>
<script src="{{ asset('user-assets/js/scrollbar.js') }}"></script>
<script src="{{ asset('user-assets/js/jquery.nice-select.min.js') }}"></script>

<!-- main-js -->
<script src="{{ asset('user-assets/js/script.js') }}"></script>

<!-- Seller Register Script -->
<script src="{{ asset('JS/sellerRegister.js') }}"></script>

<!-- MY SCRIPTS -->
<script src="{{ asset('JS/categories.js') }}"></script>
</body>
</html>

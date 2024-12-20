<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

<title>تسجيل حساب عميل جديد</title>
<meta name="author" content="Sayed Khattab">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Fav Icon -->
<link rel="icon" href="{{ asset('user-assets/images/favicon.ico') }}" type="image/png">

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
<link rel="stylesheet" href="{{ asset('Styling/customer.css') }}">

<!-- Include Google Maps JS API -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAL0mf-wYCEO4N6xNkiJaau55bfRxdB4yk&libraries=places"></script>

<style>
    body {
        background-color: #2f3e3b;
    }
</style>

</head>
<!-- page wrapper -->
<body>
    <div class="boxed_wrapper">
        <!-- preloader -->
        <div class="preloader"></div>
        <!-- preloader -->

        <!-- Registration Form -->
        <div class="container">
            <div class="row justify-content-center" style="margin-top: 100px; margin-bottom: 50px;">
                <div class="col-md-8">
                    <div class="card">
                    <div class="card-header text-center bg-white" style="color: #2f3e3b; font-weight: 600; font-size: 20px;">تسجيل عميل جديد</div>
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
                                <div class="d-flex justify-content-center align-items-center">
                                    <button type="submit" class="btn mt-3" style="background-color: #2f3e3b; color: #ffffff;">إرسال كود التحقق</button>
                                </div>
                            </form>

                            <div id="otp-section" style="display:none;" dir="ltr">
                                <form method="POST" id="otp-form">
                                    @csrf
                                    <input type="text" class="form-control mt-3" name="otp" placeholder="أدخل كود التحقق" required>
                                    <div class="d-flex justify-content-center align-items-center">
                                        <button type="submit" class="btn mt-3" style="background-color: #2f3e3b; color: #ffffff;">تحقق من OTP</button>
                                    </div>
                                </form>

                                    <!-- Resend OTP -->
                                    <!-- <form method="POST" id="resend-otp-form">
                                        @csrf
                                        <button type="submit" class="btn btn-primary mt-3 w-100" id="resend-otp-btn">اعادة ارسال كود التحقق</button>
                                    </form> -->
                                </div>
                            </div>
                            <div id="owner-section" class="container" style="display:none;"  dir="rtl">
                                <form enctype="multipart/form-data" action="{{ route('customer.register') }}" method="POST" id="owner-form">
                                    @csrf
                                    <!-- Step 1: Personal Information -->
                                    <div class="step" id="step-1">
                                        <h5 class="text-center mb-4">الخطوة الاولي</h5>
                                        <div class="form-group row text-right">
                                            <!-- First Name -->
                                            <div class="col-md-6">
                                                <label for="first_name" class="form-label">الاسم الأول</label>
                                                <input type="text" name="first_name" id="first_name" class="form-control" placeholder="محمد" required>
                                                @error('first_name')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            
                                            <!-- Last Name -->
                                            <div class="col-md-6">
                                                <label for="last_name" class="form-label">اسم العائلة</label>
                                                <input type="text" name="last_name" id="last_name" class="form-control" placeholder="عبدالله" required>
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
                                            <input type="password" name="password" id="password"  class="form-control text-left" placeholder="••••••••" required>
                                            @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="password_confirmation" style="text-align: right; display: block;">تأكيد كلمة المرور</label>
                                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control text-left" placeholder="••••••••" required>
                                            @error('password_confirmation')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <button type="button" class="btn btn-primary mb-3" onclick="nextStep()">التالي</button>
                                    </div>


                                    <!-- Step 2: Location -->
                                    <div class="step" id="step-2" style="display: none;">
                                        <h5 class="text-center mb-4">الخطوة الثالثة</h5>

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
                                                <div id="map" style="height: 500px; width: 100%;"></div>
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
                    تم التسجبل بنجاح بمكنك الانتقال الي الصفحة الرئيسية الان   
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="window.location.href='{{ route('home') }}'">موافق</button>
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
            url: "{{ route('customer.register') }}",
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
<script src="{{ asset('JS/customerRegister.js') }}"></script>
</body>
</html>

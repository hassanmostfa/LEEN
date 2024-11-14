<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

<title>تسجيل دخول عميل</title>
<meta name="author" content="Sayed Khattab">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Fav Icon -->
<link rel="icon" href="user-assets/images/favicon.png" type="image/png">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Barlow:wght@300;400;600;700;800&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
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

<style>
    .login-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }
    .login-card {
        width: 100%;
        max-width: 450px;
        background: white;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        direction: rtl;
    }
    .login-card h1 {
        text-align: center;
        margin-bottom: 2rem;
        font-size: 1.5rem;
        font-weight: 700;
        color: #88394E;
    }
    .login-card .form-control {
        height: 45px;
        margin-bottom: 1rem;
    }
    .login-card .form-check-label {
        margin-right: 1.25rem;
    }
    .login-card .btn-primary {
        background: #88394E;
        border-color: #88394E;
        height: 45px;
        font-size: 1rem;
        font-weight: 600;
    }
    .login-card .btn-primary:hover {
        background: #a94562;
        border-color: #a94562;
    }
    .login-card p {
        text-align: center;
        margin-top: 1.5rem;
    }
    .login-card p a {
        color: #88394E;
        text-decoration: underline;
    }

    .outer-box{
        height: 100px;
    }
</style>

</head>
<body>
@if (Session::has('success'))
    <div class="alert alert-success text-center">{{ Session::get('success') }}</div>
@elseif (Session::has('error'))
    <div class="alert alert-danger text-center">{{ Session::get('error') }}</div>
@endif
    <div class="boxed_wrapper">


        <div class="login-container">
            <div class="login-card">
                <h1 style="color: #2f3e3b;"> تسجيل دخول مستخدم </h1>
                <form method="post" action="{{ route('customer.login') }}">
                    @csrf
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">خطأ!</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li><span class="block sm:inline">{{ $error }}</span></li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="login" style="display: block; text-align: right;">البريد الالكتروني أو رقم الهاتف</label>
                        <input type="text" name="login" id="login" class="form-control text-left" placeholder="البريد الالكتروني أو رقم الهاتف" required>
                    </div>
                    <div class="form-group">
                        <label for="password" style="display: block; text-align: right;">كلمة المرور</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
                    </div>
                    <!-- <div class="form-group form-check">
                        <input type="checkbox" name="remember" id="remember" class="form-check-input">
                        <label class="form-check-label" for="remember">تذكرني لاحقا</label>
                    </div> -->
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary w-100" style="background-color: #2f3e3b; border-color: #2f3e3b;">سجل الدخول</button>
                    </div>
                    <p>ليس لديك حساب حتي الان؟ <a href="{{ route('customer.registerPage') }}" style="color: #2f3e3b;">انشأ حسابك</a></p>
                </form>

            </div>
        </div>
        <!--Scroll to top-->
        <button class="scroll-top scroll-to-target" data-target="html">
            <span class="far fa-long-arrow-up"></span>
        </button>
    </div>

    <script>
        function changeLanguage(lang) {
            console.log("Changing language to: " + lang);
            $.ajax({
                url: '/language/' + lang,
                type: 'GET',
                success: function (data) {
                    console.log("Language changed successfully, reloading page.");
                    window.location.reload();
                },
                error: function (error) {
                    console.error('Error changing language:', error);
                }
            });
        }
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

</body>
</html>

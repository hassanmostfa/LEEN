<!doctype html>
<html lang = "ar" dir = "rtl">
	<head>

		<!-- Basic -->
		<meta charset="UTF-8">

		<title>LEEN | Customer Dashboard</title>
		<meta name="keywords" content="HTML5 Admin Template" />
		<meta name="description" content="LeenAdmin - Responsive HTML5 Template">
		<meta name="author" content="okler.net">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<!-- Web Fonts  -->
		<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/animate/animate.compat.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/all.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/magnific-popup/magnific-popup.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/jquery-ui/jquery-ui.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/jquery-ui/jquery-ui.theme.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-multiselect/css/bootstrap-multiselect.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/morris/morris.css') }}" />

<!-- Theme CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}" />

<!-- Skin CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/skins/default.css') }}" />

<!-- Theme Custom CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">

<!-- Font Awesome Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- My CSS Files -->
<link rel="stylesheet" href="{{ asset('Styling/categories.css') }}">
<link rel="stylesheet" href="{{ asset('Styling/services.css') }}">


<!-- Head Libs -->
<script src="{{ asset('assets/vendor/modernizr/modernizr.js') }}"></script>


<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&display=swap" rel="stylesheet">

  <!-- Include Google Maps JS API -->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAL0mf-wYCEO4N6xNkiJaau55bfRxdB4yk&libraries=places"></script>
    

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



<!-- Pusher Assets -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pusher/7.0.3/pusher.min.js"></script>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>

<!-- Echo JS from CDN -->
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.0/dist/echo.iife.js"></script>

<meta name="csrf-token" content="{{ csrf_token() }}">

@vite('resources/css/app.css')

@vite('resources/js/app.js')

	</head>
	<body>
		
	<style>
		body {
			direction: rtl;
			font-family: 'Almarai', sans-serif;
		}
	</style>

	<section class="body">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="{{ route('home')}}">
		<img style=" height: 50px!important;" src="{{asset('homePage/images/leen logo.png')}}">
	</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="nav d-flex justify-content-between w-100 align-items-center">
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home')}}#homeServices">خدمات المنزل</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home')}}#studioServices">خدمات الاستوديو</a>
                </li>
            </ul>
        </div>

        <div class="mx-2">
            @if (Auth::guard('customer')->check())
                <a href="{{ route('customer.profile') }}" class="btn btn-outline-success btn-sm">ملفي الشخصي</a>
                <a href="{{ route('customer.logout') }}" class="btn btn-outline-danger btn-sm">تسجيل الخروج</a>
            @else
                <a href="{{ route('customer.loginPage') }}" class="btn btn-success btn-sm">تسجيل الدخول</a>
            @endif
        </div>

    </div>
</nav>

	<!-- End Navbar -->

			<div class="inner-wrapper p-0">
				<!-- start: sidebar -->
				<aside id="sidebar-left" class="sidebar-left" style="width: 200px;">

				    <div class="sidebar-header">
				        
				        <div class="sidebar-toggle d-none d-md-block" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
				            <i class="fas fa-bars" aria-label="Toggle sidebar"></i>
				        </div>
				    </div>

				    <div class="nano">
				        <div class="nano-content p-0">
				            <nav id="menu" class="nav-main" role="navigation">

				                <ul class="nav nav-main p-0">

								<li>
				                        <a class="nav-link" href="{{ route('customer.profile') }}">
										<i class="fa fa-user" aria-hidden="true"></i>
				                            <span>بيانات الحساب</span></span>
				                        </a>
				                    </li>

				            <!-- My Orders -->
							<li class="nav-parent">
				                        <a class="nav-link" href="#">
										<i class="fa fa-shopping-bag" aria-hidden="true"></i>
				                            <span>طلباتي</span>
				                        </a>
				                        <ul class="nav nav-children">
				                            <li>
				                                <a class="nav-link" href="{{ route('customer.homeBookings') }}">
												<i class="fa fa-angle-double-left" aria-hidden="true"></i>
				                                    المنزلية 
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="{{ route('customer.studioBookings') }}">
												<i class="fa fa-angle-double-left" aria-hidden="true"></i>
				                                    بالمقر الخاص بالبائع
				                                </a>
				                            </li>
				                        </ul>
				                    </li>

				            <!-- My Favourites -->
							<li class="nav-parent">
				                        <a class="nav-link" href="#">
										<i class="fa fa-heart" aria-hidden="true"></i>
				                            <span>المفضلة</span>
				                        </a>
				                        <ul class="nav nav-children">
				                            <li>
				                                <a class="nav-link" href="{{ route('customer.favourites') }}">
												<i class="fa fa-angle-double-left" aria-hidden="true"></i>
				                                    القائمة الرئيسية 
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="{{ route('customer.favourites.add') }}">
												<i class="fa fa-angle-double-left" aria-hidden="true"></i>
				                                    اضافة بائع للمفضلة
				                                </a>
				                            </li>
				                        </ul>
				                    </li>

									<li>
				                        <a class="nav-link" href="{{ route('customer.coupons') }}">
										<i class="fa fa-money-bill" aria-hidden="true"></i>
				                            <span>قسائم الخصم</span>
				                        </a>
				                    </li>

				                     <li>
				                        <a class="nav-link" href="{{ route('customer.sellers') }}">
										<i class="fa fa-paper-plane" aria-hidden="true"></i>
				                            <span>الرسائل</span>
				                        </a>
				                    </li>

								<!--
				                    <li>
				                        <a class="nav-link" href="#">
										<i class="fa fa-cog" aria-hidden="true"></i>
				                            <span>الاعدادات</span></span>
				                        </a>
				                    </li>

				                    <li>
				                        <a class="nav-link" href="#">
										<i class="fa fa-phone" aria-hidden="true"></i>
				                            <span>تواصل معنا</span></span>
				                        </a>
				                    </li> -->
				                    
				                </ul>
				            </nav>

				            
				        <script>
				            // Maintain Scroll Position
				            if (typeof localStorage !== 'undefined') {
				                if (localStorage.getItem('sidebar-left-position') !== null) {
				                    var initialPosition = localStorage.getItem('sidebar-left-position'),
				                        sidebarLeft = document.querySelector('#sidebar-left .nano-content');

				                    sidebarLeft.scrollTop = initialPosition;
				                }
				            }
				        </script>

				    </div>

				</aside>
				<!-- end: sidebar -->

				<section role="main" class="content-body">
					<header class="page-header">
						<h2>@yield('title')</h2>
					</header>

					<!-- start: page -->
					<div>
                        @yield('content')
                    </div>
					<!-- end: page -->
				</section>
			</div>

		</section>

		<!-- Vendor -->
<script src="{{ asset('assets/vendor/jquery/jquery.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js') }}"></script>
<script src="{{ asset('assets/vendor/popper/umd/popper.min.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('assets/vendor/common/common.js') }}"></script>
<script src="{{ asset('assets/vendor/nanoscroller/nanoscroller.js') }}"></script>
<script src="{{ asset('assets/vendor/magnific-popup/jquery.magnific-popup.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery-placeholder/jquery.placeholder.js') }}"></script>

<!-- Specific Page Vendor -->
<script src="{{ asset('assets/vendor/jquery-ui/jquery-ui.js') }}"></script>
<script src="{{ asset('assets/vendor/jqueryui-touch-punch/jquery.ui.touch-punch.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery-appear/jquery.appear.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrapv5-multiselect/js/bootstrap-multiselect.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery.easy-pie-chart/jquery.easypiechart.js') }}"></script>
<script src="{{ asset('assets/vendor/flot/jquery.flot.js') }}"></script>
<script src="{{ asset('assets/vendor/flot.tooltip/jquery.flot.tooltip.js') }}"></script>
<script src="{{ asset('assets/vendor/flot/jquery.flot.pie.js') }}"></script>
<script src="{{ asset('assets/vendor/flot/jquery.flot.categories.js') }}"></script>
<script src="{{ asset('assets/vendor/flot/jquery.flot.resize.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery-sparkline/jquery.sparkline.js') }}"></script>
<script src="{{ asset('assets/vendor/raphael/raphael.js') }}"></script>
<script src="{{ asset('assets/vendor/morris/morris.js') }}"></script>
<script src="{{ asset('assets/vendor/gauge/gauge.js') }}"></script>
<script src="{{ asset('assets/vendor/snap.svg/snap.svg.js') }}"></script>
<script src="{{ asset('assets/vendor/liquid-meter/liquid.meter.js') }}"></script>
<script src="{{ asset('assets/vendor/jqvmap/jquery.vmap.js') }}"></script>
<script src="{{ asset('assets/vendor/jqvmap/data/jquery.vmap.sampledata.js') }}"></script>
<script src="{{ asset('assets/vendor/jqvmap/maps/jquery.vmap.world.js') }}"></script>
<script src="{{ asset('assets/vendor/jqvmap/maps/continents/jquery.vmap.africa.js') }}"></script>
<script src="{{ asset('assets/vendor/jqvmap/maps/continents/jquery.vmap.asia.js') }}"></script>
<script src="{{ asset('assets/vendor/jqvmap/maps/continents/jquery.vmap.australia.js') }}"></script>
<script src="{{ asset('assets/vendor/jqvmap/maps/continents/jquery.vmap.europe.js') }}"></script>
<script src="{{ asset('assets/vendor/jqvmap/maps/continents/jquery.vmap.north-america.js') }}"></script>
<script src="{{ asset('assets/vendor/jqvmap/maps/continents/jquery.vmap.south-america.js') }}"></script>

<!-- Theme Base, Components and Settings -->
<script src="{{ asset('assets/js/theme.js') }}"></script>

<!-- Theme Custom -->
<script src="{{ asset('assets/js/custom.js') }}"></script>

<!-- Theme Initialization Files -->
<script src="{{ asset('assets/js/theme.init.js') }}"></script>

<!-- Examples -->
<script src="{{ asset('assets/js/examples/examples.dashboard.js') }}"></script>


<!-- MY SCRIPTS -->
<script src="{{ asset('JS/categories.js') }}"></script>
<script src="{{ asset('JS/admin_sellers.js') }}"></script>
<script src="{{ asset('JS/services.js') }}"></script>

<!-- include script for google map -->
<script src="{{ asset('JS/sellerRegister.js') }}"></script>


<script>
    function previewLogo(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('image-preview');
            output.src = reader.result; // Set new image source
        };
        if (event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]); // Read the uploaded file as DataURL
        }
    }
</script>

</body>
</html>
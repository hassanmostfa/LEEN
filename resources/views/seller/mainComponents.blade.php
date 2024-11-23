<!doctype html>
<html lang = "ar" dir = "rtl">
	<head>
		<!-- Basic -->
		<meta charset="UTF-8">

		<title>LEEN | Seller Dashboard</title>
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


@vite(['resources/css/app.css', 'resources/js/app.js'])


</head>
<body>
		
	<style>
		body {
			direction: rtl;
			font-family: 'Almarai', sans-serif;
		}
	</style>

	<section class="body">

			<!-- start: header -->
			<header class="header">
				<div class="logo-container">
					<a href="#" class="logo">
						<h4>LEEN _ LOGO</h4>
						<!-- <img src="#" alt="URSTAY Admin" width="75" height="35" /> -->
					</a>

					<div class="d-md-none toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
						<i class="fas fa-bars" aria-label="Toggle sidebar"></i>
					</div>

				</div>

				<!-- start: search & user box -->
				<div class="header-right">

					<form action="pages-search-results.html" class="search nav-form">
						<div class="input-group">
							<input type="text" class="form-control" name="q" id="q" placeholder="Search...">
							<button class="btn btn-default" type="submit"><i class="bx bx-search"></i></button>
						</div>
					</form>

					<span class="separator"></span>

					<ul class="notifications">
						<li>
							<a href="#" class="dropdown-toggle notification-icon" data-bs-toggle="dropdown">
								<i class="bx bx-list-ol"></i>
								<span class="badge">3</span>
							</a>

							<div class="dropdown-menu notification-menu large">
								<div class="notification-title">
									<span class="float-end badge badge-default">3</span>
									جدول المهام
								</div>

								<div class="content">
									<ul>
										<li>
											<p class="clearfix mb-1">
												<span class="message float-start">Generating Sales Report</span>
												<span class="message float-end text-dark">60%</span>
											</p>
											<div class="progress progress-xs light">
												<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;"></div>
											</div>
										</li>

										<li>
											<p class="clearfix mb-1">
												<span class="message float-start">Importing Contacts</span>
												<span class="message float-end text-dark">98%</span>
											</p>
											<div class="progress progress-xs light">
												<div class="progress-bar" role="progressbar" aria-valuenow="98" aria-valuemin="0" aria-valuemax="100" style="width: 98%;"></div>
											</div>
										</li>

										<li>
											<p class="clearfix mb-1">
												<span class="message float-start">Uploading something big</span>
												<span class="message float-end text-dark">33%</span>
											</p>
											<div class="progress progress-xs light mb-1">
												<div class="progress-bar" role="progressbar" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100" style="width: 33%;"></div>
											</div>
										</li>
									</ul>
								</div>
							</div>
						</li>
						<li>
							<a href="#" class="dropdown-toggle notification-icon" data-bs-toggle="dropdown">
								<i class="bx bx-envelope"></i>
								<span class="badge">4</span>
							</a>

							<div class="dropdown-menu notification-menu">
								<div class="notification-title">
									<span class="float-end badge badge-default">230</span>
									الرسائل
								</div>

								<div class="content">
									<ul>
										<li>
											<a href="#" class="clearfix">
												<!-- <figure class="image">
													<img src="{{asset('assets/img/!sample-user.jpg')}}" alt="Joseph Doe Junior" class="rounded-circle" />
												</figure> -->
												<span class="title">Joseph Doe</span>
												<span class="message">Lorem ipsum dolor sit.</span>
											</a>
										</li>
										<li>
											<a href="#" class="clearfix">
												<!-- <figure class="image">
													<img src="{{asset('assets/img/!sample-user.jpg')}}" alt="Joseph Junior" class="rounded-circle" />
												</figure> -->
												<span class="title">Joseph Junior</span>
												<span class="message truncate">Truncated message. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet lacinia orci. Proin vestibulum eget risus non luctus. Nunc cursus lacinia lacinia. Nulla molestie malesuada est ac tincidunt. Quisque eget convallis diam, nec venenatis risus. Vestibulum blandit faucibus est et malesuada. Sed interdum cursus dui nec venenatis. Pellentesque non nisi lobortis, rutrum eros ut, convallis nisi. Sed tellus turpis, dignissim sit amet tristique quis, pretium id est. Sed aliquam diam diam, sit amet faucibus tellus ultricies eu. Aliquam lacinia nibh a metus bibendum, eu commodo eros commodo. Sed commodo molestie elit, a molestie lacus porttitor id. Donec facilisis varius sapien, ac fringilla velit porttitor et. Nam tincidunt gravida dui, sed pharetra odio pharetra nec. Duis consectetur venenatis pharetra. Vestibulum egestas nisi quis elementum elementum.</span>
											</a>
										</li>
										<li>
											<a href="#" class="clearfix">
												<!-- <figure class="image">
													<img src="{{asset('assets/img/!sample-user.jpg')}}" alt="Joe Junior" class="rounded-circle" />
												</figure> -->
												<span class="title">Joe Junior</span>
												<span class="message">Lorem ipsum dolor sit.</span>
											</a>
										</li>
										<li>
											<a href="#" class="clearfix">
												<!-- <figure class="image">
													<img src="img/!sample-user.jpg" alt="Joseph Junior" class="rounded-circle" />
												</figure> -->
												<span class="title">Joseph Junior</span>
												<span class="message">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet lacinia orci. Proin vestibulum eget risus non luctus. Nunc cursus lacinia lacinia. Nulla molestie malesuada est ac tincidunt. Quisque eget convallis diam.</span>
											</a>
										</li>
									</ul>

									<hr />

									<div class="text-end">
										<a href="#" class="view-more">View All</a>
									</div>
								</div>
							</div>
						</li>
						<li>
							<a href="#" class="dropdown-toggle notification-icon" data-bs-toggle="dropdown">
								<i class="bx bx-bell"></i>
								<span class="badge">3</span>
							</a>

							<div class="dropdown-menu notification-menu">
								<div class="notification-title">
									<span class="float-end badge badge-default">3</span>
									التنبيهات
								</div>

								<div class="content">
									<ul>
										<li>
											<a href="#" class="clearfix">
												<div class="image">
													<i class="fas fa-thumbs-down bg-danger text-light"></i>
												</div>
												<span class="title">Server is Down!</span>
												<span class="message">Just now</span>
											</a>
										</li>
										<li>
											<a href="#" class="clearfix">
												<div class="image">
													<i class="bx bx-lock bg-warning text-light"></i>
												</div>
												<span class="title">User Locked</span>
												<span class="message">15 minutes ago</span>
											</a>
										</li>
										<li>
											<a href="#" class="clearfix">
												<div class="image">
													<i class="fas fa-signal bg-success text-light"></i>
												</div>
												<span class="title">Connection Restaured</span>
												<span class="message">10/10/2021</span>
											</a>
										</li>
									</ul>

									<hr />

									<div class="text-end">
										<a href="#" class="view-more">View All</a>
									</div>
								</div>
							</div>
						</li>
					</ul>

					<span class="separator"></span>

					<div id="userbox" class="userbox">
						<a href="#" data-bs-toggle="dropdown">
							<figure class="profile-picture">
								<img src= "{{asset(Auth::user()->seller_logo)}}" alt="Seller Image" class="rounded-circle" data-lock-picture="img/!logged-user.jpg" />
							</figure>
							<div class="profile-info" data-lock-name="John Doe" data-lock-email="johndoe@okler.com">
								<span class="name">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</span>
								<span class="role">مقدم خدمة</span>
							</div>

							<i class="fa custom-caret"></i>
						</a>

						<div class="dropdown-menu">
							<ul class="list-unstyled p-0 my-2" style="text-align:right !important;>
								<li class="divider"></li>
								<li>
									<a role="menuitem" tabindex="-1" href="#"><i class="bx bx-user-circle"></i> حسابي</a>
								</li>
								<li>
									<a role="menuitem" tabindex="-1" href="#" data-lock-screen="true"><i class="bx bx-lock"></i> شاشة القفل</a>
								</li>
								<li>
									<a role="menuitem" tabindex="-1" href="{{ route('seller.logout') }}"><i class="bx bx-power-off"></i> تسجيل خروح </a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<!-- end: search & user box -->
			</header>
			<!-- end: header -->

			<div class="inner-wrapper">
				<!-- start: sidebar -->
				<aside id="sidebar-left" class="sidebar-left">

				    <div class="sidebar-header">
				        <!-- <div class="sidebar-title">
				            الروابط
				        </div> -->
				        <div class="sidebar-toggle d-none d-md-block" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
				            <i class="fas fa-bars" aria-label="Toggle sidebar"></i>
				        </div>
				    </div>

				    <div class="nano">
				        <div class="nano-content p-0">
				            <nav id="menu" class="nav-main" role="navigation">

				                <ul class="nav nav-main p-0">
				                    <li>
				                        <a class="nav-link" href="{{ route('seller.dashboard') }}">
				                            <i class="bx bx-home-alt" aria-hidden="true"></i>
				                            <span>لوحة التحكم</span>
				                        </a>
				                    </li>

									<li>
				                        <a class="nav-link" href="{{ route('seller.timetables') }}">
										<i class="fa fa-clock" aria-hidden="true"></i>
				                            <span>مواعيد العمل</span>
				                        </a>
				                    </li>

									
									<!-- Employees -->
				                    <li class="nav-parent">
				                        <a class="nav-link" href="#">
										<i class="fa-solid fa-users"></i>
				                            <span> الموظفين</span>
				                        </a>
				                        <ul class="nav nav-children">
				                            <li>
				                                <a class="nav-link" href="{{ route('seller.employees') }}">
												<i class="fa fa-angle-double-left" aria-hidden="true"></i>
				                                    كل الموظفين 
				                                </a>
				                            </li>
				                            <!-- <li>
				                                <a class="nav-link" href="#">
												<i class="fa fa-angle-double-left" aria-hidden="true"></i>
				                                	جدول المواعيد
				                                </a>
				                            </li> -->
				                        </ul>
				                    </li>

									<!-- Home Services -->
				                    <li class="nav-parent">
				                        <a class="nav-link" href="#">
										<i class="fa fa-door-open" aria-hidden="true"></i>
				                            <span>خدماتي المنزلية</span>
				                        </a>
				                        <ul class="nav nav-children">
				                            <li>
				                                <a class="nav-link" href="{{ route('seller.homeServices') }}">
												<i class="fa fa-angle-double-left" aria-hidden="true"></i>
				                                    كل الخدمات
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="{{ route('seller.homeServices.create') }}">
												<i class="fa fa-angle-double-left" aria-hidden="true"></i>
				                                	اضافة خدمة جديدة
				                                </a>
				                            </li>
				                        </ul>
				                    </li>

									<!-- Studio Services -->
				                    <li class="nav-parent">
				                        <a class="nav-link" href="#">
										<i class="fa fa-shop" aria-hidden="true"></i>
				                            <span>خدماتي في المقر</span>
				                        </a>
				                        <ul class="nav nav-children">
				                            <li>
				                                <a class="nav-link" href="{{ route('seller.studioServices') }}">
												<i class="fa fa-angle-double-left" aria-hidden="true"></i>
				                                    كل الخدمات
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="{{ route('seller.studioServices.create') }}">
												<i class="fa fa-angle-double-left" aria-hidden="true"></i>
				                                	اضافة خدمة جديدة
				                                </a>
				                            </li>
				                        </ul>
				                    </li>
									
									<!-- Home Bookings -->
				                    <li class="nav-parent">
				                        <a class="nav-link" href="#">
										<i class="fa-solid fa-dungeon"></i>
				                            <span> الحجوزات المنزلية </span>
				                        </a>
				                        <ul class="nav nav-children">
				                            <li>
				                                <a class="nav-link" href="{{ route('seller.homeBookings') }}">
												<i class="fa fa-angle-double-left" aria-hidden="true"></i>
				                                    كل الحجوزات
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="{{ route('seller.homeBookings.newRequests') }}">
												<i class="fa fa-angle-double-left" aria-hidden="true"></i>
				                                	الطلبات الجديدة
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="{{ route('seller.homeBookings.rejectedRequests') }}">
												<i class="fa fa-angle-double-left" aria-hidden="true"></i>
				                                	الطلبات المرفوضة 
				                                </a>
				                            </li>
				                        </ul>
				                    </li>

									<!-- Studio Bookings -->
				                    <li class="nav-parent">
				                        <a class="nav-link" href="#">
										<i class="fa-solid fa-house-user"></i>
				                            <span> الحجوزات في المقر </span>
				                        </a>
				                        <ul class="nav nav-children">
				                            <li>
				                                <a class="nav-link" href="{{ route('seller.studioBookings') }}">
												<i class="fa fa-angle-double-left" aria-hidden="true"></i>
				                                    كل الحجوزات
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="{{ route('seller.studioBookings.newRequests') }}">
												<i class="fa fa-angle-double-left" aria-hidden="true"></i>
				                                	الطلبات الجديدة
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="{{ route('seller.studioBookings.rejectedRequests') }}">
												<i class="fa fa-angle-double-left" aria-hidden="true"></i>
				                                	الطلبات المرفوضة 
				                                </a>
				                            </li>
				                        </ul>
				                    </li>

									<!-- Media -->
				                    <li class="nav-parent">
				                        <a class="nav-link" href="#">
										<i class="fa-solid fa-camera"></i>
				                            <span>الصور و الريلز</span>
				                        </a>
				                        <ul class="nav nav-children">
				                            <li>
				                                <a class="nav-link" href="{{ route('seller.images') }}">
												<i class="fa fa-angle-double-left" aria-hidden="true"></i>
				                                    الصور 
				                                </a>
				                            </li>
				                            <li>
				                                <a class="nav-link" href="{{ route('seller.reels') }}">
												<i class="fa fa-angle-double-left" aria-hidden="true"></i>
				                                	الريلز
				                                </a>
				                            </li>
				                        </ul>
				                    </li>

				                    <li>
				                        <a class="nav-link" href="{{ route('seller.coupons') }}">
										<i class="fa fa-money-bill" aria-hidden="true"></i>
				                            <span>قسائم الخصم</span>
				                        </a>
				                    </li>

									<li>
				                        <a class="nav-link" href="{{ route('seller.clients') }}">
										<i class="fa fa-paper-plane" aria-hidden="true"></i>
				                            <span>الرسائل</span>
				                        </a>
				                    </li>

				                    <!-- <li>
				                        <a class="nav-link" href="#">
										<i class="fa fa-paper-plane" aria-hidden="true"></i>
				                            <span>الرسائل</span>
				                        </a>
				                    </li> -->

				                    <li>
				                        <a class="nav-link" href="{{ route('seller.profile') }}">
										<i class="fa fa-user" aria-hidden="true"></i>
				                            <span>حسابي</span></span>
				                        </a>
				                    </li>

									
				                    <!-- <li>
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

						<!-- <div class="right-wrapper text-end">
							<ol class="breadcrumbs">
								<li>
									<a href="{{ route('admin.dashboard') }}">
										<i class="bx bx-home-alt"></i>
									</a>
								</li>

								<li><span>@yield('link_one')</span></li>

								<li><span>@yield('link_two')</span></li>

							</ol>

							<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fas fa-chevron-left"></i></a>
						</div> -->
					</header>

					<!-- start: page -->
					<div>
                        @yield('content')
                    </div>
					<!-- end: page -->
				</section>
			</div>

			<aside id="sidebar-right" class="sidebar-right">
				<div class="nano">
					<div class="nano-content">
						<a href="#" class="mobile-close d-md-none">
							Collapse <i class="fas fa-chevron-right"></i>
						</a>

						<div class="sidebar-right-wrapper">

							<div class="sidebar-widget widget-calendar">
								<h6>Upcoming Tasks</h6>
								<div data-plugin-datepicker data-plugin-skin="dark"></div>

								<ul>
									<li>
										<time datetime="2021-04-19T00:00+00:00">04/19/2021</time>
										<span>Company Meeting</span>
									</li>
								</ul>
							</div>

							<div class="sidebar-widget widget-friends">
								<h6>Friends</h6>
								<ul>
									<li class="status-online">
										<!-- <figure class="profile-picture">
											<img src="img/!sample-user.jpg" alt="Joseph Doe" class="rounded-circle">
										</figure> -->
										<div class="profile-info">
											<span class="name">Joseph Doe Junior</span>
											<span class="title">Hey, how are you?</span>
										</div>
									</li>
									<li class="status-online">
										<!-- <figure class="profile-picture">
											<img src="img/!sample-user.jpg" alt="Joseph Doe" class="rounded-circle">
										</figure> -->
										<div class="profile-info">
											<span class="name">Joseph Doe Junior</span>
											<span class="title">Hey, how are you?</span>
										</div>
									</li>
									<li class="status-offline">
										<!-- <figure class="profile-picture">
											<img src="img/!sample-user.jpg" alt="Joseph Doe" class="rounded-circle">
										</figure> -->
										<div class="profile-info">
											<span class="name">Joseph Doe Junior</span>
											<span class="title">Hey, how are you?</span>
										</div>
									</li>
									<li class="status-offline">
										<!-- <figure class="profile-picture">
											<img src="img/!sample-user.jpg" alt="Joseph Doe" class="rounded-circle">
										</figure> -->
										<div class="profile-info">
											<span class="name">Joseph Doe Junior</span>
											<span class="title">Hey, how are you?</span>
										</div>
									</li>
								</ul>
							</div>

						</div>
					</div>
				</div>
			</aside>

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


</body>
</html>
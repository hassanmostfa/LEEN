<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <title>عرض تفاصيل الخدمة</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('homePage/images/leen logo2.png') }}" type="image/x-icon">
    <!-- Include Google Maps JS API -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAL0mf-wYCEO4N6xNkiJaau55bfRxdB4yk&libraries=places"></script>
    
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        body { background-color: #f9fafb; }
        h1, h2, h4, p, .card-title { color: #2f3e3b; }
        .section-title { color: #89314f; }
    </style>

</head>
<body>

@if (Session::has('success'))
    <div class="alert alert-success text-right">{{ Session::get('success') }}</div>
@elseif (Session::has('error'))
    <div class="alert alert-danger text-right">{{ Session::get('error') }}</div>
@endif


<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #2f3e3b;">
    <a class="navbar-brand text-white" href="{{ route('home')}}">
        <img style=" height: 50px!important;" src="{{asset('homePage/images/leen logo2.png')}}">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="nav d-flex justify-content-between w-100 align-items-center">
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('home')}}#studioServices">خدمات المنزل</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('home')}}#studioServices">خدمات الاستوديو</a>
                </li>
            </ul>
        </div>

        <div class="mx-2">
            @if (Auth::guard('customer')->check())
                <a href="{{ route('customer.profile') }}" class="btn btn-sm" style="background-color: transparent; color: white; border: 1px solid white;">ملفي الشخصي</a>
                <a href="{{ route('customer.logout') }}" class="btn btn-sm" style="background-color: transparent; color: white; border: 1px solid white;">تسجيل الخروج</a>
            @else
                <a href="{{ route('customer.loginPage') }}" class="btn btn-success btn-sm">تسجيل الدخول</a>
            @endif
        </div>

    </div>
</nav>

	<!-- End Navbar -->

<div class="text-right m-3">
    <div class="row">
        <div class="col-12">
            <div class="px-3 bg-transparent">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-8 bg-white shadow">
                                    <div class="row flex-column mr-2">
                                        <h1>{{ $studioService->name }}</h1>
                                        <span>كود الخدمة: {{ $studioService->id }}</span>
                                    </div>
                                    <div class="row my-4 font-weight-bold mr-2">
                                        <span class="ml-4"><i class="fas fa-tag ml-2" style="color:#2f3e3b;"></i>التصنيف: {{ $studioService->category->name }}</span>
                                        <span class="ml-4"><i class="fas fa-bookmark ml-2" style="color:#2f3e3b;"></i>الفئة الفرعية: {{ $studioService->subCategory->name }}</span>
                                        <span class="ml-4"><i class="fas fa-user ml-2" style="color:#2f3e3b;"></i>الجنس: {{ $studioService->gender == 'men' ? 'الرجال' : 'النساء' }}</span>
                                        <span class="ml-4"><i class="fas fa-money-bill ml-2" style="color:#2f3e3b;"></i>السعر: {{ $studioService->price }} ر.س</span>
                                        <span class="ml-4"><i class="fas fa-check-circle ml-2" style="color:#2f3e3b;"></i>التقييم :
                                        @if ($averageRating > 0)
                                            {{ $averageRating }} / 5
                                        @else
                                            <span class="badge badge-danger">لا يوجد تقييم</span>
                                        @endif
                                        </span>
                                    </div>
                                    <hr/>
                                    <!-- Service Details -->
                                    <div class="description mb-4 mr-2">
                                        <h2 class="section-title" style="color: #2f3e3b !important;">تفاصيل الخدمة:</h2>
                                        @foreach (json_decode($studioService->service_details) as $detail)
                                            <ul>
                                                <li class="text-justify text-secondary">{{ $detail }}</li>
                                            </ul>
                                        @endforeach
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="card shadow h-100">
                                        <!-- Seller Logo -->
                                        <img src="{{ asset($studioService->seller->seller_logo) }}" class="card-img-top" alt="Seller Image" style="width: 100%; height: 180px; object-fit: contain;">
                                        
                                        <div class="card-body">
                                            <h5 class="card-title font-weight-bold text-center" style="color: #f08b47;">عن البائع</h5>
                                            <p class="card-text"><i class="fas fa-user" style="color: #f08b47;"></i> الاسم: {{$studioService->seller->first_name}} {{$studioService->seller->last_name}}</p>
                                            <p class="card-text"><i class="fas fa-envelope" style="color: #f08b47;"></i>البريد الإلكتروني: {{$studioService->seller->email}}</p>
                                            <p class="card-text">
                                                <i class="fas fa-star" style="color: #f08b47;"></i> 
                                                التقييم: 
                                                @if ($sellerAverageRating)
                                                    {{ $sellerAverageRating }} / 5
                                                @else
                                                    <span class="badge badge-danger">لا يوجد تقييم</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Booking Section -->
                        <div class="col-sm-12 mt-3 pr-0">
                            <div class="card shadow">
                                <div class="card-header bg-white">
                                    <h3 class="card-title mb-0 text-center" style="color: #2f3e3b !important;">حجز الخدمة</h3>
                                </div>
                                <div class="card-body">
                                <form action="{{ route('customer.bookStudioService') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="studio_service_id" value="{{ $studioService->id }}">
                                    <input type="hidden" name="seller_id" value="{{ $studioService->seller_id }}">

                                    <div class="row">
                                        <!-- Date & Time Selection Row -->
                                        <div class="col-md-6 mb-3">
                                            <label for="date" class="form-label">التاريخ</label>
                                            <input type="text" name="date" id="date" class="form-control flatpickr" placeholder="اختر التاريخ" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="start_time" class="form-label">الوقت</label>
                                            <select id="start_time" class="form-control" name="start_time" required>
                                                <!-- Available times will be populated here -->
                                            </select>
                                        </div>

                                        <!-- Employee Selection & Payment Amount Row -->
                                        <div class="col-md-6 mb-3">
                                            <label for="employee" class="form-label">الموظف</label>
                                            <select class="form-control" name="employee_id" required>
                                                <option value="" disabled selected>اختر الموظف</option>
                                                @foreach ($employees as $id => $name)
                                                    <option value="{{ $id }}">{{ $name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="paid_amount" class="form-label">مبلغ الدفع</label>
                                            <input type="number" name="paid_amount" id="paid_amount" class="form-control" placeholder="ادفع مبلغ أو كامل السعر" required>
                                        </div>

                                        <!-- Total Price Display & Submit Button Row -->
                                        <div class="col-md-12 mb-3">
                                            <label for="price" class="form-label">السعر الإجمالي</label>
                                            <div class="form-control-plaintext border rounded bg-light p-2" id="price">
                                                {{ $studioService->price }} ريال سعودي
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-3 d-flex align-items-end justify-content-center">
                                        <button type="submit" class="btn" style="background-color: #2f3e3b; color: #fff;">احجز الآن</button>
                                    </div>
                                </form>

                                </div>
                            </div>
                        </div>

                    </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery, Bootstrap, and Flatpickr JS -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    // Initialize Flatpickr for date selection
    flatpickr('.flatpickr', { dateFormat: 'Y-m-d' });
</script>

<!-- Include Flatpickr CSS and JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    // Initialize Flatpickr for date and time
    flatpickr("#date", {
        dateFormat: "Y-m-d", // Format for the date
        locale: "ar", // Set locale to Arabic
    });

    flatpickr("#time", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i", // Format for the time
        time_24hr: true, // Use 24-hour format
        locale: "ar", // Set locale to Arabic
    });
</script>

<!-- include script for google map -->
<script src="{{ asset('JS/sellerRegister.js') }}"></script>
<!-- Check employee availability -->
<script src="{{ asset('JS/booking.js') }}"></script>

</body>
</html>

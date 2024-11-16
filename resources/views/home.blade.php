<!-- resources/views/services.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LEEN</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Almarai&display=swap" rel="stylesheet">
    <style>
        body {
            direction: rtl;
            font-family: 'Almarai', sans-serif;
            background-color: #f9fafb;
        }
        .section-title {
            margin-top: 20px;
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light text-white" style="background-color: #2f3e3b;">
    <a class="navbar-brand text-white" href="{{ route('home')}}">LEEN Logo</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="nav d-flex justify-content-between w-100 align-items-center">
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link text-white" href="#homeServices">خدمات المنزل</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#studioServices">خدمات الاستوديو</a>
                </li>
            </ul>
        </div>

        <div>
            @if (Auth::guard('customer')->check())
            
                <a href="{{ route('customer.profile') }}" class="btn btn-outline-success btn-sm">ملفي الشخصي</a>
                <a href="{{ route('customer.logout') }}" class="btn btn-outline-danger btn-sm">تسجيل الخروج</a>
            @else
                <a href="{{ route('customer.loginPage') }}" class="btn btn-success btn-sm">تسجيل الدخول</a>
            @endif
        </div>

    </div>
</nav>

<!-- Home Services Section -->
<div class="container mt-5" id="homeServices">
    <h2 class="section-title text-center">خدمات المنزل</h2>
    <div class="row">
        @foreach($homeServices as $service)
        <div class="col-md-4">
            <div class="card mb-4 shadow">
                <img src="{{ asset($service->seller->seller_logo) ?? 'https://via.placeholder.com/300x200?text=Home+Service+1' }}" class="card-img-top" alt="{{ $service->name }}">
                <div class="card-body text-right">
                    <h5 class="card-title">{{ $service->name }}</h5>
                    <p class="card-text">السعر : {{ $service->price }} ريال</p>
                    <a href="{{ route('homeService.show', $service->id) }}" class="btn" style="background-color: #2f3e3b; color: white;">احجز الان</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Studio Services Section -->
<div class="container mt-5" id="studioServices">
    <h2 class="section-title text-center">خدمات الاستوديو</h2>
    <div class="row">
        @foreach($studioServices as $service)
        <div class="col-md-4">
            <div class="card mb-4 shadow">
                <img src="{{ asset($service->seller->seller_logo) ?? 'https://via.placeholder.com/300x200?text=Studio+Service+1' }}" class="card-img-top" alt="{{ $service->name }}">
                <div class="card-body text-right">
                    <h5 class="card-title">{{ $service->name }}</h5>
                    <p class="card-text"> السعر : {{ $service->price }} ريال </p>
                    <a href="{{ route('studioService.show', $service->id) }}" class="btn" style="background-color: #2f3e3b; color: white;">احجز الان</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

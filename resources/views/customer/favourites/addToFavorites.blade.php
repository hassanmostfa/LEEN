@extends('customer.mainComponents')

@section('title', 'اضافة البائعين في المفضلة')

@section('link_one', ' المفضلة')
@section('link_two', 'اضافة')

@section('content')
@if (Session::has('success'))
    <div class="alert alert-success">{{ Session::get('success') }}</div>
@elseif (Session::has('error'))
    <div class="alert alert-danger">{{ Session::get('error') }}</div>
@endif

@foreach($sellers as $seller)
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header py-2 bg-success text-white d-flex align-items-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-3">
                    <i class="fa-solid fa-heart" style="font-size: 25px;"></i>
                    <h4 class="my-0 flex-grow-1" style="font-size: 20px; font-weight: 400;">اضافة البائعين في المفضلة</h4>
                </div>
            </div>
            <div class="card-body">
            <div class="container mt-4">
                        <div class="row">
                            @foreach ($sellers as $seller)
                                <div class="col-md-4 mb-4">
                                    <div class="card shadow h-100">
                                        <!-- Seller Logo -->
                                        <img src="{{ asset($seller->seller_logo) }}" alt="Seller Logo" class="card-img-top" style="width: 100%; height: 200px; object-fit: contain;">

                                        <div class="card-body">
                                            <!-- Seller Name -->
                                            <h5 class="card-title">{{ $seller->first_name }} {{ $seller->last_name }}</h5>

                                            <!-- Seller Email -->
                                            <p class="card-text text-muted">{{ $seller->email }}</p>

                                            <!-- Add to Favorites Button -->
                                            <form action="{{ route('customer.favourites.store', $seller->id) }}" method="POST" class="d-flex justify-content-center">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-success w-100">إضافة للمفضلة</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection
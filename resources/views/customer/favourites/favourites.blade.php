@extends('customer.mainComponents')

@section('title', 'المفضلة')

@section('link_one', ' المفضلة')
@section('link_two', 'الكل')

@section('content')
@if (Session::has('success'))
    <div class="alert alert-success">{{ Session::get('success') }}</div>
@elseif (Session::has('error'))
    <div class="alert alert-danger">{{ Session::get('error') }}</div>
@endif

<div class="container mt-4">
    @if ($favourites->isEmpty())
        <div class="alert alert-warning text-center">لا توجد بائعين في المفضلة.</div>
    @else
        <div class="row bg-white">
        <div class="card-header py-2 mb-3 bg-success text-white d-flex align-items-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-3">
                    <i class="fa-solid fa-heart" style="font-size: 25px;"></i>
                    <h4 class="my-0 flex-grow-1" style="font-size: 20px; font-weight: 400;">المفضلة</h4>
                </div>
            </div>
            @foreach ($favourites as $favorite)
                <div class="col-md-4 mb-3">
                    <div class="card shadow h-100 p-3">
                        <!-- Seller Logo -->
                        <img src="{{ asset($favorite->seller->seller_logo) }}" alt="Seller Logo" class="card-img-top" style="width: 100%; height: 200px; object-fit: contain;">
                        
                        <div class="card-body">
                            <!-- Seller Name -->
                            <h5 class="card-title">{{ $favorite->seller->first_name }} {{ $favorite->seller->last_name }}</h5>
                            
                            <!-- Remove from Favorites Button -->
                            <form action="{{ route('customer.favourites.destroy', $favorite->id) }}" method="POST" class="d-flex justify-content-center mt-3">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger w-100">إزالة من المفضلة</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

@endsection

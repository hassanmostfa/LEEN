
@extends('customer.mainComponents')

@section('title', 'كل الرسائل')

@section('link_one', ' الرسائل')
@section('link_two', 'الكل')

@section('content')
@if (Session::has('success'))
    <div class="alert alert-success">{{ Session::get('success') }}</div>
@elseif (Session::has('error'))
    <div class="alert alert-danger">{{ Session::get('error') }}</div>
@endif
@if (count($sellers) > 0)
<div class="container sellers mt-4">
    <div class="row">
        @foreach($sellers as $data)
            @php
                $seller = $data['seller'];
                $latestMessage = $data['latestMessage'];
                $unreadCount = $data['unreadCount'];
            @endphp

            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ $seller->seller_logo ? asset($seller->seller_logo) : 'https://via.placeholder.com/150' }}" 
                                 width="70" height="70" alt="seller image" class="rounded-circle" style="object-fit: contain;">
                            <div>
                                <h5 class="card-title mb-1">{{ $seller->first_name }} {{ $seller->last_name }}</h5>
                                
                                @if ($unreadCount > 0)
                                    <span class="badge bg-primary">({{ $unreadCount }} رسائل جديدة)</span>
                                @endif

                                @if ($latestMessage)
                                    <p class="text-muted mb-0">{{ Str::limit($latestMessage->message, 50) }}</p>
                                @else
                                    <p class="text-muted mb-0">لا توجد رسائل جديدة</p>
                                @endif
                            </div>
                        </div>

                        <div>
                            <a href="{{ route('customer.chat', $seller->id) }}" class="btn btn-outline-primary">مراسلة</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@else
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12"> 
                <div class="card">
                    <div class="card-body text-center">
                        <h4>لا يوجد رسائل حتى الآن</h4> 
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif



@endsection
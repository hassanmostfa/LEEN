@extends('seller.mainComponents')

@section('title', 'كل العملاء')


@section('link_one', 'العملاء')
@section('link_two', 'الكل')


@section('content')
@if (Session::has('success'))
    <div class="alert alert-success">{{ Session::get('success') }}</div>
@elseif (Session::has('error'))
    <div class="alert alert-danger">{{ Session::get('error') }}</div>
@endif

@if (count($clients) > 0)
<div class="container clients mt-4">
    <div class="row">
        @foreach($clients as $data)
            @php
                $client = $data['client'];
                $latestMessage = $data['latestMessage'];
                $unreadCount = $data['unreadCount'];
            @endphp

            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ $client->profile_photo ? asset($client->profile_photo) : asset('user-assets/images/chat.png') }}" 
                                 width="70" height="70" alt="client image" class="rounded-circle">
                            <div>
                                <h5 class="card-title mb-1">{{ $client->first_name }} {{ $client->last_name }}</h5>
                                
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
                            <a href="{{ route('seller.chat', $client->id) }}" class="btn btn-outline-primary">مراسلة</a>
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
                        <h4>لا يوجد عملاء حتى الآن</h4> 
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

@endsection
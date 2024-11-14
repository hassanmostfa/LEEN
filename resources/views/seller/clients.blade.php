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

<div class="container clients mt-4">
    <div class="row">
        <!-- Loop through clients data here -->
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
                            <img src="{{ asset($client->image ?? 'https://via.placeholder.com/150') }}" width="70" height="70" alt="customer image" class="rounded-circle">
                            <div>
                                <h5 class="card-title">{{ $client->first_name . ' ' . $client->last_name }}</h5>
                                
                                <p class="mb-0 text-muted">
                                    @if ($unreadCount > 0)
                                        <span class="badge bg-primary">({{ $unreadCount }} رسائل جديدة)</span>
                                    @endif
                                </p>

                                @if($latestMessage)
                                    <p class="text-muted mb-0">{{ Str::limit($latestMessage->message, 50) }}</p>
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

@endsection
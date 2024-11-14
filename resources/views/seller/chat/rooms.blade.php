@extends('seller.mainComponents')

@section('title', 'كل الرسائل')


@section('link_one', 'الرسائل')
@section('link_two', 'الكل')


@section('content')
@if (Session::has('success'))
    <div class="alert alert-success">{{ Session::get('success') }}</div>
@elseif (Session::has('error'))
    <div class="alert alert-danger">{{ Session::get('error') }}</div>
@endif

<div class="container">
    <h3>Chat Rooms</h3>
    <div class="row">
        @foreach ($chatRooms as $chatRoom)
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">{{ $chatRoom->customers->first()->name ?? 'Customer' }}</h5>
                            <p class="mb-0 text-muted">
                                Last message: {{ $chatRoom->messages->first()->message ?? 'No messages yet' }}
                            </p>
                            <small class="text-muted">
                                {{ $chatRoom->messages->first()->created_at->diffForHumans() ?? '' }}
                            </small>
                        </div>

                        <div>
                            @if ($chatRoom->unread_messages_count > 0)
                                <span class="badge bg-primary">
                                    {{ $chatRoom->unread_messages_count }} new messages
                                </span>
                            @endif
                            <a href="#" class="btn btn-outline-primary">Open Chat</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>


@endsection
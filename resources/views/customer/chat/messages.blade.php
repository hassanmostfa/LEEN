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

<div class="container bg-white">
    <h3 class="p-2">مراسلة : {{ $chatRoom->seller->first_name }} {{ $chatRoom->seller->last_name }}</h3>
    <div class="chat-box" id="chatBox">
        @foreach ($messages as $message)
            <div class="d-flex justify-content-{{ $message->sender_type == 'App\Models\Customers\Customer' ? 'start' : 'end' }} mb-3">
                <div style="width: 40%;" class="{{ $message->sender_type == 'App\Models\Customers\Customer' ? 'my-message' : 'their-message' }} rounded p-2">
                    <div class="mb-0">{{ $message->message }}</div>
                    <small>{{ $message->created_at->diffForHumans() }}</small>
                    <small class="float-start">{{ $message->is_read ? 'مقروء' : 'غير مقروء' }}</small>
                </div>
            </div>
        @endforeach
    </div>


    <form action="{{ route('customer.chat.send')}}" method="POST" class="py-2  rounded">
    @csrf
    <input type="hidden" name="chat_room_id" value="{{ $chatRoom->id }}">
    
    <div class="d-flex align-items-center mb-3">
        <textarea name="message" class="form-control me-2" rows="1" placeholder="اكتب رسالتك هنا..." required></textarea>
        <button type="submit" class="btn btn-primary" style="width: 100px;">ارسال <i class="fas fa-paper-plane"></i> </button>
    </div>

</form>

</div>

<style>
    .chat-box {
        border: 1px solid #ccc;
        padding: 10px;
        height: 300px;
        overflow-y: scroll;
        margin-bottom: 10px;
    }
    .my-message {
        text-align: right;
        background-color: #007bff;
        padding: 5px;
        border-radius: 5px;
        margin: 5px;
        color: #fff;
    }
    .their-message {
        text-align: right;
        background-color: #f1f1f1;
        padding: 5px;
        border-radius: 5px;
        margin: 5px;
    }
</style>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Scroll to the bottom of the chat box when the page is loaded
        var chatBox = document.getElementById('chatBox');
        chatBox.scrollTop = chatBox.scrollHeight; // Scroll to the bottom
    });
</script>
@endsection
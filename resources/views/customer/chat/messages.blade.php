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

<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
    // Enable Pusher logging - don't include this in production
    Pusher.logToConsole = true;

    // Initialize Pusher
    var pusher = new Pusher('02c14683a1bbc058e455', {
        cluster: 'eu',
        authEndpoint: '/broadcasting/auth/customer', // Updated endpoint for customers
        auth: {
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}', // CSRF Token for security
            }
        }
    });

    // Subscribe to the private channel
    var channel = pusher.subscribe('private-chat-room.{{ $chatRoom->id }}');

    // Bind to the new-message event
    channel.bind('new-message', function(data) {
        console.log('New message received:', data);

        // Extract message details
        const message = data.message;
        const senderType = data.sender_type; // E.g., 'App\\Models\\Customers\\Customer' or 'App\\Models\\Sellers\\Seller'
        const createdAt = data.created_at; // E.g., '2 minutes ago'
        const isRead = data.is_read ? 'مقروء' : 'غير مقروء'; // Read status

        // Determine alignment and styling
        const alignment = senderType === 'App\\Models\\Customers\\Customer' ? 'start' : 'end';
        const messageClass = senderType === 'App\\Models\\Customers\\Customer' ? 'my-message' : 'their-message';

        // Create the message HTML structure
        const messageHtml = `
            <div class="d-flex justify-content-${alignment} mb-3">
                <div style="width: 40%;" class="${messageClass} rounded p-2">
                    <div class="mb-0">${message}</div>
                    <small>${createdAt}</small>
                    <small class="float-start">${isRead}</small>
                </div>
            </div>
        `;

        // Append the message to the chat box
        const chatBox = document.getElementById('chatBox');
        chatBox.insertAdjacentHTML('beforeend', messageHtml);

        // Scroll to the bottom of the chat box for the latest message
        chatBox.scrollTop = chatBox.scrollHeight;
    });
</script>


<script>
    $(document).ready(function() {
        // Flag to prevent multiple submissions
        let isSubmitting = false;

        // Handle message form submission
        $('form').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            if (isSubmitting) {
                return; // Exit if already submitting
            }

            isSubmitting = true; // Mark as submitting

            let formData = $(this).serialize(); // Serialize form data

            $.ajax({
                url: $(this).attr('action'), // Use the form's action URL
                method: 'POST',
                data: formData,
                success: function(response) {
                    console.log('Message sent successfully:', response);

                    // Clear the message input field
                    $('textarea[name="message"]').val('');

                    // Determine the sender type (current user or the other user)
                    let senderType = response.data.sender_type; // Should be 'App\\Models\\Sellers\\Seller' or 'App\\Models\\Customers\\Customer'
                    let alignment = senderType === 'App\\Models\\Sellers\\Seller' ? 'start' : 'end';
                    let messageClass = senderType === 'App\\Models\\Sellers\\Seller' ? 'my-message' : 'their-message';

                    // Construct the message HTML
                    let newMessage = `
                        <div class="d-flex justify-content-${alignment} mb-3">
                            <div style="width: 40%;" class="${messageClass} rounded p-2">
                                <div class="mb-0">${response.data.message}</div>
                                <small>الآن</small>
                                <small class="float-start">${response.data.is_read ? 'مقروء' : 'غير مقروء'}</small>
                            </div>
                        </div>
                    `;

                    // Append the new message to the chat box
                    // $('#chatBox').append(newMessage);

                    // Scroll to the bottom of the chat box
                    $('#chatBox').scrollTop($('#chatBox')[0].scrollHeight);

                    // Reset submission flag
                    isSubmitting = false;
                },
                error: function(error) {
                    console.error('Error sending message:', error);
                    alert('Failed to send message. Please try again.');
                    // Reset submission flag even if error occurs
                    isSubmitting = false;
                }
            });
        });
    });
</script>



<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Scroll to the bottom of the chat box when the page is loaded
        var chatBox = document.getElementById('chatBox');
        chatBox.scrollTop = chatBox.scrollHeight; // Scroll to the bottom
    });
</script>
@endsection
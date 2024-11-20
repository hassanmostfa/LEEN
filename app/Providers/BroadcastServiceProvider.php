<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;
use App\Models\Sellers\Seller;
use App\Models\Customers\Customer;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Registering the broadcasting routes for authorization
        Broadcast::routes();

        // Defining the authorization logic for channels
        Broadcast::channel('chat-room.{chatRoomId}', function ($user, $chatRoomId) {
            // Check if the user is part of the chat room or is authorized to access it
            // You can modify this condition based on your application logic (e.g., check if the user is a seller, customer, etc.)
            return $user->hasAccessToChatRoom($chatRoomId); // Example function, you can implement as needed
        });

        // Load channel-specific authorization logic from routes/channels.php
        require base_path('routes/channels.php');
    }
}

<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Auth;
use App\Models\Sellers\ChatRoom;
use App\Models\Sellers\Seller;
use App\Models\Customers\Customer;
/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chat-room.{chatRoomId}', function ($user, $chatRoomId) {
    // Find the chat room by ID
    $chatRoom = ChatRoom::find($chatRoomId);
    
    // Check if the chat room exists
    if ($chatRoom) {
        // Check if the user is a seller or customer and authorize based on that
        if ($user instanceof \App\Models\Sellers\Seller) {
            return $chatRoom->canAccessChatRoomAsSeller($user);
        } elseif ($user instanceof \App\Models\Customers\Customer) {
            return $chatRoom->canAccessChatRoomAsCustomer($user);
        }
    }

    return false; // Unauthorized access if the chat room does not exist or user can't access
});



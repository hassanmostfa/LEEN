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
    \Log::info("Checking access for user ID: " . $user->id . " in chat room: " . $chatRoomId);

    $chatRoom = \App\Models\Sellers\ChatRoom::find($chatRoomId);
    if (!$chatRoom) {
        \Log::error("Chat room not found: " . $chatRoomId);
        return false;
    }

    // Check if the user is a seller
    if ($user instanceof \App\Models\Sellers\Seller) {
        $access = $chatRoom->canAccessChatRoomAsSeller($user);
        \Log::info("Seller access check: " . ($access ? "GRANTED" : "DENIED"));
        return $access;
    }

    // Check if the user is a customer
    if ($user instanceof \App\Models\Customers\Customer) {
        $access = $chatRoom->canAccessChatRoomAsCustomer($user);
        \Log::info("Customer access check: " . ($access ? "GRANTED" : "DENIED"));
        return $access;
    }

    \Log::error("Unauthorized user type for chat room access.");
    return false;
});




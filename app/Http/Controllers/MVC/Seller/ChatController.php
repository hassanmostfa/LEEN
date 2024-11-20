<?php

namespace App\Http\Controllers\MVC\Seller;

use App\Events\NewMessage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Sellers\ChatRoom;
use App\Models\Sellers\Message;

class ChatController extends Controller
{
    // Start a new chat or continue an existing one
    public function startOrResumeChat($customerId)
    {
        $sellerId = auth()->user()->id; // Assume the seller is authenticated

        // Check if a chat session already exists between this seller and customer
        $chatRoom = ChatRoom::where('seller_id', $sellerId)
            ->where('customer_id', $customerId)
            ->first();

        // If no session exists, create a new one
        if (!$chatRoom) {
            $chatRoom = ChatRoom::create([
                'seller_id' => $sellerId,
                'customer_id' => $customerId,
            ]);
        }

        // Redirect to the messages view with the chat session
        return redirect()->route('seller.chat.messages', $chatRoom->id);
    }

    // Display the messages view for an existing chat session
    public function showMessages($chatRoomId)
    {
        $chatRoom = ChatRoom::findOrFail($chatRoomId);
    
        // Retrieve the messages in ascending order of creation
        $messages = $chatRoom->messages()->orderBy('created_at', 'asc')->get();

        // update is_read to true
        foreach ($messages as $message) {
            if ($message->sender_type == 'App\Models\Customers\Customer') {
                $message->update(['is_read' => true]);
            }
        }


        return view('seller.chat.messages', compact('chatRoom', 'messages'));
    }
    

    // Store a new message in the chat session
    public function sendMessage(Request $request)
    {
        $request->validate([
            'chat_room_id' =>'required|exists:chat_rooms,id',
           'message' =>'required|string',
        ]);
    
        // Identify the current user (either a seller or a customer)
        $sender = auth()->user();
    
        // Save the message
        $message = Message::create([
            'chat_room_id' => $request->chat_room_id,
           'sender_id' => $sender->id,
           'sender_type' => get_class($sender),  // E.g., 'App\Models\Seller' or 'App\Models\Customer'
           'message' => $request->message,
            'is_read' => false,
        ]);
            
        // Broadcast the new message using Laravel Echo
        event(new NewMessage($message));
    
        // Return a JSON response for confirmation
        return response()->json([
            'status' => 'success',
            'message' => 'Message sent successfully',
            'data' => $message,
        ]);
}
    

    // get all chat rooms for the current seller
    public function getSellerChatRooms()
    {
        // Retrieve the authenticated seller's ID
        $sellerId = Auth::guard('seller')->user()->id;
    
        // Fetch chat rooms associated with this seller
        $chatRooms = ChatRoom::where('seller_id', $sellerId)
            ->with([
                'messages' => function ($query) {
                    $query->orderBy('created_at', 'desc')->limit(1); // Fetch the latest message
                },
                'messages as unread_messages_count' => function ($query) use ($sellerId) {
                    $query->where('is_read', false)
                        ->where('sender_type', '!=', 'App\Models\Sellers\Seller');
                        // Count unread messages not sent by the seller
                },
                'customer' // Assuming there's a relationship to retrieve customer details
            ])
            ->get();
    
        return view('seller.chat.rooms', compact('chatRooms'));
    }
    

    

}

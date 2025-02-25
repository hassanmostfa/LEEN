<?php

namespace App\Http\Controllers\API\Sellers;

use App\Events\NewMessage;
use App\Http\Controllers\Controller;
use App\Http\Resources\ChatRoomResource;
use App\Http\Resources\MessagesResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Sellers\ChatRoom;
use App\Models\Sellers\Message;

class ChatController extends Controller
{
    // Start a new chat or continue an existing one
    public function startOrResumeChat($customerId)
    {
        try{
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
            return response()->json(['success' => true,'data' => new ChatRoomResource($chatRoom)]);
        }catch(\Exception $e){
            return response()->json(['success' => false,'message' => $e->getMessage()]);
        }
    }
    /***************************************************************************************/
    // Display the messages view for an existing chat session
    public function showMessages($chatRoomId)
    {
        try{
            $chatRoom = ChatRoom::findOrFail($chatRoomId);
    
            // Retrieve the messages in ascending order of creation
            $messages = $chatRoom->messages()->orderBy('created_at', 'asc')->get();
    
            // update is_read to true
            foreach ($messages as $message) {
                if ($message->sender_type == 'App\Models\Customers\Customer') {
                    $message->update(['is_read' => true]);
                }
            }
            return response()->json(['success' => true,'data' =>$messages]);
        }catch(\Exception $e){
            return response()->json(['success' => false,'message' => $e->getMessage()]);
        }
    }
    
    /****************************************************************************************/

    // Store a new message in the chat session
    public function sendMessage(Request $request)
    {
        $request->validate([
            'chat_room_id' =>'required|exists:chat_rooms,id',
            'message' =>'required|string',
        ]);
    
        try{
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
            'message' => 'تم ارسال الرسالة بنجاح',
            'data' => $message,
        ]);
        }catch(\Exception $e){
            return response()->json(['success' => false,'message' => $e->getMessage()]);
        }
}
}

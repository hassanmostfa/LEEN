<?php

namespace App\Models\Sellers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customers\Customer;

class ChatRoom extends Model
{
    use HasFactory;

    protected $table = 'chat_rooms';

    protected $fillable = [
        'seller_id',
        'customer_id',
    ];
 // Define the relationship with Seller (One to Many)
 public function seller()
 {
     return $this->belongsTo(Seller::class);
 }

 // Define the relationship with Customer (One to Many)
 public function customer()
 {
     return $this->belongsTo(Customer::class);
 }

 // Check if the seller can access the chat room
 public function canAccessChatRoomAsSeller(Seller $seller)
 {
     return $this->seller_id === $seller->id;
 }

 // Check if the customer can access the chat room
 public function canAccessChatRoomAsCustomer(Customer $customer)
 {
     return $this->customer_id === $customer->id;
 }

    public function messages(){
        return $this->hasMany(Message::class);
    }

    // In your ChatRoom model
    public $timestamps = true;
}

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

    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function messages(){
        return $this->hasMany(Message::class);
    }

    // In your ChatRoom model
    public $timestamps = true;
    
}

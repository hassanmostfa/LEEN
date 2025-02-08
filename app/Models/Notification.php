<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Customers\Customer;
use App\Models\Sellers\Seller;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    protected $fillable = [
        'customer_id',
        'seller_id',
        'title',
        'sender_type',
        'content',
        'is_read',
        'category',
    ];

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function seller(){
        return $this->belongsTo(Seller::class);
    }
}

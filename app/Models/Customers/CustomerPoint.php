<?php

namespace App\Models\Customers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPoint extends Model
{
    use HasFactory;

    protected $table = 'customers_points';

    protected $fillable = [
        'customer_id',
        'seller_id',
        'points',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function seller(){
        return $this->belongsTo(Seller::class);
    }
}

<?php

namespace App\Models\Customers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sellers\Seller;

use App\Models\Customers\Customer;

class Favourit extends Model
{
    use HasFactory;

    protected $table = 'favorites';

    protected $fillable = [
        'customer_id',
        'seller_id',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function seller(){
        return $this->belongsTo(Seller::class, 'seller_id');
    }
}

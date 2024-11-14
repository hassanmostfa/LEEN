<?php

namespace App\Models\Customers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Sellers\HomeService;
use App\Models\Sellers\StudioService;
use App\Models\Sellers\Seller;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'seller_id',
        'rating',
        'review',
        'service_id',
        'service_type',
    ];
    
    public function service()
    {
        return $this->morphTo();
    }

    public function seller(){
        return $this->belongsTo(Seller::class , 'seller_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function homeService(){
        return $this->belongsTo(HomeService::class);
    }

    public function studioService(){
        return $this->belongsTo(StudioService::class);
    }
}


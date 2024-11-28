<?php

namespace App\Models\Sellers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customers\HomeServiceBookingItem;
use App\Models\Customers\Rating;
use App\Models\Customers\HomeBooking;
use App\Models\Admin\Category;
use App\Models\Admin\SubCategory;

class HomeService extends Model
{
    use HasFactory;

    protected $table = 'home_services';
    protected $fillable = [
        'seller_id',
        'name',
        'gender',
        'category',
        'sub_category',
        'service_details',
        'employees',
        'price',
        'booking_status',
        'discount',
        'percentage',
        'points',
    ];

    public function seller(){
        return $this->belongsTo(Seller::class);
    }

    public function employee(){
        return $this->hasMany(Employee::class);
    }

    public function homeServiceBookingItems(){
        return $this->hasMany(HomeServiceBookingItem::class , 'home_service_booking_id' , 'id');
    }
    
    public function ratings()
    {
        return $this->morphMany(Rating::class, 'service');
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function subCategory(){
        return $this->belongsTo(SubCategory::class);
    }

    public function home_booking(){
        return $this->hasMany(HomeBooking::class);
    }

}

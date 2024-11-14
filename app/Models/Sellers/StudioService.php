<?php

namespace App\Models\Sellers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Sellers\Seller;
use App\Models\Sellers\Employee;
use App\Models\Customers\StudioBooking;
use App\Models\Customers\StudioServiceBookingItem;
use App\Models\Customers\Rating;
use App\Models\Admin\Category;
use App\Models\Admin\SubCategory;
class StudioService extends Model
{
    use HasFactory;

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

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
    
    public function employee(){
        return $this->belongsTo(Employee::class);
    }

    public function studioBooking(){
        return $this->hasMany(StudioBooking::class);
    }

    public function studioServiceBookingItems(){
        return $this->hasMany(StudioServiceBookingItem::class , 'studio_service_id' , 'id');
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
}
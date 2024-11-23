<?php

namespace App\Models\Customers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sellers\HomeService;
use App\Models\Sellers\StudioService;
use App\Models\Sellers\Employee;
use App\Models\Sellers\Seller;
use App\Models\Customers\StudioServiceBookingItem;

class StudioBooking extends Model
{
    use HasFactory;

    
    protected $table = 'studio_services_bookings';
    
    protected $fillable = [
        'customer_id',
        'studio_service_id',
        'employee_id',
        'seller_id',
        'date',
        'start_time',
        'payment_status',
        'booking_status',
        'paid_amount',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function homeService()
    {
        return $this->belongsTo(HomeService::class);
    }

    public function studioService()
    {
        return $this->belongsTo(StudioService::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function studioServiceBookingItems()
    {
        return $this->hasMany(StudioServiceBookingItem::class , 'studio_service_booking_id' , 'id');
    }


}

<?php

namespace App\Models\Customers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sellers\HomeService;
use App\Models\Sellers\Employee;
use App\Models\Sellers\Seller;

class HomeBooking extends Model
{
    use HasFactory;

    protected $table = 'home_services_bookings';
    
    protected $fillable = [
        'customer_id',
        'home_service_id',
        'employee_id',
        'seller_id',
        'date',
        'start_time',
        'end_time',
        'location',
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

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function homeServiceBookingItems()
{
    return $this->hasMany(HomeServiceBookingItem::class, 'home_service_booking_id', 'id');
}

}

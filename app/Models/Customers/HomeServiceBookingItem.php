<?php

namespace App\Models\Customers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Sellers\HomeService;
use App\Models\Sellers\Employee;

class HomeServiceBookingItem extends Model
{
    use HasFactory;

    protected $table = 'home_service_booking_items';

    protected $fillable = [
        'home_service_booking_id',
        'service_id',
        'employee_id',  
    ];

    public function service()
    {
        return $this->belongsTo(HomeService::class, 'service_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function homeServiceBooking()
    {
        return $this->belongsTo(HomeBooking::class, 'home_service_booking_id');  
    }

}

<?php

namespace App\Models\Customers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Sellers\StudioService;
use App\Models\Sellers\Employee;

use App\Models\Customers\StudioBooking;



class StudioServiceBookingItem extends Model
{
    use HasFactory;

    protected $table = 'studio_service_booking_items';

    protected $fillable = [
        'studio_service_booking_id',
        'service_id',
        'employee_id',
    ];


    
    public function service()
    {
        return $this->belongsTo(StudioService::class, 'service_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function studioServiceBooking()
    {
        return $this->belongsTo(StudioBooking::class, 'studio_service_booking_id');  
    }

}

<?php

namespace App\Models\Sellers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Customers\HomeServiceBookingItem;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees';
    protected $fillable = [
        'name',
        'position',
        'seller_id',
        'image',
        'status',
    ];

    public function seller(){
        return $this->belongsTo(Seller::class, 'seller_id');
    }

public function homeServices(){
    return $this->hasMany(HomeService::class);
    }

    public function studioServices(){
        return $this->hasMany(StudioService::class);
    }
    
    public function employeeTimetables(){
        return $this->hasMany(EmployeeTimetable::class);
    }

    public function homeServiceBookingItems(){
        return $this->hasMany(HomeServiceBookingItem::class , 'employee_id' , 'id');
    }
}

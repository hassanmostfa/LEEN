<?php

namespace App\Models\Sellers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    use HasFactory;

    protected $table = 'employees_timetables';

    protected $fillable = ['employee_id', 'seller_id', 'date', 'start_time', 'end_time', 'status'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

}


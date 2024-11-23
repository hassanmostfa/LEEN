<?php

namespace App\Models\Sellers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerTimetable extends Model
{
    use HasFactory;

    protected $table = 'sellers_timetables';

    protected $fillable = [
        'seller_id',
        'day',
        'start_time',
        'end_time',
    ];

    public function seller(){
        return $this->belongsTo(Seller::class);
    }
}

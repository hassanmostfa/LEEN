<?php

namespace App\Models\Sellers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reel extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'reel',
        'description',
    ];

    public function seller(){
        return $this->belongsTo(Seller::class);
    }
}

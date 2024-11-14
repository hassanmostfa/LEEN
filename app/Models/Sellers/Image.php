<?php

namespace App\Models\Sellers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'image',
        'discription'
    ];

    public function seller(){
        return $this->belongsTo(Seller::class, 'seller_id');
    }
}

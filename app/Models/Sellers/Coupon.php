<?php

namespace App\Models\Sellers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'code',
        'discount_value',
        'expires_at',
        'usage_limit',
        'usage_count',
    ];

    // In your Coupon model
protected $casts = [
    'expires_at' => 'datetime',
];

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
}

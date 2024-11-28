<?php

namespace App\Models\Sellers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Customers\Favourit;
use App\Models\Customers\CustomerPoint;
use App\Models\Customers\Rating;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
class Seller extends Authenticatable
{
    use HasFactory , HasApiTokens , Notifiable;

    protected $table = 'sellers';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'phone_verified_at',
        'status',
        'request_status',
        'seller_logo',
        'seller_banner',
        'license',
        'location',
        'request_rejection_reason',
        'service_type'
    ];

    public function employee(){
        return $this->hasMany(Employee::class, 'seller_id');
    }

    public function studioService(){
        return $this->hasMany(StudioService::class, 'seller_id');
    }

    public function homeService(){
        return $this->hasMany(HomeService::class, 'seller_id');
    }

    public function images(){
        return $this->hasMany(Image::class, 'seller_id');
    }

    public function reels(){
        return $this->hasMany(Reel::class, 'seller_id');
    }

    public function coupons(){
        return $this->hasMany(Coupon::class, 'seller_id');
    }

    public function favourites(){
        return $this->hasMany(Favourit::class, 'seller_id');
    }

    public function chatRooms(){
        return $this->hasMany(ChatRoom::class, 'seller_id');
    }

    public function messages()
    {
        return $this->morphMany(Message::class, 'sender');
    }

    public function customerPoints(){
        return $this->hasMany(CustomerPoint::class, 'seller_id');
    }

    public function ratings(){
        return $this->hasMany(Rating::class, 'seller');
    }

    public function sellerTimetable(){
        return $this->hasMany(SellerTimetable::class, 'seller_id');
    }
}

<?php

namespace App\Models\Customers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Sellers\ChatRoom;
use App\Models\Sellers\Message;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use HasFactory , HasApiTokens , Notifiable;

    protected $table = 'customers';
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'location',
        'password',
        'phone',
        'phone_verified_at',
        'status',
        'image',
    ];

    public function homeBookings(){

        return $this->hasMany(HomeBooking::class, 'customer_id', 'id');
    }

    public function studioBookings(){

        return $this->hasMany(StudioBooking::class, 'customer_id', 'id');
    }

    public function favourits(){ 
        return $this->hasMany(Favourit::class, 'customer_id', 'id');
    }

    public function chatRooms(){
        return $this->hasMany(ChatRoom::class, 'customer_id');
    }

    public function messages(){
        return $this->morphMany(Message::class, 'sender');
    }
    
    public function customerPoints(){
        return $this->hasMany(CustomerPoint::class, 'customer_id');
    }

}

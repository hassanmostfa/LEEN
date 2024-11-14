<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'image',
    ];


    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }

    public function home_services(){
        return $this->hasMany(HomeService::class);
    }

    public function studio_services(){
        return $this->hasMany(StudioService::class);
    }

}

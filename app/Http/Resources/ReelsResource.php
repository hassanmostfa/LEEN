<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Customers\Rating;
class ReelsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
         // Get the average rating for the seller
         $averageRating = Rating::where('seller_id', $this->seller->id)->avg('rating');
        return [
            'id' => $this->id,
            'seller' => [
                'id' => $this->seller->id,
                'first_name' => $this->seller->first_name,
                'last_name' => $this->seller->last_name,
                'seller_logo' => $this->seller->seller_logo,
                'seller_banner' => $this->seller->seller_banner,
                'location' => $this->seller->location,
                'average_rating' => round($averageRating, 1),
            ],
            'reel' => url($this->reel),
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

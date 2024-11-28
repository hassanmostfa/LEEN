<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChatRoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'customer' => [
                'id' => $this->customer->id,
                'first_name' => $this->customer->first_name,
                'last_name' => $this->customer->last_name,
                'phone' => $this->customer->phone,
                'image' => url($this->customer->image),
            ],
            'seller' => [
                'id' => $this->seller->id,
                'first_name' => $this->seller->first_name,
                'last_name' => $this->seller->last_name,
                'phone' => $this->seller->phone,
                'seller_logo' => url($this->seller->seller_logo),
                'seller_banner' => url($this->seller->seller_banner),
            ],
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SellerResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'phone_verified_at' => $this->phone_verified_at ? $this->phone_verified_at : null,
            'status' => $this->status,
            'request_status' => $this->request_status,
            'seller_logo' => url($this->seller_logo),
            'seller_banner' => url($this->seller_banner),
            'license' => $this->license,
            'location' => $this->location,
            'request_rejection_reason' => $this->request_rejection_reason,
            'service_type' => $this->service_type,
            'created_at' => $this->created_at->toISOString(),
            'updated_at' => $this->updated_at->toISOString(),
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HomeBookingResource extends JsonResource
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
        'home_service' => $this->homeService,
        'customer' => $this->customer,
        'seller' => $this->seller,
        'employee' => ['id' => $this->employee->id, 'name' => $this->employee->name ,'position' => $this->employee->position , 'image' => $this->employee->image],
        'date' => $this->date,
        'start_time' => $this->start_time,
        'payment_status' => $this->payment_status,
        'booking_status' => $this->booking_status,
        'location' => $this->location,
        'paid_amount' => $this->paid_amount,
        'copoun_discount' => $this->copoun_discount,
        'service_discount' => $this->service_discount,
        'request_rejection_reason' => $this->request_rejection_reason,
        'additionalHomeServiceBookingItems' => $this->homeServiceBookingItems->map(function ($item) {
            return [
                'service' => $item->service,
                'employee' => ['id' => $item->employee->id, 'name' => $item->employee->name ,'position' => $item->employee->position , 'image' => $item->employee->image],
            ];
        }),
        'created_at' => $this->created_at->toDateTimeString(),
        'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}

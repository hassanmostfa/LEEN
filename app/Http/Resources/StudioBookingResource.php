<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudioBookingResource extends JsonResource
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
            'studio_service' => $this->studioService,
            'customer' => $this->customer,
            'seller' => $this->seller,
            'employee' => ['id' => $this->employee->id, 'name' => $this->employee->name ,'position' => $this->employee->position],
            'date' => $this->date,
            'start_time' => $this->start_time,
            'payment_status' => $this->payment_status,
            'booking_status' => $this->booking_status,
            'paid_amount' => $this->paid_amount,
            'request_rejection_reason' => $this->request_rejection_reason,
            'additionalStudioServiceBookingItems' => $this->studioServiceBookingItems->map(function ($item) {
                return [
                    'service' => $item->service,
                    'employee' => ['id' => $item->employee->id, 'name' => $item->employee->name ,'position' => $item->employee->position],
                ];
            }),
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
            ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Customers\Rating;

class StudioServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // Calculate the average rating for the specific home service
        $averageRating = $this->ratings()->avg('rating');
        $averageRating = number_format($averageRating, 1); // Format to 1 decimal place

        // Calculate the average rating for all home services of this seller
        $sellerAverageRating = Rating::where('seller_id', $this->seller_id)->avg('rating');
        $sellerAverageRating = number_format($sellerAverageRating, 1); // Format to 1 decimal place


        // Fetch employee details based on employee IDs stored in the 'employees' field
        $employeeIds = json_decode($this->employees); // Decoding the JSON string to get the array of employee IDs
    
        // Assuming you have an Employee model and the IDs are stored in the 'employees' attribute
        $employees = \App\Models\Sellers\Employee::whereIn('id', $employeeIds)->get(['id', 'name']);
    
        // Return the transformed data
        return [
            'id' => $this->id,
            'seller' => ['id' => $this->seller->id, 'first_name' => $this->seller->first_name, 'last_name' => $this->seller->last_name, 'seller_logo' => url($this->seller->seller_logo), 'seller_banner' => url($this->seller->seller_banner)],
            'category' => ['id' => $this->category->id, 'name' => $this->category->name,'image' => url($this->category->image)],
            'sub_category' => ['id' => $this->subCategory->id, 'name' => $this->subCategory->name,'image' => url($this->subCategory->image)],
            'name' => $this->name,
            'gender' => $this->gender,
            'service_details' => $this->service_details,
            'employees' => $employees, // Include the employee details
            "price" => $this->price,
            "booking_status" => $this->booking_status,
            "discount" => $this->discount,
            "percentage" => $this->percentage,
            "points" => $this->points,
            "service_average_rating" => $averageRating, // Add average rating for this home service
            "seller_average_rating" => $sellerAverageRating, // Add average rating for the seller
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}

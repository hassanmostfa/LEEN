<?php

namespace App\Http\Controllers\API\Customers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sellers\HomeService;
use App\Models\Sellers\StudioService;
use App\Models\Customers\Rating;
use App\Models\Notification;
class RatingController extends Controller
{
    public function store(Request $request)
    {
        try{
            $validatedData = $request->validate([
                'service_id' => 'required|integer',
                'service_type' => 'required|string',
                'rating' => 'required|integer|min:1|max:5',
                'review' => 'nullable|string|max:255',
            ]);
        
            // Determine the model based on service_type
            if ($validatedData['service_type'] === 'home') {
                $service = HomeService::find($validatedData['service_id']);
            } else {
                $service = StudioService::find($validatedData['service_id']);
            }
        
            if ($service) {
                $service->ratings()->create([
                    'service_id' => $service->id,
                    'customer_id' => auth()->user()->id,
                    'seller_id' => $service->seller_id,
                    'rating' => $validatedData['rating'],
                    'review' => $validatedData['review'],
                ]);
            }
        
        // Create a notification for the service rating
        Notification::create([
            'customer_id' => auth()->user()->id,
            'seller_id' => $service->seller_id,
            'title' => 'تقييم جديد!',
            'sender_type' => 'customer',
            'content' => 'العميل ' . auth()->user()->first_name . ' ' . auth()->user()->last_name . ' قيمك ' . $validatedData['rating'] . ' نجوم لخدمة ' . $service->name . ' وكتب: ' . $validatedData['review'],
            'category' => 'ratings',
        ]);

            return response()->json(['status' => 'success', 'message' => 'تم تقييم الخدمة بنجاح']);
        }
        catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }

    /*************************************************************************************/
// Get all ratings for a specific seller with count and average rating
public function getSellerRatings($sellerId)
{
    try {
        // Fetch ratings with customer details
        $ratings = Rating::where('seller_id', $sellerId)->with('customer')->get();

        // Calculate the total number of ratings
        $ratingsCount = $ratings->count();

        // Calculate the average rating, ensuring no division by zero
        $averageRating = $ratingsCount > 0 ? $ratings->avg('rating') : 0;


        return response()->json([
            'status' => 'success',
            'data' => $ratings,
            'ratings_count' => $ratingsCount,
            'average_rating' => round($averageRating , 1) // Rounded to 2 decimal places
        ]);
    } catch (\Throwable $th) {
        return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
    }
}

}

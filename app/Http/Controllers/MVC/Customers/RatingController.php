<?php

namespace App\Http\Controllers\MVC\Customers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sellers\HomeService;
use App\Models\Sellers\StudioService;

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
                    'customer_id' => auth()->id(),
                    'seller_id' => $service->seller_id,
                    'rating' => $validatedData['rating'],
                    'review' => $validatedData['review'],
                ]);
            }
        
            return redirect()->back()->with('success', 'تم تقييم الخدمة بنجاح');
        }
        catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

}

<?php

namespace App\Http\Controllers\MVC;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Models\Sellers\Seller;
use App\Models\Sellers\Employee;
use App\Models\Sellers\HomeService;
use App\Models\Sellers\StudioService;

use App\Models\Customers\Rating;



class HomeController extends Controller
{
    public function index(){
        try {
            // Get All Home Services
            $homeServices = HomeService::all();

            // Get All Studio Services
            $studioServices = StudioService::all();

            return view('home', compact('homeServices' , 'studioServices'));
        } catch (\Throwable $th) {
            return redirect()->route('home')->with('error', $th->getMessage());
        }
    }

// Show Home Service Details
public function showHomeService($id){
    try {
        $homeService = HomeService::findOrFail($id);

        // Calculate average rating for a specific home service
        $averageRating = $homeService->ratings()->avg('rating');
        $averageRating = number_format($averageRating, 1);

        // Get the average rating for all home services of this seller
        $sellerAverageRating = Rating::where('seller_id', $homeService->seller_id)->avg('rating');
        $sellerAverageRating = number_format($sellerAverageRating, 1);

        // Decode the JSON attribute containing employee IDs
        $employeeIds = json_decode($homeService->employees, true);

        // Fetch employee details from the employees table based on these IDs
        $employees = Employee::whereIn('id', $employeeIds)
        ->where('status', 'active')
        ->pluck('name','id');

        return view('customer.showHomeService', compact('homeService', 'employees' , 'averageRating' , 'sellerAverageRating'));
    } catch (\Throwable $th) {
        return redirect()->route('home')->with('error', $th->getMessage());
    }
}


// Show Studio Service Details
public function showStudioService($id){
    try {
        $studioService = StudioService::findOrFail($id);

        // Calculate average rating for a specific home service
        $averageRating = $studioService->ratings()->avg('rating');
        $averageRating = number_format($averageRating, 1);

        
        // Get the average rating for all home services of this seller
        $sellerAverageRating = Rating::where('seller_id', $studioService->seller_id)->avg('rating');
        $sellerAverageRating = number_format($sellerAverageRating, 1);


        // Decode the JSON attribute containing employee IDs
        $employeeIds = json_decode($studioService->employees, true);

        // Fetch employee details from the employees table based on these IDs
        $employees = Employee::whereIn('id', $employeeIds)
        ->where('status', 'active')
        ->pluck('name','id');

        return view('customer.showStudioService', compact('studioService', 'employees' , 'averageRating' , 'sellerAverageRating'));
    } catch (\Throwable $th) {
        return redirect()->route('home')->with('error', $th->getMessage()); 
    }
}

}

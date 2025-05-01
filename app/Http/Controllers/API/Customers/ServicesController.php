<?php

namespace App\Http\Controllers\API\Customers;

use App\Http\Controllers\Controller;
use App\Http\Resources\HomeServiceResource;
use App\Http\Resources\StudioServiceResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Sellers\SellerTimetable;
use App\Models\Sellers\Timetable;
use App\Models\Sellers\HomeService;
use App\Models\Sellers\StudioService;
use App\Models\Sellers\Employee;
use App\Models\Sellers\Seller;
use App\Models\Customers\Rating;
class ServicesController extends Controller
{
    public function getSellerActiveWeekdays($sellerId)
    {
        try {
             // Retrieve the seller's timetable for active weekdays
            $activeDays = SellerTimetable::where('seller_id', $sellerId)->get();
            return response()->json(['status' => 'success', 'data' => $activeDays]);
        }catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**************************************************************************************/
    public function checkEmployeeAvailability(Request $request)
    {
        try {
            $date = $request->date;
            $startTime = $request->start_time;
            $sellerId = $request->seller_id;

            $busyEmployees = Timetable::where('seller_id', $sellerId)
                ->where('date', $date)
                ->where('start_time', $startTime)
                ->pluck('employee_id');
    
            return response()->json(['busyEmployees at this time' => $busyEmployees]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    /**************************************************************************************/
    public function checkAvailableTimes(Request $request)
    {
        $date = $request->date;
        $sellerId = $request->seller_id;
    
        // Get the seller's timetable for the selected day
        $sellerTimetable = SellerTimetable::where('seller_id', $sellerId)
                                    ->where('day', 'like', '%'.date('l', strtotime($date)).'%')
                                    ->first();
    
        if (!$sellerTimetable) {
            return response()->json(['message' => 'Seller not available on the selected date'], 400);
        }
    
        // Get the seller's working hours for that day (start_time and end_time)
        $startTime = $sellerTimetable->start_time;
        $endTime = $sellerTimetable->end_time;
    
        // Generate available times between start_time and end_time
        $availableTimes = $this->generateAvailableTimes($startTime, $endTime);
    
        return response()->json([
            'message' => 'الاوقات المتاحة بالفعل',
            'availableTimes' => $availableTimes
        ]);
    }
    
    // Helper function to generate available times based on start and end time
    public function generateAvailableTimes($startTime, $endTime)
    {
        $times = [];
        $currentTime = strtotime($startTime);
        $endTime = strtotime($endTime);
    
        // Increment time in 30-minute intervals
        while ($currentTime <= $endTime) {
            $times[] = date('H:i', $currentTime);
            $currentTime = strtotime('+1 hour', $currentTime);
        }
    
        return $times;
    }

    /***************************************************************************************/
    // Get All Home Services for a specific seller
    public function getSellerHomeServices($sellerId)
    {
        try {
            $homeServices = HomeService::where('seller_id', $sellerId)->get();
            return response()->json(['homeServices' => HomeServiceResource::collection($homeServices)]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    /****************************************************************************************/
    // Get All Studio Services for a specific seller
    public function getSellerStudioServices($sellerId)
    {
        try {
            $studioServices = StudioService::where('seller_id', $sellerId)->get();
            return response()->json(['studioServices' => StudioServiceResource::collection($studioServices)]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    /****************************************************************************************/
        // get Employees By Home Service
        public function getEmployeesByService($serviceId)
        {
            $homeService = HomeService::findOrFail($serviceId);
            $employeeIds = json_decode($homeService->employees, true);
    
            // Retrieve employee details by IDs
            $employees = Employee::whereIn('id', $employeeIds)->get();
    
            return response()->json($employees);
        }
        /****************************************************************************************/
    // getEmployeesByService
    public function getStudioEmployeesByService($serviceId)
    {
        $studioService = StudioService::findOrFail($serviceId);
        $employeeIds = json_decode($studioService->employees, true);

        // Retrieve employee details by IDs
        $employees = Employee::whereIn('id', $employeeIds)->get();

        return response()->json($employees);
    }
    /*****************************************************************************************/
    // Get All Sellers
    public function getSellers()
    {
        try {
            $sellers = Seller::all()->map(function ($seller) {
                // Calculate average rating
                $averageRating = Rating::where('seller_id', $seller->id)->avg('rating');
                $seller->average_rating = number_format($averageRating, 1) ?? 0;
    
                // Fetch unique sub-category names from studio services
                $studioSubCategories = StudioService::where('seller_id', $seller->id)
                    ->with('subCategory') // Assuming the relation is named 'subCategory'
                    ->get()
                    ->pluck('subCategory.name');
    
                // Fetch unique sub-category names from home services
                $homeSubCategories = HomeService::where('seller_id', $seller->id)
                    ->with('subCategory') // Assuming the relation is named 'subCategory'
                    ->get()
                    ->pluck('subCategory.name');
    
                // Merge both arrays, filter unique values, and reindex
                $allSubCategories = $studioSubCategories->merge($homeSubCategories)->unique()->values();
    
                $seller->service_subcategories = $allSubCategories;
    
                return $seller;
            });
    
            // Sort sellers by rating in descending order
            $sellers = $sellers->sortByDesc('average_rating')->values();
    
            return response()->json(['status' => 'success', 'sellers' => $sellers]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    /******************************************************************************************/
    // Get All Employees for a specific seller
    public function getSellerEmployees($sellerId)
    {
        try {
            $employees = Employee::where('seller_id', $sellerId)->get();
            return response()->json(['status' => 'success', 'data' => $employees]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    /******************************************************************************************/
}

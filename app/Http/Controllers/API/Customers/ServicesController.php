<?php

namespace App\Http\Controllers\API\Customers;

use App\Http\Controllers\Controller;
use App\Http\Resources\HomeServiceResource;
use App\Http\Resources\StudioServiceResource;
use Illuminate\Http\Request;
use App\Models\Sellers\SellerTimetable;
use App\Models\Sellers\Timetable;
use App\Models\Sellers\HomeService;
use App\Models\Sellers\StudioService;
use App\Models\Sellers\Employee;
class ServicesController extends Controller
{
    public function getSellerActiveWeekdays($sellerId)
    {
        try {
             // Retrieve the seller's timetable for active weekdays
            $activeDays = SellerTimetable::where('seller_id', $sellerId)->pluck('day')->toArray();
            return response()->json(['activeDays' => $activeDays]);
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
}

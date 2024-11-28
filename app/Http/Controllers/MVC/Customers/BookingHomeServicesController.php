<?php

namespace App\Http\Controllers\MVC\Customers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Customers\HomeBooking;
use App\Models\Sellers\Employee;
use App\Models\Sellers\Timetable;
use App\Models\Customers\HomeServiceBookingItem;
use App\Models\Sellers\SellerTimetable;

class BookingHomeServicesController extends Controller
{

    public function getSellerActiveWeekdays($sellerId)
    {
        // Retrieve the seller's timetable for active weekdays
        $activeDays = SellerTimetable::where('seller_id', $sellerId)->pluck('day')->toArray();
    
        return response()->json(['activeDays' => $activeDays]);
    }

    
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
    
            return response()->json(['busyEmployees' => $busyEmployees]);
        } catch (\Exception $e) {
            // Log the error and return a generic message
            \Log::error('Error in checkEmployeeAvailability: ' . $e->getMessage());
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }
    


    // booking home service
    public function store(Request $request)
    { 
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'home_service_id' => 'required',
            'seller_id' => 'required',
            'employee_id' => 'required',
            'date' => 'required|date',
            'start_time' => 'required',
            'paid_amount' => 'required|numeric',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        // Create the home booking in the database
        $homeBooking = HomeBooking::create([
            'home_service_id' => $request->home_service_id,
            'seller_id' => $request->seller_id,
            'employee_id' => $request->employee_id,
            'customer_id' => Auth::guard('customer')->user()->id,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'paid_amount' => $request->paid_amount,
            'location' => $request->location,
        ]);
    
        // Create a timetable record for the selected employee
        Timetable::create([
            'employee_id' => $request->employee_id,
            'seller_id' => $request->seller_id,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'status' => 'busy',
        ]);
    
        return redirect()->route('customer.homeBookings')->with('success', 'تم الحجز بنجاح الرجاء الانتظار حتى يتم الموافقة عليه');
    }
    
    
    

    // Edit booking home service page
    public function edit($id)
    {
        // Get booking home service
        $homeBooking = HomeBooking::findOrFail($id);

        return view('customer.myOrders.updateHomeOrder', compact('homeBooking'));
    }
    // Update booking home service
    public function update(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'date' => 'required|date',
        'start_time' => 'required',
        'location' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    
    $homeBooking = HomeBooking::findOrFail($id);

    // Update the timetable record for the selected employee
    $timetable = Timetable::where('employee_id', $homeBooking->employee_id)
    ->where('date', $homeBooking->date)
    ->where('start_time', $homeBooking->start_time)
    ->first();


if ($timetable) {
    $timetable->update([
        'date' => $request->date,
        'start_time' => $request->start_time,
    ]);
}

    $homeBooking->update([
        'date' => $request->date,
        'start_time' => $request->start_time,
        'location' => $request->location,
    ]);

    if ($homeBooking->booking_status == 'accepted' || $homeBooking->booking_status == 'rejected') {
        $homeBooking->update([
            'booking_status' => 'pending',
        ]);
    }



    return redirect()->route('customer.homeBookings')->with('success', 'تم تعديل الحجز بنجاح الرجاء الانتظار حتى يتم الموافقة عليه');
}


    // add service to existing booking
    public function addServiceToExistingBooking(Request $request) {
        $validator = Validator::make($request->all(), [
            'home_service_booking_id' => 'required|exists:home_services_bookings,id',
            'service_id' => 'required|exists:home_services,id',
            'employee_id' => 'required|exists:employees,id',
        ]);
    
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }
    
        try {
            // Add the new service to the booking
            $bookingItem = HomeServiceBookingItem::create([
                'home_service_booking_id' => $request->home_service_booking_id,
                'service_id' => $request->service_id,
                'employee_id' => $request->employee_id,
            ]);

            // Update the booking status to pending
            $booking = HomeBooking::findorFail($request->home_service_booking_id);
            $booking->booking_status = 'pending';
            $booking->save();
    
            return redirect()->route('customer.homeBookings')->with('success', 'تم اضافة الخدمة بنجاح الرجاء الانتظار حتى يتم الموافقة عليه');
        } catch (\Exception $e) {
            return redirect()->route('customer.homeBookings')->with('error', $e->getMessage());
        }
    }
    


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
        'message' => 'Available times fetched successfully',
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

}

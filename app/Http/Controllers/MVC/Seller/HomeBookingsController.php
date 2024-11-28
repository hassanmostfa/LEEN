<?php

namespace App\Http\Controllers\MVC\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\Customers\HomeBooking;
use App\Models\Customers\Customer;
use App\Models\Customers\CustomerPoint;

use App\Models\Sellers\Seller;
use App\Models\Sellers\Employee;
use App\Models\Sellers\Timetable;
use App\Models\Sellers\HomeService;

class HomeBookingsController extends Controller
{
    // show all home bookings
    public function index()
    {
        $homeBookings = HomeBooking::where('seller_id', Auth::user()->id)
        ->where('booking_status', 'accepted')
        ->orWhere('booking_status', 'done')
        ->with('homeServiceBookingItems')
        ->get();
        return view('seller.home bookings.homeBookings', compact('homeBookings'));
    }

    // show all new bookings requests
    public function getNewHomeBookings()
    {
        $homeBookings = HomeBooking::where('seller_id', Auth::user()->id)
        ->where('booking_status', 'pending')
        ->with('homeServiceBookingItems')
        ->get();
        // dd($homeBookings);

        return view('seller.home bookings.newRequests', compact('homeBookings'));
    }



    // show new home booking details
    public function show($id)
    {
        try {
            $homeBooking = HomeBooking::findOrFail($id);
    
            if (!$homeBooking) {
                // Return a 404 view or custom error message if the booking is not found
                return response()->json(['error' => 'Booking not found'], 404);
            }
    
            return view('seller.home bookings.showRequest', compact('homeBooking'));
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
    

    // accept new home booking request
    public function acceptHomeBooking($id)
    {
        $homeBooking = HomeBooking::find($id);
        $homeBooking->booking_status = 'accepted';
        $homeBooking->save();
        return redirect()->route('seller.homeBookings.newRequests')->with('success', 'تم قبول الطلب بنجاح');
    }

    // reject new home booking request
    public function rejectHomeBooking(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'request_rejection_reason' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $homeBooking = HomeBooking::find($id);
        $homeBooking->booking_status = 'rejected';
        $homeBooking->request_rejection_reason = $request->request_rejection_reason;
        $homeBooking->save();

        // Remove employee from this time in employee time table
        $timetable = Timetable::where('employee_id', $homeBooking->employee_id)
        ->where('date', $homeBooking->date)
        ->where('start_time', $homeBooking->start_time)
        ->first();

        if ($timetable) {
            $timetable->delete();
        }
        return redirect()->route('seller.homeBookings.newRequests');
    }


    public function refusedRequests(){

        $homeBookings = HomeBooking::where('seller_id', Auth::user()->id)->where('booking_status', 'rejected')->get();
        // dd($studioBookings);

        return view('seller.home bookings.rejectedRequests'  , compact('homeBookings'));
    }

    // Service is done
    public function homeServiceIsDone($id){

        $homeBooking = HomeBooking::find($id);
        $homeBooking->booking_status = 'done';

        // if home service has points add points to customer
        if ($homeBooking->homeService->points > 0) {
            
            $customerPoint = new CustomerPoint();
            $customerPoint->customer_id = $homeBooking->customer_id;
            $customerPoint->seller_id = $homeBooking->seller_id;
            $customerPoint->points = $homeBooking->homeService->points;
            $customerPoint->save();
        }

        $homeBooking->save();

        return redirect()->route('seller.homeBookings')->with('success', 'تم تنفيذ الخدمة بنجاح');
    }
}
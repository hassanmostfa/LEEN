<?php

namespace App\Http\Controllers\API\Sellers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\HomeBookingResource;

use App\Models\Customers\HomeBooking;
use App\Models\Customers\CustomerPoint;
use App\Models\Sellers\Timetable;

class HomeBookingsController extends Controller
{
    // get all Accepted home bookings
    public function index(){
        try{
            $homeBookings = HomeBooking::where('seller_id', Auth::user()->id)
            ->where('booking_status', 'accepted')
            ->orWhere('booking_status', 'done')
            ->get();

            return response()->json(['success' => true,'data' => HomeBookingResource::collection($homeBookings)]);
        }catch(\Exception $e){
            return response()->json([ 'success' => false,'message' => $e->getMessage()]);
        }
    }
    /***********************************************************************************/
    // get all new home bookings
    public function getNewHomeBookings(){
        $homeBookings = HomeBooking::where('seller_id', Auth::user()->id)
        ->where('booking_status', 'pending')
        ->get();

        return response()->json(['success' => true,'data' => HomeBookingResource::collection($homeBookings)]);
    }
    /***********************************************************************************/
    // Show Home Booking Details for the current seller
    public function show($id){
        try{
            $homeBooking = HomeBooking::findOrFail($id);

            if($homeBooking->seller_id != Auth::user()->id){
                return response()->json([ 'success' => false,'message' => 'هذا الطلب ليس لك']);
            }

            return response()->json(['success' => true,'data' => new HomeBookingResource($homeBooking)]);
        }catch(\Exception $e){
            return response()->json([ 'success' => false,'message' => $e->getMessage()]);
        }
    }

    /************************************************************************************/
    // Accept Home Booking
    public function acceptHomeBooking($id){
        try{
            $homeBooking = HomeBooking::findOrFail($id);

            if($homeBooking->seller_id != Auth::user()->id){
                return response()->json([ 'success' => false,'message' => 'هذا الطلب ليس لك']);
            }

            $homeBooking->booking_status = 'accepted';
            $homeBooking->save();

            return response()->json(['success' => true,'message' => 'تم قبول الطلب بنجاح']);
        }catch(\Exception $e){
            return response()->json([ 'success' => false,'message' => $e->getMessage()]);
        }
    }

    /***********************************************************************************/
    // Reject Home Booking
    public function rejectHomeBooking(Request $request, $id){
        try{
            $validator = Validator::make($request->all(), [
                'request_rejection_reason' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([ 'success' => false,'message' => $validator->errors()->first()]);
            }

            $homeBooking = HomeBooking::findOrFail($id);

            if($homeBooking->seller_id != Auth::user()->id){
                return response()->json([ 'success' => false,'message' => 'هذا الطلب ليس لك']);
            }

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

            return response()->json(['success' => true,'message' => 'تم رفض الطلب بنجاح']);
        }catch(\Exception $e){
            return response()->json([ 'success' => false,'message' => $e->getMessage()]);
        }
    }
    /***********************************************************************************/
    // get all refused home bookings
    public function getRefusedHomeBookings(){
        $homeBookings = HomeBooking::where('seller_id', Auth::user()->id)
        ->where('booking_status', 'rejected')
        ->get();

        return response()->json(['success' => true,'data' => HomeBookingResource::collection($homeBookings)]);
    }

    /***********************************************************************************/
    // Service is done
    public function homeServiceIsDone($id){
        try{
            $homeBooking = HomeBooking::findOrFail($id);

            if($homeBooking->seller_id != Auth::user()->id){
                return response()->json([ 'success' => false,'message' => 'هذا الطلب ليس لك']);
            }

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
    
        return response()->json(['success' => true,'message' => 'تم تنفيذ الخدمة بنجاح']);
        }catch(\Exception $e){
            return response()->json([ 'success' => false,'message' => $e->getMessage()]);
        }
    }
}

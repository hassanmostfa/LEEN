<?php

namespace App\Http\Controllers\API\Sellers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\StudioBookingResource;

use App\Models\Customers\StudioBooking;
use App\Models\Customers\CustomerPoint;
use App\Models\Sellers\Timetable;


class StudioBookingsController extends Controller
{
     // get all Accepted studio bookings
     public function index(){
        try{
            $studioBookings = StudioBooking::where('seller_id', Auth::user()->id)
            ->where('booking_status', 'accepted')
            ->orWhere('booking_status', 'done')
            ->get();

            return response()->json(['success' => true,'data' => StudioBookingResource::collection($studioBookings)]);
        }catch(\Exception $e){
            return response()->json([ 'success' => false,'message' => $e->getMessage()]);
        }
    }
    /***********************************************************************************/
    // get all new studio bookings
    public function getNewStudioBookings(){
        $studioBookings = StudioBooking::where('seller_id', Auth::user()->id)
        ->where('booking_status', 'pending')
        ->get();

        return response()->json(['success' => true,'data' => StudioBookingResource::collection($studioBookings)]);
    }
    /***********************************************************************************/
    // Show studio Booking Details for the current seller
    public function show($id){
        try{
            $studioBooking = StudioBooking::findOrFail($id);

            if($studioBooking->seller_id != Auth::user()->id){
                return response()->json([ 'success' => false,'message' => 'هذا الطلب ليس لك']);
            }

            return response()->json(['success' => true,'data' => new StudioBookingResource($studioBooking)]);
        }catch(\Exception $e){
            return response()->json([ 'success' => false,'message' => $e->getMessage()]);
        }
    }

    /************************************************************************************/
    // Accept Home Booking
    public function acceptStudioBooking($id){
        try{
            $studioBooking = StudioBooking::findOrFail($id);

            if($studioBooking->seller_id != Auth::user()->id){
                return response()->json([ 'success' => false,'message' => 'هذا الطلب ليس لك']);
            }

            $studioBooking->booking_status = 'accepted';
            $studioBooking->save();

            return response()->json(['success' => true,'message' => 'تم قبول الطلب بنجاح']);
        }catch(\Exception $e){
            return response()->json([ 'success' => false,'message' => $e->getMessage()]);
        }
    }

    /***********************************************************************************/
    // Reject Studio Booking
    public function rejectStudioBooking(Request $request, $id){
        try{
            $validator = Validator::make($request->all(), [
                'request_rejection_reason' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([ 'success' => false,'message' => $validator->errors()->first()]);
            }

            $studioBooking = StudioBooking::findOrFail($id);

            if($studioBooking->seller_id != Auth::user()->id){
                return response()->json([ 'success' => false,'message' => 'هذا الطلب ليس لك']);
            }

            $studioBooking->booking_status = 'rejected';
            $studioBooking->request_rejection_reason = $request->request_rejection_reason;
            $studioBooking->save();   

            // Remove employee from this time in employee time table
            $timetable = Timetable::where('employee_id', $studioBooking->employee_id)
            ->where('date', $studioBooking->date)
            ->where('start_time', $studioBooking->start_time)
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
    // get all refused studio bookings
    public function getRefusedStudioBookings(){
        $studioBookings = StudioBooking::where('seller_id', Auth::user()->id)
        ->where('booking_status', 'rejected')
        ->get();

        return response()->json(['success' => true,'data' => StudioBookingResource::collection($studioBookings)]);
    }

    /***********************************************************************************/
    // Service is done
    public function studioServiceIsDone($id){
        try{
            $studioBooking = StudioBooking::findOrFail($id);

            if($studioBooking->seller_id != Auth::user()->id){
                return response()->json([ 'success' => false,'message' => 'هذا الطلب ليس لك']);
            }

            $studioBooking->booking_status = 'done';


        // // if studio service has points add points to customer
        if ($studioBooking->studioService->points > 0) {
            
            $customerPoint = new CustomerPoint();
            $customerPoint->customer_id = $studioBooking->customer_id;
            $customerPoint->seller_id = $studioBooking->seller_id;
            $customerPoint->points = $studioBooking->studioService->points;
            $customerPoint->save();
        }

        $studioBooking->save();
    
        return response()->json(['success' => true,'message' => 'تم تنفيذ الخدمة بنجاح']);
        }catch(\Exception $e){
            return response()->json([ 'success' => false,'message' => $e->getMessage()]);
        }
    }
}

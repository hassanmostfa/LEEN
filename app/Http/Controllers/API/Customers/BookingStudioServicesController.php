<?php

namespace App\Http\Controllers\API\Customers;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudioBookingResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Customers\StudioBooking;
use App\Models\Sellers\Employee;
use App\Models\Sellers\Timetable;
use App\Models\Customers\StudioServiceBookingItem;

class BookingStudioServicesController extends Controller
{
    // get all booking studio services
    public function index(){
        try{
            $studioBookings = StudioBooking::where('customer_id', auth()->user()->id)->get();
            return response()->json([
                'success' => true,
                'data' => StudioBookingResource::collection($studioBookings)
            ]);
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /******************************************************************************************/
    // booking home service
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'studio_service_id' => 'required',
            'seller_id' => 'required',
            'employee_id' => 'required',
            'date' => 'required|date',
            'start_time' => 'required',
            'paid_amount' => 'required|numeric',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        $studioBooking = StudioBooking::create([
            'studio_service_id' => $request->studio_service_id,
            'seller_id' => $request->seller_id,
            'employee_id' => $request->employee_id,
            'customer_id' => auth()->user()->id,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'paid_amount' => $request->paid_amount,
            'location' => $request->location,
        ]);
    
        // Create Timetable record for the selected employee
        Timetable::create([
            'employee_id' => $request->employee_id,
            'seller_id' => $request->seller_id,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'status' => 'busy',
        ]);

        return response()->json([
            'success' => true,
            'data' => StudioBookingResource::make($studioBooking)
        ]);
    }
    /*******************************************************************************************/
    // Update booking studio service
    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'start_time' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $studioBooking = StudioBooking::findOrFail($id);

            // Update the timetable record for the selected employee
    $timetable = Timetable::where('employee_id', $studioBooking->employee_id)
    ->where('date', $studioBooking->date)
    ->where('start_time', $studioBooking->start_time)
    ->first();


if ($timetable) {
    $timetable->update([
        'date' => $request->date,
        'start_time' => $request->start_time,
    ]);
}

        $studioBooking->update([
            'date' => $request->date,
            'start_time' => $request->start_time,
        ]);

        if ($studioBooking->booking_status == 'accepted') {
            $studioBooking->update([
                'booking_status' => 'pending',
            ]);
        }elseif ($studioBooking->booking_status == 'rejected') {
            $studioBooking->update([
                'booking_status' => 'pending',
            ]);
        }

        return response()->json([ 'success' => true,'data' ,'message' => 'تم تحديث الطلب بنجاح','data' => StudioBookingResource::make($studioBooking)]);
    }

    /******************************************************************************************/
    // add service to existing booking
    public function addStudioServiceToExistingBooking(Request $request) {
        $validator = Validator::make($request->all(), [
            'studio_service_booking_id' => 'required|exists:studio_services_bookings,id',
            'service_id' => 'required|exists:studio_services,id',
            'employee_id' => 'required|exists:employees,id',
        ]);
    
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }
    
        try {
            // Add the new service to the booking
            $bookingItem = StudioServiceBookingItem::create([
                'studio_service_booking_id' => $request->studio_service_booking_id,
                'service_id' => $request->service_id,
                'employee_id' => $request->employee_id,
            ]);

            // Update the booking status to pending
            $booking = StudioBooking::findorFail($request->studio_service_booking_id);
            $booking->booking_status = 'pending';
            $booking->save();
    
            return response()->json(['message' => 'تم اضافة الخدمة بنجاح الرجاء الانتظار حتى يتم الموافقة عليه'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

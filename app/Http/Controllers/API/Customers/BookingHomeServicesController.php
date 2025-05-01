<?php

namespace App\Http\Controllers\API\Customers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\HomeBookingResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Customers\HomeBooking;
use App\Models\Customers\HomeServiceBookingItem;
use App\Models\Sellers\Timetable;
use App\Models\Notification;

    class BookingHomeServicesController extends Controller
    {
        // get all home Bookings for the current customer
        public function index()
        {
            try{
                $homeBookings = HomeBooking::where('customer_id', auth()->user()->id)->get();
                return response()->json(['status' => 'success', 'data' => HomeBookingResource::collection($homeBookings)]);
            }catch(\Exception $e){
                return response()->json([ 'success' => false,'message' => $e->getMessage()]);
            }
        }
        /************************************************************************************/
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
                'customer_id' => auth()->user()->id,
                'date' => $request->date,
                'start_time' => $request->start_time,
                'paid_amount' => $request->paid_amount,
                'location' => $request->location,
                'copoun_discount' => $request->copoun_discount ?? 0,
                'service_discount' => $request->service_discount ?? 0,
            ]);
        
            // Create a timetable record for the selected employee
            Timetable::create([
                'employee_id' => $request->employee_id,
                'seller_id' => $request->seller_id,
                'date' => $request->date,
                'start_time' => $request->start_time,
                'status' => 'busy',
            ]);

        // Create a notification for the seller
        Notification::create([
            'customer_id' => auth()->user()->id,
            'seller_id' => $request->seller_id,
            'title' => 'حجز منزلي جديد',
            'sender_type' => 'customer',
            'content' => 'لديك حجز جديد من العميل ' . auth()->user()->first_name . ' ' . auth()->user()->last_name . ' للموعد ' . $request->booking_date . '. يرجى تأكيد الحجز.',
            'category' => 'booking',
        ]);

        return response()->json(['status' => 'success','message' => 'تم انشاء الحجز بنجاح الرجاء الانتظار حتى يتم الموافقة عليه' , 'data' => HomeBookingResource::make($homeBooking)], 200);
        }
        
        /************************************************************************************/
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
    
        return response()->json(['message' => 'تم تحديث الحجز بنجاح' , 'data' => new HomeBookingResource($homeBooking)], 200);
    }
    
    /***********************************************************************************/

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
        
                return response()->json(['message' => 'تم اضافة الخدمة بنجاح الرجاء الانتظار حتى يتم الموافقة عليه'], 200);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }

        /********************************************************************************************/
        public function cancelHomeBooking($id){
            $homeBooking = HomeBooking::findOrFail($id);
            $homeBooking->booking_status = 'cancelled';
            $homeBooking->save();

       // Create a cancel notification for the seller
        Notification::create([
            'customer_id' => auth()->user()->id,
            'seller_id' => $homeBooking->seller_id,
            'title' => 'تم الغاء حجز منزلي',
            'sender_type' => 'customer',
            'content' => 'لقد قام العميل ' . auth()->user()->first_name . ' ' . auth()->user()->last_name . ' بإلغاء الحجز الذي كان محددًا للموعد ' . $homeBooking->booking_date . ' في الساعة ' . $homeBooking->start_time . '.',
            'category' => 'booking',
        ]);

            return response()->json(['message' => 'تم الغاء الحجز بنجاح'], 200);
        }
        
    }

    // Cancel booking home service


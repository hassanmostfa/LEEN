<?php

namespace App\Http\Controllers\MVC\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Customers\StudioBooking;
use App\Models\Customers\CustomerPoint;
use App\Models\Sellers\Seller;
use App\Models\Sellers\Employee;
use App\Models\Sellers\Timetable;
class StudioBookingsController extends Controller
{
        // show all Studio bookings
        public function index()
        {
            $studioBookings = StudioBooking::where('seller_id', Auth::user()->id)
            ->where('booking_status', 'accepted')
            ->orWhere('booking_status', 'done')
            ->get();
            return view('seller.studio_bookings.studioBookings', compact('studioBookings'));
        }
    
        // show all new bookings requests
        public function getNewStudioBookings()
        {
            $studioBookings = StudioBooking::where('seller_id', Auth::user()->id)
            ->where('booking_status', 'pending')
            ->get();
            return view('seller.studio_bookings.newStudioBookingsRequests', compact('studioBookings'));
        }

        // show studio booking details
        public function show($id)
        {
            try {
                $studioBooking = StudioBooking::findOrFail($id);

                return view('seller.studio_bookings.showStudioBookingRequest', compact('studioBooking'));
            } catch (\Throwable $th) {
                return response()->json(['error' => $th->getMessage()], 500);
            }
        }

        // accept new studio booking request
    public function acceptStudioBooking($id)
    {
        $studioBooking = StudioBooking::find($id);
        $studioBooking->booking_status = 'accepted';
        $studioBooking->save();
        return redirect()->route('seller.studioBookings.newRequests')->with('success', 'تم قبول الطلب بنجاح');
    }

    // reject new home booking request
    public function rejectStudioBooking(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'request_rejection_reason' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $studioBooking = StudioBooking::find($id);
        $studioBooking->booking_status = 'rejected';
        $studioBooking->request_rejection_reason = $request->request_rejection_reason;
        $studioBooking->save();

        // Remove employee from this time in employee time table
        $timetable = Timetable::where('employee_id', $studioBooking->employee_id)
        ->where('date', $studioBooking->date)
        ->where('start_time', $studioBooking->start_time)
        ->where('end_time', $studioBooking->end_time)
        ->first();

        if ($timetable) {
            $timetable->delete();
        }
        return redirect()->route('seller.studioBookings.newRequests');
    }

    // show all Rejected Studio Bookings

    public function refusedRequests(){

        $studioBookings = StudioBooking::where('seller_id', Auth::user()->id)->where('booking_status', 'rejected')->get();
        // dd($studioBookings);

        return view('seller.studio_bookings.rejectedStudioBookingRequests'  , compact('studioBookings'));
    }

       // Service is done
       public function studioServiceIsDone($id){

        $studioBooking = StudioBooking::findOrFail($id);
        $studioBooking->booking_status = 'done';

                // if home service has points add points to customer
                if ($studioBooking->studioService->points > 0) {
            
                    $customerPoint = new CustomerPoint();
                    $customerPoint->customer_id = $studioBooking->customer->id;
                    $customerPoint->seller_id = $studioBooking->seller_id;
                    $customerPoint->points = $studioBooking->studioService->points;
                    $customerPoint->save();
                }

        $studioBooking->save();
        return redirect()->route('seller.studioBookings')->with('success', 'تم تنفيذ الخدمة بنجاح');
    }

}

<?php

namespace App\Http\Controllers\MVC\Customers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Models\Customers\Customer;
use App\Models\Customers\HomeBooking;
use App\Models\Customers\StudioBooking;
use App\Models\Sellers\HomeService;
use App\Models\Sellers\StudioService;

use App\Models\Sellers\Employee;

class ServicesController extends Controller
{
    public function getHomeBookings()
    {
        // Get All Home Bookings for the current customer
        $homeBookings = HomeBooking::where('customer_id', Auth::guard('customer')->user()->id)
            ->with('homeServiceBookingItems')
            ->get();

        // Initialize homeServices and employees
        $homeServices = collect();
        $employees = collect();

        // Get seller home services and employees from booking seller id
        foreach ($homeBookings as $booking) {
            $bookingHomeServices = HomeService::where('seller_id', $booking->seller_id)->get();
            $booking->homeServices = $bookingHomeServices;
            $homeServices = $homeServices->merge($bookingHomeServices);

            $bookingEmployees = Employee::where('seller_id', $booking->seller_id)->get();
            $booking->employees = $bookingEmployees;
            $employees = $employees->merge($bookingEmployees);
        }

        return view('customer.myOrders.homeOrders', compact('homeBookings', 'homeServices', 'employees'));
    }

    /*****************************************************************************************/
    // get Employees By Home Service
    public function getEmployeesByService($serviceId)
    {
        $homeService = HomeService::findOrFail($serviceId);
        $employeeIds = json_decode($homeService->employees, true);

        // Retrieve employee details by IDs
        $employees = Employee::whereIn('id', $employeeIds)->get();

        return response()->json($employees);
    }

    /*****************************************************************************************/
    // getStudioBookings
    public function getStudioBookings()
    {
        // Get All Studio Bookings for the current customer
        $studioBookings = StudioBooking::where('customer_id', Auth::guard('customer')->user()->id)
            ->with('studioServiceBookingItems')
            ->get();

        // Initialize studioServices and employees
        $studioServices = collect();
        $employees = collect();

        // Get seller studio services and employees from booking seller id
        foreach ($studioBookings as $booking) {
            $bookingStudioServices = StudioService::where('seller_id', $booking->seller_id)->get();
            $booking->studioServices = $bookingStudioServices;
            $studioServices = $studioServices->merge($bookingStudioServices);

            $bookingEmployees = Employee::where('seller_id', $booking->seller_id)->get();
            $booking->employees = $bookingEmployees;
            $employees = $employees->merge($bookingEmployees);
        }

        return view('customer.myOrders.studioOrders', compact('studioBookings', 'studioServices', 'employees'));
    }

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

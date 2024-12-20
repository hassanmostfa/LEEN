<?php

namespace App\Http\Controllers\MVC\Customers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Customers\HomeBooking;
use App\Models\Customers\StudioBooking;
use App\Models\Sellers\Coupon;


class CustomersCouponsController extends Controller
{
    // get all available coupons for the current logged in customer
    public function index()
    {
        $customerId = Auth::guard('customer')->user()->id; // get customer id

        // Step 1: Retrieve seller IDs from both bookings tables
        $homeServiceSellerIds = HomeBooking::where('customer_id', $customerId)
        ->pluck('seller_id')
        ->toArray();

        $studioServiceSellerIds = StudioBooking::where('customer_id', $customerId)
        ->pluck('seller_id')
        ->toArray();

        // Combine both seller IDs into a unique list
        $sellerIds = array_unique(array_merge($homeServiceSellerIds, $studioServiceSellerIds));

        // Step 2: Query the coupons table for any coupons from these sellers
        $coupons = Coupon::whereIn('seller_id', $sellerIds)
        ->orderBy('created_at', 'desc')
        ->get();

        return view('customer.coupons', compact('coupons'));
    }

}

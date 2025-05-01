<?php

namespace App\Http\Controllers\API\Customers;

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
            $customerId = auth()->user()->id; // get customer id
    
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
            $coupons = Coupon::whereIn('seller_id', $sellerIds)->get();
    
            return response()->json(['status' => 'success', 'data' => $coupons], 200);
        }
    
        /*********************************************************************************/

    // Apply Coupon
    public function applyCoupon(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $coupon = Coupon::where('code', $request->code)->first();

        if (!$coupon) {
            return response()->json(['error' => 'هذا الكوبون غير موجود'], 400);
        }

        // Check if the coupon is expired
        if (now()->greaterThan($coupon->expires_at)) {
            return response()->json(['error' => 'هذا الكوبون منتهي الصلاحية'], 400);
        }

        // Check if the coupon usage limit is reached
        if ($coupon->usage_count >= $coupon->usage_limit) {
            return response()->json(['error' => 'هذا الكوبون تعدي الحد الاقصى من الاستخدام'], 400);
        }

        // Increment usage count
        $coupon->increment('usage_count');

        // You can apply the discount logic here (e.g., calculating the new price)
        return response()->json([
            'message' => 'Coupon applied successfully',
            'discount_value' => $coupon->discount_value,
            'remaining_uses' => $coupon->usage_limit - $coupon->usage_count
        ]);
    }

}

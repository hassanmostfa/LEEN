<?php

namespace App\Http\Controllers\API\Customers;

use App\Http\Controllers\Controller;
use App\Http\Resources\SellerResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Customers\Favourit;
use App\Models\Sellers\Seller;
use App\Models\Customers\Customer;
use App\Models\Customers\HomeBooking;
use App\Models\Customers\StudioBooking;
class FavouritesController extends Controller
{
    // get all customer sellers
    public function getCustomerSellers(){
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

        // get these sellers and check this seller is not already in favourites
        $sellers = Seller::whereIn('id', $sellerIds)->whereNotIn('id', function ($query) use ($customerId) {
            $query->select('seller_id')->from('favorites')->where('customer_id', $customerId);
        })->get();

        return response()->json(['status' => 'success', 'data' => SellerResource::collection($sellers)], 200);
    }

    /******************************************************************************************/
    // get all favourites
    public function index()
    {
        $favourites = Favourit::where('customer_id', auth()->user()->id)->get();
        return response()->json(['status' => 'success', 'data' => $favourites], 200);
    }
    /*****************************************************************************************/
    // Store Seller to favourites
    public function store($sellerId)
    {
        $favourit = new Favourit();
        $favourit->customer_id = auth()->user()->id;
        $favourit->seller_id = $sellerId;
        $favourit->save();

        return response()->json(['status' => 'success', 'data' => $favourit], 200);
    }
    /******************************************************************************************/
    // Delete favourite
    public function destroy($id)
    {
        $favourit = Favourit::findOrFail($id);
        $favourit->delete();
        return response()->json(['status' => 'success', 'massage' => 'تم الحذف بنجاح'], 200);
    }
}

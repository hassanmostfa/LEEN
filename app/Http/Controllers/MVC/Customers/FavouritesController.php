<?php

namespace App\Http\Controllers\MVC\Customers;

use App\Http\Controllers\Controller;
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
    // get all favourites
    public function index()
    {
        $favourites = Favourit::where('customer_id', Auth::guard('customer')->user()->id)->get();
        return view('customer.favourites.favourites', compact('favourites'));
    }


    // Create a new favourite for a specific seller page
    public function create()
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

        // get these sellers and check this seller is not already in favourites
        $sellers = Seller::whereIn('id', $sellerIds)->whereNotIn('id', function ($query) use ($customerId) {
            $query->select('seller_id')->from('favorites')->where('customer_id', $customerId);
        })->get();

        return view('customer.favourites.addToFavorites', compact('sellers'));
    }


    // Store Seller to favourites
    public function store($sellerId)
    {
        $favourit = new Favourit();
        $favourit->customer_id = Auth::guard('customer')->user()->id;
        $favourit->seller_id = $sellerId;
        $favourit->save();

        return redirect()->route('customer.favourites')->with('success', 'تمت الاضافة بنجاح');

    }

    // Delete favourite
    public function destroy($id)
    {
        $favourit = Favourit::findOrFail($id);
        $favourit->delete();

        return redirect()->route('customer.favourites')->with('success', 'تم الحذف بنجاح');

    }

}

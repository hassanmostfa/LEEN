<?php

namespace App\Http\Controllers\MVC\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Sellers\Seller;

class SellerProfileController extends Controller
{
    // Show Profile Page
    public function index(){
        // Get Seller
        $seller = Auth::guard('seller')->user();
        return view('seller.profile' , compact('seller'));
    }

// Update seller
public function update(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'first_name' => 'required',
        'last_name' => 'required',
        'email' => 'required',
        'phone' => 'required',
        'location' => 'required',
        'status' => 'required',
        'seller_logo' => 'nullable|file|mimes:jpg,jpeg,png',
        'seller_banner' => 'nullable|file|mimes:jpg,jpeg,png',
        'service_type' => 'required|in:in_house,at_headquarters',
    ]);

    if ($validator->fails()) {
        return response()->json(['status' => 'error', 'message' => $validator->errors()]);
    }

    try {
        $seller = Seller::findOrFail($id);

        // Update seller details
        $seller->first_name = $request->first_name;
        $seller->last_name = $request->last_name;
        $seller->email = $request->email;
        $seller->phone = $request->phone;
        $seller->location = $request->location;
        $seller->status = $request->status;
        $seller->service_type = $request->service_type;

        // Handle logo update
        if ($request->hasFile('seller_logo')) {
            // Delete the old logo if it exists
            if ($seller->seller_logo && \Storage::exists($seller->seller_logo)) {
                \Storage::delete($seller->seller_logo);
            }

            // Store new logo
            $seller->seller_logo = $request->file('seller_logo')->store('sellers_logos');
        }

        // Handle banner update
        if ($request->hasFile('seller_banner')) {
            // Delete the old banner if it exists
            if ($seller->seller_banner && \Storage::exists($seller->seller_banner)) {
                \Storage::delete($seller->seller_banner);
            }

            // Store new banner
            $seller->seller_banner = $request->file('seller_banner')->store('sellers_banners');
        }

        // Handle License update
        if ($request->hasFile('license')) {
            // Delete the old license if it exists
            if ($seller->license && \Storage::exists($seller->license)) {
                \Storage::delete($seller->license);
            }

            // Store new license
            $seller->license = $request->file('license')->store('sellers_licenses');
        }

        if ($seller->request_status == 'rejected') {
            $seller->request_status = 'pending';
        }
        // Save updated seller information
        $seller->save();

        return redirect()->route('seller.dashboard')->with('success', 'تم تحديث بيانات البائع بنجاح');
    } catch (\Throwable $th) {
        return redirect()->route('seller.dashboard')->with('error', $th->getMessage());
    }
} 

}

<?php

namespace App\Http\Controllers\MVC\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Sellers\Seller;

class AllSellersController extends Controller
{
    //get all sellers (request_status = approved)
    public function index(){
        try {
            $sellers = Seller::where('request_status', 'approved')->get();
            return view('admin.sellers.approvedRequests', compact('sellers'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    // show seller details
    public function show($id){ 
        try {
            $seller = Seller::findOrFail($id);
            return view('admin.sellers.showSellerInfo', compact('seller'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    // Update seller page
    public function edit($id){
        try {
            $seller = Seller::findOrFail($id);
            return view('admin.sellers.updateSeller', compact('seller'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
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
            'seller_logo' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'seller_banner' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
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
    
            // Save updated seller information
            $seller->save();
    
            return redirect()->route('admin.sellers.approved')->with('success', 'تم تحديث بيانات البائع بنجاح');
        } catch (\Throwable $th) {
            return redirect()->route('admin.sellers.approved')->with('error', $th->getMessage());
        }
    }

    // Delete seller
    public function delete($id){
        try {
            $seller = Seller::findOrFail($id);
            $seller->delete();
            return redirect()->route('admin.sellers.approved')->with('success', 'تم حذف البائع بنجاح');
        } catch (\Throwable $th) {
            return redirect()->route('admin.sellers.approved')->with('error', $th->getMessage());
        }
    }
    

}

<?php

namespace App\Http\Controllers\MVC\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Mail\SellerApprovalMail;
use App\Mail\SellerRejectionMail;
use Illuminate\Support\Facades\Mail;

use App\Models\Sellers\Seller;

class SellersRequestsController extends Controller
{
    // get all requests (request_status = pending)
    public function index(){
        $sellers = Seller::where('request_status', 'pending')->get();
        return view('admin.sellers.pendingRequests', compact('sellers'));
    }

    // show new seller requests 
    public function show($id){
        $seller = Seller::find($id);
        return view('admin.sellers.showRequest', compact('seller'));
    }

    // approve seller request
    public function approveSellerRequest($id)
{
    $seller = Seller::find($id);
    
    // Update seller status to approved
    $seller->status = 'active';
    $seller->request_status = 'approved';
    $seller->save();
    
    // Send approval email
    Mail::to($seller->email)->send(new SellerApprovalMail($seller));
    
    return redirect()->route('admin.sellers.requests')->with('success', 'تم الموافقة على الطلب بنجاح');
}

    // reject seller request with reason
    public function rejectSellerRequest($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'request_rejection_reason' => 'required',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput(); 
        }
    
        try {
            $seller = Seller::find($id);
    
            // Update seller's request status to rejected and save rejection reason
            $seller->request_status = 'rejected';
            $seller->request_rejection_reason = $request->request_rejection_reason;
            $seller->save();
    
            // Send rejection email to the seller
            Mail::to($seller->email)->send(new SellerRejectionMail($seller));
    
            return redirect()->route('admin.sellers.requests')->with('success', 'تم رفض الطلب بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

}

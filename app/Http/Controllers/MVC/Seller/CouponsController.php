<?php

namespace App\Http\Controllers\MVC\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Sellers\Coupon;

class CouponsController extends Controller
{
    public function index()
    {
        $coupons = Coupon::where('seller_id', auth()->id())
        ->orderBy('created_at', 'desc')
        ->get();
        return view('seller.coupons.coupons', compact('coupons'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:coupons,code',
            'discount_value' => 'required|numeric|min:0',
            'expires_at' => 'nullable|date',
            'usage_limit' => 'nullable|integer|min:1',
        ]);

        try{
            auth()->user()->coupons()->create($request->all());
            return redirect()->route('seller.coupons')->with('success', 'تم إضافة الكوبون بنجاح');
        }catch(\Exception $e){
            return redirect()->route('seller.coupons')->with('error', $e->getMessage());
        }
    }

    // Edit Coupon
    public function edit($id)
    {
        $coupon = auth()->user()->coupons()->findOrFail($id);
        return view('seller.coupons.editCoupon', compact('coupon'));
    }

    // Update Coupon
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required',
            'discount_value' => 'required|numeric|min:0',
            'expires_at' => 'nullable|date',
            'usage_limit' => 'nullable|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()], 422);
    }
        $coupon = auth()->user()->coupons()->findOrFail($id);
        $coupon->update($request->all());

        return redirect()->route('seller.coupons')->with('success', 'تم تحديث الكوبون بنجاح');
    }


    public function destroy($id)
    {
        $coupon = auth()->user()->coupons()->findOrFail($id);
        $coupon->delete();
        return redirect()->route('seller.coupons')->with('success', 'تم حذف الكوبون بنجاح');
    }


    // Apply a coupon and track usage count
    public function applyCoupon(Request $request)
    {
        $coupon = Coupon::where('code', $request->code)->first();

        if (!$coupon) {
            return back()->with('error', 'الكوبون غير موجود.');
        }

        if ($coupon->expires_at && Carbon::now()->greaterThan($coupon->expires_at)) {
            return back()->with('error', 'الكوبون منتهي الصلاحية.');
        }

        if ($coupon->usage_limit && $coupon->usage_count >= $coupon->usage_limit) {
            return back()->with('error', 'لقد تم استخدام الكوبون الحد الأقصى من المرات.');
        }

        // Increase usage count
        $coupon->increment('usage_count');

        // Apply coupon discount here based on discount type
        // e.g., $discount = $coupon->discount_value;

        return back()->with('success', 'تم تطبيق الكوبون بنجاح.');
    }
}

<?php

namespace App\Http\Controllers\API\Sellers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Sellers\Coupon;

class CouponsController extends Controller
{
    // Get Coupons
    public function index()
    {
        try{
            $coupons = Coupon::where('seller_id', auth()->id())->get();
            return response()->json(['status' => 'success', 'data' => $coupons], 200);
        }catch(\Exception $e){
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /****************************************************************************************/
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
            return response()->json(['status' => 'success', 'message' => 'تم إضافة الكوبون بنجاح' , 'data' => auth()->user()->coupons()->latest()->first()] );
        }catch(\Exception $e){
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    /******************************************************************************************/
    // Show Coupon
    public function show($id)
    {
        try{
            $coupon = auth()->user()->coupons()->findOrFail($id);
            return response()->json(['status' => 'success', 'data' => $coupon], 200);
        }catch(\Exception $e){
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /*****************************************************************************************/
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
        try{
            $coupon = auth()->user()->coupons()->findOrFail($id);
            $coupon->update($request->all());
            return response()->json(['status' => 'success', 'message' => 'تم تحديث الكوبون بنجاح' , 'data' => auth()->user()->coupons()->latest()->first()]);
        }catch(\Exception $e){
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

/*****************************************************************************************/
// Delete Coupon
    public function destroy($id)
    {
        try{
            $coupon = auth()->user()->coupons()->findOrFail($id);
            $coupon->delete();
            return response()->json(['status' => 'success', 'message' => 'تم حذف الكوبون بنجاح']);
        }catch(\Exception $e){
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}

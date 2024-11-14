<?php

namespace App\Http\Controllers\MVC\Customers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Customers\Customer;


class ProfileController extends Controller
{
    // Get Customer Profile Page
    public function index(){
        try {
            $customer = Auth::guard('customer')->user();
            return view('customer.profile' , compact('customer'));

        }catch (\Throwable $th) {
            return redirect()->route('customer.loginPage')->with('error', 'غير مصرح لك بالدخول');
        }
    }

    // Update Customer Profile
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'mimes:jpg,jpeg,png'],
        ]);
    
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()], 422);
        }
    
        try {
            // Get the authenticated customer
            $customer = Customer::findOrFail(Auth::guard('customer')->user()->id);
    
            // Update customer details
            $customer->first_name = $request->first_name;
            $customer->last_name = $request->last_name;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->location = $request->location;
    
            // Check if a new image is uploaded
            if ($request->hasFile('image')) {
                // Delete the old image if it exists
                if ($customer->image) {
                    $oldImagePath = storage_path('app/' . $customer->image);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath); // Delete old image from storage
                    }
                }
    
                // Store the new image and update the customer model
                $newImagePath = $request->file('image')->store('customers_images');
                $customer->image = $newImagePath;
            }
    
            // Save the customer
            $customer->save();
    
            return redirect()->route('customer.profile')->with('success', 'تم تعديل الملف الشخصي بنجاح');
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }
    
}

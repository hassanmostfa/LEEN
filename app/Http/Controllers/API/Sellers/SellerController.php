<?php

namespace App\Http\Controllers\API\Sellers;

use App\Http\Controllers\Controller;
use App\Models\Sellers\Seller;
use App\Http\Requests\RegisterSellerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminNotificationMail;
use App\Models\Sellers\ChatRoom;
use App\Models\Customers\HomeBooking;
use App\Models\Customers\StudioBooking;
use App\Models\Customers\Customer;
use App\Http\Resources\SellerResource;

use App\Http\Requests\UpdateSellerRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;


class SellerController extends Controller
{
    public function registerSeller(RegisterSellerRequest $request)
    {
        try {
            $seller = Seller::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone ?? null,
                'phone_verified_at' => now(),
                'location' => $request->location,
                'seller_logo' => $request->hasFile('seller_logo') ? $request->file('seller_logo')->store('sellers_logos') : null,
                'seller_banner' => $request->hasFile('seller_banner') ? $request->file('seller_banner')->store('sellers_banners') : null,
                'license' => $request->hasFile('license') ? $request->file('license')->store('licenses') : null,
                'service_type' => $request->service_type,
            ]);

            // Send email notification to admin
            $adminEmail = 'hassan.elshiat@gmail.com';
            Mail::to($adminEmail)->send(new AdminNotificationMail($seller));

            return response()->json(['status' => 'success', 'message' => 'تم التسجيل بنجاح' ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /*************************************************************************************** */

    // Seller login
    public function sellerLogin(Request $request)
{
    // Validate the request data
    $validator = Validator::make($request->all(), [
        'login' => ['required', 'string'], // Can be email or phone
        'password' => ['required', 'string', 'min:8'],
    ]);

    if ($validator->fails()) {
        return response()->json(['status' => 'error', 'message' => $validator->errors()], 422);
    }

    // Get the login input (email or phone)
    $loginInput = $request->login;

    // Find the seller by email or phone
    $seller = Seller::where('email', $loginInput)
                    ->orWhere('phone', $loginInput)
                    ->first();

    // Check if seller exists
    if (!$seller) {
        return response()->json(['status' => 'error', 'message' => 'البائع غير موجود'], 404);
    }

    // Check seller status
    if ($seller->status !== 'active') {
        return response()->json(['status' => 'error', 'message' => 'غير مصرح لك بالدخول'], 403);
    }

    // Attempt to log in using email or phone and password
    if (Auth::guard('seller')->attempt(['email' => $seller->email, 'password' => $request->password]) || 
        Auth::guard('seller')->attempt(['phone' => $seller->phone, 'password' => $request->password])) {
        
        // Generate a token for the authenticated seller
        $token = $seller->createToken('SellerToken')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'تم تسجيل الدخول بنجاح',
            'data' => [
                'seller' => $seller,
                'token_type' => 'Bearer',
                'token' => $token
            ]
        ]);
    } else {
        return response()->json(['status' => 'error', 'message' => 'البريد الالكتروني/رقم الهاتف أو كلمة المرور غير صحيحة'], 401);
    }
}

/*************************************************************************************** */

// Seller logout
public function logout(Request $request)
{
    $request->user()->currentAccessToken()->delete();
    return response()->json(['status' => 'success', 'message' => 'تم تسجيل الخروج بنجاح']);
}

/*************************************************************************************** */

// get Seller Info
public function getSellerInfo(Request $request)
{
    try{
        $seller = Auth::guard('seller')->user();
        return response()->json(['status' => 'success', 'data' => new SellerResource($seller)]);
    }catch(\Exception $e){
        return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
    }
}

/*************************************************************************************** */
// Update Seller Info
public function updateSellerInfo(Request $request , $id)
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
        // Find the seller by ID
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
            if ($seller->seller_logo && Storage::exists($seller->seller_logo)) {
                Storage::delete($seller->seller_logo);
            }

            // Store new logo
            $seller->seller_logo = $request->file('seller_logo')->store('sellers_logos');
        }

        // Handle banner update
        if ($request->hasFile('seller_banner')) {
            // Delete the old banner if it exists
            if ($seller->seller_banner && Storage::exists($seller->seller_banner)) {
                Storage::delete($seller->seller_banner);
            }

            // Store new banner
            $seller->seller_banner = $request->file('seller_banner')->store('sellers_banners');
        }

        // Handle License update
        if ($request->hasFile('license')) {
            // Delete the old license if it exists
            if ($seller->license && Storage::exists($seller->license)) {
                Storage::delete($seller->license);
            }

            // Store new license
            $seller->license = $request->file('license')->store('sellers_licenses');
        }

        if ($seller->request_status == 'rejected') {
            $seller->request_status = 'pending';
        }

        // Save updated seller information
        $seller->save();

        return response()->json([
            'status' => 'success',
            'message' => 'تم تحديث بيانات البائع بنجاح',
            'data' => $seller
        ], 200); // 200 OK
    } catch (\Throwable $th) {
        return response()->json([
            'status' => 'error',
            'message' => $th->getMessage()
        ], 500); // 500 Internal Server Error
    }
}
/*************************************************************************************** */
// Get All Clients for a specific seller
public function getAllClients(Request $request)
{
    try {
        // Get the seller ID using Sanctum guard
        $sellerId = Auth::guard('seller')->user()->id;

        // Get home and studio clients by seller ID
        $homeClients = HomeBooking::where('seller_id', $sellerId)->pluck('customer_id')->toArray();
        $studioClients = StudioBooking::where('seller_id', $sellerId)->pluck('customer_id')->toArray();

        // Merge and make client list unique
        $clientIds = array_unique(array_merge($homeClients, $studioClients));

        $clients = [];

        foreach ($clientIds as $clientId) {
            // Fetch chat room for the seller and client
            $chatRoom = ChatRoom::where('seller_id', $sellerId)
                ->where('customer_id', $clientId)
                ->with(['messages' => function ($query) {
                    // Get the latest message for each chat room
                    $query->orderBy('created_at', 'desc')->limit(1);
                }])
                ->withCount(['messages as unread_messages_count' => function ($query) use ($sellerId) {
                    // Count unread messages in this chat room for the seller
                    $query->where('is_read', false)
                          ->where('sender_type', '!=', 'App\Models\Sellers\Seller');
                }])
                ->first();

            // Collect client info with chat details
            $client = Customer::find($clientId);
            $clients[] = [
                'client' => $client,
                'latestMessage' => $chatRoom ? $chatRoom->messages->first() : null,
                'unreadCount' => $chatRoom ? $chatRoom->unread_messages_count : 0,
            ];
        }

        return response()->json([
            'status' => 'success',
            'data' => $clients,
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
        ], 500);
    }
}

}

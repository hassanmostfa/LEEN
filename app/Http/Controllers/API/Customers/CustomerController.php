<?php

namespace App\Http\Controllers\API\Customers;

use App\Http\Controllers\Controller;
use App\Http\Resources\SellerResource;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Mail\NewCustomerAdminNotificationMail;
use App\Mail\WelcomCustomerNotificationMail;
use Illuminate\Support\Facades\Mail;

use App\Models\Customers\Customer;
use App\Models\Customers\HomeBooking;
use App\Models\Customers\StudioBooking;
use App\Models\Sellers\Seller;
use App\Models\Sellers\Message;
use App\Models\Sellers\ChatRoom;
class CustomerController extends Controller
{
    public function registerCustomer(Request $request)
    {
            $validator = Validator::make($request->all(), [
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'location' => ['required', 'string', 'max:255'],
                'password' => ['required', 'string', 'min:8' , 'confirmed'],
            ]);
    
            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message' => $validator->errors()], 422);
            }
    
            try {
                $customer = Customer::create([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'location' => $request->location,
                    'password' => Hash::make($request->password),
                    'phone' => $request->phone ?? null,
                    'phone_verified_at' => now(),
                ]);
    
                $customer->save();

                //send email to admin that a new customer has registered
                $adminEmail = 'hassan.elshiat@gmail.com'; //  Admin Email
                Mail::to($adminEmail)->send(new NewCustomerAdminNotificationMail($customer));

                // Send welcome email to the customer
                Mail::to($customer->email)->send(new WelcomCustomerNotificationMail($customer));

            return response()->json(['status' => 'success', 'message' => 'تم التسجيل بنجاح' ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /*************************************************************************************** */

    // Customer login
    public function customerLogin(Request $request)
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

    // Find the customer by email or phone
    $customer = Customer::where('email', $loginInput)
                    ->orWhere('phone', $loginInput)
                    ->first();

    // Check if seller exists
    if (!$customer) {
        return response()->json(['status' => 'error', 'message' => 'المستخدم غير موجود'], 404);
    }

    // Check seller status
    if ($customer->status !== 'active') {
        return response()->json(['status' => 'error', 'message' => 'غير مصرح لك بالدخول'], 403);
    }

    // Attempt to log in using email or phone and password
    if (Auth::guard('customer')->attempt(['email' => $customer->email, 'password' => $request->password]) || 
        Auth::guard('customer')->attempt(['phone' => $customer->phone, 'password' => $request->password])) {
        
        // Generate a token for the authenticated seller
        $token = $customer->createToken('customerToken')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'تم تسجيل الدخول بنجاح',
            'data' => [
                'customer' => $customer,
                'token_type' => 'Bearer',
                'token' => $token
            ]
        ]);
    } else {
        return response()->json(['status' => 'error', 'message' => 'البريد الالكتروني/رقم الهاتف أو كلمة المرور غير صحيحة'], 401);
    }
}

/*************************************************************************************** */

    // Customer logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['status' => 'success', 'message' => 'تم تسجيل الخروج بنجاح']);
    }

    // get Customer Info
    public function show(Request $request){
        $customer = $request->user();
        return response()->json(['status' => 'success', 'data' => $customer]);
    }

/*************************************************************************************** */
// Update Customer Profile
public function update(Request $request, $id){

    $validator = Validator::make($request->all(), [
        'first_name' => ['required', 'string', 'max:255'],
        'last_name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255'],
        'location' => ['required', 'string', 'max:255'],
        'image' => ['nullable', 'mimes:jpg,jpeg,png'],
    ]);

    if ($validator->fails()) {
        return response()->json(['status' => 'error', 'message' => $validator->errors()], 422); 
    }

    try {
        $customer = Customer::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/customers'), $imageName);
            $customer->image = $imageName;
        }

        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->email = $request->email;
        $customer->location = $request->location;
        $customer->phone = $request->phone ?? null;

        $customer->save();

        return response()->json(['status' => 'success', 'message' => 'تم تحديث الملف الشخصي بنجاح' , 'data' => $customer]);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
    }
}

/*****************************************************************************************/
// get all sellers for the customer
public function getCustomerSellers()
{
    $customerId = Auth::guard('customer')->user()->id;

    // Step 1: Retrieve seller IDs from both bookings tables
    $homeServiceSellerIds = HomeBooking::where('customer_id', $customerId)
        ->pluck('seller_id')
        ->toArray();

    $studioServiceSellerIds = StudioBooking::where('customer_id', $customerId)
        ->pluck('seller_id')
        ->toArray();

    // Combine both seller IDs into a unique list
    $sellerIds = array_unique(array_merge($homeServiceSellerIds, $studioServiceSellerIds));

    // Step 2: Retrieve seller information
    $sellers = Seller::whereIn('id', $sellerIds)->get();

    // Step 3: Add chat details for each seller
    $sellersWithChatDetails = $sellers->map(function ($seller) use ($customerId) {
        $chatRoom = ChatRoom::where('customer_id', $customerId)
            ->where('seller_id', $seller->id)
            ->with(['messages' => function ($query) {
                $query->orderBy('created_at', 'desc')->limit(1);
            }])
            ->withCount(['messages as unread_messages_count' => function ($query) use ($customerId) {
                $query->where('is_read', false)
                      ->where('sender_type', '!=', 'App\Models\Customers\Customer');
            }])
            ->first();

        $latestMessage = $chatRoom ? $chatRoom->messages->first() : null;
        $unreadCount = $chatRoom ? $chatRoom->unread_messages_count : 0;

        return [
            'seller' => new SellerResource($seller),
            'latestMessage' => $latestMessage,
            'unreadCount' => $unreadCount,
        ];
    });

    return response()->json(['status' => 'success', 'data' => $sellersWithChatDetails]);}
}

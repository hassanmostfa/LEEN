<?php

namespace App\Http\Controllers\MVC\Customers;

use App\Http\Controllers\Controller;
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
        // Register Page
        public function customerRegisterPage()
        {
            return view('customer.auth.register');
        }
    
        // Register Store
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
    
            // Retrieve the phone number from the session (stored during OTP verification)
            $phone = $request->session()->get('phone');
    
            if (!$phone) {
                return response()->json(['status' => 'error', 'message' => 'Phone number not found in session.']);
            }
    
            try {
                $customer = Customer::create([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'location' => $request->location,
                    'password' => Hash::make($request->password),
                    'phone' => $phone,
                    'phone_verified_at' => now(),
                ]);
    
                $customer->save();

                //send email to admin that a new customer has registered
                $adminEmail = 'hassan.elshiat@gmail.com'; //  Admin Email
                Mail::to($adminEmail)->send(new NewCustomerAdminNotificationMail($customer));

                // Send welcome email to the customer
                Mail::to($customer->email)->send(new WelcomCustomerNotificationMail($customer));

                return response()->json(['status' => 'success', 'message' => 'تم التسجيل بنجاح']);
            } catch (\Exception $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
            }
        }
    
        // Login Page
        public function customerLoginPage()
        {
            return view('customer.auth.login');
        }
    
        
        // Login ِAction
        public function customerLogin(Request $request)
        {

            $validator = Validator::make($request->all(), [
                'login' => ['required', 'string'],
                'password' => ['required', 'string', 'min:8'],
            ]);
        
            if ($validator->fails()) {
                return redirect()->route('customer.loginPage')->withErrors($validator)->withInput();
            }
        
            // Get the login input (email or phone)
            $loginInput = $request->login;
        
            // Find the seller by email or phone
            $customer = Customer::where('email', $loginInput)
                            ->orWhere('phone', $loginInput)
                            ->first();
        
            // Check if customer exists
            if (!$customer) {
                return redirect()->route('customer.loginPage')->with('error', 'المستخدم غير موجود');
            }
        
            // Check customer status and request status
            if ($customer->status !== 'active') {
                return redirect()->route('customer.loginPage')->with('error', 'غير مصرح لك بالدخول');
            }
        
            // Check credentials
            if (Auth::guard('customer')->attempt(['email' => $customer->email, 'password' => $request->password]) || 
                Auth::guard('customer')->attempt(['phone' => $customer->phone, 'password' => $request->password])) {
                
                        // After a successful login
                        if (session()->has('url.intended')) {
                            $redirectTo = session('url.intended');
                            session()->forget('url.intended');  // Optional: Clear the intended URL after redirect
                            return redirect()->to($redirectTo);
                        }
                return redirect()->route('home')->with('success', 'تم تسجيل الدخول بنجاح');
            } else {
                return redirect()->route('customer.loginPage')->with('error', 'البريد الالكتروني/رقم الهاتف أو كلمة المرور غير صحيحة');
            }
        }

        // Logout Action
        public function logout()
        {
            Auth::guard('customer')->logout();

            return redirect()->route('customer.loginPage');
        }

        // Customer Dashboard
        public function index()
        {
            // Get the authenticated customer's details
            $customer = Auth::guard('customer')->user();

            return view('customer.customerProfile' , compact('customer'));
        }

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
            'seller' => $seller,
            'latestMessage' => $latestMessage,
            'unreadCount' => $unreadCount,
        ];
    });

    return view('customer.chat.sellers', ['sellers' => $sellersWithChatDetails]);
}

}

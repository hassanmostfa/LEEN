<?php

namespace App\Http\Controllers\MVC\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Mail\AdminNotificationMail;
use Illuminate\Support\Facades\Mail;

use App\Models\Sellers\Seller;
use App\Models\Sellers\ChatRoom;
use App\Models\Customers\HomeBooking;
use App\Models\Customers\StudioBooking;
use App\Models\Customers\Customer;

class SellerController extends Controller
{
    // Register Page
    public function sellerRegisterPage()
    {
        return view('seller.auth.register');
    }

    // Register Store
    public function registerSeller(Request $request)
{
    $validator = Validator::make($request->all(), [
        'first_name' => ['required', 'string', 'max:255'],
        'last_name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255'],
        'password' => ['required', 'string', 'min:8' , 'confirmed'],
        'seller_logo' => ['nullable', 'file', 'mimes:jpg,jpeg,png'],
        'seller_banner' => ['nullable', 'file', 'mimes:jpg,jpeg,png'],
        'license' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png'],
        'location' => ['required', 'string', 'max:255'],
        'service_type' => ['required', 'string', 'in:in_house,at_headquarters'],
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
        $seller = Seller::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $phone,
            'phone_verified_at' => now(),
            'location' => $request->location,
            'seller_logo' => $request->hasFile('seller_logo') ? $request->file('seller_logo')->store('sellers_logos') : null,
            'seller_banner' => $request->hasFile('seller_banner') ? $request->file('seller_banner')->store('sellers_banners') : null,
            'license' => $request->hasFile('license') ? $request->file('license')->store('licenses') : null,
            'service_type' => $request->service_type,
        ]);

        $seller->save();

        // Send email notification to admin
        $adminEmail = 'hassan.elshiat@gmail.com'; //  Admin Email
        Mail::to($adminEmail)->send(new AdminNotificationMail($seller));

        return response()->json(['status' => 'success', 'message' => 'تم التسجيل بنجاح']);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' =>$e->getMessage()], 500);
    }
}

    // Login Page
    public function sellerLoginPage()
    {
        return view('seller.auth.login');
    }

    
    // Login ِAction
    public function sellerLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8'],
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('seller.loginPage')->withErrors($validator)->withInput();
        }
    
        // Get the login input (email or phone)
        $loginInput = $request->login;
    
        // Find the seller by email or phone
        $seller = Seller::where('email', $loginInput)
                        ->orWhere('phone', $loginInput)
                        ->first();
    
        // Check if seller exists
        if (!$seller) {
            return redirect()->route('seller.loginPage')->with('error', 'البائع غير موجود');
        }
    
        // Check seller status and request status
        if ($seller->status !== 'active') {
            return redirect()->route('seller.loginPage')->with('error', 'غير مصرح لك بالدخول');
        }
    
        // Check credentials
        if (Auth::guard('seller')->attempt(['email' => $seller->email, 'password' => $request->password]) || 
            Auth::guard('seller')->attempt(['phone' => $seller->phone, 'password' => $request->password])) {
            
            // If status is active and request is approved, redirect to dashboard
            return redirect()->route('seller.dashboard')->with('success', 'تم تسجيل الدخول بنجاح');
        } else {
            return redirect()->route('seller.loginPage')->with('error', 'البريد الالكتروني/رقم الهاتف أو كلمة المرور غير صحيحة');
        }
    }


    // Logout Action
    public function logout()
    {
        Auth::guard('seller')->logout();
        return redirect()->route('seller.loginPage')->with('success', 'تم تسجيل الخروج بنجاح');
    }


    // Seller Dashboard
    public function sellerDashboard()
    {
        return view('seller.sellerDashboard');
    }

    // get All Seller Clients from bookings table
    public function getAllClients()
    {
        // Get the seller ID
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
                          ->where('sender_type', '!=', 'App\Models\Sellers\Seller'); // Messages not sent by the seller
                }])
                ->first();
    
            if ($chatRoom) {
                $latestMessage = $chatRoom->messages->first();
                $unreadCount = $chatRoom->unread_messages_count;
    
                // Collect client info with chat details
                $client = Customer::find($clientId);
                $clients[] = [
                    'client' => $client,
                    'latestMessage' => $latestMessage,
                    'unreadCount' => $unreadCount,
                    'latestMessageTimestamp' => $latestMessage?->created_at, // For sorting
                ];
            } else {
                // If no chat room exists, still add the client
                $client = Customer::find($clientId);
                $clients[] = [
                    'client' => $client,
                    'latestMessage' => null,
                    'unreadCount' => 0,
                    'latestMessageTimestamp' => null, // For sorting
                ];
            }
        }
    
        // Sort clients by the timestamp of the latest message, newest first
        usort($clients, function ($a, $b) {
            return $b['latestMessageTimestamp'] <=> $a['latestMessageTimestamp'];
        });
    
        return view('seller.clients', compact('clients'));
    }
    
}

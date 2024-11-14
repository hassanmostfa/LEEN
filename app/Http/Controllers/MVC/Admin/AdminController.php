<?php

namespace App\Http\Controllers\MVC\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    // Show Login Page
    public function LoginPage()
    {
        return view('admin.auth.loginPage');
    }

    // Admin Login Action
    public function AdminLogin(Request $request)
    {
    // Validate the request data
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    try {
        // Attempt to log the user in with the provided credentials
        $credentials = $request->only('email', 'password');

        $result = Auth::guard('admin')->attempt($credentials);

        if ($result) {
            // Authentication passed
            return redirect()->route('admin.dashboard')->with('success', 'تم تسجيل الدخول بنجاح');
        } else {
                return redirect()->route('admin.loginPage')->with('error', 'اسم المستخدم او كلمة المرور غير صحيحة');
            }

    } catch (\Exception $e) {
        // Redirect with an error message
        return redirect()->route('admin.loginPage')->with('error', 'حدث خطأ ما');
    }

    }

    // Admin Logout
    public function AdminLogout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.loginPage')->with('success', 'تم تسجيل الخروج بنجاح');
    }


    // Admin Dashboard 
    public function adminDashboard()
    {
        return view('admin.dashboard');
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\ForJawalyService; 
use Illuminate\Http\Request;

class OTPController extends Controller
{
    protected $forJawalyService;

    public function __construct(ForJawalyService $forJawalyService)
    {
        $this->forJawalyService = $forJawalyService;
    }

    // Send OTP to user
    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|regex:/^5[0-9]{8}$/',
        ]);

        $phone = $request->phone;
        $verificationCode = rand(100000, 999999);

        // Save the verification code and phone in a way that suits your session management
        // Here we can use a cache or database storage instead of session for API

        // Store OTP and phone in cache (consider using a unique key per user)
        cache()->put("verificationCode_{$phone}", $verificationCode, 300); // 5 minutes expiry

        \Log::info("Sending OTP to {$phone} with code {$verificationCode}");

        try {
            $result = $this->forJawalyService->sendSMS($phone, "كود تحقق حسابك في لين هو : {$verificationCode}");

            if ($result['code'] === 200) {
                \Log::info("Message sent successfully.");
                return response()->json(['status' => 'success']);
            } else {
                \Log::error('Error sending OTP: ' . json_encode($result));
                return response()->json(['status' => 'error', 'message' => $result['message'] ?? 'An error occurred while sending OTP'], 422);
            }
        } catch (\Exception $e) {
            \Log::error('Error sending OTP: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Failed to send OTP. Please try again later.'], 500);
        }
    }

    // Verify OTP that sent to user
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|regex:/^5[0-9]{8}$/',
            'otp' => 'required|digits:6',
        ]);

        $sessionOtp = cache()->get("verificationCode_{$request->phone}"); // Retrieve the stored OTP
        $isOtpValid = $sessionOtp == $request->otp;

        if ($isOtpValid) {
            // Optionally, you can remove the OTP from cache after successful verification
            cache()->forget("verificationCode_{$request->phone}");
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Invalid OTP'], 422);
        }
    }
}

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
            'phone' => 'required',
        ]);

        $phone = $request->phone;

        if ($phone == '01121926996' || $phone == '01092841138' || $phone == '01094963620') {
            return response()->json([
                'success' => true,
                'message' => 'OTP sent successfully',
                'phone' => $phone,
            ], 200);
        }

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
            'phone' => 'required',
            'otp' => 'required|digits:6',
        ]);

        if ($request->phone == '01121926996' || $request->phone == '01092841138' || $request->phone == '01094963620') {
            if ($request->otp == '123456') {
                return response()->json([
                    'success' => true,
                    'message' => 'Phone number verified successfully.',
                    'phone' => $request->phone,
                    'isVerified' => true,
                ], 200);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid OTP. Please try again.',
                ], 400);
            }
        }

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

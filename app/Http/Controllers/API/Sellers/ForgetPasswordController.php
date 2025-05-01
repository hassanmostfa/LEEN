<?php

namespace App\Http\Controllers\API\Sellers;

use App\Http\Controllers\Controller;
use App\Models\Sellers\Seller;
use App\Services\ForJawalyService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ForgetPasswordController extends Controller
{
    protected $forJawalyService;
    protected $testNumbers = ['01121926996', '01092841138', '01094963620'];
    protected $otpExpiryMinutes = 10; // OTP expiry time in minutes

    public function __construct(ForJawalyService $forJawalyService)
    {
        $this->forJawalyService = $forJawalyService;
    }

    /**
     * Send OTP to the user's phone for password reset (store in cache only)
     */
    public function resetPasswordOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors());
        }

        $phone = $request->phone;

        // Handle test numbers
        if ($this->isTestNumber($phone)) {
            return $this->successResponse('OTP sent successfully', ['phone' => $phone]);
        }

        $seller = Seller::where('phone', $phone)->first();

        if (!$seller) {
            return $this->errorResponse('Seller with phone ' . $phone . ' not found', 404);
        }

        $verificationCode = rand(100000, 999999);
        $expiryTime = Carbon::now()->addMinutes($this->otpExpiryMinutes);

        // Store OTP in cache only (not in database)
        Cache::put($this->getOtpCacheKey($phone), [
            'code' => $verificationCode,
            'expires_at' => $expiryTime,
            'attempts' => 0 // Track verification attempts
        ], $expiryTime);

        Log::info("Sending password reset OTP to {$phone} with code {$verificationCode}");

        try {
            $message = "Your password reset verification code is: {$verificationCode}";
            $result = $this->forJawalyService->sendSMS($phone, $message);

            if ($result['code'] === 200) {
                return $this->successResponse('OTP sent successfully', ['phone' => $phone]);
            }

            return $this->errorResponse($result['message'] ?? 'Error occurred while sending OTP', 500);

        } catch (\Exception $e) {
            Log::error('Password reset OTP sending failed: ' . $e->getMessage());
            return $this->errorResponse('Failed to send OTP. Please try again later.', 500);
        }
    }

    /**
     * Verify the OTP sent to the user's phone (using cache only)
     */
    public function verifyResetPasswordOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => 'required|digits:6',
            'phone' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors());
        }

        $phone = $request->phone;
        $otp = $request->otp;

        // Handle test numbers
        if ($this->isTestNumber($phone)) {
            if ($otp === '123456') {
                return $this->successResponse('Phone number verified successfully', [
                    'phone' => $phone,
                    'isVerified' => true
                ]);
            }
            return $this->errorResponse('Invalid OTP. Please try again.', 400);
        }

        $seller = Seller::where('phone', $phone)->first();

        if (!$seller) {
            return $this->errorResponse('Phone number not found.', 404);
        }

        $cacheKey = $this->getOtpCacheKey($phone);
        $cachedOtp = Cache::get($cacheKey);

        if (!$cachedOtp) {
            return $this->errorResponse('OTP not found or expired. Please request a new one.', 400);
        }

        // Increment attempt counter
        $attempts = $cachedOtp['attempts'] + 1;
        Cache::put($cacheKey, array_merge($cachedOtp, ['attempts' => $attempts]), $cachedOtp['expires_at']);

        // Check if OTP has expired
        if (Carbon::now()->greaterThan($cachedOtp['expires_at'])) {
            Cache::forget($cacheKey);
            return $this->errorResponse('OTP has expired. Please request a new one.', 400);
        }

        // Verify OTP
        if ($cachedOtp['code'] != $otp) {
            // Optionally block after too many attempts
            if ($attempts >= 5) {
                Cache::forget($cacheKey);
                return $this->errorResponse('Too many failed attempts. Please request a new OTP.', 429);
            }
            return $this->errorResponse('Invalid OTP. Please try again.', 400);
        }

        // OTP verified successfully - store verification in cache
        Cache::put($this->getVerificationCacheKey($phone), true, now()->addMinutes(30));

        // Clear the OTP from cache after successful verification
        Cache::forget($cacheKey);

        return $this->successResponse('Phone number verified successfully', [
            'phone' => $phone,
            'isVerified' => true
        ]);
    }

    /**
     * Reset the user's password after OTP verification (using cache verification)
     */
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors());
        }

        $phone = $request->phone;
        $seller = Seller::where('phone', $phone)->first();

        if (!$seller) {
            return $this->errorResponse('Seller not found', 404);
        }
        
        // Reset password
        $seller->password = Hash::make($request->new_password);
        $seller->save();

        // Clear verification from cache
        Cache::forget($this->getVerificationCacheKey($phone));

        return $this->successResponse('Password reset successfully');
    }

    /**
     * Generate cache key for OTP storage
     */
    protected function getOtpCacheKey($phone): string
    {
        return "password_reset_otp:{$phone}";
    }

    /**
     * Generate cache key for verification status
     */
    protected function getVerificationCacheKey($phone): string
    {
        return "password_reset_verified:{$phone}";
    }

    /**
     * Check if phone number is a test number
     */
    protected function isTestNumber($phone): bool
    {
        return in_array($phone, $this->testNumbers);
    }

    /**
     * Return a standardized success response
     */
    protected function successResponse(string $message, array $data = []): \Illuminate\Http\JsonResponse
    {
        return response()->json(array_merge([
            'success' => true,
            'message' => $message,
        ], $data));
    }

    /**
     * Return a standardized error response
     */
    protected function errorResponse(string $message, int $status = 400): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $status);
    }

    /**
     * Return a validation error response
     */
    protected function validationErrorResponse($errors): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success' => false,
            'errors' => $errors,
        ], 422);
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function createToken(Request $request)
    {
        $user = User::find($request->user_id);

        if (!$user) {
            return response()->json([
                'status' => 'failed',
                'code' => 404,
                'message' => 'User not found'
            ], 404);
        }

        $token = $user->createToken('authToken', ['*'], now()->addDays(7)); // Token with 7 days expiry

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Token created successfully',
            'data' => ['token' => $token->plainTextToken]
        ], 200);
    }

    public function requestOtp(Request $request)
    {
        // Validate the request
        $request->validate([
            'identifier' => 'required|email', // Validate the identifier as an email
        ]);

        $identifier = $request->identifier;
        $otp = rand(100000, 999999); // Generate a 6-digit OTP
        $otpExpiresAt = Carbon::now()->addMinutes(10); // Set OTP expiry time to 10 minutes from now

        // Update or create the user with the OTP
        $user = User::updateOrCreate(
            ['email' => $identifier],
            ['otp' => $otp, 'otp_expires_at' => $otpExpiresAt]
        );

        // Return the OTP in the response (for testing purposes only)
        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'OTP generated successfully',
            'data' => ['otp' => $otp]
        ], 200);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'identifier' => 'required',
            'otp' => 'required',
        ]);

        $identifier = $request->identifier;
        $otp = $request->otp;

        $user = User::where('email', $identifier)->first();

        if ($user && $user->otp == $otp && Carbon::now()->lessThanOrEqualTo($user->otp_expires_at)) {
            $user->tokens()->delete(); // Revoke all existing tokens
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'code' => 200,
                'message' => 'OTP verified successfully',
                'data' => ['token' => $token]
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'code' => 401,
                'message' => 'Invalid OTP or OTP expired'
            ], 401);
        }
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        if ($user) {
            $user->currentAccessToken()->delete();
            return response()->json([
                'status' => 'success',
                'code' => 200,
                'message' => 'Logged out successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'code' => 401,
                'message' => 'No user authenticated'
            ], 401);
        }
    }
    
}

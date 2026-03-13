<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Validator;
use App\Models\User;


class AuthController extends Controller
{

    public function sendOtp(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'number' => 'required|digits:10',
                'role'   => 'required|in:user,vendor,delivery'
            ], [
                'role.in'    => 'Role must be either user, vendor, or delivery',
                'number.digits' => 'Number must be exactly 10 digits',
            ]);
        
            $user = User::firstOrCreate(
                ['number' => $request->number], // search by number
                ['role' => $request->role]      // set role if not found
            );

       
            $otp = rand(1000, 9999);

            $user->update([
                'otp' => $otp,
                'otp_expires_at' => now()->addMinutes(5)
            ]);

            // Send SMS here (Fast2SMS / Twilio etc)

            return response()->json([
                'status' => true,
                'message' => 'OTP sent successfully',
                'otp' => $otp // remove in production
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {

            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {

            Log::error('OTP Send Error: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong. Please try again later.'
            ], 500);
        }
    }

    public function verifyOtp(Request $request)
    {
        try {

            $request->validate([
                'number' => 'required|digits:10',
                'otp' => 'required|digits:4'
            ]);

            $user = User::where('number', $request->number)->first();

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found'
                ], 404);
            }

            if ($user->otp != $request->otp) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid OTP'
                ], 401);
            }

            if (now()->gt($user->otp_expires_at)) {
                return response()->json([
                    'status' => false,
                    'message' => 'OTP expired'
                ], 401);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            $user->update([
                'otp' => null,
                'otp_expires_at' => null
            ]);

            return response()->json([
                'status' => true,
                'message' => 'OTP verified successfully',
                'token' => $token,
                'user' => new UserResource($user)
            ], 200);

        } catch (ValidationException $e) {

            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {

            Log::error('Verify OTP Error: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong. Please try again later.'
            ], 500);
        }
    }

    

    
}




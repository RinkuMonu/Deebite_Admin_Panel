<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;   // For authentication
use Illuminate\Support\Facades\Log;    // For logging
use App\Http\Resources\UserResource;
use App\Models\User;

class DashBoardController extends Controller
{
     public function profile()
    {
        try {
            // Get currently authenticated user
            $user = Auth::user();

            // If somehow user is null
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found or not authenticated',
                ], 404);
            }

            // Return user data using UserResource
            return response()->json([
                'status' => true,
                'message' => 'User profile fetched successfully',
                'user' => $user
            ], 200);

        } catch (\Exception $e) {
            Log::error('Profile Fetch Error: ' . $e->getMessage());
            // Handle unexpected errors
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updateProfile(Request $request)
    {
        try {

            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found or not authenticated',
                ], 404);
            }

            // Validate incoming request
            $validatedData = $request->validate([
                'name' => 'sometimes|string|max:255',
                'email' => 'sometimes|email|unique:users,email,' . $user->id,
                'number' => 'required|digits:10|unique:users,number,' . $user->id,
                "address" => 'sometimes|string|max:500',
                // Add other fields as necessary
            ]);

            // Update user profile with validated data
            $user->update($validatedData);

            return response()->json([
                'status' => true,
                'message' => 'Profile updated successfully',
                'user' => $user
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Profile Update Error: ' . $e->getMessage());
            // Handle unexpected errors
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function activateDeactivate(Request $request)
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found or not authenticated',
                ], 404);
            }

            // ✅ Validation
            $request->validate([
                'status' => 'required|boolean',
                'latitude' => 'required_if:status,1|nullable|numeric | between:-90,90',
                'longitude' => 'required_if:status,1|nullable|numeric | between:-180,180',
            ]);

            // ✅ Update status
            $user->is_active = $request->status;

            // ✅ Save location only when active
            if ($request->status == 1) {
                $user->latitude = $request->latitude;
                $user->longitude = $request->longitude;
            }

            $user->save();

            return response()->json([
                'status' => true,
                'message' => $user->is_active 
                    ? 'Vendor activated successfully' 
                    : 'Vendor deactivated successfully',
                'is_active' => $user->is_active,
                "latitude" => $user->latitude,
                "longitude" => $user->longitude,
            ], 200);

        } catch (\Exception $e) {
            Log::error('Activate/Deactivate Error: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }







}
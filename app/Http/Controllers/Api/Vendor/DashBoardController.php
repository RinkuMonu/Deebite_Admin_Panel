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







}
<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;   // For authentication
use Illuminate\Support\Facades\Log;    // For logging
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\AddressBook;

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
                'name' => 'required|string|max:255',
                'email' => 'sometimes|email|unique:users,email,' . $user->id,
                'address' => 'sometimes|string|max:500',
                'latitude' => 'sometimes|numeric',
                'longitude' => 'sometimes|numeric',
                // Add other fields as necessary
            ]);

            // Update user profile with validated data
            $user->update($validatedData);

            return response()->json([
                'status' => true,
                'message' => 'Profile updated successfully',
                'user' => $user
            ], 200);

        } catch (\Exception $e) {
            Log::error('Profile Update Error: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function addAddress(Request $request)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found or not authenticated',
                ], 404);
            }

             $messages = [
                'address_type.in' => 'Address type must be one of: home, office, work, other.',
            ];

            // Validate incoming request
            $validatedData = $request->validate([
                'address_type' => 'required|in:home,office,work,other',
                'address' => 'required|string|max:500',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
            ], $messages);

            // Add user_id to validated data
            $validatedData['user_id'] = $user->id;

            // Create new address in address_book
            $address = AddressBook::create($validatedData);

            return response()->json([
                'status' => true,
                'message' => 'Address added successfully',
                'address' => $address
            ], 201);

        } catch (\Exception $e) {
            Log::error('Add Address Error: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    







}

<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;   // For authentication
use Illuminate\Support\Facades\Log;    // For logging
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\Category as FoodCategory;
use App\Models\AddressBook;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

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

    public function getAddress()
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found or not authenticated',
                ], 404);
            }

            // Fetch all addresses for the authenticated user
            $addresses = AddressBook::where('user_id', $user->id)->get();

            return response()->json([
                'status' => true,
                'message' => 'Addresses fetched successfully',
                'addresses' => $addresses
            ], 200);

        } catch (\Exception $e) {
            Log::error('Get Address Error: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getFoodCategories() {
        try {
            $categories = FoodCategory::select('id', 'name')->get();

            return response()->json([
                'status' => true,
                'message' => 'Food categories fetched successfully',
                'categories' => $categories
            ], 200);

        } catch (\Exception $e) {
            Log::error('Get Food Categories Error: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }    
    }

    public function getFoodItemsByCategory($category_id) {}  

    public function getNearbyVendors(Request $request)
    {
        try {

            // Validate request data
            
            $validator = Validator::make($request->all(), [
                'latitude' => 'required|numeric|between:-90,90',
                'longitude' => 'required|numeric|between:-180,180',
                'per_page' => 'sometimes|integer|min:1|max:100',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid input data',
                    'errors' => $validator->errors()
                ], 422);
            }

            $userLat = $request->latitude;
            $userLng = $request->longitude;
            $perPage = $request->per_page ?? 10;

            // Haversine formula
            $distanceFormula = "(6371 * acos(
                    cos(radians($userLat))
                    * cos(radians(users.latitude))
                    * cos(radians(users.longitude) - radians($userLng))
                    + sin(radians($userLat))
                    * sin(radians(users.latitude))
                ))";

            $vendors = User::select(
                    'users.*',
                    DB::raw("$distanceFormula AS distance"),
                    DB::raw("COALESCE(sp.priority,0) as sponsorship_priority")
                )
                ->where('role', 'vendor')
                ->whereNotNull('users.latitude')
                ->whereNotNull('users.longitude')

                // Join sponsorship
                ->leftJoin('vendor_sponsorships as vs', function ($join) {
                    $join->on('users.id', '=', 'vs.vendor_id')
                        ->where('vs.is_active', 1)
                        ->whereRaw('NOW() BETWEEN vs.start_date AND vs.end_date');
                })

                ->leftJoin('sponsorship_plans as sp', 'vs.plan_id', '=', 'sp.id')

                // Load food items
                ->with(['foodItems' => function ($query) {
                    $query->select('id', 'vendor_id', 'name', 'image', 'description');
                }])

                // Optional radius filter (5 km)
                ->having('distance', '<=', 5)

                // Sponsored first
                ->orderByDesc('sponsorship_priority')

                // Nearest vendor next
                ->orderBy('distance', 'ASC')

                ->paginate(10);

            return response()->json([
                'status' => true,
                'message' => 'Nearby vendors fetched successfully',
                'data' => $vendors
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }



    
    







}

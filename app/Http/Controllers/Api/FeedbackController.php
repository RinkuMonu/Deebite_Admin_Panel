<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        // Log::info('Step 1: Request Started');
        // 1. Validation
        $validator = Validator::make($request->all(), [
            'name'   => 'required|string|max:255',
            'number' => 'required|digits:10', // 10 digit phone number
            'feedback' => 'nullable|string',
            'rating' => 'required|numeric|min:0|max:5', // Rating 0 to 5
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation Error',
                'errors'  => $validator->errors()
            ], 422);
        }
            // Log::info('Step 2: Validation Passed');
        try {
            // 2. Data Save
            $feedback = Feedback::create([
                'name'     => $request->name,
                'number'   => $request->number,
                'feedback' => $request->feedback,
                'rating'   => $request->rating,
            ]);
                // Log::info('Step 3: Data Created in DB');
            return response()->json([
                'status'  => true,
                'message' => 'Feedback submitted successfully!',
                'data'    => $feedback
            ], 201);

        } catch (\Exception $e) {
            Log::error('Error: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong!',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function enquirySubmit(Request $request)
    {
        try {
            // ✅ Validation
            $validated = $request->validate([
                'name'   => 'required|string|max:255',
                'mobile' => 'required|digits:10',
                'role'   => 'required|in:vendor,delivery',
            ]);

            // ✅ Create Enquiry
            $enquiry = Enquiry::create([
                'name'   => $validated['name'],
                'mobile' => $validated['mobile'],
                'role'   => $validated['role'],
            ]);

            // ✅ Success Response
            return response()->json([
                'status'  => true,
                'message' => 'Enquiry submitted successfully',
                'data'    => $enquiry
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // ❌ Validation Error Response
            return response()->json([
                'status'  => false,
                'message' => 'Validation failed',
                'errors'  => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            // ❌ General Exception
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage() // remove in production
            ], 500);
        }
    }

   

    
}
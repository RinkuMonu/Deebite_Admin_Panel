<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\User\DashBoardController as UserDashBoardController;
use App\Http\Controllers\Api\Vendor\DashBoardController as VendorDashBoardController;
use App\Http\Controllers\Api\FeedbackController;


// for Rate limiting one ip-> hit the API more than 60 times in a minute then block that ip for 1 minute
Route::middleware('throttle:rateLimiter')->group(function () {
    
    //API route for feedback and Enquiry form submission
    Route::post('/feedback/submit', [FeedbackController::class, 'store']);
    Route::post('/enquiry/submit', [FeedbackController::class, 'enquirySubmit']); 
    // Route::post('/delivery-partner/enquiry/submit', [FeedbackController::class, 'deliveryPartnerEnquiry']); 

    // Auth routes for all users (Vendor, Delivery Partner, Customer)-------------------------------------
    Route::prefix('auth')->group(function () {
        Route::post('/send-otp', [AuthController::class, 'sendOtp']);
        Route::post('/verify-otp', [AuthController::class,'verifyOtp']);   
    });

    //Route with multiAuth middleware to store device token for all authenticated users-------------------------------
    Route::prefix('multiAuth')->middleware(['auth:sanctum', 'multiAuth'])->group(function () {
        Route::post('/register-token', [AuthController::class, 'storeDeviceToken']);
        // testing -> FCM -> event -> Listener -> Job -> FirebaseService 
        Route::get('/test-notification', [AuthController::class, 'sendNotification']);
    });

 
    //Protected Customer routes----------------------------------------
    Route::prefix('user')->middleware(['auth:sanctum', 'user'])->group(function () {
        Route::get('/profile', [UserDashBoardController::class, 'profile']);
        Route::post('/update-profile', [UserDashBoardController::class, 'updateProfile']);
        Route::get('/get/all-address', [UserDashBoardController::class, 'getAddress']);
        Route::post('/add-address', [UserDashBoardController::class, 'addAddress']);

        // User Routes for Vnedor listing and food item listing --
        Route::get('/food-category', [UserDashBoardController::class, 'getFoodCategories']);
        Route::get('/food-items/{category_id}', [UserDashBoardController::class, 'getFoodItemsByCategory']);
        Route::post('/get/vendors-list', [UserDashBoardController::class, 'getNearbyVendors']);
        Route::get('/vendor/{id}/food-items', [UserDashBoardController::class, 'getVendorFoodItems']);
    });


    //Protected   Vendor routes----------------------------------------
    Route::prefix('vendor')->middleware(['auth:sanctum', 'vendor'])->group(function () {
        Route::get('/profile', [VendorDashBoardController::class, 'profile']);
        Route::post('/update-profile', [VendorDashBoardController::class, 'updateProfile']);
        Route::post("/activate-deactivate" , [VendorDashBoardController::class, 'activateDeactivate']);

        // Add food items as per category
        Route::get('/food-category', [VendorDashBoardController::class, 'getFoodCategories']);
        Route::post('/add/food-items', [VendorDashBoardController::class, 'addFoodItem']);
    });


    //Protected Delivery Partner routes-----------------------------------------
    Route::prefix('delivery')->middleware(['auth:sanctum', 'delivery'])->group(function () {  
        Route::get('/profile', [DeliveryDashBoardController::class, 'profile']);
    });


});

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\User\DashBoardController as UserDashBoardController;
use App\Http\Controllers\Api\FeedbackController;

Route::get('/test', function () {
    return response()->json([
        'message' => 'API working successfully'
    ]);
});
Route::post('/feedback/submit', [FeedbackController::class, 'store']);
// Auth routes for all users (Vendor, Delivery Partner, Customer)-------------------------------------
Route::prefix('auth')->group(function () {
    Route::post('/send-otp', [AuthController::class, 'sendOtp']);
    Route::post('/verify-otp', [AuthController::class,'verifyOtp']);
});

//Protected Customer routes----------------------------------------
Route::prefix('user')->middleware(['auth:sanctum', 'user'])->group(function () {

    Route::get('/profile', [UserDashBoardController::class, 'profile']);

});

//Protected   Vendor routes----------------------------------------
Route::prefix('vendor')->middleware(['auth:sanctum', 'vendor'])->group(function () {
   
    Route::get('/profile', [VendorDashBoardController::class, 'profile']);
});

//Protected Delivery Partner routes-----------------------------------------
Route::prefix('delivery')->middleware(['auth:sanctum', 'delivery'])->group(function () {
    
    Route::get('/profile', [DeliveryDashBoardController::class, 'profile']);
});

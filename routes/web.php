<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\DeliveryPartnerController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\CategoryController;
use Kreait\Firebase\Factory;


Route::get('/', function () {
    return redirect()->route('auth.login');
});
Route::post('/feedback/submit', [FeedbackController::class, 'store'])->name('feedback.submit');
Route::get('/feedback/index',[FeedbackController::class,'index'])->name('feedback.index');

Route::get('admin-login',function(){
    return view('auth.login');
})->name('auth.login');
Route::post('admin-login',[AuthController::class,'login'])->name('admin.login.post');

Route::middleware(['isSuperAdmin'])->prefix('admin')->group(function (){
    Route::get('/dashboard',[DashboardController::class,'index'])->name('admin.dashboard');
    Route::get('/users',[UserController::class,'index'])->name('admin.users');
    Route::get('/vendors',[VendorController::class,'index'])->name('admin.vendors');
    Route::post('/vendors/store', [VendorController::class, 'storeVendor'])->name('admin.vendors.store');
    Route::post('/vendors/update/{id}', [VendorController::class, 'updateVendor'])->name('admin.vendors.update');
    Route::get('/delivery-partners',[DeliveryPartnerController::class,'index'])->name('admin.delivery-partners');
    Route::post('/delivery-partners/{id}/toggle-status', [DeliveryPartnerController::class, 'toggleStatus'])->name('admin.delivery.toggle');
    Route::get('/delivery-heat-map', [DeliveryPartnerController::class, 'heatMap'])->name('admin.delivery.heatmap');
    Route::get('/delivery-partners/{id}/track', [DeliveryPartnerController::class, 'track'])->name('admin.delivery.track');
    Route::get('/vendor/{id}/show', [FoodController::class, 'show'])->name('admin.vendors.show');
    Route::post('/food/store', [FoodController::class, 'store'])->name('admin.food.store');

    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('admin.categories.index');
        Route::post('/store', [CategoryController::class, 'store'])->name('admin.categories.store');
        Route::post('/update/{id}', [CategoryController::class, 'update'])->name('admin.categories.update');
        Route::post('/toggle-status/{id}', [CategoryController::class, 'toggleStatus'])->name('admin.categories.toggle');
        Route::delete('/delete/{id}', [CategoryController::class, 'destroy'])->name('admin.categories.delete');
        Route::get('/{id}/food-items', [CategoryController::class, 'getFoodItems']); // View items popup ke liye
    });
    Route::post('/logout',function(){
        Auth::logout();
        return redirect()->route('auth.login');
    })->name('admin.logout');
});



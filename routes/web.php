<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\DeliveryPartnerController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\FoodController;
Route::get('/', function () {
    return view('welcome');
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
    Route::get('/delivery-partners',[DeliveryPartnerController::class,'index'])->name('admin.delivery-partners');
    Route::get('/vendor/{id}/show', [FoodController::class, 'show'])->name('admin.vendors.show');
    Route::post('/food/store', [FoodController::class, 'store'])->name('admin.food.store');

    Route::post('/logout',function(){
        Auth::logout();
        return redirect()->route('auth.login');
    })->name('admin.logout');
});

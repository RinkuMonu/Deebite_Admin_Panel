<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('login',function(){
    return view('auth.login');
});
Route::post('login',[AuthController::class,'login'])->name('admin.login');

Route::middleware(['isSuperAdmin'])->prefix('admin')->group(function (){
    Route::get('/dashboard',[DashboardController::class,'index'])->name('admin.dashboard');
});

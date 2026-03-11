<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('admin-login',function(){
    return view('auth.login');
});
Route::post('admin-login',[AuthController::class,'login'])->name('admin.login.post');

Route::middleware(['isSuperAdmin'])->prefix('admin')->group(function (){
    Route::get('/dashboard',[DashboardController::class,'index'])->name('admin.dashboard');
    Route::post('/logout',function(){
        Auth::logout();
        return redirect()->route('auth.login');
    })->name('admin.logout');
});

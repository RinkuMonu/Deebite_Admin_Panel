<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // 1. Validation
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // 2. Auth::attempt check karta hai ki user exist karta hai aur password match hua ya nahi
        if (Auth::attempt($request->only('email', 'password'))) {
            
            $user = Auth::user();

            // 3. Role check - Role ek property hai, method nahi
            if ($user->role === 'superadmin') {
                $request->session()->regenerate(); // Security: Session fix aattack se bachata hai
                return redirect()->route('admin.dashboard');
            } 
            
            // 4. Role match nahi hua toh logout karo
            Auth::logout();
            return back()->withErrors(['email' => 'Access Denied! Only SuperAdmin can access this panel.']);
        }

        // 5. Credentials galat
        return back()->withErrors(['email' => 'Invalid Credentials!']);
    }

}
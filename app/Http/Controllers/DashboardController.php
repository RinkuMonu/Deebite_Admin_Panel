<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    function index(){
        return view('admin.dashboard');
    }

    function getFeedback(){
        return view('admin.feedback.index');
    }
    function postFeedback(Request $request){        
        return redirect()->route('admin.feedback')->with('success', 'Feedback submitted successfully!');
    }
}

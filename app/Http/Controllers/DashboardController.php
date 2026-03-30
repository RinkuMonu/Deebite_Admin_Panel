<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enquiry;
class DashboardController extends Controller
{
    function profile()
    {
        try {
            $admin = auth()->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Please log in to access your profile.');
        }
        return view('admin.profile', compact('admin'));
    }

    public function updateProfile(Request $request)
    {
       try{
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . auth()->id(),
            ]);

            $user = auth()->user();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();

            return redirect()->route('admin.profile')->with('success', 'Profile updated successfully!');
       }
        catch(\Exception $e){

            return redirect()->route('admin.profile')->with('error', 'An error occurred while updating profile.');
        }
        
    }

    public function updatePassword(Request $request)
    {
       $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ], [
            'new_password.required' => 'New password is required',
            'new_password.min' => 'Password must be at least 6 characters',
            'new_password.confirmed' => 'Passwords do not match',
        ]);

        try {
            $user = auth()->user();

            if (!\Hash::check($request->current_password, $user->password)) {
                return redirect()->route('admin.profile')
                    ->with('error', 'Current password is incorrect.');
            }

            $user->password = \Hash::make($request->new_password);
            $user->save();

            return redirect()->route('admin.profile')
                ->with('success', 'Password updated successfully!');
                
        } catch (\Exception $e) {
            return redirect()->route('admin.profile')
                ->with('error', 'An error occurred while updating password.');
        }

    }
    
    function index(){
        return view('admin.dashboard');
    }

    function getFeedback(){
        return view('admin.feedback.index');
    }
    function postFeedback(Request $request){        
        return redirect()->route('admin.feedback')->with('success', 'Feedback submitted successfully!');
    }

    public function vendorEnquiries()
    {
        try {
            // Fetch vendor enquiries with pagination (10 per page)
            $enquiries = Enquiry::where('role', 'vendor')
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return view('admin.vendors.vendorEnquiry', compact('enquiries'));
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Failed to fetch vendor enquiries: '.$e->getMessage());

            // Optionally, show a friendly message or redirect back
            return redirect()->back()->with('error', 'Something went wrong while fetching vendor enquiries.');
        }
    }

    public function deliveryPartnerEnquiries()
    {
        try {
            // Fetch delivery partner enquiries with pagination (10 per page)
            $enquiries = Enquiry::where('role', 'delivery')
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return view('admin.delivery-partners.deliveryEnquiry', compact('enquiries'));
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Failed to fetch delivery enquiries: '.$e->getMessage());

            // Optionally, show a friendly message or redirect back
            return redirect()->back()->with('error', 'Something went wrong while fetching delivery enquiries.');
        }
    }

    public function destroyEnquiry(Request $request)
    {
        try {
            $enquiryId = $request->input('enquiry_id');
            $enquiry = Enquiry::findOrFail($enquiryId);
            $enquiry->delete();

            return redirect()->back()->with('success', 'Enquiry deleted successfully!');
        } catch (\Exception $e) {
            \Log::error('Failed to delete enquiry: '.$e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while deleting the enquiry.');
        }
    }



}

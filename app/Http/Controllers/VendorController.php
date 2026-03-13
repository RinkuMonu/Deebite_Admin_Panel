<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\VendorDetail;
class VendorController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'vendor')->with('vendorDetail');
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%$searchTerm%")
                ->orWhereHas('vendorDetail', function($q) use ($searchTerm) {
                    $q->where('shop_name', 'like', "%$searchTerm%");
                });
            });
        }
        $vendors = $query->latest()->paginate(10)->withQueryString();

        return view('admin.vendors.index', compact('vendors'));
    }
    public function storeVendor(Request $request) {
        // Validation: Profile Photo aur Document mandatory kar diye hain
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'number' => 'required|digits:10',
            'shop_name' => 'required|string',
            'password' => 'required|min:8',
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'document_file' => 'required|mimes:pdf,jpeg,png,jpg|max:5120',
            'document_type' => 'required',
        ]);
        if ($validator->fails()) {
        // Yahan 'withInput' saara data (including password) wapas bhej dega
        return back()->withErrors($validator)->withInput();
    }
        try {
            DB::transaction(function () use ($request) {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'number' => $request->number,
                    'password' => Hash::make($request->password),
                    'role' => 'vendor',
                    'is_active' => true,
                ]);

                // File upload logic
                $profilePath = $request->file('profile_photo')->store('vendors/profiles', 'public');
                $docPath = $request->file('document_file')->store('vendors/documents', 'public');

                VendorDetail::create([
                    'user_id' => $user->id,
                    'shop_name' => $request->shop_name,
                    'fssai_number' => $request->fssai_number,
                    'document_type' => $request->document_type,
                    'profile_photo' => $profilePath,
                    'document_file' => $docPath,
                ]);
            });

            return back()->with('success', 'Vendor added successfully!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Something went wrong!');
        }
    }
}

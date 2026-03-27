<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\VendorDetail;
use Illuminate\Support\Facades\Log;
class VendorController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'vendor')->with('vendorDetail');

        if ($request->filled('search')) {
            $searchTerm = trim($request->search);

            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('email', 'like', "%{$searchTerm}%")
                    ->orWhere('number', 'like', "%{$searchTerm}%")
                    ->orWhereHas('vendorDetail', function ($vendorDetailQuery) use ($searchTerm) {
                        $vendorDetailQuery->where('shop_name', 'like', "%{$searchTerm}%")
                            ->orWhere('fssai_number', 'like', "%{$searchTerm}%")
                            ->orWhere('document_type', 'like', "%{$searchTerm}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
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
    public function updateVendor(Request $request, $id) {
        $user = User::findOrFail($id);
        $details = VendorDetail::where('user_id', $id)->first();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'number' => 'required|digits:10',
            'shop_name' => 'required|string',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'document_file' => 'nullable|mimes:pdf,jpeg,png,jpg|max:5120',
        ]);

        // 2. Agar validation fail ho, toh yahi dump karke error dikhao
        if ($validator->fails()) {
            dd($validator->errors()->all()); // Ye aapko screen par list dikha dega ki kya galat hai
        }

        try {
            DB::transaction(function () use ($request, $user, $details) {
                // 1. User Table Update
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'number' => $request->number,
                ]);

                if ($request->filled('password')) {
                    $user->update(['password' => Hash::make($request->password)]);
                }

                // 2. Prepare Data for VendorDetail Update
                $updateData = [
                    'shop_name' => $request->shop_name,
                    'fssai_number' => $request->fssai_number,
                    'document_type' => $request->document_type,
                ];

                // Sirf tabhi path badlo jab nayi file upload hui ho
                if ($request->hasFile('profile_photo')) {
                    $updateData['profile_photo'] = $request->file('profile_photo')->store('vendors/profiles', 'public');
                }

                if ($request->hasFile('document_file')) {
                    $updateData['document_file'] = $request->file('document_file')->store('vendors/documents', 'public');
                }

                // 3. Update VendorDetail with dynamic array
                $details->update($updateData);
            });

            return back()->with('success', 'Vendor updated successfully!');
        } catch (\Exception $e) {
            // Aap chaho toh yahan error message bhi dekh sakte ho debug ke liye: $e->getMessage()
            Log::error("Vendor Update Error: " . $e->getMessage());
            return back()->with('error', 'Update failed!');
        }
    }
}

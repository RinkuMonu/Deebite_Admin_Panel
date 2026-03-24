<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class DeliveryPartnerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'delivery');
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                ->orWhere('number', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%");
            });
        }

        // Filter: Status (Active/Inactive)
        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }

        $users = $query->latest()->paginate(10)->withQueryString();
        return view('admin.delivery-partners.index', compact('users'));
    }

    public function toggleStatus($id) {
        $user = User::findOrFail($id);
        $user->update(['is_active' => !$user->is_active]);
        return back()->with('success', 'Status updated successfully');
    }

    public function track($id)
    {
        $partner = User::where('role', 'delivery')->findOrFail($id);
        return view('admin.delivery-partners.track', compact('partner'));
    }

    // Saare partners ko ek saath map par dekhne ke liye (Global View)
    public function heatMap()
    {
        $partners = User::where('role', 'delivery')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get(['id', 'name', 'latitude', 'longitude', 'is_active', 'number']);

        return view('admin.delivery-partners.heatmap', compact('partners'));
    }
}

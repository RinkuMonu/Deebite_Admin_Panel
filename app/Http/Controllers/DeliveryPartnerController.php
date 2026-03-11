<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class DeliveryPartnerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'delivery');

        // Filter: Search by Name, Number or Email
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
}

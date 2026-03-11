<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
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
}

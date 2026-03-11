<?php 
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\{User, FoodItem, Category};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FoodController extends Controller
{
    public function show($id) {
        $vendor = User::with(['vendorDetail', 'foodItems.variants'])->findOrFail($id);
        $categories = Category::all();
        return view('admin.vendors.show', compact('vendor', 'categories'));
    }

    public function store(Request $request) {
        $request->validate([
            'vendor_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'name' => 'required',
            'variants' => 'required|array|min:1'
        ]);

        DB::transaction(function () use ($request) {
            $food = FoodItem::create($request->only('vendor_id', 'category_id', 'name'));
            
            // Variants save karna
            foreach ($request->variants as $variant) {
                $food->variants()->create($variant);
            }
        });

        return back()->with('success', 'Food Item added with variants!');
    }
}
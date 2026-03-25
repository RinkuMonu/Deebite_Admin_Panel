<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\FoodItem;

class CategoryController extends Controller
{
    public function index(Request $request) {
        $query = Category::query();

        // Filters
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('status')) {
            $query->where('is_active', $request->status == 'active' ? 1 : 0);
        }

        $categories = $query->latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request) {
        $request->validate(['name' => 'required|string|unique:categories,name']);
        Category::create(['name' => $request->name]);
        return back()->with('success', 'Category added!');
    }

    public function update(Request $request, $id) {
        $request->validate(['name' => 'required|string|unique:categories,name,' . $id]);
        Category::findOrFail($id)->update(['name' => $request->name]);
        return back()->with('success', 'Category updated!');
    }

    public function toggleStatus($id) {
        $cat = Category::findOrFail($id);
        $cat->update(['is_active' => !$cat->is_active]);
        return back()->with('success', 'Status updated!');
    }

    public function destroy($id) {
        Category::findOrFail($id)->delete();
        return back()->with('success', 'Category deleted!');
    }

    public function getFoodItems($id) {
        $foodItems = FoodItem::where('category_id', $id)->with('variants')->get();
        return response()->json($foodItems);
    }
}

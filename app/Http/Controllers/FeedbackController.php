<?php 
namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index(Request $request)
    {
        $query = Feedback::query();
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                ->orWhere('number', 'like', "%$search%")
                ->orWhere('feedback', 'like', "%$search%");
            });
        }
        $feedbacks = $query->latest()->paginate(10)->withQueryString();
        return view('admin.feedback.index', compact('feedbacks'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'required|digits:10',
            'feedback' => 'required|string|min:10',
        ]);

        Feedback::create([
            'user_id' => auth()->id(), // null if guest
            'name' => $request->name,
            'number' => $request->number,
            'feedback' => $request->feedback,
        ]);

        return back()->with('success', 'Thank you for your feedback!');
    }
}
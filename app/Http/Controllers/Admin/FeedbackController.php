<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::orderBy('position')->get();
        return view('admin.feedbacks.index', compact('feedbacks'));
    }

    public function create()
    {
        return view('admin.feedbacks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'message' => 'required|string',
            'image' => 'nullable|string|max:255',
            'position' => 'nullable|integer|min:0',
            'active' => 'nullable|boolean',
        ]);

        Feedback::create(array_merge($request->all(), ['active' => $request->has('active')]));

        return redirect()->route('admin.feedbacks.index')->with('success', 'Feedback saved successfully.');
    }

    public function edit($id)
    {
        $feedback = Feedback::findOrFail($id);
        return view('admin.feedbacks.edit', compact('feedback'));
    }

    public function update(Request $request, $id)
    {
        $feedback = Feedback::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'message' => 'required|string',
            'image' => 'nullable|string|max:255',
            'position' => 'nullable|integer|min:0',
            'active' => 'nullable|boolean',
        ]);

        $feedback->update(array_merge($request->all(), ['active' => $request->has('active')]));

        return redirect()->route('admin.feedbacks.index')->with('success', 'Feedback updated successfully.');
    }

    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();

        return redirect()->route('admin.feedbacks.index')->with('success', 'Feedback deleted successfully.');
    }
}

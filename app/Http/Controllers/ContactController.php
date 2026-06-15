<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Category;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function show()
    {
        $categories = Category::orderBy('name')->get();
        return view('contact.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        ContactMessage::create($request->only(['name', 'email', 'subject', 'message']));

        return back()->with('success', 'Your message has been received. We will contact you soon.');
    }
}

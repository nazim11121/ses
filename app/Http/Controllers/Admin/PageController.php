<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function edit()
    {
        $page = Page::firstOrCreate(
            ['slug' => 'about'],
            [
                'title' => 'About Saree Bazaar',
                'content' => 'Saree Bazaar brings you a curated collection of sarees for every celebration. Our online storefront is built to help you discover elegant fabrics, rich designs, and comfortable styling with trusted delivery.',
                'sidebar_title' => 'Why choose us?',
                'sidebar_text' => 'From party wear to festive silk sarees, every design is managed from the admin panel so our store stays fresh and curated.',
                'feature_one_title' => 'Curated Collection',
                'feature_one_text' => 'Handpicked sarees for style and comfort.',
                'feature_two_title' => 'Easy Checkout',
                'feature_two_text' => 'Pay by Cash on Delivery or bKash.',
            ]
        );

        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request)
    {
        $page = Page::where('slug', 'about')->firstOrFail();

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'sidebar_title' => 'nullable|string|max:255',
            'sidebar_text' => 'nullable|string',
            'feature_one_title' => 'nullable|string|max:255',
            'feature_one_text' => 'nullable|string',
            'feature_two_title' => 'nullable|string|max:255',
            'feature_two_text' => 'nullable|string',
        ]);

        $page->update($request->only([
            'title',
            'content',
            'sidebar_title',
            'sidebar_text',
            'feature_one_title',
            'feature_one_text',
            'feature_two_title',
            'feature_two_text',
        ]));

        return redirect()->route('admin.pages.edit')->with('success', 'About page updated successfully.');
    }
}

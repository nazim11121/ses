<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        $categories = Category::orderBy('name')->get();
        return view('pages.about', compact('categories'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Feedback;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function home()
    {
        $categories = Category::orderBy('name')->get();
        $slides = Slider::where('active', true)->orderBy('position')->get();
        $allProducts = Product::with('category')->where('active', true)->orderBy('created_at', 'desc')->get();
        $newArrivals = Product::with('category')->where('active', true)->where('section', 'new_arrival')->orderBy('created_at', 'desc')->take(8)->get();
        $featuredProducts = Product::with('category')->where('active', true)->where('section', 'featured')->orderBy('created_at', 'desc')->take(8)->get();
        $topRatedProducts = Product::with('category')->where('active', true)->where('section', 'top_rated')->orderBy('created_at', 'desc')->take(8)->get();
        $feedbacks = Feedback::orderBy('position')->take(3)->get();

        return view('home', compact('categories', 'slides', 'allProducts', 'newArrivals', 'featuredProducts', 'topRatedProducts', 'feedbacks'));
    }

    public function index(Request $request)
    {
        $categories = Category::orderBy('name')->get();
        $selectedCategory = null;
        $productsQuery = Product::with('category')->where('active', true);

        if ($request->filled('category')) {
            $selectedCategory = Category::where('slug', $request->category)->first();
            if ($selectedCategory) {
                $productsQuery->where('category_id', $selectedCategory->id);
            }
        }

        if ($request->filled('q')) {
            $productsQuery->where('name', 'like', '%' . $request->q . '%');
        }

        $products = $productsQuery->orderBy('created_at', 'desc')->get();

        return view('products.index', compact('products', 'categories', 'selectedCategory'));
    }

    public function show($slug)
    {
        $product = Product::with('category')->where('slug', $slug)->firstOrFail();

        return view('products.show', compact('product'));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $categories = Category::orderBy('name')->get();
        $products = Product::with('category')->where('category_id', $category->id)->where('active', true)->orderBy('created_at', 'desc')->get();
        $selectedCategory = $category;

        return view('products.index', compact('products', 'categories', 'selectedCategory'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts   = Product::count();
        $totalCategories = Category::count();
        $totalOrders     = Order::count();
        $pendingOrders   = Order::where('status', 'pending')->count();
        $totalRevenue    = Order::whereNotIn('status', ['cancelled'])->sum('total_amount');
        $latestOrders    = Order::latest()->take(8)->get();

        return view('admin.dashboard', compact(
            'totalProducts', 'totalCategories',
            'totalOrders', 'pendingOrders',
            'totalRevenue', 'latestOrders'
        ));
    }
}

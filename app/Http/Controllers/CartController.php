<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        $items = Product::whereIn('id', array_keys($cart))->get()->map(function ($product) use ($cart) {
            $quantity = $cart[$product->id] ?? 0;
            return (object) [
                'product' => $product,
                'quantity' => $quantity,
                'subtotal' => $product->price * $quantity,
            ];
        });

        $total = $items->sum('subtotal');

        return view('cart.index', compact('items', 'total'));
    }

    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session('cart', []);
        $cart[$id] = min($product->stock, ($cart[$id] ?? 0) + 1);
        session(['cart' => $cart]);

        return redirect()->route('cart.index')->with('success', "$product->name added to cart.");
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($id);
        $cart = session('cart', []);
        $cart[$id] = min($product->stock, $request->quantity);
        session(['cart' => $cart]);

        return redirect()->route('cart.index')->with('success', 'Cart updated successfully.');
    }

    public function remove($id)
    {
        $cart = session('cart', []);
        unset($cart[$id]);
        session(['cart' => $cart]);

        return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Cart cleared successfully.');
    }
}

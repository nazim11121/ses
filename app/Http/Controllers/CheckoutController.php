<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CheckoutController extends Controller
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

        if ($items->isEmpty()) {
            return redirect()->route('home')->with('info', 'Your cart is empty. Add a saree to checkout.');
        }

        $total = $items->sum('subtotal');

        return view('checkout.index', compact('items', 'total'));
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:30',
            'shipping_address' => 'required|string',
            'payment_method' => 'required|in:Cash on Delivery,bKash',
        ]);

        $cart = session('cart', []);
        $products = Product::whereIn('id', array_keys($cart))->get();

        if ($products->isEmpty()) {
            return redirect()->route('home')->with('info', 'Your cart is empty.');
        }

        $total = 0;
        foreach ($products as $product) {
            $quantity = $cart[$product->id] ?? 0;
            $total += $product->price * $quantity;
        }

        $order = Order::create([
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'shipping_address' => $request->shipping_address,
            'payment_method' => $request->payment_method,
            'total_amount' => $total,
            'status' => 'Pending',
        ]);

        foreach ($products as $product) {
            $quantity = $cart[$product->id] ?? 0;
            if ($quantity <= 0) {
                continue;
            }

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->price,
                'subtotal' => $product->price * $quantity,
            ]);
        }

        session()->forget('cart');

        return redirect()->route('checkout.success', $order->id)->with('success', 'Order placed successfully.');
    }

    public function success($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        return view('checkout.success', compact('order'));
    }
}

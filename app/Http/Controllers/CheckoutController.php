<?php

namespace App\Http\Controllers;

use App\Models\CompanyProfile;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\CourierService;
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

        $companyProfile = CompanyProfile::where('active', true)->first();
        $dhakaCharge = $companyProfile ? $companyProfile->dhaka_delivery_charge : 50;
        $outsideCharge = $companyProfile ? $companyProfile->outside_dhaka_delivery_charge : 100;
        $total = $items->sum('subtotal');

        return view('checkout.index', compact('items', 'total', 'dhakaCharge', 'outsideCharge', 'companyProfile'));
    }

    public function placeOrder(Request $request)
    {
        $rules = [
            'customer_name'    => 'required|string|max:255',
            'customer_email'   => 'required|email|max:255',
            'customer_phone'   => 'required|string|max:30',
            'shipping_address' => 'required|string',
            'delivery_zone'    => 'required|in:dhaka,outside',
            'payment_method'   => 'required|in:Cash on Delivery,bKash',
        ];

        if ($request->payment_method === 'bKash') {
            $rules['bkash_transaction_id'] = 'required|string|max:100';
            $rules['bkash_amount']         = 'required|numeric|min:1';
        }

        $request->validate($rules);

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

        $companyProfile = CompanyProfile::where('active', true)->first();
        $dhakaCharge = $companyProfile ? $companyProfile->dhaka_delivery_charge : 50;
        $outsideCharge = $companyProfile ? $companyProfile->outside_dhaka_delivery_charge : 100;
        $shippingCharge = $request->delivery_zone === 'outside' ? $outsideCharge : $dhakaCharge;

        $orderData = [
            'customer_name'    => $request->customer_name,
            'customer_email'   => $request->customer_email,
            'customer_phone'   => $request->customer_phone,
            'shipping_address' => $request->shipping_address,
            'payment_method'   => $request->payment_method,
            'total_amount'     => $total + $shippingCharge,
            'status'           => 'Pending',
        ];

        if ($request->payment_method === 'bKash') {
            $orderData['bkash_transaction_id'] = $request->bkash_transaction_id;
            $orderData['bkash_amount']         = $request->bkash_amount;
        }

        $order = Order::create($orderData);

        $courierService = app(CourierService::class);
        $courierProvider = $request->input('courier_provider', config('couriers.default', 'mock'));
        $courierService->dispatch($order, [
            'delivery_zone' => $request->delivery_zone,
            'shipping_address' => $request->shipping_address,
            'payment_method' => $request->payment_method,
            'items' => $products->map(function ($product) use ($cart) {
                return [
                    'product_id' => $product->id,
                    'quantity' => $cart[$product->id] ?? 0,
                ];
            })->values()->all(),
        ], $courierProvider);

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

<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run()
    {
        $productIds = Product::whereIn('slug', [
            'banarasi-silk-saree',
            'georgette-party-wear-saree',
            'kanjivaram-silk-saree',
            'chiffon-designer-saree',
        ])->pluck('id', 'slug')->toArray();

        $orders = [
            [
                'reference' => 'ORD-1001',
                'customer_name' => 'Mina Rahman',
                'customer_email' => 'mina.rahman@example.com',
                'customer_phone' => '+8801712345678',
                'shipping_address' => 'House 23, Road 12, Dhanmondi, Dhaka 1209',
                'payment_method' => 'Cash on Delivery',
                'status' => 'Delivered',
                'items' => [
                    ['slug' => 'banarasi-silk-saree', 'quantity' => 1],
                    ['slug' => 'georgette-party-wear-saree', 'quantity' => 2],
                ],
            ],
            [
                'reference' => 'ORD-1002',
                'customer_name' => 'Arif Hossain',
                'customer_email' => 'arif.hossain@example.com',
                'customer_phone' => '+8801812345678',
                'shipping_address' => 'Flat 5B, House 14, Banani, Dhaka 1213',
                'payment_method' => 'bKash',
                'status' => 'Pending',
                'items' => [
                    ['slug' => 'kanjivaram-silk-saree', 'quantity' => 1],
                    ['slug' => 'chiffon-designer-saree', 'quantity' => 1],
                ],
            ],
        ];

        foreach ($orders as $orderData) {
            $order = Order::updateOrCreate(
                ['customer_email' => $orderData['customer_email'], 'status' => $orderData['status']],
                [
                    'customer_name' => $orderData['customer_name'],
                    'customer_phone' => $orderData['customer_phone'],
                    'shipping_address' => $orderData['shipping_address'],
                    'payment_method' => $orderData['payment_method'],
                    'total_amount' => 0,
                ]
            );

            $totalAmount = 0;

            foreach ($orderData['items'] as $item) {
                if (!isset($productIds[$item['slug']])) {
                    continue;
                }

                $product = Product::find($productIds[$item['slug']]);
                $quantity = $item['quantity'];
                $price = $product->price;
                $subtotal = $price * $quantity;

                OrderItem::updateOrCreate(
                    ['order_id' => $order->id, 'product_id' => $product->id],
                    [
                        'quantity' => $quantity,
                        'price' => $price,
                        'subtotal' => $subtotal,
                    ]
                );

                $totalAmount += $subtotal;
            }

            $order->update(['total_amount' => $totalAmount]);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'name' => 'Banarasi Silk Saree',
                'slug' => 'banarasi-silk-saree',
                'category_slug' => 'silk',
                'description' => 'A luxurious Banarasi saree with rich zari work and an elegant border for weddings and festivals.',
                'price' => 4399.00,
                'image' => 'https://images.unsplash.com/photo-1523381218844-1f0c08260346?auto=format&fit=crop&w=800&q=80',
                'stock' => 24,
                'active' => true,
            ],
            [
                'name' => 'Georgette Party Wear Saree',
                'slug' => 'georgette-party-wear-saree',
                'category_slug' => 'georgette',
                'description' => 'A lightweight georgette saree with sequins and a modern blouse design for evening parties.',
                'price' => 2599.00,
                'image' => 'https://images.unsplash.com/photo-1521334884684-d80222895322?auto=format&fit=crop&w=800&q=80',
                'stock' => 18,
                'active' => true,
            ],
            [
                'name' => 'Kanjivaram Silk Saree',
                'slug' => 'kanjivaram-silk-saree',
                'category_slug' => 'silk',
                'description' => 'Traditional Kanjivaram saree with contrasting border and classic temple motifs for elegant celebrations.',
                'price' => 7899.00,
                'image' => 'https://images.unsplash.com/photo-1512436991641-6745cdb1723f?auto=format&fit=crop&w=800&q=80',
                'stock' => 12,
                'active' => true,
            ],
            [
                'name' => 'Chiffon Designer Saree',
                'slug' => 'chiffon-designer-saree',
                'category_slug' => 'chiffon',
                'description' => 'A flowing chiffon saree with intricate embroidery and pastel shades for a graceful look.',
                'price' => 3299.00,
                'image' => 'https://images.unsplash.com/photo-1503341455253-b2e723bb3dbb?auto=format&fit=crop&w=800&q=80',
                'stock' => 30,
                'active' => true,
            ],
        ];

        foreach ($products as $item) {
            $category = Category::where('slug', $item['category_slug'])->first();
            Product::updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'category_id' => $category ? $category->id : null,
                    'name' => $item['name'],
                    'description' => $item['description'],
                    'price' => $item['price'],
                    'image' => $item['image'],
                    'stock' => $item['stock'],
                    'active' => $item['active'],
                ]
            );
        }
    }
}

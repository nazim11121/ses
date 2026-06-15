<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run()
    {
        Page::updateOrCreate(
            ['slug' => 'about'],
            [
                'title' => 'About Our Saree Boutique',
                'content' => 'We are a Bangladesh-based saree boutique dedicated to handpicked fabrics, timeless designs, and customer-first service. Our collection blends traditional craftsmanship with modern styling so every celebration feels special.',
                'sidebar_title' => 'Why Choose Us',
                'sidebar_text' => 'Shop with confidence from a curated range of silk, georgette and chiffon sarees backed by fast delivery and secure payment.',
                'feature_one_title' => 'Authentic Craftsmanship',
                'feature_one_text' => 'Each saree is selected for its quality, details, and beautiful finish, perfect for weddings, festivals, and everyday elegance.',
                'feature_two_title' => 'Trusted Local Support',
                'feature_two_text' => 'Our customer care team is ready to help with styling, sizing and delivery updates across Bangladesh.',
            ]
        );
    }
}

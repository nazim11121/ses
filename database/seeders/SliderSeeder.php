<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    public function run()
    {
        $slides = [
            [
                'title' => 'Elegant Bangladeshi Sarees',
                'subtitle' => 'Discover premium handwoven designs for every celebration.',
                'button_text' => 'Shop Now',
                'button_link' => '/shop',
                'image' => 'https://images.unsplash.com/photo-1512436991641-6745cdb1723f8?auto=format&fit=crop&w=1300&q=80',
                'position' => 1,
                'active' => true,
            ],
            [
                'title' => 'Luxury Silk Collection',
                'subtitle' => 'Rich textures and vibrant colors, curated just for you.',
                'button_text' => 'Browse Collection',
                'button_link' => '/shop',
                'image' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=1300&q=80',
                'position' => 2,
                'active' => true,
            ],
            [
                'title' => 'Modern Designer Sarees',
                'subtitle' => 'Style your wardrobe with comfortable, statement-making drapes.',
                'button_text' => 'View More',
                'button_link' => '/shop',
                'image' => 'https://images.unsplash.com/photo-1520975917114-799e5b44c351?auto=format&fit=crop&w=1300&q=80',
                'position' => 3,
                'active' => true,
            ],
        ];

        foreach ($slides as $slide) {
            Slider::updateOrCreate(['title' => $slide['title']], $slide);
        }
    }
}

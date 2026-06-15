<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Silk',
                'slug' => 'silk',
                'description' => 'Rich silk sarees for weddings and celebrations.',
            ],
            [
                'name' => 'Georgette',
                'slug' => 'georgette',
                'description' => 'Lightweight georgette sarees with elegant designs.',
            ],
            [
                'name' => 'Chiffon',
                'slug' => 'chiffon',
                'description' => 'Soft chiffon sarees that drape gracefully.',
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['slug' => $category['slug']], $category);
        }
    }
}

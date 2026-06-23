<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin User', 'password' => Hash::make('password')]
        );

        $this->call([
            RolesPermissionsSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            SliderSeeder::class,
            PageSeeder::class,
            FeedbackSeeder::class,
            ContactMessageSeeder::class,
            OrderSeeder::class,
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Feedback;
use Illuminate\Database\Seeder;

class FeedbackSeeder extends Seeder
{
    public function run()
    {
        $feedbacks = [
            [
                'name' => 'Ayesha Karim',
                'designation' => 'Fashion Blogger',
                'message' => 'The saree quality exceeded my expectations and the delivery was prompt. I loved the rich texture and color.',
                'image' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=200&q=80',
                'active' => true,
                'position' => 1,
            ],
            [
                'name' => 'Sadia Islam',
                'designation' => 'Wedding Guest',
                'message' => 'Beautiful saree and great customer service. The piece arrived in perfect condition and looked stunning.',
                'image' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=200&q=80',
                'active' => true,
                'position' => 2,
            ],
            [
                'name' => 'Farzana Akter',
                'designation' => 'Boutique Shopper',
                'message' => 'I keep coming back for the latest saree designs. The fabric and prints are excellent for special occasions.',
                'image' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=200&q=80',
                'active' => true,
                'position' => 3,
            ],
        ];

        foreach ($feedbacks as $feedback) {
            Feedback::updateOrCreate(
                ['name' => $feedback['name'], 'designation' => $feedback['designation']],
                $feedback
            );
        }
    }
}

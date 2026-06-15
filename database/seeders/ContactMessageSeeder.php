<?php

namespace Database\Seeders;

use App\Models\ContactMessage;
use Illuminate\Database\Seeder;

class ContactMessageSeeder extends Seeder
{
    public function run()
    {
        $messages = [
            [
                'name' => 'Nusrat Jahan',
                'email' => 'nusrat@example.com',
                'subject' => 'Saree material inquiry',
                'message' => 'Hi, can you tell me if the Banarasi silk saree is pure silk and if there is a matching blouse available?',
                'status' => 'New',
            ],
            [
                'name' => 'Imran Hossain',
                'email' => 'imran@example.com',
                'subject' => 'Shipping to Dhaka',
                'message' => 'I need this saree delivered to Gulshan by tomorrow. Do you offer same-day or next-day delivery?',
                'status' => 'Read',
            ],
            [
                'name' => 'Rumana Sultana',
                'email' => 'rumana@example.com',
                'subject' => 'Order cancellation',
                'message' => 'Please cancel my recent order if it has not been shipped yet, and refund the amount to my bKash account.',
                'status' => 'New',
            ],
            [
                'name' => 'Arman Khan',
                'email' => 'arman@example.com',
                'subject' => 'Gift wrapping',
                'message' => 'Can I request gift wrapping for the Kanjivaram saree if I place the order today?',
                'status' => 'New',
            ],
        ];

        foreach ($messages as $message) {
            ContactMessage::updateOrCreate(
                ['email' => $message['email'], 'subject' => $message['subject']],
                $message
            );
        }
    }
}

<?php

namespace App\Notifications\Sms\Contracts;

interface SmsDriver
{
    public function send(string $recipient, string $message): array;
    // Returns ['success' => bool, 'response' => mixed, 'error' => string|null]
}

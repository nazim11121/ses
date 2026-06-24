<?php

namespace App\Notifications\Sms\Drivers;

use App\Notifications\Sms\Contracts\SmsDriver;
use Illuminate\Support\Facades\Http;

class TwilioDriver implements SmsDriver
{
    private array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function send(string $recipient, string $message): array
    {
        try {
            $sid   = $this->config['account_sid'] ?? '';
            $token = $this->config['auth_token'] ?? '';
            $from  = $this->config['from'] ?? '';

            $response = Http::withBasicAuth($sid, $token)
                ->asForm()
                ->post("https://api.twilio.com/2010-04-01/Accounts/{$sid}/Messages.json", [
                    'From' => $from,
                    'To'   => $recipient,
                    'Body' => $message,
                ]);

            $data = $response->json();

            if ($response->successful() && isset($data['sid'])) {
                return ['success' => true, 'response' => $data, 'error' => null];
            }

            return ['success' => false, 'response' => $data, 'error' => $data['message'] ?? 'Unknown error'];
        } catch (\Throwable $e) {
            return ['success' => false, 'response' => null, 'error' => $e->getMessage()];
        }
    }
}

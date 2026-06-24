<?php

namespace App\Notifications\Sms\Drivers;

use App\Notifications\Sms\Contracts\SmsDriver;
use Illuminate\Support\Facades\Http;

class InfobipDriver implements SmsDriver
{
    private array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function send(string $recipient, string $message): array
    {
        try {
            $baseUrl = $this->config['base_url'] ?? 'https://api.infobip.com';
            $apiKey  = $this->config['api_key'] ?? '';
            $sender  = $this->config['sender'] ?? 'InfoSMS';

            $response = Http::withHeaders([
                'Authorization' => "App {$apiKey}",
                'Content-Type'  => 'application/json',
                'Accept'        => 'application/json',
            ])->post("{$baseUrl}/sms/2/text/advanced", [
                'messages' => [[
                    'from'         => $sender,
                    'destinations' => [['to' => $recipient]],
                    'text'         => $message,
                ]],
            ]);

            $data = $response->json();

            if ($response->successful()) {
                return ['success' => true, 'response' => $data, 'error' => null];
            }

            return ['success' => false, 'response' => $data, 'error' => $data['requestError']['serviceException']['text'] ?? 'Unknown error'];
        } catch (\Throwable $e) {
            return ['success' => false, 'response' => null, 'error' => $e->getMessage()];
        }
    }
}

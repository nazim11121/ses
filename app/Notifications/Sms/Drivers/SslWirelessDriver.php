<?php

namespace App\Notifications\Sms\Drivers;

use App\Notifications\Sms\Contracts\SmsDriver;
use Illuminate\Support\Facades\Http;

class SslWirelessDriver implements SmsDriver
{
    private array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function send(string $recipient, string $message): array
    {
        try {
            $response = Http::post('https://globalsms.sslwireless.com/api/v3/send-sms', [
                'api_token' => $this->config['api_token'] ?? '',
                'sid'       => $this->config['sid'] ?? '',
                'sms'       => $message,
                'msisdn'    => $recipient,
                'csms_id'   => uniqid('ssl_'),
            ]);

            $data = $response->json();

            if ($response->successful() && isset($data['status']) && $data['status'] === 'ACCEPTED') {
                return ['success' => true, 'response' => $data, 'error' => null];
            }

            return ['success' => false, 'response' => $data, 'error' => $data['error'] ?? 'Unknown error'];
        } catch (\Throwable $e) {
            return ['success' => false, 'response' => null, 'error' => $e->getMessage()];
        }
    }
}

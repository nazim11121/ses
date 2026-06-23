<?php

namespace App\Couriers\Drivers;

use App\Couriers\Contracts\CourierDriver;

class MockCourierDriver implements CourierDriver
{
    public function dispatch($order, array $payload = []): array
    {
        return [
            'tracking_number' => 'MOCK-' . strtoupper(substr(md5((string) $order->id . time()), 0, 8)),
            'status' => 'Booked',
            'provider' => 'mock',
            'raw_response' => $payload,
        ];
    }
}

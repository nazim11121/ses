<?php

namespace App\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class CourierService
{
    public function dispatch($order, array $payload = [], ?string $provider = null): array
    {
        $provider = $provider ?? config('couriers.default', 'mock');
        $config = config("couriers.providers.{$provider}", []);

        $driverClass = Arr::get($config, 'class');

        if (! $driverClass || ! class_exists($driverClass)) {
            throw new \InvalidArgumentException("Courier provider [{$provider}] is not configured.");
        }

        $driver = app($driverClass);
        $result = $driver->dispatch($order, $payload);

        $order->courier_provider = $result['provider'] ?? $provider;
        $order->courier_tracking_number = $result['tracking_number'] ?? null;
        $order->courier_status = $result['status'] ?? 'Pending';
        $order->courier_payload = $result['raw_response'] ?? $payload;
        $order->save();

        return $result + [
            'provider' => $order->courier_provider,
            'tracking_number' => $order->courier_tracking_number,
        ];
    }
}

<?php

namespace App\Couriers\Contracts;

interface CourierDriver
{
    public function dispatch($order, array $payload = []): array;
}

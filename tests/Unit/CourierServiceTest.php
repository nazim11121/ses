<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Services\CourierService;
use Tests\TestCase;

class CourierServiceTest extends TestCase
{
    public function test_it_can_dispatch_an_order_with_a_pluggable_courier_driver()
    {
        config()->set('couriers.default', 'mock');
        config()->set('couriers.providers.mock.class', \App\Couriers\Drivers\MockCourierDriver::class);

        $order = new Order([
            'customer_name' => 'Test Customer',
            'customer_email' => 'test@example.com',
            'customer_phone' => '01700000000',
            'shipping_address' => 'Dhaka',
            'payment_method' => 'Cash on Delivery',
            'total_amount' => 250,
            'status' => 'Pending',
        ]);

        $service = new CourierService();
        $result = $service->dispatch($order, ['source' => 'unit-test'], 'mock');

        $this->assertSame('mock', $result['provider']);
        $this->assertNotEmpty($result['tracking_number']);
        $this->assertSame('Booked', $order->courier_status);
        $this->assertSame('mock', $order->courier_provider);
    }
}

<?php

return [
    'default' => env('COURIER_DRIVER', 'mock'),
    'providers' => [
        'mock' => [
            'class' => App\Couriers\Drivers\MockCourierDriver::class,
        ],
        'manual' => [
            'class' => App\Couriers\Drivers\MockCourierDriver::class,
        ],
    ],
];

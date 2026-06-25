<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItem;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'customer_email',
        'customer_phone',
        'shipping_address',
        'payment_method',
        'bkash_transaction_id',
        'bkash_amount',
        'total_amount',
        'status',
        'courier_provider',
        'courier_tracking_number',
        'courier_status',
        'courier_payload',
    ];

    protected $casts = [
        'courier_payload' => 'array',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}

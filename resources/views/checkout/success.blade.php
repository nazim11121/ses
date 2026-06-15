@extends('layouts.app')

@section('title', 'Order Confirmed')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm p-5 text-center">
            <h2 class="fw-bold">Thank you for your order!</h2>
            <p class="text-muted mb-4">Your order #{{ $order->id }} has been placed successfully.</p>
            <div class="text-start mb-4">
                <p><strong>Name:</strong> {{ $order->customer_name }}</p>
                <p><strong>Email:</strong> {{ $order->customer_email }}</p>
                <p><strong>Phone:</strong> {{ $order->customer_phone }}</p>
                <p><strong>Payment method:</strong> {{ $order->payment_method }}</p>
                <p><strong>Total:</strong> ₹{{ number_format($order->total_amount, 2) }}</p>
            </div>
            <a href="{{ route('home') }}" class="btn btn-primary">Continue Shopping</a>
        </div>
    </div>
</div>
@endsection

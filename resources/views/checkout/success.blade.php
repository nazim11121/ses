@extends('layouts.app')

@section('title', 'Order Confirmed')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm p-5">
            <div class="text-center mb-4">
                <div style="width:64px;height:64px;background:#d1fae5;border-radius:50%;display:grid;place-items:center;margin:0 auto .75rem">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
                <h2 class="fw-bold mb-1">Order Confirmed!</h2>
                <p class="text-muted">Thank you for your order. We'll process it shortly.</p>
            </div>

            <div class="bg-light rounded-3 p-4 mb-4">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Order ID</span>
                    <span class="fw-bold">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Name</span>
                    <span>{{ $order->customer_name }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Phone</span>
                    <span>{{ $order->customer_phone }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Payment</span>
                    <span class="fw-semibold">{{ $order->payment_method }}</span>
                </div>
                <div class="d-flex justify-content-between pt-2 border-top fw-bold" style="font-size:1.05rem">
                    <span>Total</span>
                    <span>৳{{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>

            @if($order->payment_method === 'bKash' && $order->bkash_transaction_id)
            <div class="rounded-3 p-4 mb-4" style="background:#fff8f9;border:1.5px solid #fcd5e4">
                <div style="font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#e2136e;margin-bottom:.75rem">bKash Payment Details</div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted" style="font-size:.9rem">Transaction ID</span>
                    <span class="fw-bold" style="font-size:.9rem;letter-spacing:.04em">{{ $order->bkash_transaction_id }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted" style="font-size:.9rem">Amount Paid</span>
                    <span class="fw-bold" style="font-size:.9rem;color:#e2136e">৳{{ number_format($order->bkash_amount, 2) }}</span>
                </div>
            </div>
            @endif

            <a href="{{ route('home') }}" class="btn btn-primary btn-lg w-100">Continue Shopping</a>
        </div>
    </div>
</div>
@endsection

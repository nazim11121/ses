@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="row gy-4">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm p-4">
            <h2 class="fw-bold">Checkout</h2>
            <p class="text-muted">Complete your order with a secure payment option.</p>
            <form action="{{ route('checkout.placeOrder') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="customer_name" class="form-control" value="{{ old('customer_name') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="customer_email" class="form-control" value="{{ old('customer_email') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="customer_phone" class="form-control" value="{{ old('customer_phone') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Shipping Address</label>
                    <textarea name="shipping_address" rows="4" class="form-control" required>{{ old('shipping_address') }}</textarea>
                </div>
                <div class="mb-4">
                    <label class="form-label d-block">Payment Method</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="paymentCash" name="payment_method" value="Cash on Delivery" checked>
                        <label class="form-check-label" for="paymentCash">Cash on Delivery</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="paymentBkash" name="payment_method" value="bKash">
                        <label class="form-check-label" for="paymentBkash">bKash</label>
                    </div>
                </div>
                <button class="btn btn-primary btn-lg">Place Order</button>
            </form>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm p-4">
            <h4 class="fw-bold">Order Summary</h4>
            <div class="mt-3">
                @foreach($items as $item)
                    <div class="d-flex align-items-center justify-content-between py-3 border-bottom">
                        <div>
                            <h6 class="mb-1">{{ $item->product->name }}</h6>
                            <small class="text-muted">Qty: {{ $item->quantity }}</small>
                        </div>
                        <span class="fw-semibold">₹{{ number_format($item->subtotal, 2) }}</span>
                    </div>
                @endforeach
                <div class="d-flex align-items-center justify-content-between pt-4">
                    <strong>Total</strong>
                    <strong>₹{{ number_format($total, 2) }}</strong>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

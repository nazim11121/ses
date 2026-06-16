@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<form action="{{ route('checkout.placeOrder') }}" method="POST">
    @csrf
    <div class="row gy-4">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm p-4">
                <h2 class="fw-bold">Checkout</h2>
                <p class="text-muted">Complete your order with a secure payment option.</p>
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
                    <div class="mb-4">
                        <!-- <label class="form-label d-block">Delivery Type</label> -->
                        <br>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="deliveryDhaka" name="delivery_zone" value="dhaka" {{ old('delivery_zone', 'dhaka') === 'dhaka' ? 'checked' : '' }}>
                            <label class="form-check-label" for="deliveryDhaka">Delivery inside Dhaka ৳{{ number_format($dhakaCharge, 2) }}</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="deliveryOutside" name="delivery_zone" value="outside" {{ old('delivery_zone', 'dhaka') === 'outside' ? 'checked' : '' }}>
                            <label class="form-check-label" for="deliveryOutside">Delivery outside Dhaka ৳{{ number_format($outsideCharge, 2) }}</label>
                        </div>
                    </div>
                    <div class="py-3 px-3 rounded-3 bg-light mb-3">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span>Subtotal</span>
                            <span>₹{{ number_format($total, 2) }}</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span>Delivery</span>
                            <span>৳<span id="deliveryChargeDisplay">{{ number_format(old('delivery_zone', 'dhaka') === 'outside' ? $outsideCharge : $dhakaCharge, 2) }}</span></span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between fw-semibold pt-3 border-top">
                            <span>Total</span>
                            <span>₹<span id="orderTotalDisplay">{{ number_format($total + (old('delivery_zone', 'dhaka') === 'outside' ? $outsideCharge : $dhakaCharge), 2) }}</span></span>
                        </div>
                    </div>
                    <button class="btn btn-primary btn-lg w-100">Place Order</button>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const baseTotal = {{ $total }};
        const dhakaCharge = {{ $dhakaCharge }};
        const outsideCharge = {{ $outsideCharge }};
        const deliveryChargeDisplay = document.getElementById('deliveryChargeDisplay');
        const orderTotalDisplay = document.getElementById('orderTotalDisplay');
        const deliveryRadios = document.querySelectorAll('input[name="delivery_zone"]');

        function updateDeliverySummary() {
            const selected = document.querySelector('input[name="delivery_zone"]:checked');
            const charge = selected && selected.value === 'outside' ? outsideCharge : dhakaCharge;
            deliveryChargeDisplay.textContent = charge.toFixed(2);
            orderTotalDisplay.textContent = (baseTotal + charge).toFixed(2);
        }

        deliveryRadios.forEach(function (radio) {
            radio.addEventListener('change', updateDeliverySummary);
        });

        updateDeliverySummary();
    });
</script>
@endsection

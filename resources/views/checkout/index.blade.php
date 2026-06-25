@extends('layouts.app')

@section('title', 'Checkout')

@section('head')
<style>
/* ── bKash modal ── */
.bkash-modal-header {
    background: linear-gradient(135deg, #e2136e 0%, #c01060 100%);
    color: #fff;
    border-radius: 12px 12px 0 0;
    padding: 1.5rem 1.75rem 1.25rem;
}
.bkash-logo-wrap {
    display: flex;
    align-items: center;
    gap: .75rem;
    margin-bottom: .5rem;
}
.bkash-logo-icon {
    width: 44px; height: 44px;
    background: #fff;
    border-radius: 10px;
    display: grid;
    place-items: center;
    font-weight: 900;
    font-size: 1.1rem;
    color: #e2136e;
    flex-shrink: 0;
}
.bkash-instruction-box {
    background: #fff8f9;
    border: 1.5px solid #fcd5e4;
    border-radius: 10px;
    padding: 1rem 1.2rem;
    margin-bottom: 1.25rem;
}
.bkash-number-display {
    font-size: 1.3rem;
    font-weight: 800;
    color: #e2136e;
    letter-spacing: .04em;
}
.bkash-step {
    display: flex;
    align-items: flex-start;
    gap: .6rem;
    font-size: .875rem;
    color: #4b5563;
    margin-bottom: .4rem;
}
.bkash-step-num {
    width: 20px; height: 20px;
    background: #e2136e;
    color: #fff;
    border-radius: 50%;
    font-size: .7rem;
    font-weight: 700;
    display: grid;
    place-items: center;
    flex-shrink: 0;
    margin-top: .05rem;
}
.bkash-input-group label { font-weight: 600; font-size: .875rem; color: #374151; margin-bottom: .35rem; }
.bkash-input-group .form-control:focus { border-color: #e2136e; box-shadow: 0 0 0 .2rem rgba(226,19,110,.15); }
.btn-bkash {
    background: linear-gradient(135deg, #e2136e, #c01060);
    color: #fff;
    border: none;
    font-weight: 700;
    letter-spacing: .02em;
    padding: .75rem 1.5rem;
    border-radius: 8px;
    transition: opacity .2s;
}
.btn-bkash:hover { opacity: .9; color: #fff; }
/* Payment method card style */
.payment-card {
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    padding: .85rem 1.1rem;
    cursor: pointer;
    transition: all .2s;
    display: flex;
    align-items: center;
    gap: .85rem;
    margin-bottom: .6rem;
}
.payment-card:has(input:checked) { border-color: #7c3aed; background: #faf7ff; }
.payment-card-icon {
    width: 40px; height: 40px;
    border-radius: 8px;
    display: grid;
    place-items: center;
    font-weight: 800;
    font-size: .8rem;
    flex-shrink: 0;
}
.payment-card-icon.cod  { background: #d1fae5; color: #059669; }
.payment-card-icon.bkash { background: #fce7f3; color: #e2136e; }
.payment-card input[type="radio"] { display: none; }
</style>
@endsection

@section('content')
<form action="{{ route('checkout.placeOrder') }}" method="POST" id="checkoutForm">
    @csrf
    {{-- Hidden bKash fields — filled by modal --}}
    <input type="hidden" name="bkash_transaction_id" id="hidBkashTxn">
    <input type="hidden" name="bkash_amount" id="hidBkashAmt">

    <div class="row gy-4">
        {{-- ── Left: Customer info ── --}}
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm p-4">
                <h2 class="fw-bold mb-1">Checkout</h2>
                <p class="text-muted mb-4">Fill in your details to complete the order.</p>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Full Name</label>
                    <input type="text" name="customer_name" class="form-control" value="{{ old('customer_name') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="customer_email" class="form-control" value="{{ old('customer_email') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Phone</label>
                    <input type="text" name="customer_phone" class="form-control" value="{{ old('customer_phone') }}" required>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold">Shipping Address</label>
                    <textarea name="shipping_address" rows="4" class="form-control" required>{{ old('shipping_address') }}</textarea>
                </div>

                <div class="mb-2">
                    <label class="form-label fw-semibold d-block mb-2">Payment Method</label>

                    <label class="payment-card">
                        <input type="radio" name="payment_method" id="paymentCash" value="Cash on Delivery" {{ old('payment_method', 'Cash on Delivery') === 'Cash on Delivery' ? 'checked' : '' }}>
                        <span class="payment-card-icon cod">COD</span>
                        <div>
                            <div class="fw-semibold" style="font-size:.9rem">Cash on Delivery</div>
                            <div class="text-muted" style="font-size:.78rem">Pay when you receive the parcel</div>
                        </div>
                    </label>

                    <label class="payment-card">
                        <input type="radio" name="payment_method" id="paymentBkash" value="bKash" {{ old('payment_method') === 'bKash' ? 'checked' : '' }}>
                        <span class="payment-card-icon bkash">bKash</span>
                        <div>
                            <div class="fw-semibold" style="font-size:.9rem">bKash</div>
                            <div class="text-muted" style="font-size:.78rem">Pay via bKash mobile banking</div>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        {{-- ── Right: Order summary ── --}}
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm p-4">
                <h4 class="fw-bold mb-3">Order Summary</h4>
                @foreach($items as $item)
                <div class="d-flex align-items-center justify-content-between py-2 border-bottom">
                    <div>
                        <div class="fw-semibold" style="font-size:.9rem">{{ $item->product->name }}</div>
                        <small class="text-muted">Qty: {{ $item->quantity }}</small>
                    </div>
                    <span class="fw-semibold">৳{{ number_format($item->subtotal, 2) }}</span>
                </div>
                @endforeach

                <div class="mt-3 mb-3">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" id="deliveryDhaka" name="delivery_zone" value="dhaka" {{ old('delivery_zone', 'dhaka') === 'dhaka' ? 'checked' : '' }}>
                        <label class="form-check-label" for="deliveryDhaka">Inside Dhaka &nbsp;<span class="fw-semibold">৳{{ number_format($dhakaCharge, 2) }}</span></label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" id="deliveryOutside" name="delivery_zone" value="outside" {{ old('delivery_zone') === 'outside' ? 'checked' : '' }}>
                        <label class="form-check-label" for="deliveryOutside">Outside Dhaka &nbsp;<span class="fw-semibold">৳{{ number_format($outsideCharge, 2) }}</span></label>
                    </div>
                </div>

                <div class="py-3 px-3 rounded-3 bg-light mb-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal</span>
                        <span>৳{{ number_format($total, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Delivery</span>
                        <span>৳<span id="deliveryChargeDisplay">{{ number_format(old('delivery_zone') === 'outside' ? $outsideCharge : $dhakaCharge, 2) }}</span></span>
                    </div>
                    <div class="d-flex justify-content-between fw-bold pt-2 border-top" style="font-size:1.05rem">
                        <span>Total</span>
                        <span>৳<span id="orderTotalDisplay">{{ number_format($total + (old('delivery_zone') === 'outside' ? $outsideCharge : $dhakaCharge), 2) }}</span></span>
                    </div>
                </div>

                <button type="button" id="placeOrderBtn" class="btn btn-primary btn-lg w-100">Place Order</button>
            </div>
        </div>
    </div>
</form>

{{-- ══════════════════════════════════════
     bKash Payment Modal
══════════════════════════════════════ --}}
<div class="modal fade" id="bkashModal" tabindex="-1" aria-labelledby="bkashModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" style="max-width:460px;margin-top:80px;margin-bottom:1.5rem">
        <div class="modal-content border-0 shadow-lg" style="border-radius:12px;overflow:hidden;max-height:calc(100vh - 96px)">

            {{-- Header --}}
            <div class="bkash-modal-header">
                <div class="bkash-logo-wrap">
                    <div class="bkash-logo-icon">bK</div>
                    <div>
                        <div style="font-weight:800;font-size:1.15rem">bKash Payment</div>
                        <div style="font-size:.8rem;opacity:.85">Complete your payment to place the order</div>
                    </div>
                </div>
            </div>

            {{-- Body --}}
            <div class="modal-body p-4" style="overflow-y:auto">

                {{-- Instruction box --}}
                <div class="bkash-instruction-box">
                    <div style="font-size:.8rem;font-weight:600;color:#9ca3af;text-transform:uppercase;letter-spacing:.05em;margin-bottom:.4rem">Send Money To</div>
                    <div class="bkash-number-display">
                        {{ $companyProfile && $companyProfile->mobile_number ? $companyProfile->mobile_number : '01XXXXXXXXX' }}
                    </div>
                    <div style="font-size:.78rem;color:#6b7280;margin-top:.25rem">bKash Personal / Merchant Number</div>

                    <hr style="margin:.85rem 0;border-color:#fcd5e4">

                    <div class="bkash-step">
                        <span class="bkash-step-num">1</span>
                        <span>Open your bKash app and tap <strong>Send Money</strong></span>
                    </div>
                    <div class="bkash-step">
                        <span class="bkash-step-num">2</span>
                        <span>Send exactly <strong>৳<span id="modalAmountHint">0.00</span></strong> to the number above</span>
                    </div>
                    <div class="bkash-step">
                        <span class="bkash-step-num">3</span>
                        <span>Copy the <strong>Transaction ID</strong> from your bKash confirmation message</span>
                    </div>
                    <div class="bkash-step" style="margin-bottom:0">
                        <span class="bkash-step-num">4</span>
                        <span>Enter the Transaction ID and amount below and confirm</span>
                    </div>
                </div>

                {{-- Fields --}}
                <div class="bkash-input-group mb-3">
                    <label for="bkashTxnInput">bKash Transaction ID <span class="text-danger">*</span></label>
                    <input type="text" id="bkashTxnInput" class="form-control form-control-lg"
                           placeholder="e.g. 8N7A2B3C4D" autocomplete="off" style="letter-spacing:.05em;font-weight:600">
                    <div class="invalid-feedback">Please enter the bKash Transaction ID.</div>
                </div>

                <div class="bkash-input-group mb-4">
                    <label for="bkashAmtInput">Amount Sent (৳) <span class="text-danger">*</span></label>
                    <input type="number" id="bkashAmtInput" class="form-control form-control-lg"
                           placeholder="0.00" step="0.01" min="1">
                    <div class="invalid-feedback">Please enter the amount you sent.</div>
                </div>

                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary flex-fill" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="bkashConfirmBtn" class="btn btn-bkash flex-fill">
                        Confirm &amp; Place Order
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const baseTotal       = {{ $total }};
    const dhakaCharge     = {{ $dhakaCharge }};
    const outsideCharge   = {{ $outsideCharge }};
    const deliveryDisplay = document.getElementById('deliveryChargeDisplay');
    const totalDisplay    = document.getElementById('orderTotalDisplay');
    const deliveryRadios  = document.querySelectorAll('input[name="delivery_zone"]');
    const modalAmountHint = document.getElementById('modalAmountHint');

    function currentCharge() {
        const sel = document.querySelector('input[name="delivery_zone"]:checked');
        return sel && sel.value === 'outside' ? outsideCharge : dhakaCharge;
    }

    function updateSummary() {
        const charge = currentCharge();
        deliveryDisplay.textContent = charge.toFixed(2);
        totalDisplay.textContent = (baseTotal + charge).toFixed(2);
    }

    deliveryRadios.forEach(function (r) { r.addEventListener('change', updateSummary); });
    updateSummary();

    /* ── Place Order button ── */
    document.getElementById('placeOrderBtn').addEventListener('click', function () {
        const isBkash = document.querySelector('input[name="payment_method"]:checked').value === 'bKash';
        if (isBkash) {
            // Pre-fill the amount hint in modal
            const total = baseTotal + currentCharge();
            modalAmountHint.textContent = total.toFixed(2);
            document.getElementById('bkashAmtInput').value = total.toFixed(2);
            document.getElementById('bkashTxnInput').value = '';
            // Remove previous validation states
            document.getElementById('bkashTxnInput').classList.remove('is-invalid');
            document.getElementById('bkashAmtInput').classList.remove('is-invalid');
            new bootstrap.Modal(document.getElementById('bkashModal')).show();
        } else {
            document.getElementById('checkoutForm').submit();
        }
    });

    /* ── bKash modal confirm ── */
    document.getElementById('bkashConfirmBtn').addEventListener('click', function () {
        const txnInput = document.getElementById('bkashTxnInput');
        const amtInput = document.getElementById('bkashAmtInput');
        let valid = true;

        if (!txnInput.value.trim()) {
            txnInput.classList.add('is-invalid');
            valid = false;
        } else {
            txnInput.classList.remove('is-invalid');
        }

        if (!amtInput.value || parseFloat(amtInput.value) <= 0) {
            amtInput.classList.add('is-invalid');
            valid = false;
        } else {
            amtInput.classList.remove('is-invalid');
        }

        if (!valid) return;

        document.getElementById('hidBkashTxn').value = txnInput.value.trim();
        document.getElementById('hidBkashAmt').value = amtInput.value;
        document.getElementById('checkoutForm').submit();
    });
});
</script>
@endsection

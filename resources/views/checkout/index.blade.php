@extends('layouts.app')

@section('title', 'Checkout')

@section('head')
<style>
/* ── Form validation states ── */
.field-group { margin-bottom: 1.1rem; }
.field-group label { font-weight: 600; font-size: .875rem; color: #374151; margin-bottom: .4rem; display: block; }
.field-group .form-control,
.field-group .form-select { border-radius: 8px; border: 1.5px solid #d1d5db; font-size: .92rem; transition: border-color .18s, box-shadow .18s; }
.field-group .form-control:focus,
.field-group .form-select:focus { border-color: #7c3aed; box-shadow: 0 0 0 3px rgba(124,58,237,.12); outline: none; }
.field-group .form-control.is-invalid,
.field-group .form-select.is-invalid { border-color: #ef4444; background-image: none; }
.field-group .form-control.is-invalid:focus { box-shadow: 0 0 0 3px rgba(239,68,68,.12); }
.field-group .form-control.is-valid { border-color: #10b981; background-image: none; }
.field-error { font-size: .78rem; color: #ef4444; margin-top: .3rem; display: none; }
.field-error.show { display: block; }
.server-error { font-size: .78rem; color: #ef4444; margin-top: .3rem; }

/* ── Payment method cards ── */
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
    user-select: none;
}
.payment-card:has(input:checked) { border-color: #7c3aed; background: #faf7ff; }
.payment-card-icon { width: 40px; height: 40px; border-radius: 8px; display: grid; place-items: center; font-weight: 800; font-size: .8rem; flex-shrink: 0; }
.payment-card-icon.cod   { background: #d1fae5; color: #059669; }
.payment-card-icon.bkash { background: #fce7f3; color: #e2136e; }
.payment-card input[type="radio"] { display: none; }

/* ── bKash modal ── */
.bkash-modal-header {
    background: linear-gradient(135deg, #e2136e 0%, #c01060 100%);
    color: #fff;
    border-radius: 12px 12px 0 0;
    padding: 1.25rem 1.5rem 1rem;
    flex-shrink: 0;
}
.bkash-logo-wrap { display: flex; align-items: center; gap: .75rem; }
.bkash-logo-icon {
    width: 42px; height: 42px;
    background: #fff;
    border-radius: 10px;
    display: grid;
    place-items: center;
    font-weight: 900;
    font-size: 1rem;
    color: #e2136e;
    flex-shrink: 0;
}
.bkash-instruction-box {
    background: #fff8f9;
    border: 1.5px solid #fcd5e4;
    border-radius: 10px;
    padding: .9rem 1rem;
    margin-bottom: 1.1rem;
}
.bkash-number-display { font-size: 1.25rem; font-weight: 800; color: #e2136e; letter-spacing: .04em; }
.bkash-step { display: flex; align-items: flex-start; gap: .55rem; font-size: .845rem; color: #4b5563; margin-bottom: .35rem; }
.bkash-step-num {
    width: 19px; height: 19px;
    background: #e2136e; color: #fff;
    border-radius: 50%; font-size: .68rem; font-weight: 700;
    display: grid; place-items: center; flex-shrink: 0; margin-top: .08rem;
}
.bkash-input-group label { font-weight: 600; font-size: .875rem; color: #374151; margin-bottom: .35rem; display: block; }
.bkash-input-group .form-control:focus { border-color: #e2136e; box-shadow: 0 0 0 .2rem rgba(226,19,110,.15); }
.btn-bkash {
    background: linear-gradient(135deg, #e2136e, #c01060);
    color: #fff; border: none; font-weight: 700;
    padding: .7rem 1.5rem; border-radius: 8px; transition: opacity .2s;
}
.btn-bkash:hover { opacity: .9; color: #fff; }

/* ── Alert for general errors ── */
.co-alert {
    background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c;
    border-radius: 10px; padding: .85rem 1.1rem; margin-bottom: 1.25rem;
    font-size: .875rem; display: flex; align-items: flex-start; gap: .6rem;
}
</style>
@endsection

@section('content')

{{-- ── Server validation alert ── --}}
@if($errors->any())
<div class="co-alert">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:.05rem"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
    <div>
        <strong>Please fix the following errors:</strong>
        <ul class="mb-0 mt-1 ps-3">
            @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif

<form action="{{ route('checkout.placeOrder') }}" method="POST" id="checkoutForm" novalidate>
    @csrf
    <input type="hidden" name="bkash_transaction_id" id="hidBkashTxn">
    <input type="hidden" name="bkash_amount"         id="hidBkashAmt">

    <div class="row gy-4">

        {{-- ── Left: Customer info ── --}}
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm p-4">
                <h2 class="fw-bold mb-1">Checkout</h2>
                <p class="text-muted mb-4">Fill in your details to complete the order.</p>

                {{-- Full Name --}}
                <div class="field-group">
                    <label for="customer_name">Full Name <span class="text-danger">*</span></label>
                    <input type="text" id="customer_name" name="customer_name"
                           class="form-control @error('customer_name') is-invalid @enderror"
                           value="{{ old('customer_name') }}"
                           placeholder="Enter your full name">
                    <div class="field-error" id="err_name">Full name is required (min. 2 characters).</div>
                    @error('customer_name')<div class="server-error">{{ $message }}</div>@enderror
                </div>

                {{-- Email --}}
                <div class="field-group">
                    <label for="customer_email">Email Address <span class="text-danger">*</span></label>
                    <input type="email" id="customer_email" name="customer_email"
                           class="form-control @error('customer_email') is-invalid @enderror"
                           value="{{ old('customer_email') }}"
                           placeholder="you@example.com">
                    <div class="field-error" id="err_email">Please enter a valid email address.</div>
                    @error('customer_email')<div class="server-error">{{ $message }}</div>@enderror
                </div>

                {{-- Phone --}}
                <div class="field-group">
                    <label for="customer_phone">Phone Number <span class="text-danger">*</span></label>
                    <input type="tel" id="customer_phone" name="customer_phone"
                           class="form-control @error('customer_phone') is-invalid @enderror"
                           value="{{ old('customer_phone') }}"
                           placeholder="01XXXXXXXXX"
                           maxlength="14">
                    <div class="field-error" id="err_phone">Enter a valid Bangladeshi phone number (e.g. 01712345678).</div>
                    @error('customer_phone')<div class="server-error">{{ $message }}</div>@enderror
                </div>

                {{-- Shipping Address --}}
                <div class="field-group" style="margin-bottom:1.4rem">
                    <label for="shipping_address">Shipping Address <span class="text-danger">*</span></label>
                    <textarea id="shipping_address" name="shipping_address" rows="4"
                              class="form-control @error('shipping_address') is-invalid @enderror"
                              placeholder="House no, Road, Area, City">{{ old('shipping_address') }}</textarea>
                    <div class="field-error" id="err_address">Please enter your full shipping address (min. 10 characters).</div>
                    @error('shipping_address')<div class="server-error">{{ $message }}</div>@enderror
                </div>

                {{-- Payment Method --}}
                <div>
                    <label class="form-label fw-semibold d-block mb-2">Payment Method <span class="text-danger">*</span></label>

                    <label class="payment-card">
                        <input type="radio" name="payment_method" id="paymentCash" value="Cash on Delivery"
                               {{ old('payment_method', 'Cash on Delivery') === 'Cash on Delivery' ? 'checked' : '' }}>
                        <span class="payment-card-icon cod">COD</span>
                        <div>
                            <div class="fw-semibold" style="font-size:.9rem">Cash on Delivery</div>
                            <div class="text-muted" style="font-size:.78rem">Pay when you receive the parcel</div>
                        </div>
                    </label>

                    <label class="payment-card">
                        <input type="radio" name="payment_method" id="paymentBkash" value="bKash"
                               {{ old('payment_method') === 'bKash' ? 'checked' : '' }}>
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
                        <input class="form-check-input" type="radio" id="deliveryDhaka" name="delivery_zone" value="dhaka"
                               {{ old('delivery_zone', 'dhaka') === 'dhaka' ? 'checked' : '' }}>
                        <label class="form-check-label" for="deliveryDhaka">
                            Inside Dhaka &nbsp;<span class="fw-semibold">৳{{ number_format($dhakaCharge, 2) }}</span>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" id="deliveryOutside" name="delivery_zone" value="outside"
                               {{ old('delivery_zone') === 'outside' ? 'checked' : '' }}>
                        <label class="form-check-label" for="deliveryOutside">
                            Outside Dhaka &nbsp;<span class="fw-semibold">৳{{ number_format($outsideCharge, 2) }}</span>
                        </label>
                    </div>
                </div>

                <div class="py-3 px-3 rounded-3 bg-light mb-4">
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

                <button type="button" id="placeOrderBtn" class="btn btn-primary btn-lg w-100 fw-semibold">
                    Place Order
                </button>
            </div>
        </div>

    </div>
</form>

{{-- ══════════════════════════════════════
     bKash Payment Modal
══════════════════════════════════════ --}}
<div class="modal fade" id="bkashModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" style="max-width:460px;margin-top:80px;margin-bottom:1.5rem">
        <div class="modal-content border-0 shadow-lg d-flex flex-column"
             style="border-radius:12px;overflow:hidden;max-height:calc(100vh - 96px)">

            <div class="bkash-modal-header">
                <div class="bkash-logo-wrap">
                    <div class="bkash-logo-icon">bK</div>
                    <div>
                        <div style="font-weight:800;font-size:1.1rem">bKash Payment</div>
                        <div style="font-size:.78rem;opacity:.85">Complete your payment to place the order</div>
                    </div>
                </div>
            </div>

            <div class="modal-body p-4" style="overflow-y:auto">

                <div class="bkash-instruction-box">
                    <div style="font-size:.75rem;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.06em;margin-bottom:.35rem">Send Money To</div>
                    <div class="bkash-number-display">
                        {{ $companyProfile && $companyProfile->mobile_number ? $companyProfile->mobile_number : '01XXXXXXXXX' }}
                    </div>
                    <div style="font-size:.75rem;color:#6b7280;margin-top:.2rem">bKash Personal / Merchant Number</div>
                    <hr style="margin:.7rem 0;border-color:#fcd5e4">
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
                        <span>Copy the <strong>Transaction ID</strong> from your bKash confirmation SMS</span>
                    </div>
                    <div class="bkash-step" style="margin-bottom:0">
                        <span class="bkash-step-num">4</span>
                        <span>Paste the Transaction ID and amount below, then confirm</span>
                    </div>
                </div>

                <div class="bkash-input-group mb-3">
                    <label for="bkashTxnInput">bKash Transaction ID <span class="text-danger">*</span></label>
                    <input type="text" id="bkashTxnInput" class="form-control form-control-lg"
                           placeholder="e.g. 8N7A2B3C4D" autocomplete="off"
                           style="letter-spacing:.05em;font-weight:600;text-transform:uppercase">
                    <div class="invalid-feedback">Please enter the Transaction ID from your bKash SMS.</div>
                </div>

                <div class="bkash-input-group mb-4">
                    <label for="bkashAmtInput">Amount Sent (৳) <span class="text-danger">*</span></label>
                    <input type="number" id="bkashAmtInput" class="form-control form-control-lg"
                           placeholder="0.00" step="0.01" min="1">
                    <div class="invalid-feedback">Amount must be greater than 0.</div>
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

    /* ── Delivery charge update ── */
    function currentCharge() {
        const sel = document.querySelector('input[name="delivery_zone"]:checked');
        return sel && sel.value === 'outside' ? outsideCharge : dhakaCharge;
    }
    function updateSummary() {
        const charge = currentCharge();
        deliveryDisplay.textContent = charge.toFixed(2);
        totalDisplay.textContent    = (baseTotal + charge).toFixed(2);
    }
    document.querySelectorAll('input[name="delivery_zone"]').forEach(function (r) {
        r.addEventListener('change', updateSummary);
    });
    updateSummary();

    /* ══════════════════════════════════════
       CLIENT-SIDE FORM VALIDATION
    ══════════════════════════════════════ */
    function showErr(inputId, errId) {
        document.getElementById(inputId).classList.add('is-invalid');
        document.getElementById(inputId).classList.remove('is-valid');
        var e = document.getElementById(errId);
        if (e) e.classList.add('show');
    }
    function clearErr(inputId, errId) {
        document.getElementById(inputId).classList.remove('is-invalid');
        document.getElementById(inputId).classList.add('is-valid');
        var e = document.getElementById(errId);
        if (e) e.classList.remove('show');
    }

    function validateForm() {
        var ok = true;

        /* Name */
        var name = document.getElementById('customer_name').value.trim();
        if (name.length < 2) { showErr('customer_name', 'err_name'); ok = false; }
        else                  { clearErr('customer_name', 'err_name'); }

        /* Email */
        var email = document.getElementById('customer_email').value.trim();
        var emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRe.test(email)) { showErr('customer_email', 'err_email'); ok = false; }
        else                       { clearErr('customer_email', 'err_email'); }

        /* Phone — BD format: starts with 01, 11 digits total */
        var phone = document.getElementById('customer_phone').value.trim();
        var phoneRe = /^(\+?880|0)1[3-9]\d{8}$/;
        if (!phoneRe.test(phone)) { showErr('customer_phone', 'err_phone'); ok = false; }
        else                       { clearErr('customer_phone', 'err_phone'); }

        /* Address */
        var addr = document.getElementById('shipping_address').value.trim();
        if (addr.length < 10) { showErr('shipping_address', 'err_address'); ok = false; }
        else                   { clearErr('shipping_address', 'err_address'); }

        if (!ok) {
            /* Scroll to first invalid field */
            var first = document.querySelector('.form-control.is-invalid');
            if (first) first.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
        return ok;
    }

    /* Clear error on user input */
    ['customer_name','customer_email','customer_phone','shipping_address'].forEach(function (id) {
        var el = document.getElementById(id);
        if (!el) return;
        el.addEventListener('input', function () {
            el.classList.remove('is-invalid');
            var errMap = {
                customer_name: 'err_name', customer_email: 'err_email',
                customer_phone: 'err_phone', shipping_address: 'err_address'
            };
            var e = document.getElementById(errMap[id]);
            if (e) e.classList.remove('show');
        });
    });

    /* ── Place Order button ── */
    document.getElementById('placeOrderBtn').addEventListener('click', function () {
        if (!validateForm()) return;

        var isBkash = document.querySelector('input[name="payment_method"]:checked').value === 'bKash';
        if (isBkash) {
            var total = baseTotal + currentCharge();
            document.getElementById('modalAmountHint').textContent = total.toFixed(2);
            document.getElementById('bkashAmtInput').value = total.toFixed(2);
            document.getElementById('bkashTxnInput').value = '';
            document.getElementById('bkashTxnInput').classList.remove('is-invalid');
            document.getElementById('bkashAmtInput').classList.remove('is-invalid');
            new bootstrap.Modal(document.getElementById('bkashModal')).show();
        } else {
            document.getElementById('checkoutForm').submit();
        }
    });

    /* ── bKash modal confirm ── */
    document.getElementById('bkashConfirmBtn').addEventListener('click', function () {
        var txn = document.getElementById('bkashTxnInput');
        var amt = document.getElementById('bkashAmtInput');
        var ok  = true;

        if (!txn.value.trim()) { txn.classList.add('is-invalid'); ok = false; }
        else                    { txn.classList.remove('is-invalid'); }

        if (!amt.value || parseFloat(amt.value) <= 0) { amt.classList.add('is-invalid'); ok = false; }
        else                                            { amt.classList.remove('is-invalid'); }

        if (!ok) return;

        document.getElementById('hidBkashTxn').value = txn.value.trim().toUpperCase();
        document.getElementById('hidBkashAmt').value = amt.value;
        document.getElementById('checkoutForm').submit();
    });

    /* Clear bKash modal errors on input */
    document.getElementById('bkashTxnInput').addEventListener('input', function () { this.classList.remove('is-invalid'); });
    document.getElementById('bkashAmtInput').addEventListener('input', function () { this.classList.remove('is-invalid'); });
});
</script>
@endsection

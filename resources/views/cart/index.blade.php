@extends('layouts.app')

@section('title', 'Your Cart')

@section('head')
<style>
/* ══════════════════════════════════════
   CART PAGE
══════════════════════════════════════ */
.cart-page { padding: 2rem 0 3.5rem; }

/* Flash messages */
.cart-flash {
    display: flex; align-items: center; gap: .65rem;
    border-radius: 10px; padding: .85rem 1.1rem;
    font-size: .875rem; font-weight: 500; margin-bottom: 1.25rem;
}
.cart-flash.success { background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; }
.cart-flash.error   { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }

/* Section title */
.cart-title {
    font-size: 1.45rem; font-weight: 800;
    color: var(--sb-text, #0f172a); margin-bottom: .25rem;
}
.cart-sub { font-size: .875rem; color: var(--sb-text-muted, #64748b); margin-bottom: 1.5rem; }

/* ── Cart item card ── */
.cart-item {
    display: grid;
    grid-template-columns: 88px 1fr;
    gap: 1rem;
    background: #fff;
    border: 1.5px solid #f1f5f9;
    border-radius: 14px;
    padding: 1rem;
    margin-bottom: .85rem;
    box-shadow: 0 1px 4px rgba(0,0,0,.04);
    transition: box-shadow .2s;
    position: relative;
}
.cart-item:hover { box-shadow: 0 4px 16px rgba(0,0,0,.08); }

.cart-item-img {
    width: 88px; height: 88px;
    border-radius: 10px;
    object-fit: cover;
    background: #f8fafc;
    flex-shrink: 0;
}

.cart-item-body { display: flex; flex-direction: column; justify-content: space-between; min-width: 0; }

.cart-item-name {
    font-weight: 700; font-size: .95rem;
    color: var(--sb-text, #0f172a);
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    margin-bottom: .15rem;
}
.cart-item-price {
    font-size: .82rem; color: var(--sb-text-muted, #64748b); margin-bottom: .55rem;
}

.cart-item-footer { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: .5rem; }

.cart-item-subtotal {
    font-size: 1rem; font-weight: 800; color: var(--sb-primary, #7c3aed);
}

/* Remove button */
.cart-remove-btn {
    position: absolute; top: .75rem; right: .85rem;
    width: 28px; height: 28px;
    border: none; background: #fee2e2; color: #ef4444;
    border-radius: 50%; display: grid; place-items: center;
    cursor: pointer; transition: background .18s, color .18s;
    padding: 0;
}
.cart-remove-btn:hover { background: #ef4444; color: #fff; }

/* ── Quantity stepper ── */
.qty-stepper {
    display: inline-flex; align-items: center;
    border: 1.5px solid #e2e8f0; border-radius: 8px;
    overflow: hidden; background: #f8fafc;
}
.qty-btn {
    width: 32px; height: 32px;
    border: none; background: transparent;
    font-size: 1.1rem; font-weight: 700; color: #475569;
    cursor: pointer; display: grid; place-items: center;
    transition: background .15s;
    line-height: 1;
}
.qty-btn:hover { background: #e2e8f0; color: #0f172a; }
.qty-input {
    width: 40px; height: 32px;
    border: none; border-left: 1.5px solid #e2e8f0; border-right: 1.5px solid #e2e8f0;
    text-align: center; font-weight: 700; font-size: .9rem;
    background: #fff; color: #0f172a;
    -moz-appearance: textfield;
}
.qty-input::-webkit-inner-spin-button,
.qty-input::-webkit-outer-spin-button { -webkit-appearance: none; }

/* ── Empty cart ── */
.cart-empty {
    text-align: center; padding: 3.5rem 1.5rem;
    background: #fff; border-radius: 16px;
    border: 1.5px dashed #e2e8f0;
}
.cart-empty-icon {
    width: 80px; height: 80px;
    background: #f1f5f9; border-radius: 50%;
    display: grid; place-items: center;
    margin: 0 auto 1.25rem;
}

/* ── Summary card ── */
.cart-summary-card {
    background: #fff;
    border: 1.5px solid #f1f5f9;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 2px 12px rgba(0,0,0,.05);
    position: sticky; top: 84px;
}
.cart-summary-title {
    font-size: 1.05rem; font-weight: 800;
    color: var(--sb-text, #0f172a); margin-bottom: 1.1rem;
    padding-bottom: .85rem; border-bottom: 1.5px solid #f1f5f9;
}
.summary-row {
    display: flex; justify-content: space-between; align-items: center;
    font-size: .875rem; color: var(--sb-text-muted, #64748b);
    margin-bottom: .65rem;
}
.summary-row.total {
    font-size: 1.1rem; font-weight: 800;
    color: var(--sb-text, #0f172a);
    padding-top: .85rem; margin-top: .35rem;
    border-top: 1.5px solid #f1f5f9; margin-bottom: 1.2rem;
}
.summary-row.total span:last-child { color: var(--sb-primary, #7c3aed); font-size: 1.2rem; }

.cart-checkout-btn {
    display: flex; align-items: center; justify-content: center; gap: .5rem;
    background: var(--sb-primary, #7c3aed); color: #fff;
    border: none; border-radius: 10px; padding: .9rem 1.5rem;
    font-weight: 700; font-size: .95rem; width: 100%;
    text-decoration: none; cursor: pointer;
    transition: background .2s, transform .15s;
}
.cart-checkout-btn:hover { background: var(--sb-primary-dark, #6d28d9); color: #fff; transform: translateY(-1px); }

.cart-continue-link {
    display: flex; align-items: center; justify-content: center; gap: .4rem;
    margin-top: .85rem; font-size: .85rem; font-weight: 500;
    color: var(--sb-text-muted, #64748b); text-decoration: none;
    transition: color .18s;
}
.cart-continue-link:hover { color: var(--sb-primary, #7c3aed); }

.delivery-note {
    background: #faf7ff; border: 1px solid #e9d5ff;
    border-radius: 8px; padding: .65rem .85rem;
    font-size: .78rem; color: #6d28d9;
    display: flex; align-items: flex-start; gap: .4rem;
    margin-top: .75rem; margin-bottom: .85rem;
}

/* Action bar */
.cart-action-bar {
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: .75rem;
    margin-top: .5rem;
}

@media (max-width: 575px) {
    .cart-item { grid-template-columns: 72px 1fr; }
    .cart-item-img { width: 72px; height: 72px; }
}
</style>
@endsection

@section('content')
<div class="cart-page">

    {{-- Flash messages --}}
    @if(session('success'))
    <div class="cart-flash success">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="cart-flash error">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        {{ session('error') }}
    </div>
    @endif

    @if($items->isEmpty())

    {{-- ── Empty cart ── --}}
    <div class="cart-empty">
        <div class="cart-empty-icon">
            <svg width="38" height="38" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
        </div>
        <h3 style="font-weight:800;font-size:1.3rem;margin-bottom:.5rem">Your cart is empty</h3>
        <p style="color:#64748b;font-size:.9rem;max-width:320px;margin:0 auto 1.5rem">
            Looks like you haven't added any sarees yet. Browse our collection and find something you love!
        </p>
        <a href="{{ route('products.index') }}" class="btn btn-primary px-4 py-2 fw-semibold">
            Shop Now
        </a>
    </div>

    @else

    <div class="row gy-4 align-items-start">

        {{-- ── Left: Cart items ── --}}
        <div class="col-lg-8">
            <h1 class="cart-title">
                Your Cart
                <span style="font-size:.95rem;font-weight:500;color:#64748b;margin-left:.5rem">({{ $items->count() }} {{ $items->count() === 1 ? 'item' : 'items' }})</span>
            </h1>
            <p class="cart-sub">Review your selected sarees before checkout.</p>

            @foreach($items as $item)
            <div class="cart-item">

                {{-- Remove button --}}
                <form action="{{ route('cart.remove', $item->product->id) }}" method="POST" style="display:contents">
                    @csrf
                    <button type="submit" class="cart-remove-btn" title="Remove item" onclick="return confirm('Remove {{ addslashes($item->product->name) }} from cart?')">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>
                </form>

                {{-- Product image --}}
                <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="cart-item-img">

                {{-- Item body --}}
                <div class="cart-item-body">
                    <div>
                        <div class="cart-item-name" style="padding-right:2.2rem">{{ $item->product->name }}</div>
                        <div class="cart-item-price">৳{{ number_format($item->product->price, 2) }} / piece</div>
                    </div>
                    <div class="cart-item-footer">

                        {{-- Qty stepper --}}
                        <form action="{{ route('cart.update', $item->product->id) }}" method="POST" class="qty-form">
                            @csrf
                            <div class="qty-stepper">
                                <button type="button" class="qty-btn qty-minus" aria-label="Decrease">−</button>
                                <input type="number" name="quantity" class="qty-input"
                                       value="{{ $item->quantity }}" min="1"
                                       max="{{ $item->product->stock }}" readonly>
                                <button type="button" class="qty-btn qty-plus" aria-label="Increase"
                                        data-max="{{ $item->product->stock }}">+</button>
                            </div>
                        </form>

                        <div class="cart-item-subtotal">৳{{ number_format($item->subtotal, 2) }}</div>
                    </div>
                </div>

            </div>
            @endforeach

            {{-- Action bar --}}
            <div class="cart-action-bar">
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary d-inline-flex align-items-center gap-2">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                    Continue Shopping
                </a>
                <form action="{{ route('cart.clear') }}" method="POST"
                      onsubmit="return confirm('Clear all items from your cart?')">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger d-inline-flex align-items-center gap-2">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                        Clear Cart
                    </button>
                </form>
            </div>
        </div>

        {{-- ── Right: Summary ── --}}
        <div class="col-lg-4">
            <div class="cart-summary-card">
                <div class="cart-summary-title">Order Summary</div>

                @foreach($items as $item)
                <div class="summary-row">
                    <span style="max-width:140px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">
                        {{ $item->product->name }}
                        <span style="color:#94a3b8">×{{ $item->quantity }}</span>
                    </span>
                    <span style="font-weight:600;color:var(--sb-text,#0f172a)">৳{{ number_format($item->subtotal, 2) }}</span>
                </div>
                @endforeach

                <div class="summary-row total">
                    <span>Subtotal</span>
                    <span>৳{{ number_format($total, 2) }}</span>
                </div>

                <div class="delivery-note">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:.1rem"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <span>Delivery charge will be calculated at checkout based on your location.</span>
                </div>

                <a href="{{ route('checkout.index') }}" class="cart-checkout-btn">
                    Proceed to Checkout
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>

                <a href="{{ route('products.index') }}" class="cart-continue-link">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                    Continue Shopping
                </a>
            </div>
        </div>

    </div>
    @endif

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.qty-form').forEach(function (form) {
        var input   = form.querySelector('.qty-input');
        var btnMinus = form.querySelector('.qty-minus');
        var btnPlus  = form.querySelector('.qty-plus');
        var maxStock = parseInt(btnPlus.dataset.max) || 999;

        btnMinus.addEventListener('click', function () {
            var val = parseInt(input.value);
            if (val > 1) {
                input.value = val - 1;
                form.submit();
            }
        });

        btnPlus.addEventListener('click', function () {
            var val = parseInt(input.value);
            if (val < maxStock) {
                input.value = val + 1;
                form.submit();
            }
        });
    });
});
</script>
@endsection

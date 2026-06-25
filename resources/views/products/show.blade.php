@extends('layouts.app')

@section('title', $product->name)

@section('head')
<style>
/* ══════════════════════════════════════
   PRODUCT DETAIL PAGE
══════════════════════════════════════ */
.pd-wrap { padding: 2rem 0 4rem; }

/* ── Breadcrumb ── */
.pd-breadcrumb {
    display: flex; align-items: center; gap: .45rem;
    font-size: .8rem; color: #94a3b8; margin-bottom: 2rem; flex-wrap: wrap;
}
.pd-breadcrumb a { color: #94a3b8; text-decoration: none; transition: color .18s; }
.pd-breadcrumb a:hover { color: var(--sb-primary, #7c3aed); }
.pd-breadcrumb .sep { color: #cbd5e1; }
.pd-breadcrumb .current { color: #475569; font-weight: 500;
    max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

/* ── Image panel ── */
.pd-img-panel { position: sticky; top: 84px; }
.pd-img-wrap {
    border-radius: 18px; overflow: hidden;
    background: #f8fafc;
    box-shadow: 0 4px 24px rgba(0,0,0,.08);
    aspect-ratio: 1 / 1.1;
    cursor: zoom-in;
}
.pd-img-wrap img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: transform .55s cubic-bezier(.25,.46,.45,.94);
    display: block;
}
.pd-img-wrap:hover img { transform: scale(1.06); }

/* ── Info panel ── */
.pd-info { padding-left: .5rem; }

.pd-category-badge {
    display: inline-flex; align-items: center; gap: .35rem;
    background: var(--sb-primary-light, #ede9fe); color: var(--sb-primary, #7c3aed);
    font-size: .72rem; font-weight: 700; letter-spacing: .07em; text-transform: uppercase;
    padding: .3rem .85rem; border-radius: 50px; margin-bottom: .85rem;
}

.pd-section-badge {
    display: inline-flex; align-items: center; gap: .3rem;
    font-size: .73rem; font-weight: 700; letter-spacing: .06em; text-transform: uppercase;
    padding: .28rem .75rem; border-radius: 50px; margin-left: .5rem;
}
.pd-section-badge.new       { background: #d1fae5; color: #065f46; }
.pd-section-badge.featured  { background: #fef3c7; color: #92400e; }
.pd-section-badge.top_rated { background: #fff0f6; color: #be185d; }

.pd-name {
    font-size: clamp(1.5rem, 3.5vw, 2.1rem);
    font-weight: 800; line-height: 1.2;
    color: var(--sb-text, #0f172a); margin-bottom: .65rem;
}

.pd-price {
    font-size: 1.9rem; font-weight: 900;
    color: var(--sb-primary, #7c3aed); margin-bottom: .85rem; letter-spacing: -.01em;
}
.pd-price-old {
    font-size: 1rem; font-weight: 400; color: #94a3b8;
    text-decoration: line-through; margin-left: .5rem;
}

/* Stock badge */
.pd-stock-badge {
    display: inline-flex; align-items: center; gap: .4rem;
    font-size: .8rem; font-weight: 600; padding: .3rem .8rem;
    border-radius: 50px; margin-bottom: 1.2rem;
}
.pd-stock-badge.in-stock    { background: #d1fae5; color: #065f46; }
.pd-stock-badge.low-stock   { background: #fef3c7; color: #92400e; }
.pd-stock-badge.out-of-stock{ background: #fee2e2; color: #991b1b; }
.pd-stock-dot {
    width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0;
}
.in-stock .pd-stock-dot     { background: #059669; }
.low-stock .pd-stock-dot    { background: #d97706; }
.out-of-stock .pd-stock-dot { background: #ef4444; }

/* Divider */
.pd-divider { border: none; border-top: 1.5px solid #f1f5f9; margin: 1.1rem 0; }

/* Description */
.pd-desc {
    font-size: .92rem; color: #475569; line-height: 1.75;
    margin-bottom: 1.2rem;
}

/* Qty stepper */
.pd-qty-label { font-size: .8rem; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: #94a3b8; margin-bottom: .5rem; }
.pd-qty-stepper {
    display: inline-flex; align-items: center;
    border: 2px solid #e2e8f0; border-radius: 10px; overflow: hidden;
    background: #f8fafc; margin-bottom: 1.3rem;
}
.pd-qty-btn {
    width: 42px; height: 42px; border: none; background: transparent;
    font-size: 1.25rem; font-weight: 700; color: #475569;
    cursor: pointer; display: grid; place-items: center; transition: background .15s;
}
.pd-qty-btn:hover:not(:disabled) { background: #e2e8f0; color: #0f172a; }
.pd-qty-btn:disabled { opacity: .35; cursor: not-allowed; }
.pd-qty-input {
    width: 52px; height: 42px; border: none;
    border-left: 2px solid #e2e8f0; border-right: 2px solid #e2e8f0;
    text-align: center; font-weight: 800; font-size: 1rem;
    background: #fff; color: #0f172a;
    -moz-appearance: textfield;
}
.pd-qty-input::-webkit-inner-spin-button,
.pd-qty-input::-webkit-outer-spin-button { -webkit-appearance: none; }

/* CTA buttons */
.pd-cta-add {
    display: flex; align-items: center; justify-content: center; gap: .55rem;
    width: 100%; padding: .95rem; border-radius: 12px;
    background: var(--sb-primary, #7c3aed); color: #fff;
    font-weight: 700; font-size: 1rem; border: none; cursor: pointer;
    transition: background .2s, transform .15s; margin-bottom: .65rem;
    text-decoration: none;
}
.pd-cta-add:hover:not(:disabled) { background: #6d28d9; color: #fff; transform: translateY(-1px); }
.pd-cta-add:disabled { opacity: .55; cursor: not-allowed; }

.pd-cta-cart {
    display: flex; align-items: center; justify-content: center; gap: .55rem;
    width: 100%; padding: .9rem; border-radius: 12px;
    background: transparent; color: var(--sb-primary, #7c3aed);
    font-weight: 600; font-size: .9rem;
    border: 2px solid var(--sb-primary, #7c3aed);
    text-decoration: none; transition: background .18s;
}
.pd-cta-cart:hover { background: var(--sb-primary-light, #ede9fe); color: var(--sb-primary, #7c3aed); }

/* Info chips */
.pd-info-chips {
    display: flex; flex-wrap: wrap; gap: .6rem; margin-top: 1.1rem;
}
.pd-chip {
    display: inline-flex; align-items: center; gap: .45rem;
    font-size: .78rem; font-weight: 500; color: #475569;
    background: #f8fafc; border: 1px solid #e2e8f0;
    padding: .4rem .85rem; border-radius: 50px;
}

/* Flash */
.pd-flash {
    display: flex; align-items: center; gap: .6rem;
    border-radius: 10px; padding: .8rem 1rem;
    font-size: .875rem; font-weight: 500;
    margin-bottom: 1.25rem;
}
.pd-flash.success { background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; }

/* ── Related products ── */
.pd-related-title {
    font-size: 1.3rem; font-weight: 800; color: var(--sb-text, #0f172a);
    margin-bottom: 1.25rem; padding-bottom: .75rem;
    border-bottom: 2px solid #f1f5f9;
    display: flex; align-items: center; gap: .6rem;
}
.pd-related-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1.1rem;
}
.pd-rel-card {
    border-radius: 14px; overflow: hidden;
    border: 1.5px solid #f1f5f9;
    background: #fff;
    box-shadow: 0 2px 8px rgba(0,0,0,.04);
    transition: box-shadow .22s, transform .22s;
    text-decoration: none;
}
.pd-rel-card:hover { box-shadow: 0 8px 28px rgba(0,0,0,.1); transform: translateY(-3px); }
.pd-rel-img { width: 100%; aspect-ratio: 1; object-fit: cover; display: block; }
.pd-rel-body { padding: .75rem .9rem .9rem; }
.pd-rel-cat  { font-size: .68rem; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: #94a3b8; margin-bottom: .25rem; }
.pd-rel-name { font-size: .9rem; font-weight: 700; color: #0f172a; margin-bottom: .4rem; line-height: 1.3;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.pd-rel-price { font-size: .95rem; font-weight: 800; color: var(--sb-primary, #7c3aed); }
</style>
@endsection

@section('content')
<div class="pd-wrap">

    {{-- Flash --}}
    @if(session('success'))
    <div class="pd-flash success">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- Breadcrumb --}}
    <nav class="pd-breadcrumb" aria-label="Breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span class="sep">/</span>
        <a href="{{ route('products.index') }}">Shop</a>
        @if($product->category)
        <span class="sep">/</span>
        <a href="{{ route('product.category', $product->category->slug) }}">{{ $product->category->name }}</a>
        @endif
        <span class="sep">/</span>
        <span class="current">{{ $product->name }}</span>
    </nav>

    {{-- ── Main product section ── --}}
    <div class="row g-5 mb-5">

        {{-- Image --}}
        <div class="col-lg-5">
            <div class="pd-img-panel">
                <div class="pd-img-wrap">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" id="pdMainImg">
                </div>
            </div>
        </div>

        {{-- Details --}}
        <div class="col-lg-7">
            <div class="pd-info">

                {{-- Category + section badges --}}
                <div style="margin-bottom:.85rem">
                    @if($product->category)
                    <span class="pd-category-badge">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                        {{ $product->category->name }}
                    </span>
                    @endif
                    @if($product->section === 'new_arrival')
                    <span class="pd-section-badge new">✦ New Arrival</span>
                    @elseif($product->section === 'featured')
                    <span class="pd-section-badge featured">⭐ Featured Pick</span>
                    @elseif($product->section === 'top_rated')
                    <span class="pd-section-badge top_rated">🔥 Top Rated</span>
                    @endif
                </div>

                <h1 class="pd-name">{{ $product->name }}</h1>

                <div class="pd-price">
                    ৳{{ number_format($product->price, 0) }}
                </div>

                {{-- Stock badge --}}
                @if($product->stock <= 0)
                <span class="pd-stock-badge out-of-stock">
                    <span class="pd-stock-dot"></span> Out of Stock
                </span>
                @elseif($product->stock <= 10)
                <span class="pd-stock-badge low-stock">
                    <span class="pd-stock-dot"></span> Only {{ $product->stock }} left
                </span>
                @else
                <span class="pd-stock-badge in-stock">
                    <span class="pd-stock-dot"></span> In Stock ({{ $product->stock }} available)
                </span>
                @endif

                <hr class="pd-divider">

                @if($product->description)
                <p class="pd-desc">{{ $product->description }}</p>
                @endif

                {{-- Add to Cart form --}}
                @if($product->stock > 0)
                <form action="{{ route('cart.add', $product->id) }}" method="POST" id="pdAddForm">
                    @csrf
                    <div class="pd-qty-label">Quantity</div>
                    <div class="pd-qty-stepper">
                        <button type="button" class="pd-qty-btn" id="pdQtyMinus" aria-label="Decrease">−</button>
                        <input type="number" name="quantity" id="pdQtyInput" class="pd-qty-input"
                               value="1" min="1" max="{{ $product->stock }}" readonly>
                        <button type="button" class="pd-qty-btn" id="pdQtyPlus"
                                aria-label="Increase" data-max="{{ $product->stock }}">+</button>
                    </div>
                    <button type="submit" class="pd-cta-add">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                        Add to Cart
                    </button>
                </form>
                @else
                <button class="pd-cta-add" disabled>Out of Stock</button>
                @endif

                <a href="{{ route('cart.index') }}" class="pd-cta-cart">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                    View Cart
                </a>

                {{-- Info chips --}}
                <div class="pd-info-chips">
                    <span class="pd-chip">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        Cash on Delivery
                    </span>
                    <span class="pd-chip" style="color:#e2136e;border-color:#fcd5e4;background:#fff8f9">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
                        bKash Accepted
                    </span>
                    <span class="pd-chip">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13" rx="1"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                        Fast Delivery
                    </span>
                    <span class="pd-chip">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 4 23 10 17 10"/><polyline points="1 20 1 14 7 14"/><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/></svg>
                        Easy Returns
                    </span>
                </div>

            </div>
        </div>

    </div>

    {{-- ── Related Products ── --}}
    @if($relatedProducts->isNotEmpty())
    <div style="margin-top:3rem">
        <div class="pd-related-title">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
            You Might Also Like
        </div>
        <div class="pd-related-grid">
            @foreach($relatedProducts as $rel)
            <a href="{{ route('product.show', $rel->slug) }}" class="pd-rel-card">
                <img src="{{ $rel->image_url }}" alt="{{ $rel->name }}" class="pd-rel-img">
                <div class="pd-rel-body">
                    <div class="pd-rel-cat">{{ $rel->category ? $rel->category->name : 'Saree' }}</div>
                    <div class="pd-rel-name">{{ $rel->name }}</div>
                    <div class="pd-rel-price">৳{{ number_format($rel->price, 0) }}</div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var input    = document.getElementById('pdQtyInput');
    var btnMinus = document.getElementById('pdQtyMinus');
    var btnPlus  = document.getElementById('pdQtyPlus');
    if (!input) return;
    var maxStock = parseInt(btnPlus ? btnPlus.dataset.max : 1) || 1;

    function refreshBtns() {
        if (btnMinus) btnMinus.disabled = parseInt(input.value) <= 1;
        if (btnPlus)  btnPlus.disabled  = parseInt(input.value) >= maxStock;
    }

    if (btnMinus) {
        btnMinus.addEventListener('click', function () {
            var v = parseInt(input.value);
            if (v > 1) { input.value = v - 1; refreshBtns(); }
        });
    }
    if (btnPlus) {
        btnPlus.addEventListener('click', function () {
            var v = parseInt(input.value);
            if (v < maxStock) { input.value = v + 1; refreshBtns(); }
        });
    }

    refreshBtns();
});
</script>
@endsection

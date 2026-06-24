@extends('layouts.app')

@section('title', 'Home')
@section('full-width', true)

@section('head')
<style>
/* ── Solid navbar for home (carousel replaces dark hero) ── */
.sb-navbar { background:#fff !important; box-shadow:0 1px 8px rgba(0,0,0,.08) !important; }
.sb-navbar .sb-nav-link { color:var(--sb-text-muted) !important; }
.sb-navbar .sb-nav-link:hover, .sb-navbar .sb-nav-link.active { color:var(--sb-primary) !important; }

/* ══════════════════════════════════════════
   MODERN HOME SLIDER
══════════════════════════════════════════ */
.home-slider-section { padding-top:68px; } /* fixed navbar offset */

/* ── Slide ── */
.hs-slide {
    position: relative;
    height: 540px;
    display: flex;
    align-items: center;
    overflow: hidden;
}
@media(max-width:991px){ .hs-slide { height:400px; } }
@media(max-width:575px){ .hs-slide { height:300px; } }

/* Ken Burns zoom-out on active slide */
.hs-bg {
    position: absolute; inset: 0;
    background-size: cover;
    background-position: center top;
    transform: scale(1.07);
    transition: transform 7s cubic-bezier(.25,.46,.45,.94);
    will-change: transform;
}
.carousel-item.active .hs-bg { transform: scale(1); }

/* Gradient overlay — dark left, fades right */
.hs-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(105deg,
        rgba(8,6,22,.82) 0%,
        rgba(8,6,22,.55) 45%,
        rgba(8,6,22,.08) 100%);
}

/* ── Text content ── */
.hs-content {
    position: relative;
    z-index: 3;
    color: #fff;
    padding: 0 1rem;
    max-width: 600px;
}

.hs-tag {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    font-size: .7rem;
    font-weight: 700;
    letter-spacing: .14em;
    text-transform: uppercase;
    color: rgba(255,255,255,.9);
    background: rgba(255,255,255,.12);
    border: 1px solid rgba(255,255,255,.25);
    border-radius: 50px;
    padding: .3rem .9rem;
    backdrop-filter: blur(6px);
    margin-bottom: 1.1rem;
}

.hs-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(1.85rem, 4.2vw, 3.2rem);
    font-weight: 700;
    line-height: 1.12;
    margin-bottom: .85rem;
    color: #fff;
}

.hs-sub {
    font-size: 1.02rem;
    color: rgba(255,255,255,.78);
    line-height: 1.65;
    margin-bottom: 1.75rem;
    max-width: 440px;
}

.hs-btn {
    padding: .72rem 1.9rem;
    font-size: .93rem;
    font-weight: 600;
    border-radius: 50px;
}

/* ── Content animation (fires every time a slide becomes active) ── */
@keyframes hsFadeUp {
    from { opacity:0; transform:translateY(22px); }
    to   { opacity:1; transform:translateY(0); }
}
.carousel-item.active .hs-tag   { animation: hsFadeUp .55s .1s  both; }
.carousel-item.active .hs-title { animation: hsFadeUp .55s .24s both; }
.carousel-item.active .hs-sub   { animation: hsFadeUp .55s .38s both; }
.carousel-item.active .hs-btn   { animation: hsFadeUp .55s .5s  both; }

/* ── Slide count badge (top-right) ── */
.hs-counter {
    position: absolute;
    top: 1.5rem;
    right: 1.75rem;
    z-index: 10;
    color: rgba(255,255,255,.7);
    font-size: .78rem;
    font-weight: 600;
    letter-spacing: .06em;
    pointer-events: none;
}
.hs-counter strong { color: #fff; }

/* ── Custom line indicators ── */
.home-slider .carousel-indicators {
    bottom: 1.4rem;
    gap: .45rem;
    margin: 0;
    align-items: center;
}
.home-slider .carousel-indicators [data-bs-slide-to] {
    width: 28px; height: 4px;
    border-radius: 2px;
    background: rgba(255,255,255,.38);
    border-top: 0; border-bottom: 0;
    margin: 0; opacity: 1;
    transition: width .35s ease, background .35s ease;
    flex-shrink: 0;
}
.home-slider .carousel-indicators [data-bs-slide-to].active {
    width: 56px;
    background: #fff;
}

/* ── Custom arrow buttons ── */
.hs-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    z-index: 10;
    width: 50px; height: 50px;
    border-radius: 50%;
    background: rgba(255,255,255,.13);
    border: 1.5px solid rgba(255,255,255,.35);
    backdrop-filter: blur(10px);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    padding: 0;
    transition: background .22s, border-color .22s, transform .22s;
}
.hs-arrow:hover {
    background: rgba(255,255,255,.26);
    border-color: rgba(255,255,255,.7);
    transform: translateY(-50%) scale(1.08);
    color: #fff;
}
.hs-arrow-prev { left: 1.4rem; }
.hs-arrow-next { right: 1.4rem; }

@media(max-width:575px){
    .hs-arrow { width:38px; height:38px; }
    .hs-arrow-prev { left: .6rem; }
    .hs-arrow-next { right: .6rem; }
    .hs-sub { display:none; }
    .hs-title { font-size:1.4rem; }
}
</style>
@endsection

@section('content')

{{-- ══════════════════════════════════════
     HERO SLIDER
══════════════════════════════════════ --}}
@php
    $hsSlides = $slides->count() ? $slides : collect([
        (object)['image_url'=>'https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&w=1600&q=80','title'=>'Elegant Bangladeshi Sarees','subtitle'=>'Discover premium handwoven designs crafted for every celebration and occasion.','button_text'=>'Shop Collection','button_link'=>route('products.index')],
        (object)['image_url'=>'https://images.unsplash.com/photo-1583391733956-3750e0ff4e8b?auto=format&fit=crop&w=1600&q=80','title'=>'Festival Collections','subtitle'=>'Celebrate Eid, Puja and every special moment with our exclusive festive sarees.','button_text'=>'Explore Now','button_link'=>route('products.index')],
        (object)['image_url'=>'https://images.unsplash.com/photo-1594938298603-c8148c4b4a6a?auto=format&fit=crop&w=1600&q=80','title'=>'Bridal Sarees','subtitle'=>'Make your most special day unforgettable with our exquisite bridal collection.','button_text'=>'Shop Bridal','button_link'=>route('products.index')],
    ]);
    $hsCount = $hsSlides->count();
@endphp

<div class="home-slider-section">
    <div id="homeSlider" class="carousel slide home-slider" data-bs-ride="carousel" data-bs-interval="5500">

        {{-- Line indicators --}}
        <div class="carousel-indicators">
            @foreach($hsSlides as $i => $sl)
            <button type="button" data-bs-target="#homeSlider" data-bs-slide-to="{{ $i }}"
                class="{{ $i === 0 ? 'active' : '' }}"
                aria-current="{{ $i === 0 ? 'true' : 'false' }}"
                aria-label="Slide {{ $i + 1 }}"></button>
            @endforeach
        </div>

        {{-- Slides --}}
        <div class="carousel-inner">
            @foreach($hsSlides as $i => $sl)
            <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                <div class="hs-slide">
                    <div class="hs-bg" style="background-image:url('{{ $sl->image_url }}')"></div>
                    <div class="hs-overlay"></div>

                    {{-- Slide counter top-right --}}
                    <div class="hs-counter">
                        <strong>{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</strong> / {{ str_pad($hsCount, 2, '0', STR_PAD_LEFT) }}
                    </div>

                    <div class="container-xl">
                        <div class="hs-content">
                            <span class="hs-tag">✦ New Collection 2025</span>
                            <h2 class="hs-title">{!! nl2br(e($sl->title)) !!}</h2>
                            <p class="hs-sub">{{ $sl->subtitle }}</p>
                            @if(!empty($sl->button_text) && !empty($sl->button_link))
                            <a href="{{ $sl->button_link }}" class="btn sb-btn-primary hs-btn">
                                {{ $sl->button_text }}
                                <svg class="ms-2" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Custom arrow — prev --}}
        <button class="hs-arrow hs-arrow-prev" type="button" data-bs-target="#homeSlider" data-bs-slide="prev" aria-label="Previous slide">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
        </button>

        {{-- Custom arrow — next --}}
        <button class="hs-arrow hs-arrow-next" type="button" data-bs-target="#homeSlider" data-bs-slide="next" aria-label="Next slide">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
        </button>

    </div>
</div>

{{-- ══════════════════════════════════════
     TRUST BADGES
══════════════════════════════════════ --}}
<section class="sb-trust-bar">
    <div class="container-xl">
        <div class="sb-trust-grid">

            <div class="sb-trust-item">
                <div class="sb-trust-icon-wrap" style="background:#ede9fe; color:#7c3aed">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                </div>
                <div class="sb-trust-body">
                    <div class="sb-trust-title">Free Delivery</div>
                    <div class="sb-trust-sub">On all orders above ৳999</div>
                </div>
            </div>

            <div class="sb-trust-item">
                <div class="sb-trust-icon-wrap" style="background:#d1fae5; color:#059669">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
                </div>
                <div class="sb-trust-body">
                    <div class="sb-trust-title">Easy Returns</div>
                    <div class="sb-trust-sub">7-day hassle-free policy</div>
                </div>
            </div>

            <div class="sb-trust-item">
                <div class="sb-trust-icon-wrap" style="background:#dbeafe; color:#2563eb">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                </div>
                <div class="sb-trust-body">
                    <div class="sb-trust-title">Secure Payment</div>
                    <div class="sb-trust-sub">100% encrypted &amp; safe</div>
                </div>
            </div>

            <div class="sb-trust-item">
                <div class="sb-trust-icon-wrap" style="background:#fef3c7; color:#d97706">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.18 2 2 0 0 1 3.6 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.65a16 16 0 0 0 6 6l.86-.86a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21.71 16z"/></svg>
                </div>
                <div class="sb-trust-body">
                    <div class="sb-trust-title">24/7 Support</div>
                    <div class="sb-trust-sub">Always here to help you</div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ══════════════════════════════════════
     CATEGORIES
══════════════════════════════════════ --}}
@if($categories->count())
<section class="sb-section reveal">
    <div class="container-xl">
        <div class="sb-section-head">
            <div>
                <p class="sb-section-eyebrow">Browse By</p>
                <h2 class="sb-section-title">Shop Categories</h2>
            </div>
        </div>
        <div class="sb-category-grid">
            @foreach($categories as $cat)
            <a href="{{ route('product.category', $cat->slug) }}" class="sb-cat-card">
                <div class="sb-cat-icon">
                    {{ strtoupper(substr($cat->name, 0, 1)) }}
                </div>
                <div class="sb-cat-name">{{ $cat->name }}</div>
            </a>
            @endforeach
            <a href="{{ route('products.index') }}" class="sb-cat-card sb-cat-all">
                <div class="sb-cat-icon">→</div>
                <div class="sb-cat-name">All</div>
            </a>
        </div>
    </div>
</section>
@endif

{{-- ══════════════════════════════════════
     PRODUCTS — TABBED
══════════════════════════════════════ --}}
<section class="sb-section sb-section-alt reveal">
    <div class="container-xl">
        <div class="sb-section-head">
            <div>
                <p class="sb-section-eyebrow">Our Selection</p>
                <h2 class="sb-section-title">Curated Collections</h2>
            </div>
            <a href="{{ route('products.index') }}" class="btn sb-btn-outline">View All</a>
        </div>

        {{-- Tabs --}}
        <div class="sb-tabs" id="productTabs">
            <button class="sb-tab active" data-target="tab-new">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                New Arrivals
            </button>
            <button class="sb-tab" data-target="tab-featured">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                Featured
            </button>
            <button class="sb-tab" data-target="tab-top">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                Top Rated
            </button>
        </div>

        {{-- New Arrivals --}}
        <div class="sb-tab-panel active" id="tab-new">
            <div class="sb-product-grid">
                @forelse($newArrivals->take(8) as $product)
                <a href="{{ route('product.show', $product->slug) }}" class="sb-product-card">
                    <div class="sb-product-img-wrap">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy">
                        <div class="sb-product-badge sb-badge-new">New</div>
                        <div class="sb-product-actions">
                            <span class="sb-quick-btn">Quick View</span>
                        </div>
                    </div>
                    <div class="sb-product-info">
                        <span class="sb-product-cat">{{ $product->category ? $product->category->name : 'Saree' }}</span>
                        <h3 class="sb-product-name">{{ $product->name }}</h3>
                        <div class="sb-product-footer">
                            <span class="sb-product-price">৳{{ number_format($product->price, 0) }}</span>
                            <span class="sb-product-cta">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                            </span>
                        </div>
                    </div>
                </a>
                @empty
                <div class="col-12 text-center py-5 text-muted">No products yet in this section.</div>
                @endforelse
            </div>
        </div>

        {{-- Featured --}}
        <div class="sb-tab-panel" id="tab-featured">
            <div class="sb-product-grid">
                @forelse($featuredProducts->take(8) as $product)
                <a href="{{ route('product.show', $product->slug) }}" class="sb-product-card">
                    <div class="sb-product-img-wrap">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy">
                        <div class="sb-product-badge sb-badge-featured">Pick</div>
                        <div class="sb-product-actions">
                            <span class="sb-quick-btn">Quick View</span>
                        </div>
                    </div>
                    <div class="sb-product-info">
                        <span class="sb-product-cat">{{ $product->category ? $product->category->name : 'Saree' }}</span>
                        <h3 class="sb-product-name">{{ $product->name }}</h3>
                        <div class="sb-product-footer">
                            <span class="sb-product-price">৳{{ number_format($product->price, 0) }}</span>
                            <span class="sb-product-cta">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                            </span>
                        </div>
                    </div>
                </a>
                @empty
                <div class="col-12 text-center py-5 text-muted">No products yet in this section.</div>
                @endforelse
            </div>
        </div>

        {{-- Top Rated --}}
        <div class="sb-tab-panel" id="tab-top">
            <div class="sb-product-grid">
                @forelse($topRatedProducts->take(8) as $product)
                <a href="{{ route('product.show', $product->slug) }}" class="sb-product-card">
                    <div class="sb-product-img-wrap">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy">
                        <div class="sb-product-badge sb-badge-top">⭐ Top</div>
                        <div class="sb-product-actions">
                            <span class="sb-quick-btn">Quick View</span>
                        </div>
                    </div>
                    <div class="sb-product-info">
                        <span class="sb-product-cat">{{ $product->category ? $product->category->name : 'Saree' }}</span>
                        <h3 class="sb-product-name">{{ $product->name }}</h3>
                        <div class="sb-product-footer">
                            <span class="sb-product-price">৳{{ number_format($product->price, 0) }}</span>
                            <span class="sb-product-cta">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                            </span>
                        </div>
                    </div>
                </a>
                @empty
                <div class="col-12 text-center py-5 text-muted">No products yet in this section.</div>
                @endforelse
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════
     PROMOTIONAL BANNER
══════════════════════════════════════ --}}
<section class="sb-promo-banner reveal">
    <div class="container-xl">
        <div class="sb-promo-inner">
            <div class="sb-promo-text">
                <h2>Handpicked for the<br><span>Festive Season</span></h2>
                <p>Eid, Puja, or any celebration — our exclusive collection is ready for your special moments.</p>
                <a href="{{ route('products.index') }}" class="btn sb-btn-primary mt-2">Explore Now</a>
            </div>
            <div class="sb-promo-image">
                <img src="https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&w=600&q=80" alt="Festive Collection">
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════
     ALL PRODUCTS CAROUSEL
══════════════════════════════════════ --}}
<section class="sb-section reveal">
    <div class="container-xl">
        <div class="sb-section-head">
            <div>
                <p class="sb-section-eyebrow">Browse All</p>
                <h2 class="sb-section-title">Complete Collection</h2>
            </div>
            <div class="d-flex gap-2">
                <button class="sb-carousel-arrow" id="carouselPrev">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
                </button>
                <button class="sb-carousel-arrow" id="carouselNext">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                </button>
            </div>
        </div>
        <div class="sb-h-scroll" id="allProductsCarousel">
            @foreach($allProducts as $product)
            <a href="{{ route('product.show', $product->slug) }}" class="sb-h-card">
                <div class="sb-h-img">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy">
                </div>
                <div class="sb-h-info">
                    <span class="sb-product-cat">{{ $product->category ? $product->category->name : 'Saree' }}</span>
                    <div class="sb-h-name">{{ $product->name }}</div>
                    <div class="sb-h-price">৳{{ number_format($product->price, 0) }}</div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════
     STATS COUNTER
══════════════════════════════════════ --}}
<section class="sb-stats reveal">
    <div class="container-xl">
        <div class="sb-stats-grid">
            <div class="sb-stat-item">
                <div class="sb-stat-num" data-count="2000">0</div>
                <div class="sb-stat-label">Unique Designs</div>
            </div>
            <div class="sb-stat-item">
                <div class="sb-stat-num" data-count="15000">0</div>
                <div class="sb-stat-label">Happy Customers</div>
            </div>
            <div class="sb-stat-item">
                <div class="sb-stat-num" data-count="50">0</div>
                <div class="sb-stat-label">Collections</div>
            </div>
            <div class="sb-stat-item">
                <div class="sb-stat-num" data-count="5">0</div>
                <div class="sb-stat-label">Years of Excellence</div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════
     TESTIMONIALS
══════════════════════════════════════ --}}
<section class="sb-section reveal">
    <div class="container-xl">
        <div class="sb-section-head text-center d-block">
            <p class="sb-section-eyebrow">What They Say</p>
            <h2 class="sb-section-title">Customer Reviews</h2>
        </div>
        <div class="sb-testimonial-grid">
            @forelse($feedbacks ?? [] as $fb)
            <div class="sb-testimonial-card">
                <div class="sb-stars">★★★★★</div>
                <p class="sb-testimonial-text">"{{ $fb->message }}"</p>
                <div class="sb-testimonial-author">
                    <div class="sb-testimonial-avatar">{{ strtoupper(substr($fb->name, 0, 1)) }}</div>
                    <div>
                        <div class="sb-testimonial-name">{{ $fb->name }}</div>
                        <div class="sb-testimonial-role">{{ $fb->designation ?? 'Customer' }}</div>
                    </div>
                </div>
            </div>
            @empty
            <div class="sb-testimonial-card">
                <div class="sb-stars">★★★★★</div>
                <p class="sb-testimonial-text">"The quality of the saree is exceptional and the delivery was so fast. I received many compliments at the wedding!"</p>
                <div class="sb-testimonial-author">
                    <div class="sb-testimonial-avatar">R</div>
                    <div>
                        <div class="sb-testimonial-name">Riya Das</div>
                        <div class="sb-testimonial-role">Verified Buyer</div>
                    </div>
                </div>
            </div>
            <div class="sb-testimonial-card">
                <div class="sb-stars">★★★★★</div>
                <p class="sb-testimonial-text">"Beautiful prints and smooth fabric. Loved the saree design for my family event. Will definitely order again!"</p>
                <div class="sb-testimonial-author">
                    <div class="sb-testimonial-avatar">S</div>
                    <div>
                        <div class="sb-testimonial-name">Sohana Ahmed</div>
                        <div class="sb-testimonial-role">Repeat Buyer</div>
                    </div>
                </div>
            </div>
            <div class="sb-testimonial-card">
                <div class="sb-stars">★★★★★</div>
                <p class="sb-testimonial-text">"Best customer support and a gorgeous saree. Highly recommended for festive shopping. Packaging was perfect too."</p>
                <div class="sb-testimonial-author">
                    <div class="sb-testimonial-avatar">M</div>
                    <div>
                        <div class="sb-testimonial-name">Mina Khatun</div>
                        <div class="sb-testimonial-role">Verified Buyer</div>
                    </div>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════
     NEWSLETTER
══════════════════════════════════════ --}}
<section class="sb-newsletter reveal">
    <div class="container-xl">
        <div class="sb-newsletter-inner">
            <div class="sb-newsletter-text">
                <h2>Stay in the Loop</h2>
                <p>Get the latest collections, exclusive offers, and styling tips delivered to your inbox.</p>
            </div>
            <form class="sb-newsletter-form" onsubmit="return false;">
                <input type="email" placeholder="Enter your email address" class="sb-newsletter-input" required>
                <button type="submit" class="btn sb-btn-primary">Subscribe</button>
            </form>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
(function () {
    // ── Slider counter sync ──
    var sliderEl = document.getElementById('homeSlider');
    if (sliderEl) {
        sliderEl.addEventListener('slide.bs.carousel', function (e) {
            var total = sliderEl.querySelectorAll('.carousel-item').length;
            var counters = sliderEl.querySelectorAll('.hs-counter strong');
            counters.forEach(function (el) {
                el.textContent = String(e.to + 1).padStart(2, '0');
            });
        });
    }

    // ── Product tabs ──
    var tabBtns = document.querySelectorAll('.sb-tab');
    var tabPanels = document.querySelectorAll('.sb-tab-panel');

    tabBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            tabBtns.forEach(function (b) { b.classList.remove('active'); });
            tabPanels.forEach(function (p) { p.classList.remove('active'); });
            btn.classList.add('active');
            var panel = document.getElementById(btn.dataset.target);
            if (panel) panel.classList.add('active');
        });
    });

    // ── Horizontal carousel arrows ──
    var carousel = document.getElementById('allProductsCarousel');
    var prevBtn = document.getElementById('carouselPrev');
    var nextBtn = document.getElementById('carouselNext');
    var scrollAmt = 300;

    if (prevBtn && carousel) prevBtn.addEventListener('click', function () {
        carousel.scrollBy({ left: -scrollAmt, behavior: 'smooth' });
    });
    if (nextBtn && carousel) nextBtn.addEventListener('click', function () {
        carousel.scrollBy({ left: scrollAmt, behavior: 'smooth' });
    });

    // ── Stats counter ──
    var statsSection = document.querySelector('.sb-stats');
    var counted = false;

    function animateCounters() {
        if (counted) return;
        counted = true;
        document.querySelectorAll('.sb-stat-num[data-count]').forEach(function (el) {
            var target = parseInt(el.dataset.count);
            var duration = 1800;
            var step = target / (duration / 16);
            var current = 0;
            var timer = setInterval(function () {
                current += step;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                el.textContent = (target >= 1000)
                    ? (current >= 1000 ? (current / 1000).toFixed(1) + 'K+' : Math.floor(current).toString())
                    : Math.floor(current) + '+';
            }, 16);
        });
    }

    var statObserver = new IntersectionObserver(function (entries) {
        if (entries[0].isIntersecting) animateCounters();
    }, { threshold: 0.3 });

    if (statsSection) statObserver.observe(statsSection);
})();
</script>
@endsection

@extends('layouts.app')

@section('title', 'About Us')
@section('full-width', true)

@section('content')

{{-- ── Page Hero ── --}}
<section class="pg-hero">
    <div class="pg-hero-bg" style="background-image:url('https://images.unsplash.com/photo-1583391733956-3750e0ff4e8b?auto=format&fit=crop&w=1600&q=60')"></div>
    <div class="pg-hero-overlay"></div>
    <div class="container-xl pg-hero-content">
        <nav aria-label="breadcrumb" class="pg-breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span>/</span>
            <span>About</span>
        </nav>
        <h1 class="pg-hero-title">Our Story</h1>
        <p class="pg-hero-sub">Weaving tradition into every thread since 2019</p>
    </div>
</section>

{{-- ── Mission ── --}}
<section class="sb-section">
    <div class="container-xl">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6 reveal">
                <p class="sb-section-eyebrow">Who We Are</p>
                <h2 class="sb-section-title mb-4">Celebrating Bangladesh's<br>Textile Heritage</h2>
                <p class="about-body">Saree Bazaar was born from a deep love for Bangladesh's rich weaving traditions. We work directly with artisans across Rajshahi, Tangail, and Jamdani districts to bring their craft to modern customers — without the middlemen, without compromise.</p>
                <p class="about-body">Every saree in our collection tells a story of skilled hands, heritage looms, and generations of knowledge passed down with pride.</p>
                <div class="about-badges mt-4">
                    <span class="about-badge">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                        Ethically Sourced
                    </span>
                    <span class="about-badge">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                        Artisan Direct
                    </span>
                    <span class="about-badge">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                        Premium Quality
                    </span>
                </div>
            </div>
            <div class="col-lg-6 reveal">
                <div class="about-img-wrap">
                    <img src="https://images.unsplash.com/photo-1594938298603-c8148c4b4a6a?auto=format&fit=crop&w=800&q=80" alt="Saree artisan" class="about-img-main">
                    <div class="about-img-card">
                        <div class="about-img-card-num">2019</div>
                        <div class="about-img-card-label">Founded</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── Values ── --}}
<section class="sb-section sb-section-alt">
    <div class="container-xl">
        <div class="text-center mb-5 reveal">
            <p class="sb-section-eyebrow">What Drives Us</p>
            <h2 class="sb-section-title">Our Core Values</h2>
        </div>
        <div class="about-values-grid">
            <div class="about-value-card reveal">
                <div class="about-value-icon" style="background:#ede9fe;color:#7c3aed">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <h4 class="about-value-title">Quality Guarantee</h4>
                <p class="about-value-text">Every saree passes a 12-point quality check before it reaches your doorstep. No shortcuts, ever.</p>
            </div>
            <div class="about-value-card reveal">
                <div class="about-value-icon" style="background:#fef3c7;color:#d97706">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <h4 class="about-value-title">Artisan Support</h4>
                <p class="about-value-text">We pay fair prices and build long-term relationships with over 200 weavers across Bangladesh.</p>
            </div>
            <div class="about-value-card reveal">
                <div class="about-value-icon" style="background:#d1fae5;color:#059669">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                </div>
                <h4 class="about-value-title">Transparent Pricing</h4>
                <p class="about-value-text">No hidden fees, no inflated markups. You get premium quality at honest, fair prices.</p>
            </div>
            <div class="about-value-card reveal">
                <div class="about-value-icon" style="background:#fee2e2;color:#dc2626">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                </div>
                <h4 class="about-value-title">Customer First</h4>
                <p class="about-value-text">7-day returns, 24/7 support, and free delivery on every order above ৳999 — always.</p>
            </div>
        </div>
    </div>
</section>

{{-- ── Stats ── --}}
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
                <div class="sb-stat-num" data-count="200">0</div>
                <div class="sb-stat-label">Partner Artisans</div>
            </div>
            <div class="sb-stat-item">
                <div class="sb-stat-num" data-count="5">0</div>
                <div class="sb-stat-label">Years of Excellence</div>
            </div>
        </div>
    </div>
</section>

{{-- ── Why Us ── --}}
<section class="sb-section">
    <div class="container-xl">
        <div class="row g-4 align-items-center">
            <div class="col-lg-5 reveal">
                <div class="about-process-img">
                    <img src="https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&w=700&q=80" alt="Saree collection">
                </div>
            </div>
            <div class="col-lg-6 offset-lg-1 reveal">
                <p class="sb-section-eyebrow">How It Works</p>
                <h2 class="sb-section-title mb-5">From Loom to<br>Your Doorstep</h2>
                <div class="about-steps">
                    <div class="about-step">
                        <div class="about-step-num">01</div>
                        <div>
                            <h5 class="about-step-title">Artisan Selection</h5>
                            <p class="about-step-text">Our team visits weavers across Bangladesh and curates only the finest handcrafted pieces.</p>
                        </div>
                    </div>
                    <div class="about-step">
                        <div class="about-step-num">02</div>
                        <div>
                            <h5 class="about-step-title">Quality Inspection</h5>
                            <p class="about-step-text">Each saree is reviewed for fabric integrity, colour consistency, and weave quality.</p>
                        </div>
                    </div>
                    <div class="about-step">
                        <div class="about-step-num">03</div>
                        <div>
                            <h5 class="about-step-title">Fast Delivery</h5>
                            <p class="about-step-text">Packaged with care and shipped to your door within 3–5 business days across Bangladesh.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── CTA ── --}}
<section class="about-cta-section reveal">
    <div class="container-xl">
        <div class="about-cta-inner">
            <h2>Ready to Find Your Perfect Saree?</h2>
            <p>Explore over 2,000 designs crafted by Bangladesh's finest artisans.</p>
            <div class="d-flex gap-3 justify-content-center flex-wrap mt-4">
                <a href="{{ route('products.index') }}" class="btn sb-btn-primary btn-lg px-5">Shop Now</a>
                <a href="{{ route('contact.show') }}" class="btn sb-btn-ghost btn-lg px-5">Contact Us</a>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
(function () {
    var statsSection = document.querySelector('.sb-stats');
    var counted = false;
    function animateCounters() {
        if (counted) return; counted = true;
        document.querySelectorAll('.sb-stat-num[data-count]').forEach(function (el) {
            var target = parseInt(el.dataset.count), duration = 1800, step = target / (duration / 16), cur = 0;
            var t = setInterval(function () {
                cur += step;
                if (cur >= target) { cur = target; clearInterval(t); }
                el.textContent = (target >= 1000) ? (cur / 1000).toFixed(1) + 'K+' : Math.floor(cur) + '+';
            }, 16);
        });
    }
    var obs = new IntersectionObserver(function (e) { if (e[0].isIntersecting) animateCounters(); }, { threshold: 0.3 });
    if (statsSection) obs.observe(statsSection);
})();
</script>
@endsection

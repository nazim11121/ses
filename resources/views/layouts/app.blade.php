<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Saree Bazaar') — Premium Saree Collection</title>
    <meta name="description" content="Discover handcrafted Bangladeshi sarees for every occasion. Premium quality, fast delivery.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    @yield('head')
</head>
<body>

@php
    $cartCount = array_sum(session('cart', []));
    $isHome    = request()->routeIs('home');
    $isShop    = request()->routeIs('products.*') || request()->routeIs('product.*');
    $isAbout   = request()->routeIs('about');
    $isContact = request()->routeIs('contact.*');
@endphp

{{-- ═══════════════ SEARCH OVERLAY ═══════════════ --}}
<div class="sb-search-overlay" id="searchOverlay">
    <div class="sb-search-box">
        <form action="{{ route('products.index') }}" method="GET">
            <button type="button" class="sb-search-close" id="searchClose" aria-label="Close">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
            <p class="sb-search-label">What are you looking for?</p>
            <div class="sb-search-input-wrap">
                <input type="text" name="q" id="searchInput" class="sb-search-input" placeholder="Search sarees, categories…" autocomplete="off">
                <button type="submit" class="sb-search-submit">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ═══════════════ NAVBAR ═══════════════ --}}
<nav class="sb-navbar{{ $isHome ? '' : ' scrolled scrolled-solid' }}" id="sbNavbar">
    <div class="container-xl d-flex align-items-center justify-content-between" style="height:68px">

        {{-- Brand --}}
        <a class="sb-brand" href="{{ route('home') }}">
            <span class="sb-brand-icon">S</span>
            <span>Saree<strong>Bazaar</strong></span>
        </a>

        {{-- Desktop nav --}}
        <ul class="sb-nav-links d-none d-lg-flex mb-0 list-unstyled align-items-center gap-1">
            <li><a href="{{ route('home') }}"          class="sb-nav-link{{ $isHome    ? ' active' : '' }}">Home</a></li>
            <li><a href="{{ route('products.index') }}" class="sb-nav-link{{ $isShop   ? ' active' : '' }}">Shop</a></li>
            <li><a href="{{ route('about') }}"          class="sb-nav-link{{ $isAbout  ? ' active' : '' }}">About</a></li>
            <li><a href="{{ route('contact.show') }}"   class="sb-nav-link{{ $isContact? ' active' : '' }}">Contact</a></li>
        </ul>

        {{-- Actions --}}
        <div class="d-flex align-items-center gap-1">

            {{-- Search toggle --}}
            <button class="sb-icon-btn" id="searchToggle" aria-label="Search">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            </button>

            {{-- Cart --}}
            <a href="{{ route('cart.index') }}" class="sb-icon-btn sb-cart-link{{ request()->routeIs('cart.*') ? ' active' : '' }}" title="Cart">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                @if($cartCount > 0)
                <span class="sb-cart-badge">{{ $cartCount > 99 ? '99+' : $cartCount }}</span>
                @endif
            </a>

            {{-- Auth --}}
            @auth
            <a href="{{ route('admin.dashboard') }}" class="btn sb-btn-primary d-none d-lg-inline-flex ms-1">Dashboard</a>
            @else
            <a href="{{ route('login') }}" class="btn sb-btn-primary d-none d-lg-inline-flex ms-1">Sign In</a>
            @endauth

            {{-- Hamburger --}}
            <button class="sb-hamburger d-lg-none ms-1" id="mobileMenuBtn" aria-label="Menu">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>
</nav>

{{-- Mobile drawer --}}
<div class="sb-mobile-menu" id="mobileMenu">
    <div class="sb-mobile-menu-header">
        <a class="sb-brand" href="{{ route('home') }}" style="color:var(--sb-text)">
            <span class="sb-brand-icon">S</span>
            <span>Saree<strong>Bazaar</strong></span>
        </a>
        <button class="sb-mobile-close" id="mobileClose" aria-label="Close">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
    </div>

    {{-- Mobile search --}}
    <form action="{{ route('products.index') }}" method="GET" class="sb-mobile-search">
        <input type="text" name="q" placeholder="Search sarees…" class="sb-mobile-search-input">
        <button type="submit" class="sb-mobile-search-btn">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        </button>
    </form>

    <nav class="sb-mobile-nav">
        <a href="{{ route('home') }}"           class="sb-mobile-link{{ $isHome    ? ' active' : '' }}">Home</a>
        <a href="{{ route('products.index') }}" class="sb-mobile-link{{ $isShop   ? ' active' : '' }}">Shop</a>
        <a href="{{ route('about') }}"          class="sb-mobile-link{{ $isAbout  ? ' active' : '' }}">About</a>
        <a href="{{ route('contact.show') }}"   class="sb-mobile-link{{ $isContact? ' active' : '' }}">Contact</a>
        <a href="{{ route('cart.index') }}"     class="sb-mobile-link d-flex justify-content-between align-items-center">
            Cart
            @if($cartCount > 0)
            <span class="badge rounded-pill" style="background:var(--sb-primary)">{{ $cartCount }}</span>
            @endif
        </a>
        @auth
        <a href="{{ route('admin.dashboard') }}" class="sb-mobile-link">Dashboard</a>
        @else
        <a href="{{ route('login') }}" class="sb-mobile-link">Sign In</a>
        @endauth
    </nav>
</div>
<div class="sb-mobile-overlay" id="mobileOverlay"></div>

{{-- ═══════════════ FLASH MESSAGES ═══════════════ --}}
@if(session('success') || session('info') || $errors->any())
<div style="position:relative;z-index:10" class="{{ $isHome ? '' : 'mt-0' }}">
    <div class="container-xl pt-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 rounded-3 shadow-sm">
                {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('info'))
            <div class="alert alert-info alert-dismissible fade show border-0 rounded-3 shadow-sm">
                {{ session('info') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show border-0 rounded-3 shadow-sm">
                <ul class="mb-0 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>
</div>
@endif

{{-- ═══════════════ MAIN CONTENT ═══════════════ --}}
<main>
    @hasSection('full-width')
        @yield('content')
    @else
        <div class="container-xl page-content">
            @yield('content')
        </div>
    @endif
</main>

{{-- ═══════════════ FOOTER ═══════════════ --}}
<footer class="sb-footer">
    <div class="container-xl">
        <div class="row gy-5">
            <div class="col-lg-4">
                <a class="sb-brand mb-4 d-inline-flex" href="{{ route('home') }}" style="color:#fff">
                    <span class="sb-brand-icon" style="background:rgba(255,255,255,.15)">S</span>
                    <span>Saree<strong>Bazaar</strong></span>
                </a>
                <p class="sb-footer-text">Bringing the finest handcrafted Bangladeshi sarees to your doorstep. Tradition meets modernity in every weave.</p>
                <div class="d-flex gap-3 mt-4">
                    <a href="#" class="sb-social-icon" aria-label="Facebook">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                    </a>
                    <a href="#" class="sb-social-icon" aria-label="Instagram">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                    </a>
                    <a href="#" class="sb-social-icon" aria-label="YouTube">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 0 0-1.95 1.96A29 29 0 0 0 1 12a29 29 0 0 0 .46 5.58 2.78 2.78 0 0 0 1.95 1.96C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 0 0 1.95-1.96A29 29 0 0 0 23 12a29 29 0 0 0-.46-5.58z"/><polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02" fill="white"/></svg>
                    </a>
                </div>
            </div>

            <div class="col-sm-6 col-lg-2 offset-lg-1">
                <h6 class="sb-footer-heading">Shop</h6>
                <ul class="list-unstyled sb-footer-links">
                    <li><a href="{{ route('products.index') }}">All Sarees</a></li>
                    <li><a href="{{ route('products.index') }}">New Arrivals</a></li>
                    <li><a href="{{ route('products.index') }}">Featured</a></li>
                    <li><a href="{{ route('products.index') }}">Top Rated</a></li>
                </ul>
            </div>

            <div class="col-sm-6 col-lg-2">
                <h6 class="sb-footer-heading">Company</h6>
                <ul class="list-unstyled sb-footer-links">
                    <li><a href="{{ route('about') }}">About Us</a></li>
                    <li><a href="{{ route('contact.show') }}">Contact</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Returns</a></li>
                </ul>
            </div>

            <div class="col-lg-3">
                <h6 class="sb-footer-heading">Get in Touch</h6>
                <ul class="list-unstyled sb-footer-contact">
                    <li>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        support@sareebazaar.example
                    </li>
                    <li>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.18 2 2 0 0 1 3.6 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.65a16 16 0 0 0 6 6l.86-.86a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21.71 16z"/></svg>
                        +880 1700 000 000
                    </li>
                    <li>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        Dhaka, Bangladesh
                    </li>
                </ul>
            </div>
        </div>

        <div class="sb-footer-bottom">
            <p class="mb-0">&copy; {{ date('Y') }} SareeBazaar. All rights reserved.</p>
            <div class="d-flex align-items-center gap-2">
                <span class="sb-pay-badge">VISA</span>
                <span class="sb-pay-badge">Mastercard</span>
                <span class="sb-pay-badge" style="background:#E2136E">bKash</span>
            </div>
        </div>
    </div>
</footer>

{{-- Scroll to top --}}
<button class="sb-scroll-top" id="scrollTop" aria-label="Scroll to top">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="18 15 12 9 6 15"/></svg>
</button>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
(function () {
    var nav = document.getElementById('sbNavbar');

    // Navbar scroll — only transparent on home
    var isHome = {{ $isHome ? 'true' : 'false' }};
    if (isHome) {
        window.addEventListener('scroll', function () {
            nav.classList.toggle('scrolled', window.scrollY > 40);
        });
    }

    // Mobile menu
    var btn = document.getElementById('mobileMenuBtn');
    var closeBtn = document.getElementById('mobileClose');
    var menu = document.getElementById('mobileMenu');
    var overlay = document.getElementById('mobileOverlay');

    function openMenu() { menu.classList.add('open'); overlay.classList.add('open'); if (btn) btn.classList.add('open'); document.body.style.overflow = 'hidden'; }
    function closeMenu() { menu.classList.remove('open'); overlay.classList.remove('open'); if (btn) btn.classList.remove('open'); document.body.style.overflow = ''; }

    if (btn)      btn.addEventListener('click', function () { menu.classList.contains('open') ? closeMenu() : openMenu(); });
    if (closeBtn) closeBtn.addEventListener('click', closeMenu);
    if (overlay)  overlay.addEventListener('click', closeMenu);

    // Search overlay
    var searchOverlay = document.getElementById('searchOverlay');
    var searchToggle  = document.getElementById('searchToggle');
    var searchClose   = document.getElementById('searchClose');
    var searchInput   = document.getElementById('searchInput');

    function openSearch() { searchOverlay.classList.add('open'); document.body.style.overflow = 'hidden'; setTimeout(function () { if (searchInput) searchInput.focus(); }, 200); }
    function closeSearch() { searchOverlay.classList.remove('open'); document.body.style.overflow = ''; }

    if (searchToggle) searchToggle.addEventListener('click', openSearch);
    if (searchClose)  searchClose.addEventListener('click', closeSearch);
    if (searchOverlay) searchOverlay.addEventListener('click', function (e) { if (e.target === searchOverlay) closeSearch(); });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') { closeSearch(); closeMenu(); } });

    // Scroll to top
    var scrollTopBtn = document.getElementById('scrollTop');
    window.addEventListener('scroll', function () {
        if (scrollTopBtn) scrollTopBtn.classList.toggle('visible', window.scrollY > 400);
    });
    if (scrollTopBtn) scrollTopBtn.addEventListener('click', function () { window.scrollTo({ top: 0, behavior: 'smooth' }); });

    // Reveal on scroll
    var revealObserver = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) { entry.target.classList.add('revealed'); revealObserver.unobserve(entry.target); }
        });
    }, { threshold: 0.1 });
    document.querySelectorAll('.reveal').forEach(function (el) { revealObserver.observe(el); });
})();
</script>
@yield('scripts')
</body>
</html>

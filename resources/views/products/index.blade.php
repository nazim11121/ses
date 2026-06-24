@extends('layouts.app')

@section('title', 'Shop — Saree Collection')
@section('full-width', true)

@section('content')

{{-- ── Page Hero ── --}}
<section class="pg-hero">
    <div class="pg-hero-bg" style="background-image:url('https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&w=1600&q=60')"></div>
    <div class="pg-hero-overlay"></div>
    <div class="container-xl pg-hero-content">
        <nav aria-label="breadcrumb" class="pg-breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span>/</span>
            <span>Shop</span>
        </nav>
        <h1 class="pg-hero-title">Saree Collection</h1>
        <p class="pg-hero-sub">Handcrafted elegance for every occasion</p>

        {{-- Hero search bar --}}
        <form action="{{ route('products.index') }}" method="GET" class="pg-search-bar">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search sarees, categories…" class="pg-search-input" autofocus>
            @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            <button type="submit" class="btn sb-btn-primary">Search</button>
        </form>
    </div>
</section>

{{-- ── Main content ── --}}
<div class="container-xl py-5">
    <div class="row g-4">

        {{-- ── Sidebar ── --}}
        <div class="col-lg-3">
            {{-- Mobile filter toggle --}}
            <button class="btn w-100 sb-filter-toggle d-lg-none mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarFilters">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="4" y1="6" x2="20" y2="6"/><line x1="8" y1="12" x2="16" y2="12"/><line x1="11" y1="18" x2="13" y2="18"/></svg>
                Filters &amp; Categories
            </button>

            <div class="collapse d-lg-block" id="sidebarFilters">

                {{-- Categories card --}}
                <div class="sb-sidebar-card mb-4">
                    <div class="sb-sidebar-card-header">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                        Categories
                    </div>
                    <div class="sb-sidebar-card-body">
                        <a href="{{ route('products.index') }}{{ request('q') ? '?q='.request('q') : '' }}"
                           class="sb-cat-pill{{ !request('category') ? ' active' : '' }}">
                            All Sarees
                            <span class="sb-cat-pill-count">{{ $products->count() }}</span>
                        </a>
                        @foreach($categories as $cat)
                        <a href="{{ route('product.category', $cat->slug) }}{{ request('q') ? '?q='.request('q') : '' }}"
                           class="sb-cat-pill{{ optional($selectedCategory)->id === $cat->id ? ' active' : '' }}">
                            {{ $cat->name }}
                        </a>
                        @endforeach
                    </div>
                </div>

                {{-- Quick links --}}
                <div class="sb-sidebar-card">
                    <div class="sb-sidebar-card-header">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        Collections
                    </div>
                    <div class="sb-sidebar-card-body">
                        <a href="{{ route('cart.index') }}" class="sb-sidebar-link">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                            View Cart
                        </a>
                        <a href="{{ route('checkout.index') }}" class="sb-sidebar-link">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 12 20 22 4 22 4 12"/><rect x="2" y="7" width="20" height="5"/><line x1="12" y1="22" x2="12" y2="7"/><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"/><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"/></svg>
                            Checkout
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Products grid ── --}}
        <div class="col-lg-9">

            {{-- Toolbar --}}
            <div class="sb-toolbar">
                <div class="sb-toolbar-info">
                    @if(request('q'))
                        <span>Results for <strong>"{{ request('q') }}"</strong></span>
                    @elseif($selectedCategory)
                        <span>Showing <strong>{{ $selectedCategory->name }}</strong></span>
                    @else
                        <span>All Sarees</span>
                    @endif
                    <span class="sb-toolbar-count">{{ $products->count() }} items</span>
                </div>
                @if(request('q') || request('category'))
                <a href="{{ route('products.index') }}" class="sb-clear-filter">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Clear filters
                </a>
                @endif
            </div>

            @forelse($products as $product)
            @if($loop->first)<div class="sb-shop-grid">@endif

            <div class="sb-product-card reveal">
                <div class="sb-product-img-wrap">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy">
                    @if($product->section === 'new_arrival')
                        <div class="sb-product-badge sb-badge-new">New</div>
                    @elseif($product->section === 'featured')
                        <div class="sb-product-badge sb-badge-featured">Pick</div>
                    @elseif($product->section === 'top_rated')
                        <div class="sb-product-badge sb-badge-top">⭐ Top</div>
                    @endif
                    <div class="sb-product-actions">
                        <a href="{{ route('product.show', $product->slug) }}" class="sb-quick-btn">Quick View</a>
                    </div>
                </div>
                <div class="sb-product-info">
                    <span class="sb-product-cat">{{ $product->category ? $product->category->name : 'Saree' }}</span>
                    <h3 class="sb-product-name">{{ $product->name }}</h3>
                    @if($product->description)
                    <p class="sb-product-desc">{{ \Illuminate\Support\Str::limit($product->description, 70) }}</p>
                    @endif
                    <div class="sb-product-footer">
                        <span class="sb-product-price">৳{{ number_format($product->price, 0) }}</span>
                        <div class="d-flex gap-1 align-items-center">
                            <a href="{{ route('product.show', $product->slug) }}" class="sb-view-btn">Details</a>
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="sb-product-cta" title="Add to cart">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            @if($loop->last)</div>@endif

            @empty
            <div class="sb-empty-state">
                <div class="sb-empty-icon">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                </div>
                <h3>No sarees found</h3>
                <p>Try a different search term or browse all categories.</p>
                <a href="{{ route('products.index') }}" class="btn sb-btn-primary mt-2">Browse All</a>
            </div>
            @endforelse
        </div>
    </div>
</div>

@endsection

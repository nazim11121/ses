@extends('layouts.app')

@section('title', 'Shop Sarees')

@section('content')
<div class="row gy-4 mb-4">
    <div class="col-md-8">
        <h2 class="fw-bold">Saree Collection</h2>
        <p class="text-muted">Browse our latest sarees by category and add your favorites to the cart.</p>
    </div>
    <div class="col-md-4 text-md-end">
        <a href="{{ route('checkout.index') }}" class="btn btn-primary">Checkout</a>
    </div>
</div>
<div class="card border-0 shadow-sm p-4 mb-4">
    <form action="{{ route('products.index') }}" method="GET" class="row g-2 align-items-center">
        <div class="col-sm">
            <div class="input-group">
                <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Search sarees by name">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </div>
        <div class="col-sm-auto">
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Clear</a>
        </div>
    </form>
</div>
<div class="row gy-4">
    <div class="col-lg-3">
        <div class="card border-0 shadow-sm p-4 mb-4">
            <h5 class="fw-bold">Categories</h5>
            <ul class="list-unstyled mt-3">
                <li><a class="text-decoration-none text-dark d-block py-2{{ request('category') ? '' : ' fw-bold' }}" href="{{ route('products.index') }}">All Sarees</a></li>
                @foreach($categories as $category)
                    <li>
                        <a class="text-decoration-none text-dark d-block py-2{{ optional($selectedCategory)->id === $category->id ? ' fw-bold' : '' }}" href="{{ route('product.category', $category->slug) }}">{{ $category->name }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="col-lg-9">
        <div class="row gy-4">
            @forelse($products as $product)
                <div class="col-sm-6 col-xl-4">
                    <div class="card product-card shadow-sm h-100">
                        <img src="{{ $product->image_url }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body d-flex flex-column">
                            <small class="text-uppercase text-primary">{{ $product->category ? $product->category->name : 'Saree' }}</small>
                            <h5 class="card-title mt-2">{{ $product->name }}</h5>
                            <p class="text-muted small">{{ \Illuminate\Support\Str::limit($product->description, 100) }}</p>
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <strong class="fs-5">₹{{ number_format($product->price, 2) }}</strong>
                                    <a href="{{ route('product.show', $product->slug) }}" class="btn btn-outline-primary btn-sm">View</a>
                                </div>
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary w-100">Add to Cart</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">No sarees found in this category.</div>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

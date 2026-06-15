@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="row gy-4">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm overflow-hidden">
            <img src="{{ $product->image_url }}" class="img-fluid" alt="{{ $product->name }}">
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm p-4">
            <span class="badge bg-primary mb-2">{{ $product->category ? $product->category->name : 'Saree' }}</span>
            <h1 class="fw-bold">{{ $product->name }}</h1>
            <p class="text-muted">{{ $product->description }}</p>
            <div class="d-flex align-items-center gap-3 mb-3">
                <h3 class="text-primary">₹{{ number_format($product->price, 2) }}</h3>
                <span class="text-muted">Stock: {{ $product->stock }}</span>
            </div>
            <div class="mb-4">
                <p class="mb-1"><strong>Pay</strong> using Cash on Delivery or bKash.</p>
                <p class="mb-0 text-muted">Fast shipping and easy returns.</p>
            </div>
            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary btn-lg w-100">Add to Cart</button>
            </form>
            <a href="{{ route('home') }}" class="btn btn-link mt-3">Back to collection</a>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="mb-5">
    <div id="homeSlider" class="carousel slide home-slider" data-bs-ride="carousel">
        <div class="carousel-indicators">
            @forelse($slides as $slide)
                <button type="button" data-bs-target="#homeSlider" data-bs-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}" aria-current="{{ $loop->first ? 'true' : 'false' }}" aria-label="Slide {{ $loop->iteration }}"></button>
            @empty
                <button type="button" data-bs-target="#homeSlider" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            @endforelse
        </div>
        <div class="carousel-inner rounded-4 overflow-hidden shadow-sm">
            @forelse($slides as $slide)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                    <img src="{{ $slide->image_url }}" class="d-block w-100" alt="{{ $slide->title }}">
                    <div class="carousel-caption d-none d-md-block text-start">
                        <h2 class="display-6 fw-bold">{{ $slide->title }}</h2>
                        <p>{{ $slide->subtitle }}</p>
                        @if($slide->button_text && $slide->button_link)
                            <a href="{{ $slide->button_link }}" class="btn btn-primary">{{ $slide->button_text }}</a>
                        @elseif($slide->button_text)
                            <span class="btn btn-primary disabled">{{ $slide->button_text }}</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="carousel-item active">
                    <img src="https://images.unsplash.com/photo-1512436991641-6745cdb1723f8?auto=format&fit=crop&w=1300&q=80" class="d-block w-100" alt="Bangladeshi saree">
                    <div class="carousel-caption d-none d-md-block text-start">
                        <h2 class="display-6 fw-bold">Elegant Bangladeshi Sarees</h2>
                        <p>Discover premium handwoven designs for every celebration.</p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary">Shop Now</a>
                    </div>
                </div>
            @endforelse
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#homeSlider" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#homeSlider" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>

<div class="row gy-4 mb-5">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-4">
            <h5 class="fw-bold">New Arrival</h5>
            <p class="text-muted">Freshly added sarees selected from the latest drops.</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-4">
            <h5 class="fw-bold">Featured Picks</h5>
            <p class="text-muted">Handpicked sarees with premium craftsmanship and value.</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-4">
            <h5 class="fw-bold">Top Rated</h5>
            <p class="text-muted">Popular sarees loved by customers for style and comfort.</p>
        </div>
    </div>
</div>

<div class="row gy-4 mb-5">
    <div class="col-12 d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="fw-bold">New Arrival</h3>
            <p class="text-muted mb-0">Shop our freshest saree arrivals in today’s popular styles.</p>
        </div>
        <a href="{{ route('products.index') }}" class="btn btn-outline-primary">Explore More</a>
    </div>
    @foreach($newArrivals->take(3) as $product)
        <div class="col-sm-6 col-xl-4">
            <div class="card product-card shadow-sm h-100">
                <img src="{{ $product->image_url }}" class="card-img-top" alt="{{ $product->name }}">
                <div class="card-body d-flex flex-column">
                    <span class="badge bg-primary mb-2">{{ $product->category ? $product->category->name : 'Saree' }}</span>
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="text-muted small mb-3">₹{{ number_format($product->price, 2) }}</p>
                    <a href="{{ route('product.show', $product->slug) }}" class="btn btn-outline-primary mt-auto">View Details</a>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="row gy-4 mb-5">
    <div class="col-12 d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="fw-bold">Featured Products</h3>
            <p class="text-muted mb-0">Beautiful sarees picked for festive and special moments.</p>
        </div>
        <a href="{{ route('products.index') }}" class="btn btn-outline-primary">View All</a>
    </div>
    @foreach($featuredProducts->take(3) as $product)
        <div class="col-sm-6 col-xl-4">
            <div class="card product-card shadow-sm h-100">
                <img src="{{ $product->image_url }}" class="card-img-top" alt="{{ $product->name }}">
                <div class="card-body d-flex flex-column">
                    <span class="badge bg-secondary mb-2">{{ $product->category ? $product->category->name : 'Saree' }}</span>
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="text-muted small mb-3">₹{{ number_format($product->price, 2) }}</p>
                    <a href="{{ route('product.show', $product->slug) }}" class="btn btn-outline-primary mt-auto">Buy Now</a>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="row gy-4 mb-5">
    <div class="col-12 d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="fw-bold">Top Rated</h3>
            <p class="text-muted mb-0">Best-selling sarees with the highest customer satisfaction.</p>
        </div>
        <a href="{{ route('products.index') }}" class="btn btn-outline-primary">See Collection</a>
    </div>
    @foreach($topRatedProducts->take(3) as $product)
        <div class="col-sm-6 col-xl-4">
            <div class="card product-card shadow-sm h-100">
                <img src="{{ $product->image_url }}" class="card-img-top" alt="{{ $product->name }}">
                <div class="card-body d-flex flex-column">
                    <span class="badge bg-success mb-2">{{ $product->category ? $product->category->name : 'Saree' }}</span>
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="text-muted small mb-3">₹{{ number_format($product->price, 2) }}</p>
                    <a href="{{ route('product.show', $product->slug) }}" class="btn btn-outline-primary mt-auto">Shop Now</a>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="row gy-4">
    <div class="col-12 text-center mb-4">
        <h3 class="fw-bold">Customer Feedback</h3>
        <p class="text-muted">Real reviews from customers who love our sarees.</p>
    </div>
    <div class="col-12">
        <div id="feedbackCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card feedback-card text-center p-4 shadow-sm border-0">
                                <p class="mb-4">“The quality of the saree is exceptional and the delivery was so fast. I received many compliments!”</p>
                                <h5 class="fw-bold">Riya Das</h5>
                                <small class="text-muted">Happy Customer</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card feedback-card text-center p-4 shadow-sm border-0">
                                <p class="mb-4">“Beautiful prints and smooth fabric. I loved the saree design for my family event.”</p>
                                <h5 class="fw-bold">Sohana Ahmed</h5>
                                <small class="text-muted">Repeat Buyer</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card feedback-card text-center p-4 shadow-sm border-0">
                                <p class="mb-4">“The best customer support and a beautiful saree. Highly recommended for festive shopping.”</p>
                                <h5 class="fw-bold">Mina Khatun</h5>
                                <small class="text-muted">Verified Buyer</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#feedbackCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#feedbackCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</div>
@endsection

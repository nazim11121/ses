@extends('layouts.app')

@section('title', 'About Us')

@section('content')
<div class="row align-items-center gy-4">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm p-4">
            <h2 class="fw-bold">About Saree Bazaar</h2>
            <p class="text-muted">Saree Bazaar brings you a curated collection of sarees for every celebration. Our online storefront is built to help you discover elegant fabrics, rich designs, and comfortable styling with trusted delivery.</p>
            <ul class="list-unstyled mt-4 text-muted">
                <li class="mb-2">• Modern responsive design for mobile and desktop.</li>
                <li class="mb-2">• Dynamic product categories and smart product pages.</li>
                <li class="mb-2">• Fast checkout with Cash on Delivery and bKash payment options.</li>
            </ul>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="bg-white rounded-4 shadow-sm p-4 h-100">
            <h3 class="fw-bold">Why choose us?</h3>
            <p class="text-muted">From party wear to festive silk sarees, every design is managed from the admin panel so our store stays fresh and curated.</p>
            <div class="row gy-3">
                <div class="col-12 col-sm-6">
                    <div class="p-3 bg-light rounded-3">
                        <strong>Curated Collection</strong>
                        <p class="mb-0 text-muted">Handpicked sarees for style and comfort.</p>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="p-3 bg-light rounded-3">
                        <strong>Easy Checkout</strong>
                        <p class="mb-0 text-muted">Pay by Cash on Delivery or bKash.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Saree Bazaar')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
<header class="bg-white shadow-sm">
    <div class="container py-3 d-flex align-items-center justify-content-between">
        <a class="navbar-brand fs-3 fw-bold text-dark" href="{{ route('home') }}">Saree Bazaar</a>
        <nav class="d-none d-md-flex gap-4 align-items-center">
            <a class="text-dark nav-link p-0" href="{{ route('home') }}">Home</a>
            <a class="text-dark nav-link p-0" href="{{ route('products.index') }}">Shop</a>
            <a class="text-dark nav-link p-0" href="{{ route('about') }}">About</a>
            <a class="text-dark nav-link p-0" href="{{ route('contact.show') }}">Contact</a>
            <a class="text-dark nav-link p-0" href="{{ route('cart.index') }}">Cart</a>
        </nav>
        <a class="btn btn-outline-primary d-md-none" href="{{ route('cart.index') }}">Cart</a>
    </div>
</header>
<main class="py-5 bg-light">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('info'))
            <div class="alert alert-info">{{ session('info') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @yield('content')
    </div>
</main>
<footer class="bg-dark text-white py-5">
    <div class="container">
        <div class="row gy-4">
            <div class="col-md-6">
                <h5>Saree Bazaar</h5>
                <p>Premium sarees and easy shopping with reliable delivery across India.</p>
            </div>
            <div class="col-md-3">
                <h6>Quick Links</h6>
                <ul class="list-unstyled">
                    <li><a class="text-white-50" href="{{ route('home') }}">Home</a></li>
                    <li><a class="text-white-50" href="{{ route('about') }}">About</a></li>
                    <li><a class="text-white-50" href="{{ route('contact.show') }}">Contact</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h6>Contact</h6>
                <p class="text-white-50 mb-1">support@sareebazaar.example</p>
                <p class="text-white-50">+91 98765 43210</p>
            </div>
        </div>
        <hr class="border-secondary mt-4">
        <p class="mb-0 text-white-50 text-center">&copy; {{ date('Y') }} Saree Bazaar. All rights reserved.</p>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

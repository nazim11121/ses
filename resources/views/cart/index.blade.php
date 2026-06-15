@extends('layouts.app')

@section('title', 'Your Cart')

@section('content')
<div class="row gy-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm p-4">
            <h2 class="fw-bold">Your Cart</h2>
            <p class="text-muted">Review your selected sarees and update quantities before checking out.</p>
            @if($items->isEmpty())
                <div class="alert alert-info">Your cart is empty. Browse our saree collection to add items.</div>
                <a href="{{ route('home') }}" class="btn btn-primary">Continue Shopping</a>
            @else
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>{{ $item->product->name }}</td>
                                    <td>₹{{ number_format($item->product->price, 2) }}</td>
                                    <td>
                                        <form action="{{ route('cart.update', $item->product->id) }}" method="POST" class="d-flex gap-2 align-items-center">
                                            @csrf
                                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="form-control w-50">
                                            <button class="btn btn-outline-secondary btn-sm">Update</button>
                                        </form>
                                    </td>
                                    <td>₹{{ number_format($item->subtotal, 2) }}</td>
                                    <td>
                                        <form action="{{ route('cart.remove', $item->product->id) }}" method="POST">
                                            @csrf
                                            <button class="btn btn-outline-danger btn-sm">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="3" class="text-end"><strong>Total</strong></td>
                                <td><strong>₹{{ number_format($total, 2) }}</strong></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mt-4">
                    <div class="btn-group">
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary">Continue Shopping</a>
                        <form action="{{ route('cart.clear') }}" method="POST">
                            @csrf
                            <button class="btn btn-outline-danger">Clear Cart</button>
                        </form>
                    </div>
                    <a href="{{ route('checkout.index') }}" class="btn btn-success">Proceed to Checkout</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

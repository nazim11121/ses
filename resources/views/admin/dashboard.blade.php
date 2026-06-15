@extends('admin.layout')

@section('title', 'Admin Dashboard')
@section('page-heading', 'Dashboard')

@section('content')
<div class="row g-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-4">
            <h5 class="mb-3">Products</h5>
            <p class="display-6 mb-0">{{ $totalProducts }}</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-4">
            <h5 class="mb-3">Categories</h5>
            <p class="display-6 mb-0">{{ $totalCategories }}</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-4">
            <h5 class="mb-3">Orders</h5>
            <p class="display-6 mb-0">{{ $totalOrders }}</p>
        </div>
    </div>
</div>
<div class="mt-4">
    <div class="card border-0 shadow-sm p-4">
        <h5 class="mb-3">Latest Orders</h5>
        @if($latestOrders->isEmpty())
            <p class="mb-0 text-muted">No orders yet.</p>
        @else
            <div class="list-group">
                @foreach($latestOrders as $order)
                    <a href="{{ route('admin.orders.show', $order->id) }}" class="list-group-item list-group-item-action">
                        Order #{{ $order->id }} — {{ $order->customer_name }} <span class="text-muted">({{ $order->status }})</span>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection

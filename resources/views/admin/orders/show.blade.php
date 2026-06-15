@extends('admin.layout')

@section('title', 'Order Details')
@section('page-heading', 'Order Details')

@section('content')
<div class="card border-0 shadow-sm p-4">
    <div class="d-flex justify-content-between mb-4">
        <div>
            <h4 class="fw-bold">Order #{{ $order->id }}</h4>
            <p class="text-muted mb-1">{{ $order->customer_name }} — {{ $order->customer_email }}</p>
            <p class="text-muted">{{ $order->customer_phone }}</p>
        </div>
        <div class="text-end">
            <span class="badge bg-info text-dark">{{ $order->status }}</span>
        </div>
    </div>
    <div class="mb-4">
        <p><strong>Shipping Address</strong></p>
        <p>{{ $order->shipping_address }}</p>
        <p><strong>Payment Method:</strong> {{ $order->payment_method }}</p>
    </div>
    <div class="table-responsive mb-4">
        <table class="table">
            <thead class="table-light">
                <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>₹{{ number_format($item->price, 2) }}</td>
                        <td>₹{{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3" class="text-end"><strong>Total</strong></td>
                    <td><strong>₹{{ number_format($order->total_amount, 2) }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>
    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="row g-3 align-items-end">
        @csrf
        @method('PUT')
        <div class="col-md-6">
            <label class="form-label">Order Status</label>
            <select name="status" class="form-select">
                <option value="Pending"{{ $order->status === 'Pending' ? ' selected' : '' }}>Pending</option>
                <option value="Processing"{{ $order->status === 'Processing' ? ' selected' : '' }}>Processing</option>
                <option value="Completed"{{ $order->status === 'Completed' ? ' selected' : '' }}>Completed</option>
                <option value="Cancelled"{{ $order->status === 'Cancelled' ? ' selected' : '' }}>Cancelled</option>
            </select>
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-primary">Update Status</button>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">Back to Orders</a>
        </div>
    </form>
</div>
@endsection

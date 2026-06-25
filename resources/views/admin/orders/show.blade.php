@extends('admin.layout')

@section('title', 'Order Details')
@section('page-heading', 'Order Details')

@section('content')
<div class="ap-card">
    {{-- ── Header ── --}}
    <div class="ap-card-header" style="padding-bottom:1rem;border-bottom:1px solid var(--ap-border)">
        <div>
            <h2 class="ap-card-title" style="font-size:1.2rem">
                Order #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
            </h2>
            <p style="margin:0;font-size:.85rem;color:var(--ap-text-muted)">
                Placed {{ $order->created_at->format('d M Y, h:i A') }}
            </p>
        </div>
        <span class="ap-badge ap-badge-{{ strtolower($order->status) }}">{{ $order->status }}</span>
    </div>

    <div class="ap-card-body" style="padding-top:1.5rem">
        <div class="row g-4 mb-4">

            {{-- Customer info --}}
            <div class="col-md-4">
                <div style="font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--ap-text-muted);margin-bottom:.6rem">Customer</div>
                <div class="fw-semibold">{{ $order->customer_name }}</div>
                <div style="font-size:.85rem;color:var(--ap-text-muted)">{{ $order->customer_email }}</div>
                <div style="font-size:.85rem;color:var(--ap-text-muted)">{{ $order->customer_phone }}</div>
            </div>

            {{-- Shipping --}}
            <div class="col-md-4">
                <div style="font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--ap-text-muted);margin-bottom:.6rem">Shipping Address</div>
                <div style="font-size:.875rem;line-height:1.5">{{ $order->shipping_address }}</div>
            </div>

            {{-- Payment --}}
            <div class="col-md-4">
                <div style="font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--ap-text-muted);margin-bottom:.6rem">Payment</div>
                <div class="fw-semibold">{{ $order->payment_method }}</div>

                @if($order->payment_method === 'bKash' && $order->bkash_transaction_id)
                <div style="margin-top:.85rem;background:#fff8f9;border:1.5px solid #fcd5e4;border-radius:10px;padding:.85rem 1rem">
                    <div style="font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#e2136e;margin-bottom:.5rem">bKash Details</div>
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:.35rem">
                        <span style="font-size:.8rem;color:#6b7280">Transaction ID</span>
                        <span style="font-size:.85rem;font-weight:700;letter-spacing:.04em;color:#111">{{ $order->bkash_transaction_id }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center">
                        <span style="font-size:.8rem;color:#6b7280">Amount Paid</span>
                        <span style="font-size:.9rem;font-weight:700;color:#e2136e">৳{{ number_format($order->bkash_amount, 2) }}</span>
                    </div>
                </div>
                @endif
            </div>

        </div>

        {{-- ── Order items ── --}}
        <div style="overflow-x:auto;margin-bottom:1.5rem">
            <table class="ap-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th style="text-align:center">Qty</th>
                        <th style="text-align:right">Unit Price</th>
                        <th style="text-align:right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td class="fw-semibold">{{ $item->product->name ?? '—' }}</td>
                        <td style="text-align:center">{{ $item->quantity }}</td>
                        <td style="text-align:right">৳{{ number_format($item->price, 2) }}</td>
                        <td style="text-align:right">৳{{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" style="text-align:right;font-weight:700;font-size:.95rem;padding-top:.75rem">Order Total</td>
                        <td style="text-align:right;font-weight:800;font-size:1rem;padding-top:.75rem;color:var(--ap-accent)">
                            ৳{{ number_format($order->total_amount, 2) }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        {{-- ── Status update ── --}}
        @if(auth()->user()->hasPermission('orders.update-status'))
        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="row g-3 align-items-end">
            @csrf
            @method('PUT')
            <div class="col-md-5">
                <label class="form-label fw-semibold" style="font-size:.85rem">Update Status</label>
                <select name="status" class="form-select">
                    <option value="Pending"    {{ $order->status === 'Pending'    ? 'selected' : '' }}>Pending</option>
                    <option value="Processing" {{ $order->status === 'Processing' ? 'selected' : '' }}>Processing</option>
                    <option value="Shipped"    {{ $order->status === 'Shipped'    ? 'selected' : '' }}>Shipped</option>
                    <option value="Delivered"  {{ $order->status === 'Delivered'  ? 'selected' : '' }}>Delivered</option>
                    <option value="Completed"  {{ $order->status === 'Completed'  ? 'selected' : '' }}>Completed</option>
                    <option value="Cancelled"  {{ $order->status === 'Cancelled'  ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div class="col-md-7 d-flex gap-2 justify-content-end">
                <button class="ap-btn ap-btn-primary">Update Status</button>
                <a href="{{ route('admin.orders.index') }}" class="ap-btn ap-btn-outline">Back to Orders</a>
            </div>
        </form>
        @else
        <div class="text-end">
            <a href="{{ route('admin.orders.index') }}" class="ap-btn ap-btn-outline">Back to Orders</a>
        </div>
        @endif

    </div>
</div>
@endsection

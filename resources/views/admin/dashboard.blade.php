@extends('admin.layout')

@section('title', 'Dashboard')
@section('page-heading', 'Dashboard')

@section('content')

{{-- ── Page header ── --}}
<div class="ap-page-header">
    <div>
        <h1 class="ap-page-title">Overview</h1>
        <p class="ap-page-sub">Welcome back, {{ auth()->user()->name }}. Here's what's happening today.</p>
    </div>
    @if(auth()->user()->hasPermission('orders.view'))
    <a href="{{ route('admin.orders.index') }}" class="ap-btn ap-btn-primary">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
        View Orders
    </a>
    @endif
</div>

{{-- ── Stat cards ── --}}
<div class="row g-3 mb-4">

    <div class="col-sm-6 col-xl-3">
        <div class="ap-stat ap-stat-blue">
            <div class="ap-stat-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
            </div>
            <div class="ap-stat-body">
                <div class="ap-stat-label">Total Orders</div>
                <div class="ap-stat-num ap-count" data-count="{{ $totalOrders }}">0</div>
                <div class="ap-stat-sub">{{ $pendingOrders }} pending</div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="ap-stat ap-stat-orange">
            <div class="ap-stat-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            </div>
            <div class="ap-stat-body">
                <div class="ap-stat-label">Revenue</div>
                <div class="ap-stat-num">৳{{ number_format($totalRevenue, 0) }}</div>
                <div class="ap-stat-sub">Excluding cancelled</div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="ap-stat ap-stat-purple">
            <div class="ap-stat-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
            </div>
            <div class="ap-stat-body">
                <div class="ap-stat-label">Products</div>
                <div class="ap-stat-num ap-count" data-count="{{ $totalProducts }}">0</div>
                <div class="ap-stat-sub">In catalogue</div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="ap-stat ap-stat-green">
            <div class="ap-stat-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
            </div>
            <div class="ap-stat-body">
                <div class="ap-stat-label">Categories</div>
                <div class="ap-stat-num ap-count" data-count="{{ $totalCategories }}">0</div>
                <div class="ap-stat-sub">Active groups</div>
            </div>
        </div>
    </div>

</div>

{{-- ── Recent orders + Quick actions ── --}}
<div class="row g-3">

    {{-- Recent orders --}}
    <div class="col-lg-8">
        <div class="ap-card h-100">
            <div class="ap-card-header">
                <h2 class="ap-card-title">Recent Orders</h2>
                @if(auth()->user()->hasPermission('orders.view'))
                <a href="{{ route('admin.orders.index') }}" class="ap-btn ap-btn-outline ap-btn-sm">View all</a>
                @endif
            </div>
            <div style="overflow-x:auto">
                @if($latestOrders->isEmpty())
                <div style="padding:3rem;text-align:center;color:#94a3b8">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin-bottom:.75rem;display:block;margin-left:auto;margin-right:auto"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                    <p style="margin:0;font-size:.875rem">No orders yet.</p>
                </div>
                @else
                <table class="ap-table">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>Status</th>
                            @if(auth()->user()->hasPermission('orders.view-detail'))
                            <th></th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($latestOrders as $order)
                        <tr>
                            <td><span class="ap-order-row-id">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span></td>
                            <td><span class="ap-order-customer">{{ $order->customer_name }}</span></td>
                            <td><span class="ap-order-amount">৳{{ number_format($order->total_amount ?? 0, 0) }}</span></td>
                            <td>
                                @php $st = strtolower($order->status ?? 'default'); @endphp
                                <span class="ap-badge ap-badge-{{ in_array($st,['pending','processing','shipped','delivered','completed','cancelled']) ? $st : 'default' }}">
                                    {{ ucfirst($order->status ?? 'Unknown') }}
                                </span>
                            </td>
                            @if(auth()->user()->hasPermission('orders.view-detail'))
                            <td style="text-align:right">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="ap-btn ap-btn-outline ap-btn-sm">View</a>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </div>

    {{-- Quick actions + Summary ── --}}
    <div class="col-lg-4 d-flex flex-column gap-3">

        {{-- Quick actions --}}
        <div class="ap-card">
            <div class="ap-card-header">
                <h2 class="ap-card-title">Quick Actions</h2>
            </div>
            <div class="ap-card-body">
                <div class="ap-quick-grid">
                    @if(auth()->user()->hasPermission('products.create'))
                    <a href="{{ route('admin.products.create') }}" class="ap-quick-btn">
                        <span class="ap-quick-icon" style="background:#ede9fe;color:#7c3aed">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        </span>
                        Add Product
                    </a>
                    @endif
                    @if(auth()->user()->hasPermission('orders.view'))
                    <a href="{{ route('admin.orders.index') }}" class="ap-quick-btn">
                        <span class="ap-quick-icon" style="background:#dbeafe;color:#2563eb">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                        </span>
                        All Orders
                    </a>
                    @endif
                    @if(auth()->user()->hasPermission('notifications.send') || auth()->user()->hasPermission('notifications.manage'))
                    <a href="{{ route('admin.notifications.send') }}" class="ap-quick-btn">
                        <span class="ap-quick-icon" style="background:#d1fae5;color:#059669">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                        </span>
                        Send Notif
                    </a>
                    @endif
                    @if(auth()->user()->hasPermission('sliders.view'))
                    <a href="{{ route('admin.sliders.index') }}" class="ap-quick-btn">
                        <span class="ap-quick-icon" style="background:#fef3c7;color:#d97706">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
                        </span>
                        Manage Slider
                    </a>
                    @endif
                </div>
            </div>
        </div>

        {{-- Order status summary --}}
        <div class="ap-card">
            <div class="ap-card-header">
                <h2 class="ap-card-title">Order Status</h2>
            </div>
            <div class="ap-card-body" style="padding-top:.9rem">
                @php
                    $statuses = [
                        ['label'=>'Pending',    'class'=>'ap-badge-pending',    'count'=> $latestOrders->where('status','pending')->count()],
                        ['label'=>'Processing', 'class'=>'ap-badge-processing', 'count'=> $latestOrders->where('status','processing')->count()],
                        ['label'=>'Shipped',    'class'=>'ap-badge-shipped',    'count'=> $latestOrders->where('status','shipped')->count()],
                        ['label'=>'Delivered',  'class'=>'ap-badge-delivered',  'count'=> $latestOrders->where('status','delivered')->count()],
                        ['label'=>'Cancelled',  'class'=>'ap-badge-cancelled',  'count'=> $latestOrders->where('status','cancelled')->count()],
                    ];
                @endphp
                <div style="display:flex;flex-direction:column;gap:.6rem">
                    @foreach($statuses as $s)
                    <div style="display:flex;align-items:center;justify-content:space-between">
                        <span class="ap-badge {{ $s['class'] }}">{{ $s['label'] }}</span>
                        <span style="font-size:.85rem;font-weight:700;color:#0f172a">{{ $s['count'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

@section('scripts')
<script>
(function () {
    // Animate stat counters
    var els = document.querySelectorAll('.ap-count[data-count]');
    var done = false;

    function run() {
        if (done) return; done = true;
        els.forEach(function (el) {
            var target   = parseInt(el.dataset.count, 10);
            var duration = 1200;
            var steps    = 40;
            var step     = target / steps;
            var cur      = 0;
            var interval = setInterval(function () {
                cur += step;
                if (cur >= target) { cur = target; clearInterval(interval); }
                el.textContent = Math.floor(cur).toLocaleString();
            }, duration / steps);
        });
    }

    var obs = new IntersectionObserver(function (entries) {
        if (entries[0].isIntersecting) run();
    }, { threshold: .3 });

    var first = document.querySelector('.ap-stat');
    if (first) obs.observe(first);
})();
</script>
@endsection

@extends('admin.layout')

@section('title', 'Notification Logs')
@section('page-heading', 'Notification Logs')

@section('content')
{{-- Filters --}}
<form method="GET" action="{{ route('admin.notifications.logs') }}" class="card border-0 shadow-sm mb-4">
    <div class="card-body py-3">
        <div class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label small mb-1">Type</label>
                <select name="type" class="form-select form-select-sm">
                    <option value="">All Types</option>
                    <option value="mail" {{ request('type') === 'mail' ? 'selected' : '' }}>Mail</option>
                    <option value="sms" {{ request('type') === 'sms' ? 'selected' : '' }}>SMS</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small mb-1">Status</label>
                <select name="status" class="form-select form-select-sm">
                    <option value="">All Statuses</option>
                    <option value="sent" {{ request('status') === 'sent' ? 'selected' : '' }}>Sent</option>
                    <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label small mb-1">Recipient</label>
                <input type="text" name="search" class="form-control form-control-sm" value="{{ request('search') }}" placeholder="Search email / phone...">
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                <a href="{{ route('admin.notifications.logs') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
            </div>
        </div>
    </div>
</form>

{{-- Summary badges --}}
@php
    $totalSent   = \App\Models\NotificationLog::sent()->count();
    $totalFailed = \App\Models\NotificationLog::failed()->count();
@endphp
<div class="d-flex gap-3 mb-3">
    <span class="badge bg-success fs-6 px-3 py-2">{{ $totalSent }} Sent</span>
    <span class="badge bg-danger fs-6 px-3 py-2">{{ $totalFailed }} Failed</span>
    <span class="badge bg-secondary fs-6 px-3 py-2">{{ $totalSent + $totalFailed }} Total</span>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Type</th>
                    <th>Driver</th>
                    <th>Recipient</th>
                    <th>Subject / Message</th>
                    <th>Template</th>
                    <th>Status</th>
                    <th>Sent At</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr>
                    <td class="text-muted small">{{ $log->id }}</td>
                    <td><span class="badge bg-{{ $log->type === 'mail' ? 'primary' : 'success' }}">{{ strtoupper($log->type) }}</span></td>
                    <td><code class="small">{{ $log->driver }}</code></td>
                    <td class="small">{{ $log->recipient }}</td>
                    <td class="small" style="max-width:240px">
                        @if($log->subject)
                            <div class="fw-semibold">{{ Str::limit($log->subject, 40) }}</div>
                        @endif
                        <div class="text-muted">{{ Str::limit($log->message, 60) }}</div>
                    </td>
                    <td class="small text-muted">{{ $log->template ? $log->template->name : '—' }}</td>
                    <td>
                        @if($log->status === 'sent')
                            <span class="badge bg-success">Sent</span>
                        @else
                            <span class="badge bg-danger" title="{{ $log->error }}">Failed</span>
                            @if($log->error)
                            <div class="text-danger small mt-1" style="max-width:180px; word-break:break-word;">{{ Str::limit($log->error, 60) }}</div>
                            @endif
                        @endif
                    </td>
                    <td class="small text-muted text-nowrap">{{ $log->sent_at ? $log->sent_at->format('d M Y H:i') : '—' }}</td>
                    <td>
                        @if(auth()->user()->hasPermission('notifications.manage'))
                        <form action="{{ route('admin.notifications.logs.destroy', $log) }}" method="POST" onsubmit="return confirm('Delete this log?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Del</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" class="text-center text-muted py-4">No notification logs found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($logs->hasPages())
    <div class="card-footer bg-white border-top-0">
        {{ $logs->links() }}
    </div>
    @endif
</div>
@endsection

@extends('admin.layout')

@section('title', 'Notification Settings')
@section('page-heading', 'Notification Settings')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <p class="text-muted mb-0">Configure Mail &amp; SMS API credentials. Only one setting per type can be active at a time.</p>
    @if(auth()->user()->hasPermission('notifications.manage'))
    <a href="{{ route('admin.notifications.settings.create') }}" class="btn btn-primary btn-sm">+ Add Setting</a>
    @endif
</div>

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead class="table-light">
                <tr>
                    <th>Label</th>
                    <th>Type</th>
                    <th>Driver</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($settings as $setting)
                <tr>
                    <td>{{ $setting->label }}</td>
                    <td><span class="badge bg-{{ $setting->type === 'mail' ? 'primary' : 'success' }}">{{ strtoupper($setting->type) }}</span></td>
                    <td><code>{{ $setting->driver }}</code></td>
                    <td>
                        @if($setting->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </td>
                    <td class="text-end">
                        @if(auth()->user()->hasPermission('notifications.manage'))
                        @unless($setting->is_active)
                        <form action="{{ route('admin.notifications.settings.activate', $setting) }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-sm btn-outline-success">Set Active</button>
                        </form>
                        @endunless
                        <a href="{{ route('admin.notifications.settings.edit', $setting) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                        <form action="{{ route('admin.notifications.settings.destroy', $setting) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this setting?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4">No settings configured yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@extends('admin.layout')

@section('title', 'Notification Templates')
@section('page-heading', 'Notification Templates')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <p class="text-muted mb-0">Use <code>{variable}</code> placeholders in subject &amp; body.</p>
    @if(auth()->user()->hasPermission('notifications.manage'))
    <a href="{{ route('admin.notifications.templates.create') }}" class="btn btn-primary btn-sm">+ New Template</a>
    @endif
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table mb-0 datatable">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Subject</th>
                    <th>Variables</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($templates as $tpl)
                <tr>
                    <td>{{ $tpl->name }}</td>
                    <td><span class="badge bg-{{ $tpl->type === 'mail' ? 'primary' : ($tpl->type === 'sms' ? 'success' : 'info') }}">{{ strtoupper($tpl->type) }}</span></td>
                    <td>{{ $tpl->subject ?: '—' }}</td>
                    <td>
                        @if($tpl->variables)
                            @foreach($tpl->variables as $v)
                                <code class="me-1">{{'{'}}{{ $v }}{{'}'}}</code>
                            @endforeach
                        @else —
                        @endif
                    </td>
                    <td>
                        @if($tpl->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </td>
                    <td class="text-end">
                        @if(auth()->user()->hasPermission('notifications.manage'))
                        <a href="{{ route('admin.notifications.templates.edit', $tpl) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                        <form action="{{ route('admin.notifications.templates.destroy', $tpl) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this template?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">No templates yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

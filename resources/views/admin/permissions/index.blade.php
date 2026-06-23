@extends('admin.layout')

@section('title', 'Permissions')
@section('page-heading', 'Manage Permissions')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0">Permissions</h3>
    <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary">Add Permission</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table mb-0 datatable">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Group</th>
                    <th>Description</th>
                    <th>Roles</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($permissions as $permission)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $permission->name }}</td>
                        <td><code>{{ $permission->slug }}</code></td>
                        <td><span class="badge bg-light text-dark border">{{ $permission->group }}</span></td>
                        <td>{{ $permission->description ?: '—' }}</td>
                        <td><span class="badge bg-secondary">{{ $permission->roles_count }}</span></td>
                        <td class="text-end">
                            <a href="{{ route('admin.permissions.edit', $permission->id) }}" class="btn btn-sm btn-outline-secondary me-1">Edit</a>
                            <form action="{{ route('admin.permissions.destroy', $permission->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete this permission?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-3">No permissions found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

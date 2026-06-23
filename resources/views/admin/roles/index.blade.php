@extends('admin.layout')

@section('title', 'Roles')
@section('page-heading', 'Manage Roles')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0">Roles</h3>
    @if(auth()->user()->hasPermission('roles.create'))
        <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">Add Role</a>
    @endif
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table mb-0 datatable">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Description</th>
                    <th>Permissions</th>
                    <th>Users</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($roles as $role)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $role->name }}</td>
                        <td><code>{{ $role->slug }}</code></td>
                        <td>{{ $role->description ?: '—' }}</td>
                        <td><span class="badge bg-info text-dark">{{ $role->permissions_count }}</span></td>
                        <td><span class="badge bg-secondary">{{ $role->users_count }}</span></td>
                        <td class="text-end">
                            @if(auth()->user()->hasPermission('roles.edit'))
                                <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-sm btn-outline-secondary me-1">Edit</a>
                            @endif
                            @if(auth()->user()->hasPermission('roles.delete'))
                                <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete this role?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-3">No roles found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

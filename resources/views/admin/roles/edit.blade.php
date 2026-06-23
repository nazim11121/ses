@extends('admin.layout')

@section('title', 'Edit Role')
@section('page-heading', 'Edit Role')

@section('content')
<div class="card border-0 shadow-sm p-4" style="max-width:720px;">
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Role Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $role->name) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Slug</label>
            <input type="text" name="slug" class="form-control" value="{{ old('slug', $role->slug) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="2">{{ old('description', $role->description) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold">Permissions</label>
            @php $assignedIds = $role->permissions->pluck('id')->toArray(); @endphp
            @forelse($permissions as $group => $items)
                <div class="mb-3">
                    <p class="text-muted small text-uppercase fw-semibold mb-2">{{ $group }}</p>
                    <div class="row row-cols-2 row-cols-md-3 g-2">
                        @foreach($items as $permission)
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                           id="perm_{{ $permission->id }}" value="{{ $permission->id }}"
                                           {{ in_array($permission->id, old('permissions', $assignedIds)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perm_{{ $permission->id }}">
                                        {{ $permission->name }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @if(!$loop->last)<hr class="my-2">@endif
            @empty
                <p class="text-muted">No permissions yet. <a href="{{ route('admin.permissions.create') }}">Create one</a>.</p>
            @endforelse
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Update Role</button>
            <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection

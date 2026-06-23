@extends('admin.layout')

@section('title', 'Edit User')
@section('page-heading', 'Edit User')

@section('content')
<div class="card border-0 shadow-sm p-4" style="max-width:760px;">
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">New Password <small class="text-muted">(leave blank to keep current)</small></label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Confirm New Password</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>

        {{-- Roles --}}
        <div class="mb-3">
            <label class="form-label fw-semibold">Roles</label>
            @php $userRoleIds = $user->roles->pluck('id')->toArray(); @endphp
            <div class="row row-cols-2 row-cols-md-3 g-2">
                @foreach($roles as $role)
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="roles[]"
                                   id="role_{{ $role->id }}" value="{{ $role->id }}"
                                   {{ in_array($role->id, old('roles', $userRoleIds)) ? 'checked' : '' }}>
                            <label class="form-check-label" for="role_{{ $role->id }}">{{ $role->name }}</label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Direct Permissions --}}
        @if($permissions->count())
        <div class="mb-4">
            <label class="form-label fw-semibold">
                Extra Permissions
                <small class="text-muted fw-normal">(role-র বাইরে সরাসরি এই user-কে দেওয়া permissions)</small>
            </label>
            @php $userPermIds = $user->permissions->pluck('id')->toArray(); @endphp
            @foreach($permissions as $group => $perms)
                <div class="mb-2">
                    <div class="text-muted small text-uppercase fw-semibold mb-1" style="letter-spacing:.05em;">{{ $group ?: 'General' }}</div>
                    <div class="row row-cols-2 row-cols-md-3 g-1">
                        @foreach($perms as $perm)
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="direct_permissions[]"
                                           id="perm_{{ $perm->id }}" value="{{ $perm->id }}"
                                           {{ in_array($perm->id, old('direct_permissions', $userPermIds)) ? 'checked' : '' }}>
                                    <label class="form-check-label small" for="perm_{{ $perm->id }}">{{ $perm->name }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
        @endif

        <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" name="active" id="active"
                   {{ old('active', $user->active) ? 'checked' : '' }}>
            <label class="form-check-label" for="active">Active</label>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Update User</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection

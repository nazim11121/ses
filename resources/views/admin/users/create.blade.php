@extends('admin.layout')

@section('title', 'Create User')
@section('page-heading', 'Create User')

@section('content')
<div class="card border-0 shadow-sm p-4" style="max-width:760px;">
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        {{-- Roles --}}
        <div class="mb-3">
            <label class="form-label fw-semibold">Roles</label>
            <div class="row row-cols-2 row-cols-md-3 g-2">
                @foreach($roles as $role)
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="roles[]"
                                   id="role_{{ $role->id }}" value="{{ $role->id }}"
                                   {{ in_array($role->id, old('roles', [])) ? 'checked' : '' }}>
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
            @foreach($permissions as $group => $perms)
                <div class="mb-2">
                    <div class="text-muted small text-uppercase fw-semibold mb-1" style="letter-spacing:.05em;">{{ $group ?: 'General' }}</div>
                    <div class="row row-cols-2 row-cols-md-3 g-1">
                        @foreach($perms as $perm)
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="direct_permissions[]"
                                           id="perm_{{ $perm->id }}" value="{{ $perm->id }}"
                                           {{ in_array($perm->id, old('direct_permissions', [])) ? 'checked' : '' }}>
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
                   {{ old('active', true) ? 'checked' : '' }}>
            <label class="form-check-label" for="active">Active</label>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Create User</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection

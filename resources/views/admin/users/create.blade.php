@extends('admin.layout')

@section('title', 'Create User')
@section('page-heading', 'Create User')

@section('content')
<div class="card border-0 shadow-sm p-4" style="max-width:680px;">
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

        <div class="mb-3">
            <label class="form-label">Roles</label>
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

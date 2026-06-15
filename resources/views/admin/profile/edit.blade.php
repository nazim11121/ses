@extends('admin.layout')

@section('title', 'Edit Profile')
@section('page-heading', 'Edit Profile')

@section('content')
<div class="card border-0 shadow-sm p-4">
    <form action="{{ route('admin.profile.update') }}" method="POST">
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

        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
</div>
@endsection

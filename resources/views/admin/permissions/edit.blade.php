@extends('admin.layout')

@section('title', 'Edit Permission')
@section('page-heading', 'Edit Permission')

@section('content')
<div class="card border-0 shadow-sm p-4" style="max-width:600px;">
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('admin.permissions.update', $permission->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Permission Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $permission->name) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Slug</label>
            <input type="text" name="slug" class="form-control" value="{{ old('slug', $permission->slug) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Group</label>
            <input type="text" name="group" class="form-control" list="group-list"
                   value="{{ old('group', $permission->group) }}" required>
            <datalist id="group-list">
                @foreach($groups as $g)
                    <option value="{{ $g }}">
                @endforeach
            </datalist>
        </div>

        <div class="mb-4">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="2">{{ old('description', $permission->description) }}</textarea>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Update Permission</button>
            <a href="{{ route('admin.permissions.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection

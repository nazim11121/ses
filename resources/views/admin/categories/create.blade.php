@extends('admin.layout')

@section('title', 'Create Category')
@section('page-heading', 'Create Category')

@section('content')
<div class="card border-0 shadow-sm p-4">
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Slug</label>
            <input type="text" name="slug" class="form-control" value="{{ old('slug') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" rows="4" class="form-control">{{ old('description') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save Category</button>
    </form>
</div>
@endsection

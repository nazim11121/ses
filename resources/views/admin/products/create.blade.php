@extends('admin.layout')

@section('title', 'Create Product')
@section('page-heading', 'Create Product')

@section('content')
<div class="card border-0 shadow-sm p-4">
    <form action="{{ route('admin.products.store') }}" method="POST">
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
            <label class="form-label">Category</label>
            <select name="category_id" class="form-select">
                <option value="">Unassigned</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Price</label>
            <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Stock</label>
            <input type="number" name="stock" class="form-control" value="{{ old('stock', 0) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Image URL or public path</label>
            <input type="text" name="image" class="form-control" value="{{ old('image') }}">
            <div class="form-text">Enter an absolute image URL or a path relative to your public folder, e.g. <code>images/saree.jpg</code>.</div>
        </div>
        <div class="mb-3">
            <label class="form-label">Section</label>
            <select name="section" class="form-select">
                <option value="">None</option>
                <option value="new_arrival"{{ old('section') == 'new_arrival' ? ' selected' : '' }}>New Arrival</option>
                <option value="featured"{{ old('section') == 'featured' ? ' selected' : '' }}>Featured Product</option>
                <option value="top_rated"{{ old('section') == 'top_rated' ? ' selected' : '' }}>Top Rated</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" rows="5" class="form-control" required>{{ old('description') }}</textarea>
        </div>
        <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" name="active" id="active" checked>
            <label class="form-check-label" for="active">Active</label>
        </div>
        <button type="submit" class="btn btn-primary">Save Product</button>
    </form>
</div>
@endsection

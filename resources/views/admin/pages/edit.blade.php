@extends('admin.layout')

@section('title', 'Edit About Page')
@section('page-heading', 'Edit About Page')

@section('content')
<div class="card border-0 shadow-sm p-4">
    <form action="{{ route('admin.pages.update') }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Page Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $page->title) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Main Content</label>
            <textarea name="content" rows="6" class="form-control" required>{{ old('content', $page->content) }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Sidebar Title</label>
            <input type="text" name="sidebar_title" class="form-control" value="{{ old('sidebar_title', $page->sidebar_title) }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Sidebar Text</label>
            <textarea name="sidebar_text" rows="4" class="form-control">{{ old('sidebar_text', $page->sidebar_text) }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Feature One Title</label>
            <input type="text" name="feature_one_title" class="form-control" value="{{ old('feature_one_title', $page->feature_one_title) }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Feature One Text</label>
            <textarea name="feature_one_text" rows="3" class="form-control">{{ old('feature_one_text', $page->feature_one_text) }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Feature Two Title</label>
            <input type="text" name="feature_two_title" class="form-control" value="{{ old('feature_two_title', $page->feature_two_title) }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Feature Two Text</label>
            <textarea name="feature_two_text" rows="3" class="form-control">{{ old('feature_two_text', $page->feature_two_text) }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save About Page</button>
    </form>
</div>
@endsection

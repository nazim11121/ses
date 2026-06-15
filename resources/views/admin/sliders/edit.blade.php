@extends('admin.layout')

@section('title', 'Edit Slider Item')
@section('page-heading', 'Edit Slider Item')

@section('content')
<div class="card border-0 shadow-sm p-4">
    <form action="{{ route('admin.sliders.update', $slide->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $slide->title) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Subtitle</label>
            <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $slide->subtitle) }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Image URL or public path</label>
            <input type="text" name="image" class="form-control" value="{{ old('image', $slide->image) }}" required>
            <div class="form-text">Example: <code>https://example.com/image.jpg</code> or <code>images/slide1.jpg</code></div>
        </div>
        <div class="mb-3">
            <label class="form-label">Button Text</label>
            <input type="text" name="button_text" class="form-control" value="{{ old('button_text', $slide->button_text) }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Button Link</label>
            <input type="url" name="button_link" class="form-control" value="{{ old('button_link', $slide->button_link) }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Position</label>
            <input type="number" name="position" class="form-control" value="{{ old('position', $slide->position) }}">
        </div>
        <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" name="active" id="active"{{ old('active', $slide->active) ? ' checked' : '' }}>
            <label class="form-check-label" for="active">Active</label>
        </div>
        <button type="submit" class="btn btn-primary">Update Slide</button>
    </form>
</div>
@endsection

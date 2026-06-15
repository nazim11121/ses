@extends('admin.layout')

@section('title', 'Create Slider Item')
@section('page-heading', 'Create Slider Item')

@section('content')
<div class="card border-0 shadow-sm p-4">
    <form action="{{ route('admin.sliders.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Subtitle</label>
            <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Image URL or public path</label>
            <input type="text" name="image" class="form-control" value="{{ old('image') }}" required>
            <div class="form-text">Example: <code>https://example.com/image.jpg</code> or <code>images/slide1.jpg</code></div>
        </div>
        <div class="mb-3">
            <label class="form-label">Button Text</label>
            <input type="text" name="button_text" class="form-control" value="{{ old('button_text') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Button Link</label>
            <input type="url" name="button_link" class="form-control" value="{{ old('button_link') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Position</label>
            <input type="number" name="position" class="form-control" value="{{ old('position', 0) }}">
        </div>
        <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" name="active" id="active" checked>
            <label class="form-check-label" for="active">Active</label>
        </div>
        <button type="submit" class="btn btn-primary">Save Slide</button>
    </form>
</div>
@endsection

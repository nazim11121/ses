@extends('admin.layout')

@section('title', 'Add Feedback')
@section('page-heading', 'Add Feedback')

@section('content')
<div class="card border-0 shadow-sm p-4">
    <form action="{{ route('admin.feedbacks.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Designation</label>
            <input type="text" name="designation" class="form-control" value="{{ old('designation') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Message</label>
            <textarea name="message" rows="4" class="form-control" required>{{ old('message') }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Image URL or public path</label>
            <input type="text" name="image" class="form-control" value="{{ old('image') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Position</label>
            <input type="number" name="position" class="form-control" value="{{ old('position', 0) }}">
        </div>
        <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" name="active" id="active" checked>
            <label class="form-check-label" for="active">Active</label>
        </div>
        <button type="submit" class="btn btn-primary">Save Feedback</button>
    </form>
</div>
@endsection

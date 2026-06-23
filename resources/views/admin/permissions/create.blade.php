@extends('admin.layout')

@section('title', 'Create Permission')
@section('page-heading', 'Create Permission')

@section('content')
<div class="card border-0 shadow-sm p-4" style="max-width:600px;">
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('admin.permissions.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Permission Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                   placeholder="e.g. View Products" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Slug</label>
            <input type="text" name="slug" class="form-control" value="{{ old('slug') }}"
                   placeholder="e.g. products.view" required>
            <div class="form-text">Unique identifier used in code checks (e.g. <code>products.view</code>).</div>
        </div>

        <div class="mb-3">
            <label class="form-label">Group</label>
            <input type="text" name="group" class="form-control" list="group-list"
                   value="{{ old('group') }}" placeholder="e.g. Products" required>
            <datalist id="group-list">
                @foreach($groups as $g)
                    <option value="{{ $g }}">
                @endforeach
            </datalist>
            <div class="form-text">Used to organise permissions when assigning to roles.</div>
        </div>

        <div class="mb-4">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="2">{{ old('description') }}</textarea>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Create Permission</button>
            <a href="{{ route('admin.permissions.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>

<script>
document.querySelector('[name="name"]').addEventListener('input', function () {
    const slug = document.querySelector('[name="slug"]');
    if (!slug.dataset.edited) {
        slug.value = this.value.toLowerCase().replace(/\s+/g, '.').replace(/[^a-z0-9.]/g, '');
    }
});
document.querySelector('[name="slug"]').addEventListener('input', function () {
    this.dataset.edited = 'true';
});
</script>
@endsection

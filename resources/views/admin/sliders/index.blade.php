@extends('admin.layout')

@section('title', 'Slider Items')
@section('page-heading', 'Manage Slider')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0">Slider Items</h3>
    @if(auth()->user()->hasPermission('sliders.create'))
        <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary">Add Slide</a>
    @endif
</div>
<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table mb-0 datatable">
            <thead class="table-light">
                <tr>
                    <th>Title</th>
                    <th>Subtitle</th>
                    <th>Image</th>
                    <th>Button</th>
                    <th>Position</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($slides as $slide)
                    <tr>
                        <td>{{ $slide->title }}</td>
                        <td>{{ $slide->subtitle }}</td>
                        <td><img src="{{ $slide->image_url }}" alt="{{ $slide->title }}" width="100"></td>
                        <td>{{ $slide->button_text ?? '—' }}</td>
                        <td>{{ $slide->position }}</td>
                        <td>{{ $slide->active ? 'Active' : 'Inactive' }}</td>
                        <td class="text-end">
                            @if(auth()->user()->hasPermission('sliders.edit'))
                                <a href="{{ route('admin.sliders.edit', $slide->id) }}" class="btn btn-sm btn-outline-secondary me-2">Edit</a>
                            @endif
                            @if(auth()->user()->hasPermission('sliders.delete'))
                                <form action="{{ route('admin.sliders.destroy', $slide->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete this slide?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center text-muted">-</td>
                        <td class="text-center text-muted">-</td>
                        <td class="text-center text-muted">-</td>
                        <td class="text-center text-muted">-</td>
                        <td class="text-center text-muted">-</td>
                        <td class="text-center text-muted">-</td>
                        <td class="text-center text-muted">No slider items yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

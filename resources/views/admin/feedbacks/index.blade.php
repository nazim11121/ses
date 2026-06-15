@extends('admin.layout')

@section('title', 'Customer Feedback')
@section('page-heading', 'Customer Feedback')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0">Customer Feedback</h3>
    <a href="{{ route('admin.feedbacks.create') }}" class="btn btn-primary">Add Feedback</a>
</div>
<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table mb-0 datatable">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Designation</th>
                    <th>Message</th>
                    <th>Position</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($feedbacks as $feedback)
                    <tr>
                        <td>{{ $feedback->name }}</td>
                        <td>{{ $feedback->designation }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($feedback->message, 100) }}</td>
                        <td>{{ $feedback->position }}</td>
                        <td>{{ $feedback->active ? 'Active' : 'Inactive' }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.feedbacks.edit', $feedback->id) }}" class="btn btn-sm btn-outline-secondary me-2">Edit</a>
                            <form action="{{ route('admin.feedbacks.destroy', $feedback->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">No feedback items yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

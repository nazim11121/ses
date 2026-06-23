@extends('admin.layout')

@section('title', 'Contact Messages')
@section('page-heading', 'Contact Messages')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table mb-0 datatable">
            <thead class="table-light">
                <tr>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $message)
                    <tr>
                        <td>{{ $message->created_at->format('d M Y') }}</td>
                        <td>{{ $message->name }}</td>
                        <td>{{ $message->email }}</td>
                        <td>{{ $message->subject }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($message->message, 80) }}</td>
                        <td class="text-end">
                            @if(auth()->user()->hasPermission('contacts.delete'))
                                <form action="{{ route('admin.contacts.destroy', $message->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete this message?')">
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
                        <td class="text-center text-muted">No contact messages yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

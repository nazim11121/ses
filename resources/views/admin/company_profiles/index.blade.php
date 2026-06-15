@extends('admin.layout')

@section('title', 'Company Profiles')
@section('page-heading', 'Company Profiles')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0">Company Profiles</h3>
    <a href="{{ route('admin.company-profiles.create') }}" class="btn btn-primary">Add Company Profile</a>
</div>
<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table mb-0 datatable">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Website</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($profiles as $profile)
                    <tr>
                        <td>{{ $profile->name }}</td>
                        <td>{{ $profile->email ?? '-' }}</td>
                        <td>{{ $profile->phone ?? '-' }}</td>
                        <td>{{ $profile->website ? parse_url($profile->website, PHP_URL_HOST) : '-' }}</td>
                        <td>{{ $profile->active ? 'Active' : 'Inactive' }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.company-profiles.edit', $profile->id) }}" class="btn btn-sm btn-outline-secondary me-2">Edit</a>
                            <form action="{{ route('admin.company-profiles.destroy', $profile->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center text-muted">-</td>
                        <td class="text-center text-muted">-</td>
                        <td class="text-center text-muted">-</td>
                        <td class="text-center text-muted">-</td>
                        <td class="text-center text-muted">-</td>
                        <td class="text-center text-muted">No company profiles yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

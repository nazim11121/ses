@extends('admin.layout')

@section('title', 'Company Profiles')
@section('page-heading', 'Company Profiles')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0">Company Profile</h3>
    @if(!$profile)
        <a href="{{ route('admin.company-profiles.create') }}" class="btn btn-primary">Create Company Profile</a>
    @endif
</div>
<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table mb-0 datatable">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Owner</th>
                    <th>Delivery Charge</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @if($profile)
                    <tr>
                        <td>{{ $profile->name }}</td>
                        <td>{{ $profile->owner_name ?? '-' }}</td>
                        <td>{{ $profile->dhaka_delivery_charge ?? 50 }} / {{ $profile->outside_dhaka_delivery_charge ?? 100 }}</td>
                        <td>{{ $profile->active ? 'Active' : 'Inactive' }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.company-profiles.edit', $profile->id) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                        </td>
                    </tr>
                @else
                    <tr>
                        <td class="text-center text-muted" colspan="5">No company profile created yet.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection

@extends('admin.layout')

@section('title', 'Edit Company Profile')
@section('page-heading', 'Edit Company Profile')

@section('content')
<div class="card border-0 shadow-sm p-4">
    <form action="{{ route('admin.company-profiles.update', $profile->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Company Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $profile->name) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $profile->email) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $profile->phone) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Address</label>
            <textarea name="address" rows="3" class="form-control">{{ old('address', $profile->address) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Website</label>
            <input type="url" name="website" class="form-control" value="{{ old('website', $profile->website) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Tagline</label>
            <input type="text" name="tagline" class="form-control" value="{{ old('tagline', $profile->tagline) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" rows="4" class="form-control">{{ old('description', $profile->description) }}</textarea>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label">Dhaka Delivery Charge</label>
                <input type="number" name="dhaka_delivery_charge" class="form-control" value="{{ old('dhaka_delivery_charge', $profile->dhaka_delivery_charge ?? 50) }}" min="0">
            </div>
            <div class="col-md-6">
                <label class="form-label">Outside Dhaka Delivery Charge</label>
                <input type="number" name="outside_dhaka_delivery_charge" class="form-control" value="{{ old('outside_dhaka_delivery_charge', $profile->outside_dhaka_delivery_charge ?? 100) }}" min="0">
            </div>
        </div>
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label">Facebook URL</label>
                <input type="url" name="facebook" class="form-control" value="{{ old('facebook', $profile->facebook) }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Instagram URL</label>
                <input type="url" name="instagram" class="form-control" value="{{ old('instagram', $profile->instagram) }}">
            </div>
        </div>

        <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" name="active" id="active"{{ old('active', $profile->active) ? ' checked' : '' }}>
            <label class="form-check-label" for="active">Active</label>
        </div>

        <button type="submit" class="btn btn-primary">Update Company Profile</button>
    </form>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
<div class="row gy-4">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm p-4">
            <h2 class="fw-bold">Get in touch</h2>
            <p class="text-muted">Send us a message and our team will respond within one business day.</p>
            <ul class="list-unstyled text-muted">
                <li class="mb-2"><strong>Email:</strong> support@sareebazaar.example</li>
                <li class="mb-2"><strong>Phone:</strong> +91 98765 43210</li>
                <li class="mb-2"><strong>Address:</strong> Market Street, Kolkata, India</li>
            </ul>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm p-4">
            <h3 class="fw-bold">Contact Form</h3>
            <form action="{{ route('contact.store') }}" method="POST" class="mt-4">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Subject</label>
                    <input type="text" name="subject" class="form-control" value="{{ old('subject') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Message</label>
                    <textarea name="message" rows="5" class="form-control" required>{{ old('message') }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Send Message</button>
            </form>
        </div>
    </div>
</div>
@endsection

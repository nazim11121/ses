@extends('layouts.app')

@section('title', 'Contact Us')
@section('full-width', true)

@section('content')

{{-- ── Page Hero ── --}}
<section class="pg-hero">
    <div class="pg-hero-bg" style="background-image:url('https://images.unsplash.com/photo-1512436991641-6745cdb1723f?auto=format&fit=crop&w=1600&q=60')"></div>
    <div class="pg-hero-overlay"></div>
    <div class="container-xl pg-hero-content">
        <nav aria-label="breadcrumb" class="pg-breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span>/</span>
            <span>Contact</span>
        </nav>
        <h1 class="pg-hero-title">Get in Touch</h1>
        <p class="pg-hero-sub">We'd love to hear from you — our team typically responds within 24 hours</p>
    </div>
</section>

{{-- ── Info cards ── --}}
<div class="container-xl" style="margin-top:-2.5rem; position:relative; z-index:5">
    <div class="contact-info-grid">
        <div class="contact-info-card reveal">
            <div class="contact-info-icon" style="background:#ede9fe;color:#7c3aed">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            </div>
            <h5 class="contact-info-title">Email Us</h5>
            <p class="contact-info-text">support@sareebazaar.example</p>
            <a href="mailto:support@sareebazaar.example" class="contact-info-link">Send Email →</a>
        </div>
        <div class="contact-info-card reveal">
            <div class="contact-info-icon" style="background:#d1fae5;color:#059669">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.18 2 2 0 0 1 3.6 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.65a16 16 0 0 0 6 6l.86-.86a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21.71 16z"/></svg>
            </div>
            <h5 class="contact-info-title">Call Us</h5>
            <p class="contact-info-text">+880 1700 000 000</p>
            <a href="tel:+8801700000000" class="contact-info-link">Call Now →</a>
        </div>
        <div class="contact-info-card reveal">
            <div class="contact-info-icon" style="background:#fef3c7;color:#d97706">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
            </div>
            <h5 class="contact-info-title">Visit Us</h5>
            <p class="contact-info-text">Dhanmondi, Dhaka, Bangladesh</p>
            <a href="#" class="contact-info-link">View Map →</a>
        </div>
        <div class="contact-info-card reveal">
            <div class="contact-info-icon" style="background:#fee2e2;color:#dc2626">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <h5 class="contact-info-title">Working Hours</h5>
            <p class="contact-info-text">Sat – Thu: 9AM – 8PM</p>
            <span class="contact-info-link" style="cursor:default">Friday: Closed</span>
        </div>
    </div>
</div>

{{-- ── Form + Map ── --}}
<section class="sb-section">
    <div class="container-xl">
        <div class="row g-5 align-items-start">

            {{-- Form --}}
            <div class="col-lg-7 reveal">
                <div class="contact-form-card">
                    <div class="contact-form-header">
                        <p class="sb-section-eyebrow">Send a Message</p>
                        <h2 class="sb-section-title">We'll Reply Within 24 Hours</h2>
                    </div>

                    <form action="{{ route('contact.store') }}" method="POST" class="contact-form" id="contactForm">
                        @csrf
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <div class="cf-field">
                                    <label class="cf-label">Your Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="cf-input{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" placeholder="e.g. Fatema Khatun" required>
                                    @error('name')<div class="cf-error">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="cf-field">
                                    <label class="cf-label">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="cf-input{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" placeholder="you@example.com" required>
                                    @error('email')<div class="cf-error">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="cf-field">
                                    <label class="cf-label">Subject <span class="text-danger">*</span></label>
                                    <input type="text" name="subject" class="cf-input{{ $errors->has('subject') ? ' is-invalid' : '' }}" value="{{ old('subject') }}" placeholder="How can we help you?" required>
                                    @error('subject')<div class="cf-error">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="cf-field">
                                    <label class="cf-label">Message <span class="text-danger">*</span></label>
                                    <textarea name="message" rows="6" class="cf-input cf-textarea{{ $errors->has('message') ? ' is-invalid' : '' }}" placeholder="Tell us more about your inquiry…" required>{{ old('message') }}</textarea>
                                    @error('message')<div class="cf-error">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn sb-btn-primary w-100 py-3 fs-6">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-2"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                                    Send Message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Sidebar info --}}
            <div class="col-lg-5 reveal">
                {{-- Map placeholder --}}
                <div class="contact-map-placeholder mb-4">
                    <div class="contact-map-inner">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="color:var(--sb-primary)"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        <p class="mt-3 mb-1 fw-600" style="color:var(--sb-text)">Dhanmondi, Dhaka</p>
                        <p class="small text-muted">Bangladesh</p>
                    </div>
                </div>

                {{-- Social --}}
                <div class="contact-social-card">
                    <h5 class="contact-social-title">Follow Us</h5>
                    <p class="contact-social-sub">Stay updated with new collections and special offers</p>
                    <div class="d-flex gap-3 mt-3">
                        <a href="#" class="sb-social-icon" style="border-color:rgba(0,0,0,.1);color:var(--sb-text-muted)" aria-label="Facebook">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                        </a>
                        <a href="#" class="sb-social-icon" style="border-color:rgba(0,0,0,.1);color:var(--sb-text-muted)" aria-label="Instagram">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                        </a>
                        <a href="#" class="sb-social-icon" style="border-color:rgba(0,0,0,.1);color:var(--sb-text-muted)" aria-label="YouTube">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 0 0-1.95 1.96A29 29 0 0 0 1 12a29 29 0 0 0 .46 5.58 2.78 2.78 0 0 0 1.95 1.96C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 0 0 1.95-1.96A29 29 0 0 0 23 12a29 29 0 0 0-.46-5.58z"/><polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02" fill="currentColor"/></svg>
                        </a>
                    </div>
                </div>

                {{-- FAQ teaser --}}
                <div class="contact-faq-card mt-4">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--sb-primary)"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    <div>
                        <h6 class="mb-1 fw-700">Have a quick question?</h6>
                        <p class="small text-muted mb-0">Check our returns policy, delivery info, and payment methods in the footer links below.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

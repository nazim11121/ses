@extends('admin.layout')

@section('title', 'Access Denied')
@section('page-heading', 'Access Denied')

@section('content')
<div class="d-flex flex-column align-items-center justify-content-center py-5 text-center">
    <div style="font-size:5rem; line-height:1;">&#128274;</div>
    <h2 class="mt-3 fw-bold">403 &mdash; Access Denied</h2>
    <p class="text-muted mb-4">You do not have permission to access this page.<br>
       Please contact your administrator if you believe this is a mistake.</p>
    <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('admin.dashboard') }}"
       class="btn btn-outline-secondary">Go Back</a>
</div>
@endsection

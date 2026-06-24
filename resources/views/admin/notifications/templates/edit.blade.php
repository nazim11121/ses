@extends('admin.layout')

@section('title', 'Edit Template')
@section('page-heading', 'Edit Notification Template')

@section('content')
<div class="card border-0 shadow-sm" style="max-width:720px">
    <div class="card-body p-4">
        @if($errors->any())
            <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        @endif

        <form action="{{ route('admin.notifications.templates.update', $template) }}" method="POST">
            @csrf @method('PUT')

            <div class="row g-3">
                <div class="col-8">
                    <label class="form-label fw-semibold">Template Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $template->name) }}" required>
                </div>
                <div class="col-4">
                    <label class="form-label fw-semibold">Type</label>
                    <select name="type" id="tplType" class="form-select" required onchange="toggleSubject()">
                        <option value="mail" {{ old('type', $template->type) === 'mail' ? 'selected' : '' }}>Mail</option>
                        <option value="sms" {{ old('type', $template->type) === 'sms' ? 'selected' : '' }}>SMS</option>
                        <option value="both" {{ old('type', $template->type) === 'both' ? 'selected' : '' }}>Both</option>
                    </select>
                </div>

                <div class="col-12" id="subjectRow">
                    <label class="form-label fw-semibold">Subject</label>
                    <input type="text" name="subject" class="form-control" value="{{ old('subject', $template->subject) }}">
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Body</label>
                    <small class="text-muted d-block mb-1">Use <code>{variable}</code> for dynamic values.</small>
                    <textarea name="body" class="form-control" rows="8" required>{{ old('body', $template->body) }}</textarea>
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Available Variables <span class="text-muted">(comma-separated)</span></label>
                    <input type="text" name="variables" class="form-control"
                        value="{{ old('variables', $template->variables ? implode(', ', $template->variables) : '') }}">
                </div>

                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="isActive"
                            {{ old('is_active', $template->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="isActive">Active</label>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">Update Template</button>
                <a href="{{ route('admin.notifications.templates.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
function toggleSubject() {
    const type = document.getElementById('tplType').value;
    document.getElementById('subjectRow').style.display = type === 'sms' ? 'none' : '';
}
toggleSubject();
</script>
@endsection

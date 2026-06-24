@extends('admin.layout')

@section('title', 'Send Notification')
@section('page-heading', 'Send Notification')

@section('content')
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="row g-4">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('admin.notifications.send.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Channel</label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="channel" id="chMail" value="mail"
                                    {{ old('channel', 'mail') === 'mail' ? 'checked' : '' }} onchange="toggleChannel()">
                                <label class="form-check-label" for="chMail">Mail</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="channel" id="chSms" value="sms"
                                    {{ old('channel') === 'sms' ? 'checked' : '' }} onchange="toggleChannel()">
                                <label class="form-check-label" for="chSms">SMS</label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Recipient</label>
                        <div class="input-group">
                            <input type="text" name="recipient" id="recipientInput" class="form-control"
                                value="{{ old('recipient') }}" required
                                placeholder="Email address or phone number">
                            <button class="btn btn-outline-secondary" type="button" data-bs-toggle="modal" data-bs-target="#customerModal">
                                Pick Customer
                            </button>
                        </div>
                        @error('recipient')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Template <span class="text-muted">(optional)</span></label>
                        <select name="template_id" id="templateSelect" class="form-select" onchange="loadTemplate()">
                            <option value="">-- Write custom message --</option>
                            @foreach($templates as $tpl)
                                <option value="{{ $tpl->id }}"
                                    data-type="{{ $tpl->type }}"
                                    data-subject="{{ $tpl->subject }}"
                                    data-body="{{ $tpl->body }}"
                                    {{ old('template_id') == $tpl->id ? 'selected' : '' }}>
                                    {{ $tpl->name }} ({{ strtoupper($tpl->type) }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div id="subjectRow" class="mb-3">
                        <label class="form-label fw-semibold">Subject</label>
                        <input type="text" name="subject" class="form-control" value="{{ old('subject') }}" placeholder="Email subject">
                        @error('subject')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Message</label>
                        <textarea name="message" id="messageArea" class="form-control" rows="7"
                            placeholder="Write your message here...">{{ old('message') }}</textarea>
                        @error('message')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" class="btn btn-primary px-4">Send Now</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold py-3">Quick Stats</div>
            <div class="card-body">
                @php
                    $mailSent   = \App\Models\NotificationLog::mail()->sent()->count();
                    $mailFailed = \App\Models\NotificationLog::mail()->failed()->count();
                    $smsSent    = \App\Models\NotificationLog::sms()->sent()->count();
                    $smsFailed  = \App\Models\NotificationLog::sms()->failed()->count();
                @endphp
                <div class="row g-3 text-center">
                    <div class="col-6">
                        <div class="border rounded p-3">
                            <div class="h4 text-success mb-0">{{ $mailSent }}</div>
                            <small class="text-muted">Mails Sent</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="border rounded p-3">
                            <div class="h4 text-danger mb-0">{{ $mailFailed }}</div>
                            <small class="text-muted">Mails Failed</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="border rounded p-3">
                            <div class="h4 text-success mb-0">{{ $smsSent }}</div>
                            <small class="text-muted">SMS Sent</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="border rounded p-3">
                            <div class="h4 text-danger mb-0">{{ $smsFailed }}</div>
                            <small class="text-muted">SMS Failed</small>
                        </div>
                    </div>
                </div>
                <div class="mt-3 text-center">
                    <a href="{{ route('admin.notifications.logs') }}" class="btn btn-sm btn-outline-secondary">View All Logs</a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Customer picker modal --}}
<div class="modal fade" id="customerModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pick Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <div class="p-3 border-bottom">
                    <input type="text" id="customerSearch" class="form-control" placeholder="Search by name, email or phone..." oninput="filterCustomers()">
                </div>
                <div style="max-height:400px; overflow-y:auto">
                    <table class="table table-hover mb-0" id="customerTable">
                        <thead class="table-light sticky-top"><tr><th>Name</th><th>Email</th><th>Phone</th><th></th></tr></thead>
                        <tbody>
                            @foreach($customers as $c)
                            <tr>
                                <td>{{ $c->customer_name }}</td>
                                <td>{{ $c->customer_email }}</td>
                                <td>{{ $c->customer_phone }}</td>
                                <td>
                                    @if($c->customer_email)
                                    <button class="btn btn-sm btn-outline-primary me-1" onclick="pickRecipient('{{ $c->customer_email }}', 'mail')">Email</button>
                                    @endif
                                    @if($c->customer_phone)
                                    <button class="btn btn-sm btn-outline-success" onclick="pickRecipient('{{ $c->customer_phone }}', 'sms')">SMS</button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleChannel() {
    const isMail = document.getElementById('chMail').checked;
    document.getElementById('subjectRow').style.display = isMail ? '' : 'none';
    document.getElementById('recipientInput').placeholder = isMail ? 'Email address' : 'Phone number (e.g. +8801XXXXXXXXX)';
}

function loadTemplate() {
    const sel = document.getElementById('templateSelect');
    const opt = sel.options[sel.selectedIndex];
    if (!opt.value) return;
    document.getElementById('messageArea').value = opt.dataset.body || '';
    const subjectInput = document.querySelector('input[name="subject"]');
    if (subjectInput) subjectInput.value = opt.dataset.subject || '';
}

function pickRecipient(value, channel) {
    document.getElementById('recipientInput').value = value;
    if (channel === 'sms') {
        document.getElementById('chSms').checked = true;
    } else {
        document.getElementById('chMail').checked = true;
    }
    toggleChannel();
    bootstrap.Modal.getInstance(document.getElementById('customerModal')).hide();
}

function filterCustomers() {
    const q = document.getElementById('customerSearch').value.toLowerCase();
    document.querySelectorAll('#customerTable tbody tr').forEach(tr => {
        tr.style.display = tr.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
}

toggleChannel();
</script>
@endsection

@extends('admin.layout')

@section('title', 'Add Notification Setting')
@section('page-heading', 'Add Notification Setting')

@section('content')
<div class="card border-0 shadow-sm" style="max-width:680px">
    <div class="card-body p-4">
        @if($errors->any())
            <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        @endif

        <form action="{{ route('admin.notifications.settings.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold">Type</label>
                <select name="type" id="typeSelect" class="form-select" required onchange="toggleDriverFields()">
                    <option value="">-- Select Type --</option>
                    <option value="mail" {{ old('type') === 'mail' ? 'selected' : '' }}>Mail</option>
                    <option value="sms" {{ old('type') === 'sms' ? 'selected' : '' }}>SMS</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Driver</label>
                <select name="driver" id="driverSelect" class="form-select" required onchange="showFields()">
                    <option value="">-- Select Driver --</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Label</label>
                <input type="text" name="label" class="form-control" value="{{ old('label') }}" placeholder="e.g. Primary SMTP, Marketing SMS" required>
            </div>

            {{-- Mail: SMTP fields --}}
            <div id="fields-smtp" class="driver-fields d-none">
                <h6 class="text-muted mb-3">SMTP Configuration</h6>
                <div class="row g-3">
                    <div class="col-8"><label class="form-label">Host</label><input type="text" name="host" class="form-control" value="{{ old('host') }}" placeholder="smtp.gmail.com"></div>
                    <div class="col-4"><label class="form-label">Port</label><input type="number" name="port" class="form-control" value="{{ old('port', 587) }}"></div>
                    <div class="col-6"><label class="form-label">Username</label><input type="text" name="username" class="form-control" value="{{ old('username') }}"></div>
                    <div class="col-6"><label class="form-label">Password</label><input type="password" name="password" class="form-control"></div>
                    <div class="col-6">
                        <label class="form-label">Encryption</label>
                        <select name="encryption" class="form-select">
                            <option value="tls" {{ old('encryption') === 'tls' ? 'selected' : '' }}>TLS</option>
                            <option value="ssl" {{ old('encryption') === 'ssl' ? 'selected' : '' }}>SSL</option>
                            <option value="" {{ old('encryption') === '' ? 'selected' : '' }}>None</option>
                        </select>
                    </div>
                    <div class="col-6"><label class="form-label">From Address</label><input type="email" name="from_address" class="form-control" value="{{ old('from_address') }}"></div>
                    <div class="col-6"><label class="form-label">From Name</label><input type="text" name="from_name" class="form-control" value="{{ old('from_name') }}"></div>
                </div>
            </div>

            {{-- Mail: Mailgun fields --}}
            <div id="fields-mailgun" class="driver-fields d-none">
                <h6 class="text-muted mb-3">Mailgun Configuration</h6>
                <div class="row g-3">
                    <div class="col-12"><label class="form-label">Domain</label><input type="text" name="domain" class="form-control" value="{{ old('domain') }}" placeholder="mg.example.com"></div>
                    <div class="col-12"><label class="form-label">API Secret</label><input type="text" name="secret" class="form-control" value="{{ old('secret') }}"></div>
                    <div class="col-6"><label class="form-label">Endpoint</label><input type="text" name="endpoint" class="form-control" value="{{ old('endpoint', 'api.mailgun.net') }}"></div>
                    <div class="col-6"><label class="form-label">From Address</label><input type="email" name="from_address" class="form-control" value="{{ old('from_address') }}"></div>
                    <div class="col-6"><label class="form-label">From Name</label><input type="text" name="from_name" class="form-control" value="{{ old('from_name') }}"></div>
                </div>
            </div>

            {{-- Mail: SES fields --}}
            <div id="fields-ses" class="driver-fields d-none">
                <h6 class="text-muted mb-3">Amazon SES Configuration</h6>
                <div class="row g-3">
                    <div class="col-12"><label class="form-label">Access Key</label><input type="text" name="key" class="form-control" value="{{ old('key') }}"></div>
                    <div class="col-12"><label class="form-label">Secret</label><input type="password" name="secret" class="form-control"></div>
                    <div class="col-6"><label class="form-label">Region</label><input type="text" name="region" class="form-control" value="{{ old('region', 'us-east-1') }}"></div>
                    <div class="col-6"><label class="form-label">From Address</label><input type="email" name="from_address" class="form-control" value="{{ old('from_address') }}"></div>
                    <div class="col-6"><label class="form-label">From Name</label><input type="text" name="from_name" class="form-control" value="{{ old('from_name') }}"></div>
                </div>
            </div>

            {{-- SMS: SSL Wireless --}}
            <div id="fields-ssl_wireless" class="driver-fields d-none">
                <h6 class="text-muted mb-3">SSL Wireless Configuration</h6>
                <div class="row g-3">
                    <div class="col-12"><label class="form-label">API Token</label><input type="text" name="api_token" class="form-control" value="{{ old('api_token') }}"></div>
                    <div class="col-12"><label class="form-label">SID (Sender ID)</label><input type="text" name="sid" class="form-control" value="{{ old('sid') }}"></div>
                </div>
            </div>

            {{-- SMS: Twilio --}}
            <div id="fields-twilio" class="driver-fields d-none">
                <h6 class="text-muted mb-3">Twilio Configuration</h6>
                <div class="row g-3">
                    <div class="col-12"><label class="form-label">Account SID</label><input type="text" name="account_sid" class="form-control" value="{{ old('account_sid') }}"></div>
                    <div class="col-12"><label class="form-label">Auth Token</label><input type="password" name="auth_token" class="form-control"></div>
                    <div class="col-12"><label class="form-label">From Number</label><input type="text" name="from" class="form-control" value="{{ old('from') }}" placeholder="+1234567890"></div>
                </div>
            </div>

            {{-- SMS: Infobip --}}
            <div id="fields-infobip" class="driver-fields d-none">
                <h6 class="text-muted mb-3">Infobip Configuration</h6>
                <div class="row g-3">
                    <div class="col-12"><label class="form-label">API Key</label><input type="text" name="api_key" class="form-control" value="{{ old('api_key') }}"></div>
                    <div class="col-12"><label class="form-label">Base URL</label><input type="text" name="base_url" class="form-control" value="{{ old('base_url', 'https://api.infobip.com') }}"></div>
                    <div class="col-12"><label class="form-label">Sender</label><input type="text" name="sender" class="form-control" value="{{ old('sender') }}"></div>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">Save Setting</button>
                <a href="{{ route('admin.notifications.settings.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
const mailDrivers = [
    { value: 'smtp', label: 'SMTP' },
    { value: 'mailgun', label: 'Mailgun' },
    { value: 'ses', label: 'Amazon SES' },
];
const smsDrivers = [
    { value: 'ssl_wireless', label: 'SSL Wireless' },
    { value: 'twilio', label: 'Twilio' },
    { value: 'infobip', label: 'Infobip' },
];

function toggleDriverFields() {
    const type = document.getElementById('typeSelect').value;
    const driverSel = document.getElementById('driverSelect');
    driverSel.innerHTML = '<option value="">-- Select Driver --</option>';
    const drivers = type === 'mail' ? mailDrivers : (type === 'sms' ? smsDrivers : []);
    drivers.forEach(d => {
        const opt = document.createElement('option');
        opt.value = d.value; opt.text = d.label;
        driverSel.appendChild(opt);
    });
    document.querySelectorAll('.driver-fields').forEach(el => el.classList.add('d-none'));
}

function showFields() {
    const driver = document.getElementById('driverSelect').value;
    document.querySelectorAll('.driver-fields').forEach(el => el.classList.add('d-none'));
    if (driver) {
        const el = document.getElementById('fields-' + driver);
        if (el) el.classList.remove('d-none');
    }
}

// Restore old values on page reload
const oldType = '{{ old('type') }}';
const oldDriver = '{{ old('driver') }}';
if (oldType) {
    document.getElementById('typeSelect').value = oldType;
    toggleDriverFields();
    if (oldDriver) {
        document.getElementById('driverSelect').value = oldDriver;
        showFields();
    }
}
</script>
@endsection

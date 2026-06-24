<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NotificationLog;
use App\Models\NotificationSetting;
use App\Models\NotificationTemplate;
use App\Models\Order;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    private NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    // ───────────────── Settings ─────────────────

    public function settingsIndex()
    {
        $settings = NotificationSetting::latest()->get();
        return view('admin.notifications.settings.index', compact('settings'));
    }

    public function settingsCreate()
    {
        return view('admin.notifications.settings.create');
    }

    public function settingsStore(Request $request)
    {
        $data = $request->validate([
            'type'   => 'required|in:mail,sms',
            'driver' => 'required|string',
            'label'  => 'required|string|max:255',
        ]);

        $settings = $this->extractDriverSettings($request);
        $data['settings']   = $settings;
        $data['is_active']  = false;

        NotificationSetting::create($data);

        return redirect()->route('admin.notifications.settings.index')
            ->with('success', 'Notification setting created successfully.');
    }

    public function settingsEdit(NotificationSetting $setting)
    {
        return view('admin.notifications.settings.edit', compact('setting'));
    }

    public function settingsUpdate(Request $request, NotificationSetting $setting)
    {
        $data = $request->validate([
            'type'   => 'required|in:mail,sms',
            'driver' => 'required|string',
            'label'  => 'required|string|max:255',
        ]);

        $data['settings']  = $this->extractDriverSettings($request);
        $data['is_active'] = $setting->is_active;

        $setting->update($data);

        return redirect()->route('admin.notifications.settings.index')
            ->with('success', 'Notification setting updated successfully.');
    }

    public function settingsActivate(NotificationSetting $setting)
    {
        // Deactivate all settings of the same type, then activate this one
        NotificationSetting::where('type', $setting->type)->update(['is_active' => false]);
        $setting->update(['is_active' => true]);

        return redirect()->route('admin.notifications.settings.index')
            ->with('success', ucfirst($setting->type) . ' setting "' . $setting->label . '" is now active.');
    }

    public function settingsDestroy(NotificationSetting $setting)
    {
        $setting->delete();
        return redirect()->route('admin.notifications.settings.index')
            ->with('success', 'Setting deleted.');
    }

    // ───────────────── Templates ─────────────────

    public function templatesIndex()
    {
        $templates = NotificationTemplate::latest()->get();
        return view('admin.notifications.templates.index', compact('templates'));
    }

    public function templatesCreate()
    {
        return view('admin.notifications.templates.create');
    }

    public function templatesStore(Request $request)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'type'      => 'required|in:mail,sms,both',
            'subject'   => 'nullable|string|max:255',
            'body'      => 'required|string',
            'variables' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
        ]);

        $data['variables'] = $data['variables']
            ? array_map('trim', explode(',', $data['variables']))
            : [];
        $data['is_active'] = $request->boolean('is_active', true);

        NotificationTemplate::create($data);

        return redirect()->route('admin.notifications.templates.index')
            ->with('success', 'Template created successfully.');
    }

    public function templatesEdit(NotificationTemplate $template)
    {
        return view('admin.notifications.templates.edit', compact('template'));
    }

    public function templatesUpdate(Request $request, NotificationTemplate $template)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'type'      => 'required|in:mail,sms,both',
            'subject'   => 'nullable|string|max:255',
            'body'      => 'required|string',
            'variables' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
        ]);

        $data['variables'] = $data['variables']
            ? array_map('trim', explode(',', $data['variables']))
            : [];
        $data['is_active'] = $request->boolean('is_active');

        $template->update($data);

        return redirect()->route('admin.notifications.templates.index')
            ->with('success', 'Template updated successfully.');
    }

    public function templatesDestroy(NotificationTemplate $template)
    {
        $template->delete();
        return redirect()->route('admin.notifications.templates.index')
            ->with('success', 'Template deleted.');
    }

    // ───────────────── Send ─────────────────

    public function sendIndex()
    {
        $templates = NotificationTemplate::where('is_active', true)->get();
        $customers = Order::select('customer_name', 'customer_email', 'customer_phone')
            ->distinct()
            ->get();

        return view('admin.notifications.send', compact('templates', 'customers'));
    }

    public function sendStore(Request $request)
    {
        $request->validate([
            'channel'     => 'required|in:mail,sms',
            'recipient'   => 'required|string',
            'template_id' => 'nullable|integer|exists:notification_templates,id',
            'subject'     => 'nullable|string|max:255',
            'message'     => 'required_without:template_id|nullable|string',
        ]);

        $channel   = $request->channel;
        $recipient = $request->recipient;

        if ($request->template_id) {
            $log = $this->notificationService->sendFromTemplate($channel, $recipient, $request->template_id);
        } elseif ($channel === 'mail') {
            $log = $this->notificationService->sendMail($recipient, $request->subject ?? '(no subject)', $request->message);
        } else {
            $log = $this->notificationService->sendSms($recipient, $request->message);
        }

        $flash = $log->status === 'sent'
            ? 'success:Notification sent successfully.'
            : 'error:Failed to send: ' . $log->error;

        [$key, $msg] = explode(':', $flash, 2);
        return redirect()->route('admin.notifications.send')->with($key, $msg);
    }

    // ───────────────── Logs ─────────────────

    public function logsIndex(Request $request)
    {
        $query = NotificationLog::with(['setting', 'template'])->latest();

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where('recipient', 'like', '%' . $request->search . '%');
        }

        $logs = $query->paginate(25)->withQueryString();

        return view('admin.notifications.logs', compact('logs'));
    }

    public function logsDestroy(NotificationLog $log)
    {
        $log->delete();
        return back()->with('success', 'Log entry deleted.');
    }

    // ───────────────── Helpers ─────────────────

    private function extractDriverSettings(Request $request): array
    {
        $all = $request->except(['_token', '_method', 'type', 'driver', 'label', 'is_active']);
        // Only return non-empty values
        return array_filter($all, fn($v) => $v !== null && $v !== '');
    }
}

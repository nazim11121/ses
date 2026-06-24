<?php

namespace App\Services;

use App\Mail\DynamicMail;
use App\Models\NotificationLog;
use App\Models\NotificationSetting;
use App\Models\NotificationTemplate;
use App\Notifications\Sms\Drivers\InfobipDriver;
use App\Notifications\Sms\Drivers\SslWirelessDriver;
use App\Notifications\Sms\Drivers\TwilioDriver;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class NotificationService
{
    private const SMS_DRIVERS = [
        'ssl_wireless' => SslWirelessDriver::class,
        'twilio'       => TwilioDriver::class,
        'infobip'      => InfobipDriver::class,
    ];

    public function sendMail(string $recipient, string $subject, string $body, ?NotificationSetting $setting = null, ?NotificationTemplate $template = null): NotificationLog
    {
        $setting = $setting ?? NotificationSetting::activeFor('mail');

        if ($setting) {
            $this->applyMailConfig($setting);
        }

        $log = new NotificationLog([
            'type'                     => 'mail',
            'driver'                   => $setting ? $setting->driver : config('mail.default'),
            'recipient'                => $recipient,
            'subject'                  => $subject,
            'message'                  => $body,
            'notification_setting_id'  => $setting ? $setting->id : null,
            'notification_template_id' => $template ? $template->id : null,
        ]);

        try {
            Mail::to($recipient)->send(new DynamicMail($subject, $body));
            $log->status  = 'sent';
            $log->sent_at = now();
        } catch (\Throwable $e) {
            $log->status = 'failed';
            $log->error  = $e->getMessage();
        }

        $log->save();
        return $log;
    }

    public function sendSms(string $recipient, string $message, ?NotificationSetting $setting = null, ?NotificationTemplate $template = null): NotificationLog
    {
        $setting = $setting ?? NotificationSetting::activeFor('sms');

        $log = new NotificationLog([
            'type'                     => 'sms',
            'driver'                   => $setting ? $setting->driver : 'none',
            'recipient'                => $recipient,
            'message'                  => $message,
            'notification_setting_id'  => $setting ? $setting->id : null,
            'notification_template_id' => $template ? $template->id : null,
        ]);

        if (! $setting) {
            $log->status = 'failed';
            $log->error  = 'No active SMS setting configured.';
            $log->save();
            return $log;
        }

        $driverClass = self::SMS_DRIVERS[$setting->driver] ?? null;

        if (! $driverClass) {
            $log->status = 'failed';
            $log->error  = "SMS driver [{$setting->driver}] is not supported.";
            $log->save();
            return $log;
        }

        $driver = new $driverClass($setting->settings ?? []);
        $result = $driver->send($recipient, $message);

        $log->status  = $result['success'] ? 'sent' : 'failed';
        $log->error   = $result['error'];
        $log->sent_at = $result['success'] ? now() : null;
        $log->save();

        return $log;
    }

    public function sendFromTemplate(string $type, string $recipient, int $templateId, array $data = []): NotificationLog
    {
        $template = NotificationTemplate::findOrFail($templateId);
        $body     = $template->render($data);

        if ($type === 'mail') {
            $subject = $template->renderSubject($data);
            return $this->sendMail($recipient, $subject, $body, null, $template);
        }

        return $this->sendSms($recipient, $body, null, $template);
    }

    private function applyMailConfig(NotificationSetting $setting): void
    {
        $s      = $setting->settings;
        $driver = $setting->driver;

        Config::set('mail.default', $driver);

        if ($driver === 'smtp') {
            Config::set('mail.mailers.smtp', [
                'transport'  => 'smtp',
                'host'       => $s['host'] ?? '127.0.0.1',
                'port'       => $s['port'] ?? 587,
                'encryption' => $s['encryption'] ?? 'tls',
                'username'   => $s['username'] ?? null,
                'password'   => $s['password'] ?? null,
                'timeout'    => null,
            ]);
        } elseif ($driver === 'mailgun') {
            Config::set('services.mailgun.domain', $s['domain'] ?? '');
            Config::set('services.mailgun.secret', $s['secret'] ?? '');
            Config::set('services.mailgun.endpoint', $s['endpoint'] ?? 'api.mailgun.net');
        } elseif ($driver === 'ses') {
            Config::set('services.ses.key', $s['key'] ?? '');
            Config::set('services.ses.secret', $s['secret'] ?? '');
            Config::set('services.ses.region', $s['region'] ?? 'us-east-1');
        }

        Config::set('mail.from.address', $s['from_address'] ?? config('mail.from.address'));
        Config::set('mail.from.name', $s['from_name'] ?? config('mail.from.name'));
    }
}

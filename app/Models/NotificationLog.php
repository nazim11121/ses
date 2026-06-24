<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationLog extends Model
{
    protected $fillable = [
        'type', 'driver', 'recipient', 'subject', 'message',
        'status', 'error', 'notification_setting_id', 'notification_template_id', 'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function setting()
    {
        return $this->belongsTo(NotificationSetting::class, 'notification_setting_id');
    }

    public function template()
    {
        return $this->belongsTo(NotificationTemplate::class, 'notification_template_id');
    }

    public function scopeSent($query)
    {
        return $query->where('status', 'sent');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopeMail($query)
    {
        return $query->where('type', 'mail');
    }

    public function scopeSms($query)
    {
        return $query->where('type', 'sms');
    }
}

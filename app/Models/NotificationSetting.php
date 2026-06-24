<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationSetting extends Model
{
    protected $fillable = ['type', 'driver', 'label', 'settings', 'is_active'];

    protected $casts = [
        'settings' => 'array',
        'is_active' => 'boolean',
    ];

    public function logs()
    {
        return $this->hasMany(NotificationLog::class);
    }

    public static function activeFor(string $type): ?self
    {
        return static::where('type', $type)->where('is_active', true)->first();
    }
}

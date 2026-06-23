<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'active' => 'boolean',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function hasRole(string $slug): bool
    {
        static $cache = [];
        $key = $this->id . ':' . $slug;
        if (!isset($cache[$key])) {
            $cache[$key] = $this->roles()->where('slug', $slug)->exists();
        }
        return $cache[$key];
    }

    public function allPermissionSlugs(): array
    {
        static $cache = [];
        if (!isset($cache[$this->id])) {
            $fromRoles = $this->roles()
                ->with('permissions')
                ->get()
                ->flatMap(fn($role) => $role->permissions->pluck('slug'));

            $direct = $this->permissions()->pluck('slug');

            $cache[$this->id] = $fromRoles->concat($direct)->unique()->values()->toArray();
        }
        return $cache[$this->id];
    }

    public function hasPermission(string $slug): bool
    {
        return in_array($slug, $this->allPermissionSlugs());
    }
}

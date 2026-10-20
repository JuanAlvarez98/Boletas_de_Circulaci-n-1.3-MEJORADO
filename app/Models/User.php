<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'username', 'password', 'two_factor_code',
        'two_factor_expires_at', 'two_factor_sent_at', 'two_factor_attempts', 'two_factor_secret',
        'two_factor_recovery_codes', 'disabled_at'];

    protected $hidden = ['password', 'remember_token', 'two_factor_code', 'two_factor_secret', 'two_factor_recovery_codes'];

    protected function casts(): array
    {
        return ['email_verified_at' => 'datetime', 'password' => 'hashed', 'two_factor_expires_at' => 'datetime',
            'two_factor_sent_at' => 'datetime', 'two_factor_attempts' => 'integer', 'disabled_at' => 'datetime'];
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasRole(string|array $role): bool
    {
        return $this->hasAnyRole((array) $role);
    }

    public function hasAnyRole(array $roles): bool
    {
        // Compatibilidad bidireccional entre "operator" y "operador-emisor"
        $normalizedRoles = [];
        foreach ($roles as $role) {
            $normalizedRoles[] = $role;
            if ($role === 'operator') {
                $normalizedRoles[] = 'operador-emisor';
            } elseif ($role === 'operador-emisor') {
                $normalizedRoles[] = 'operator';
            }
        }

        return $this->roles()->whereIn('slug', array_unique($normalizedRoles))->exists();
    }
}

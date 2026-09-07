<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, HasUuids, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'region',
        'phone',
        'avatar_url',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // Filament: Control de acceso a paneles
    public function canAccessPanel(Panel $panel): bool
    {
        return match ($panel->getId()) {
            'admin'   => in_array($this->role, ['admin']) && $this->is_active,
            'coach'   => in_array($this->role, ['coach', 'admin']) && $this->is_active,
            'manager' => in_array($this->role, ['manager', 'admin']) && $this->is_active,
            'trainee' => in_array($this->role, ['trainee']) && $this->is_active,
            default   => false,
        };
    }

    // Relaciones
    public function trainingProgram()
    {
        return $this->hasOne(TrainingProgram::class, 'trainee_id');
    }

    public function coachedPrograms()
    {
        return $this->hasMany(TrainingProgram::class, 'coach_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    // Helpers
    public function isTrainee(): bool
    {
        return $this->role === 'trainee';
    }

    public function isCoach(): bool
    {
        return $this->role === 'coach';
    }

    public function isManager(): bool
    {
        return $this->role === 'manager';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // Scopes
    public function scopeTrainees($query)
    {
        return $query->where('role', 'trainee')->where('is_active', true);
    }

    public function scopeCoaches($query)
    {
        return $query->where('role', 'coach')->where('is_active', true);
    }

    public function scopeByRegion($query, string $region)
    {
        return $query->where('region', $region);
    }
}

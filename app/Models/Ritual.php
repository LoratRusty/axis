<?php
// app/Models/Ritual.php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Ritual extends Model
{
    use HasUuids;

    protected $fillable = [
        'number',
        'name',
        'description',
        'phase_id',
        'tool',
        'frequency',
        'evidence_type',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function phase()
    {
        return $this->belongsTo(ProgramPhase::class, 'phase_id');
    }

    public function evidences()
    {
        return $this->hasMany(Evidence::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByPhase($query, string $phaseCode)
    {
        return $query->whereHas('phase', fn($q) => $q->where('code', $phaseCode));
    }
}
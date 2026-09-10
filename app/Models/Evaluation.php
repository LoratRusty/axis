<?php
// app/Models/Evaluation.php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasUuids;

    protected $fillable = [
        'program_id',
        'weekly_tracking_id',
        'coach_id',
        'instrument',
        'ritual_id',

        'evidence_status',
        'frequency_level',
        'frequency_pct',
        'quality_level',

        'field_observed',
        'field_notes',

        'strengths',
        'gaps',
        'improvement_action',

        'overall_score',
        'next_cycle_focus',
        'advance_to_next',

        'dimension_focus',
        'evaluated_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'frequency_pct'   => 'decimal:2',
            'quality_level'   => 'integer',
            'field_observed'  => 'boolean',
            'overall_score'   => 'decimal:2',
            'advance_to_next' => 'boolean',
            'evaluated_at'    => 'datetime',
        ];
    }

    // Relaciones
    public function trainingProgram()
    {
        return $this->belongsTo(TrainingProgram::class, 'program_id');
    }

    public function weeklyTracking()
    {
        return $this->belongsTo(WeeklyTracking::class, 'weekly_tracking_id');
    }

    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id');
    }

    public function ritual()
    {
        return $this->belongsTo(Ritual::class);
    }

    public function ritualScores()
    {
        return $this->hasMany(EvaluationRitualScore::class);
    }

    // Scopes
    public function scopeByInstrument($query, string $instrument)
    {
        return $query->where('instrument', $instrument);
    }

    public function scopeQuality($query)
    {
        return $query->where('instrument', 'I3');
    }
}
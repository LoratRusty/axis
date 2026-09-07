<?php
// app/Models/WeeklyTracking.php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class WeeklyTracking extends Model
{
    use HasUuids;

    protected $table = 'weekly_tracking';

    protected $fillable = [
        'program_id',
        'week_number',
        'week_start_date',
        'week_end_date',
        'target_interactions',
        'actual_interactions',
        'rituals_target',
        'rituals_completed',
        'evidences_target',
        'evidences_uploaded',
        'status',
        'coach_reviewed',
        'coach_reviewed_at',
        'coach_reviewed_by',
        'stage_at_start',
        'subrole_at_start',
        'dimension_at_start',
    ];

    protected function casts(): array
    {
        return [
            'week_start_date' => 'date',
            'week_end_date' => 'date',
            'coach_reviewed' => 'boolean',
            'coach_reviewed_at' => 'datetime',
        ];
    }

    public function trainingProgram()
    {
        return $this->belongsTo(TrainingProgram::class, 'program_id');
    }

    public function evidences()
    {
        return $this->hasMany(Evidence::class, 'weekly_tracking_id');
    }

    public function fieldInteractions()
    {
        return $this->hasMany(FieldInteraction::class, 'weekly_tracking_id');
    }

    public function reviewedBy()
    {
        return $this->belongsTo(User::class, 'coach_reviewed_by');
    }

    // Métodos de cálculo
    public function recalculateInteractions(): void
    {
        $this->actual_interactions = $this->fieldInteractions()
            ->where('is_valid', true)
            ->count();
        $this->save();
    }

    public function recalculateEvidences(): void
    {
        $this->evidences_uploaded = $this->evidences()->count();
        $this->save();
    }
}
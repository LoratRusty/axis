<?php
// app/Models/TrainingProgram.php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingProgram extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = [
        'trainee_id',
        'coach_id',
        'start_date',
        'current_week',
        'current_stage',
        'current_subrole',
        'status',
        'notes',
        'promotion_recommended_at',
        'promotion_recommended_by',
        'promotion_recommendation_notes',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'promotion_recommended_at' => 'datetime',
        ];
    }

    // Relaciones
    public function trainee()
    {
        return $this->belongsTo(User::class, 'trainee_id');
    }

    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id');
    }

    public function weeklyTrackings()
    {
        return $this->hasMany(WeeklyTracking::class, 'program_id');
    }

    public function currentWeekTracking()
    {
        return $this->hasOne(WeeklyTracking::class, 'program_id')
            ->where('status', 'in_progress');
    }

    public function evidences()
    {
        return $this->hasMany(Evidence::class, 'program_id');
    }

    public function fieldInteractions()
    {
        return $this->hasMany(FieldInteraction::class, 'program_id');
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class, 'program_id');
    }

    public function feedbackSessions()
    {
        return $this->hasMany(FeedbackSession::class, 'program_id');
    }

    public function subroleAchievements()
    {
        return $this->hasMany(SubroleAchievement::class, 'program_id')
            ->orderBy('accredited_date');
    }

    public function kpiSnapshots()
    {
        return $this->hasMany(KpiSnapshot::class, 'program_id')
            ->orderBy('snapshot_date');
    }

    // Helpers
    public function getWeeklyInteractionTarget(): int
    {
        return match (true) {
            $this->current_week <= 4  => 1,
            $this->current_week <= 9  => 3,
            $this->current_week <= 16 => 5,
            $this->current_week <= 24 => 7,
            default                   => 8,
        };
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByCoach($query, string $coachId)
    {
        return $query->where('coach_id', $coachId);
    }

    public function scopeByStage($query, string $stage)
    {
        return $query->where('current_stage', $stage);
    }

    public function promotionRecommendedBy()
    {
        return $this->belongsTo(User::class, 'promotion_recommended_by');
    }

    public function hasPromotionPending(): bool
    {
        return $this->promotion_recommended_at !== null
            && $this->status === 'active';
    }
}

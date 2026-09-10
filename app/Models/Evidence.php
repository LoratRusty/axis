<?php
// app/Models/Evidence.php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Evidence extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'evidences';

    protected $fillable = [
        'program_id',
        'weekly_tracking_id',
        'ritual_id',
        'uploaded_by',
        'title',
        'description',
        'evidence_type',
        'file_path',
        'file_url',
        'external_url',
        'file_name',
        'file_mime',
        'file_size_kb',
        'status',
        'coach_notes',
        'self_assessment_score',
        'reviewed_by',
        'reviewed_at',
    ];

    protected function casts(): array
    {
        return [
            'reviewed_at'           => 'datetime',
            'self_assessment_score' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::created(function (Evidence $evidence) {
            $evidence->weeklyTracking->recalculateEvidences();
        });

        static::deleted(function (Evidence $evidence) {
            $evidence->weeklyTracking->recalculateEvidences();
        });
    }

    public function trainingProgram()
    {
        return $this->belongsTo(TrainingProgram::class, 'program_id');
    }

    public function weeklyTracking()
    {
        return $this->belongsTo(WeeklyTracking::class, 'weekly_tracking_id');
    }

    public function ritual()
    {
        return $this->belongsTo(Ritual::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function scopePendingReview($query)
    {
        return $query->where('status', 'pending_review');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }
}
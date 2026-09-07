<?php
// app/Models/FeedbackSession.php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class FeedbackSession extends Model
{
    use HasUuids;

    protected $table = 'feedback_sessions';

    protected $fillable = [
        'program_id',
        'coach_id',
        'session_type',
        'session_date',
        'strengths',
        'gaps',
        'single_action',
        'ritual_focus',
        'next_steps',
        'trainee_ack',
    ];

    protected function casts(): array
    {
        return [
            'session_date' => 'datetime',
            'next_steps'   => 'array',
            'trainee_ack'  => 'boolean',
        ];
    }

    // Relaciones
    public function trainingProgram()
    {
        return $this->belongsTo(TrainingProgram::class, 'program_id');
    }

    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id');
    }

    public function ritual()
    {
        return $this->belongsTo(Ritual::class, 'ritual_focus');
    }

    // Helpers
    public function acknowledge(): void
    {
        $this->update(['trainee_ack' => true]);
    }

    // Scope
    public function scopePending($query)
    {
        return $query->where('trainee_ack', false);
    }
}
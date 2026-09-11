<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class TraineeRitualScore extends Model
{
    use HasUuids;

    protected $table = 'trainee_ritual_scores';

    protected $fillable = [
        'program_id',
        'weekly_tracking_id',
        'ritual_id',
        'score',
        'notes',
    ];

    protected function casts(): array
    {
        return ['score' => 'integer'];
    }

    public function trainingProgram()
    {
        return $this->belongsTo(TrainingProgram::class, 'program_id');
    }

    public function weeklyTracking()
    {
        return $this->belongsTo(WeeklyTracking::class);
    }

    public function ritual()
    {
        return $this->belongsTo(Ritual::class);
    }
}
<?php
// app/Models/EvaluationRitualScore.php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class EvaluationRitualScore extends Model
{
    use HasUuids;

    protected $table = 'evaluation_ritual_scores';

    protected $fillable = [
        'evaluation_id',
        'ritual_id',
        'score',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'score' => 'integer',
        ];
    }

    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class);
    }

    public function ritual()
    {
        return $this->belongsTo(Ritual::class);
    }
}
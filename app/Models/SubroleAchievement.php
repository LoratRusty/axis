<?php
// app/Models/SubroleAchievement.php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class SubroleAchievement extends Model
{
    use HasUuids;

    protected $table = 'subrole_achievements';
    
    protected $fillable = [
        'program_id',
        'subrole',
        'accredited_date',
        'accredited_by',
        'evidence_summary',
        'kpis_at_accreditation',
    ];

    protected function casts(): array
    {
        return [
            'accredited_date'       => 'date',
            'kpis_at_accreditation' => 'array',
        ];
    }

    // Relaciones
    public function trainingProgram()
    {
        return $this->belongsTo(TrainingProgram::class, 'program_id');
    }

    public function accreditedBy()
    {
        return $this->belongsTo(User::class, 'accredited_by');
    }
}
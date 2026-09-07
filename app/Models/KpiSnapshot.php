<?php
// app/Models/KpiSnapshot.php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class KpiSnapshot extends Model
{
    use HasUuids;

    protected $table = 'kpi_snapshots';

    protected $fillable = [
        'program_id',
        'snapshot_date',
        'week_number',
        'weekly_interactions',
        'total_interactions',
        'spiced_opportunities',
        'mutual_agreements',
        'win_rate',
        'arr_consumables',
        'current_dimension',
        'current_phase',
        'advancement_recommendation',
    ];

    protected function casts(): array
    {
        return [
            'snapshot_date'       => 'date',
            'weekly_interactions' => 'integer',
            'total_interactions'  => 'integer',
            'spiced_opportunities'=> 'integer',
            'mutual_agreements'   => 'integer',
            'win_rate'            => 'decimal:2',
            'arr_consumables'     => 'decimal:2',
        ];
    }

    public function trainingProgram()
    {
        return $this->belongsTo(TrainingProgram::class, 'program_id');
    }
}
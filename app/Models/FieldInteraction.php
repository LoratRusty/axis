<?php
// app/Models/FieldInteraction.php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FieldInteraction extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'field_interactions';

    protected $fillable = [
        'program_id',
        'weekly_tracking_id',
        'client_name',
        'client_account',
        'opportunity_name',
        'leader_approval',
        'visit_date',
        'visit_type',
        'is_in_matrix',
        'is_scheduled',
        'is_presential',
        'crm_registered',
        'has_artifacts',
        'is_valid',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'visit_date'    => 'date',
            'is_in_matrix'  => 'boolean',
            'is_scheduled'  => 'boolean',
            'is_presential' => 'boolean',
            'crm_registered'=> 'boolean',
            'has_artifacts' => 'boolean',
            'is_valid'      => 'boolean',
            'leader_approval' => 'boolean',
        ];
    }

    public static array $visitTypes = [
        'prospecting'  => 'Prospección',
        'discovery'    => 'Descubrimiento',
        'proposal'     => 'Propuesta',
        'negotiation'  => 'Negociación',
        'closing'      => 'Cierre',
    ];

    protected static function booted(): void
    {
        static::saving(function (FieldInteraction $interaction) {
            $interaction->is_valid = (
                $interaction->is_in_matrix &&
                $interaction->is_scheduled &&
                $interaction->is_presential &&
                $interaction->crm_registered &&
                $interaction->has_artifacts
            );
        });

        static::saved(function (FieldInteraction $interaction) {
            $interaction->weeklyTracking->recalculateInteractions();
        });

        static::deleted(function (FieldInteraction $interaction) {
            $interaction->weeklyTracking->recalculateInteractions();
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

    public function scopeValid($query)
    {
        return $query->where('is_valid', true);
    }

    public function getMissingValidations(): array
    {
        $missing = [];

        if (!$this->is_in_matrix)   $missing[] = 'El cliente debe figurar en la Matriz de Planificación';
        if (!$this->is_scheduled)   $missing[] = 'La cita debe ser agendada proactivamente';
        if (!$this->is_presential)  $missing[] = 'La interacción debe ser estrictamente presencial';
        if (!$this->crm_registered) $missing[] = 'Debe estar registrada en CRM antes del corte';
        if (!$this->has_artifacts)  $missing[] = 'Se requiere evidencia tangible de la cita';

        return $missing;
    }
}
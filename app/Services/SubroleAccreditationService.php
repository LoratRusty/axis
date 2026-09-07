<?php

namespace App\Services;

use App\Models\SubroleAchievement;
use App\Models\TrainingProgram;
use App\Models\User;

class SubroleAccreditationService
{
    public const SUBROLE_ORDER = [
        'visitador',
        'prospectador',
        'descubridor',
        'articulador',
        'negociador',
        'asesor_comercial',
    ];

    public const SUBROLE_STAGE_MAP = [
        'visitador'       => 'A',
        'prospectador'    => 'A',
        'descubridor'     => 'B',
        'articulador'     => 'C',
        'negociador'      => 'D',
        'asesor_comercial'=> 'E',
    ];

    public function canAccredit(TrainingProgram $program): array
    {
        $rules  = app(BusinessRulesService::class);
        $result = $rules->canAdvanceSubrole($program);
        return $result;
    }

    public function accredit(TrainingProgram $program, User $coach, string $summary): SubroleAchievement
    {
        $currentSubrole = $program->current_subrole;
        $nextSubrole    = $this->getNextSubrole($currentSubrole);
        $nextStage      = self::SUBROLE_STAGE_MAP[$nextSubrole] ?? $program->current_stage;

        $achievement = SubroleAchievement::create([
            'program_id'       => $program->id,
            'subrole'          => $currentSubrole,
            'accredited_date'  => now()->toDateString(),
            'accredited_by'    => $coach->id,
            'evidence_summary' => $summary,
            'kpis_at_accreditation' => json_encode([
                'week'          => $program->current_week,
                'stage'         => $program->current_stage,
                'accredited_by' => $coach->name,
                'date'          => now()->toDateString(),
            ]),
        ]);

        $program->update([
            'current_subrole' => $nextSubrole,
            'current_stage'   => $nextStage,
        ]);

        return $achievement;
    }

    public function getNextSubrole(string $current): string
    {
        $index = array_search($current, self::SUBROLE_ORDER);
        return self::SUBROLE_ORDER[$index + 1] ?? 'asesor_comercial';
    }

    public function isGraduated(TrainingProgram $program): bool
    {
        return $program->current_subrole === 'asesor_comercial'
            && $program->subroleAchievements()->count() >= 5;
    }
}
<?php

namespace App\Services;

use App\Models\TrainingProgram;
use App\Models\WeeklyTracking;

class BusinessRulesService
{
    /*
    |--------------------------------------------------------------------------
    | REGLA 1 - Orden de dimensiones
    |--------------------------------------------------------------------------
    */

    public const DIMENSION_ORDER = [
        'volume',
        'time',
        'quality',
        'cost'
    ];

    public const DIMENSION_THRESHOLDS = [
        'volume'  => 0.90,
        'time'    => 0.85,
        'quality' => 2.5,
        'cost'    => null,
    ];

    public function canAdvanceDimension(
        string $dimension,
        TrainingProgram $program
    ): bool {

        $threshold = self::DIMENSION_THRESHOLDS[$dimension] ?? null;
        if ($threshold === null) {
            return false;
        }

        $week = $program->currentWeekTracking;
        if (!$week) {
            return false;
        }

        return match ($dimension) {

            'volume' =>
                $week->target_interactions > 0 &&
                ($week->actual_interactions / $week->target_interactions) >= $threshold,

            'time' =>
                $week->rituals_target > 0 &&
                ($week->rituals_completed / $week->rituals_target) >= $threshold,

            'quality' =>
                $program->evaluations()
                    ->where('instrument', 'I3')
                    ->avg('quality_level') >= $threshold,

            default => false,
        };
    }

    /*
    |--------------------------------------------------------------------------
    | REGLA 2 - Herramientas por fase
    |--------------------------------------------------------------------------
    */

    public const PHASE_TOOLS = [
        'A' => ['GTM', 'planning_matrix'],
        'B' => ['GTM', 'planning_matrix', 'SPICED'],
        'C' => ['GTM', 'planning_matrix', 'SPICED', 'ATAR_presentation'],
        'D' => ['GTM', 'planning_matrix', 'SPICED', 'ATAR_presentation', 'quotations', 'battlecards'],
        'E' => ['GTM', 'planning_matrix', 'SPICED', 'ATAR_presentation', 'quotations', 'battlecards', 'PHVA_full'],
    ];

    public function canAccessTool(string $phase, string $tool): bool
    {
        return in_array($tool, self::PHASE_TOOLS[$phase] ?? []);
    }

    /*
    |--------------------------------------------------------------------------
    | REGLA 5 - Transición de sub-rol
    |--------------------------------------------------------------------------
    */

    public function canAdvanceSubrole(TrainingProgram $program): array
    {
        $week = $program->currentWeekTracking;

        if (!$week) {
            return ['can_advance' => false];
        }

        $volumeOk = $week->actual_interactions >= $week->target_interactions;

        $consistencyOk = $week->rituals_target > 0 &&
            ($week->rituals_completed / $week->rituals_target) >= 0.90;

        $avgRubric = $program->evaluations()
            ->where('instrument', 'I3')
            ->avg('quality_level') ?? 0;

        $qualityOk = $avgRubric >= 2;

        return [
            'can_advance'   => $volumeOk && $consistencyOk && $qualityOk,
            'volume_ok'     => $volumeOk,
            'consistency_ok'=> $consistencyOk,
            'quality_ok'    => $qualityOk,
            'avg_rubric'    => round($avgRubric, 2),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | REGLA 6 - Meta de interacciones por semana
    |--------------------------------------------------------------------------
    */

    public function getWeeklyTarget(int $week): int
    {
        return match (true) {
            $week <= 4  => 1,
            $week <= 9  => 3,
            $week <= 16 => 5,
            $week <= 24 => 7,
            default     => 8,
        };
    }
}
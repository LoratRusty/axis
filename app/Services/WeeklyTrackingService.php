<?php

namespace App\Services;

use App\Models\KpiSnapshot;
use App\Models\TrainingProgram;
use App\Models\WeeklyTracking;
use App\Models\Ritual;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class WeeklyTrackingService
{
    public function openWeek(TrainingProgram $program): WeeklyTracking
    {
        return DB::transaction(function () use ($program) {

            $newWeek = $program->current_week + 1;

            $ritualsTarget = Ritual::whereHas('phase', function ($q) use ($program) {
                $q->where('code', $program->current_stage);
            })->where('is_active', true)->count();

            $week = WeeklyTracking::create([
                'program_id'          => $program->id,
                'week_number'         => $newWeek,
                'week_start_date'     => Carbon::now()->startOfWeek(),
                'week_end_date'       => Carbon::now()->endOfWeek(),
                'target_interactions' => app(BusinessRulesService::class)
                                            ->getWeeklyTarget($newWeek),
                'rituals_target'      => $ritualsTarget,
                'status'              => 'in_progress',
                'stage_at_start'      => $program->current_stage,
                'subrole_at_start'    => $program->current_subrole,
            ]);

            $program->update(['current_week' => $newWeek]);

            return $week;
        });
    }

    public function closeWeek(WeeklyTracking $week): void
    {
        DB::transaction(function () use ($week) {

            $week->recalculateInteractions();
            $week->recalculateEvidences();
            $week->update(['status' => 'completed']);

            $this->generateKpiSnapshot($week);
        });
    }

    public function generateKpiSnapshot(WeeklyTracking $week): KpiSnapshot
    {
        $program = $week->trainingProgram;

        $totalInteractions = $program->weeklyTrackings()
            ->where('status', 'completed')
            ->sum('actual_interactions');

        $spicedOpportunities = $program->fieldInteractions()
            ->whereNotNull('spiced_doc_url')
            ->where('is_valid', true)
            ->count();

        $validInteractions = $program->fieldInteractions()
            ->where('is_valid', true)
            ->count();

        $winRate = $validInteractions > 0
            ? round(($spicedOpportunities / $validInteractions) * 100, 2)
            : 0;

        $avgRubric = $program->evaluations()
            ->where('instrument', 'I3')
            ->avg('quality_level') ?? 0;

        $currentDimension = match(true) {
            $avgRubric >= 2.5 => 'cost',
            $avgRubric >= 2.0 => 'quality',
            ($week->rituals_completed / max($week->rituals_target, 1)) >= 0.85 => 'time',
            default => 'volume',
        };

        return KpiSnapshot::create([
            'program_id'                 => $program->id,
            'snapshot_date'              => now()->toDateString(),
            'week_number'                => $week->week_number,
            'weekly_interactions'        => $week->actual_interactions,
            'total_interactions'         => $totalInteractions,
            'spiced_opportunities'       => $spicedOpportunities,
            'win_rate'                   => $winRate,
            'current_dimension'          => $currentDimension,
            'current_phase'              => $program->current_stage,
            'advancement_recommendation' => $this->getAdvancementRecommendation($week, $program),
        ]);
    }

    private function getAdvancementRecommendation(WeeklyTracking $week, TrainingProgram $program): string
    {
        $rules   = app(BusinessRulesService::class);
        $canAdv  = $rules->canAdvanceSubrole($program);

        if ($canAdv['can_advance']) return 'graduate';

        $metInteractions = $week->target_interactions > 0
            && $week->actual_interactions >= $week->target_interactions;

        if (!$metInteractions) return 'review';
        if (!$canAdv['consistency_ok']) return 'reinforce';

        return 'continue';
    }

    public function recalculateWeek(WeeklyTracking $week): void
    {
        $week->recalculateInteractions();
        $week->recalculateEvidences();
    }
}
<?php

namespace App\Filament\Coach\Widgets;

use App\Models\TrainingProgram;
use App\Models\Evidence;
use App\Models\FieldInteraction;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CoachDashboard extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $coachId = auth()->id();

        $programas = TrainingProgram::where('coach_id', $coachId)
            ->where('status', 'active')
            ->with(['trainee', 'weeklyTrackings' => function ($q) {
                $q->where('status', 'in_progress');
            }])
            ->get();

        $totalTrainees   = $programas->count();
        $sinInteracciones = 0;
        $sinEvidencias    = 0;
        $enRiesgo         = 0;

        foreach ($programas as $program) {
            $semana = $program->weeklyTrackings->first();

            if ($semana) {
                if ($semana->actual_interactions === 0) {
                    $sinInteracciones++;
                }
                if ($semana->rituals_completed < ($semana->rituals_target * 0.5)) {
                    $sinEvidencias++;
                }
                if ($semana->actual_interactions === 0 || $semana->rituals_completed < ($semana->rituals_target * 0.5)) {
                    $enRiesgo++;
                }
            }
        }

        $evidenciasPendientes = Evidence::whereIn('program_id', $programas->pluck('id'))
            ->where('status', 'pending_review')
            ->count();

        return [
            Stat::make('Trainees activos', $totalTrainees)
                ->description('Programas bajo tu coaching')
                ->color('primary'),

            Stat::make('Evidencias por revisar', $evidenciasPendientes)
                ->description('Pendientes de tu aprobación')
                ->color($evidenciasPendientes > 0 ? 'warning' : 'success'),

            Stat::make('Trainees sin interacciones', $sinInteracciones)
                ->description('Esta semana - requieren atención')
                ->color($sinInteracciones > 0 ? 'danger' : 'success'),

            Stat::make('Trainees en riesgo', $enRiesgo)
                ->description('0 interacciones o menos del 50% de rituales')
                ->color($enRiesgo > 0 ? 'danger' : 'success'),
        ];
    }
}
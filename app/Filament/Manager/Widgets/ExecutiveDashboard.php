<?php

namespace App\Filament\Manager\Widgets;

use App\Models\TrainingProgram;
use App\Models\FieldInteraction;
use App\Models\Evidence;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ExecutiveDashboard extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $totalActivos = TrainingProgram::where('status', 'active')->count();
        $graduados    = TrainingProgram::where('status', 'graduated')->count();
        $enRiesgo     = TrainingProgram::where('status', 'active')
            ->whereHas('weeklyTrackings', function ($q) {
                $q->where('status', 'in_progress')
                    ->where('actual_interactions', 0);
            })->count();

        $porFase = TrainingProgram::where('status', 'active')
            ->selectRaw('current_stage, count(*) as total')
            ->groupBy('current_stage')
            ->pluck('total', 'current_stage');

        $evidenciasPendientes = Evidence::where('status', 'pending_review')->count();

        $proximosAscenso = TrainingProgram::where('status', 'active')
            ->where('current_subrole', 'negociador')
            ->count();

        return [
            Stat::make('Trainees activos', $totalActivos)
                ->description('Programas en curso')
                ->color('primary'),

            Stat::make('Graduados', $graduados)
                ->description('Asesores Comerciales acreditados')
                ->color('success'),

            Stat::make('En riesgo', $enRiesgo)
                ->description('Sin interacciones esta semana')
                ->color($enRiesgo > 0 ? 'danger' : 'success'),

            Stat::make('Evidencias pendientes', $evidenciasPendientes)
                ->description('Esperando revisión del coach')
                ->color($evidenciasPendientes > 0 ? 'warning' : 'success'),

            Stat::make('Próximos a ascenso', $proximosAscenso)
                ->description('En sub-rol Negociador')
                ->color('info'),
        ];
    }
}

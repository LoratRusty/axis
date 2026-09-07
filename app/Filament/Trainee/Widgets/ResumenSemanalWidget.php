<?php

namespace App\Filament\Trainee\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class ResumenSemanalWidget extends Widget
{
    protected string $view = 'filament.trainee.widgets.resumen-semanal';

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 1;

    public function getViewData(): array
    {
        $user    = Auth::user();
        $program = $user->trainingProgram()->with('currentWeekTracking')->first();

        if (! $program) {
            return ['program' => null];
        }

        $tracking = $program->currentWeekTracking;

        $interaccionesActual = $tracking?->actual_interactions ?? 0;
        $interaccionesMeta   = $tracking?->target_interactions ?? $program->getWeeklyInteractionTarget();
        $ritualesCompletados = $tracking?->rituals_completed ?? 0;
        $ritualesMeta        = $tracking?->rituals_target ?? 0;
        $evidenciasSubidas   = $tracking?->evidences_uploaded ?? 0;
        $evidenciasMeta      = $tracking?->evidences_target ?? 0;

        $diasParaCorte = null;
        if ($tracking?->week_end_date) {
            $diasParaCorte = max(0, now()->startOfDay()->diffInDays($tracking->week_end_date->startOfDay(), false));
        }

        return [
            'program'               => $program,
            'tracking'              => $tracking,
            'interaccionesActual'   => $interaccionesActual,
            'interaccionesMeta'     => $interaccionesMeta,
            'ritualesCompletados'   => $ritualesCompletados,
            'ritualesMeta'          => $ritualesMeta,
            'evidenciasSubidas'     => $evidenciasSubidas,
            'evidenciasMeta'        => $evidenciasMeta,
            'diasParaCorte'         => $diasParaCorte,
            'semaforoInteracciones' => $this->semaforo($interaccionesActual, $interaccionesMeta),
            'semaforoRituales'      => $this->semaforo($ritualesCompletados, $ritualesMeta),
            'semaforoEvidencias'    => $this->semaforo($evidenciasSubidas, $evidenciasMeta),
        ];
    }

    private function semaforo(int $actual, int $meta): string
    {
        if ($meta === 0) return 'gris';
        $pct = $actual / $meta;
        return match(true) {
            $pct >= 1.0 => 'verde',
            $pct >= 0.5 => 'amarillo',
            default     => 'rojo',
        };
    }
}
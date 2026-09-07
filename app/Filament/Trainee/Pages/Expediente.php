<?php

namespace App\Filament\Trainee\Pages;

use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;

class Expediente extends Page
{
    protected static ?string $navigationLabel = 'Mi Expediente';
    protected static ?int    $navigationSort  = 5;

    protected string $view = 'filament.trainee.pages.expediente';

    public static function getNavigationIcon(): string|BackedEnum|null
    {
        return Heroicon::OutlinedIdentification;
    }

    public function getViewData(): array
    {
        $user    = Auth::user();
        $program = $user->trainingProgram()->with([
            'subroleAchievements.accreditedBy',
            'kpiSnapshots',
            'coach',
        ])->first();

        if (! $program) {
            return ['program' => null, 'user' => $user, 'kpis' => collect(), 'logros' => collect(), 'ultimo' => null];
        }

        $kpis   = $program->kpiSnapshots()->orderByDesc('snapshot_date')->get();
        $logros = $program->subroleAchievements()->orderBy('accredited_date')->get();
        $ultimo = $kpis->first();

        return [
            'user'    => $user,
            'program' => $program,
            'kpis'    => $kpis,
            'logros'  => $logros,
            'ultimo'  => $ultimo,
        ];
    }
}
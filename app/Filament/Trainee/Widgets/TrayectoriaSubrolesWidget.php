<?php

namespace App\Filament\Trainee\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class TrayectoriaSubrolesWidget extends Widget
{
    protected string $view = 'filament.trainee.widgets.trayectoria-subroles';

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 2;

    public function getViewData(): array
    {
        $user    = Auth::user();
        $program = $user->trainingProgram()->with('subroleAchievements')->first();

        if (! $program) {
            return ['program' => null, 'subroles' => [], 'logrosClaves' => [], 'actual' => ''];
        }

        $subroles = [
            'A' => [
                ['clave' => 'Vendedor Novato',    'semana_min' => 1,  'semana_max' => 4],
                ['clave' => 'Vendedor Aprendiz',   'semana_min' => 5,  'semana_max' => 9],
                ['clave' => 'Vendedor Practicante',   'semana_min' => 10, 'semana_max' => 16],
            ],
            'B' => [
                ['clave' => 'Vendedor Intermedio',    'semana_min' => 17, 'semana_max' => 20],
                ['clave' => 'Vendedor Avanzado', 'semana_min' => 21, 'semana_max' => 24],
            ],
            'C' => [
                ['clave' => 'Vendedor',    'semana_min' => 25, 'semana_max' => 28],
            ],
        ];

        $logrosClaves = $program->subroleAchievements
            ->pluck('subrole')
            ->map(fn($v) => strtolower($v))
            ->toArray();

        return [
            'program'      => $program,
            'subroles'     => $subroles,
            'logrosClaves' => $logrosClaves,
            'actual'       => strtolower($program->current_subrole ?? ''),
        ];
    }
}
<?php

namespace App\Filament\Manager\Pages;

use App\Exports\FieldInteractionsExport;
use App\Models\TrainingProgram;
use App\Models\WeeklyTracking;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Actions\Action;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use BackedEnum;

class ExportarInteracciones extends Page
{
    protected static string|BackedEnum|null $navigationIcon = \Filament\Support\Icons\Heroicon::OutlinedArrowDownTray;
    protected static ?string $navigationLabel  = 'Exportar Interacciones';
    protected static ?string $title            = 'Exportar Interacciones';
    protected static ?int    $navigationSort   = 3;

    public ?string $program_id         = null;
    public ?string $weekly_tracking_id = null;

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('program_id')
                ->label('Trainee')
                ->options(
                    fn() => TrainingProgram::with('trainee')
                        ->active()
                        ->get()
                        ->mapWithKeys(fn($p) => [
                            $p->id => $p->trainee->name . ' — Sem. ' . $p->current_week,
                        ])
                )
                ->required()
                ->searchable()
                ->live(),

            Select::make('weekly_tracking_id')
                ->label('Semana (opcional — vacío exporta todo)')
                ->options(function () {
                    if (! $this->program_id) return [];
                    return WeeklyTracking::where('program_id', $this->program_id)
                        ->orderByDesc('week_number')
                        ->get()
                        ->mapWithKeys(fn($wt) => [
                            $wt->id => 'Semana ' . $wt->week_number . ' (' . $wt->week_start_date?->format('d/m/Y') . ')',
                        ]);
                })
                ->searchable()
                ->placeholder('Todas las semanas'),
        ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('exportar')
                ->label('Descargar Excel')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->action(function (): BinaryFileResponse {
                    $program = TrainingProgram::with('trainee')->find($this->program_id);
                    $nombre  = $program?->trainee->name ?? 'interacciones';
                    $semana  = $this->weekly_tracking_id
                        ? '_sem' . WeeklyTracking::find($this->weekly_tracking_id)?->week_number
                        : '_todas';

                    $filename = 'interacciones_' . str($nombre)->slug() . $semana . '.xlsx';

                    return Excel::download(
                        new FieldInteractionsExport($this->program_id, $this->weekly_tracking_id),
                        $filename
                    );
                })
                ->requiresConfirmation(false),
        ];
    }

    public function getView(): string
    {
        return 'filament.manager.pages.exportar-interacciones';
    }
}

<?php

namespace App\Filament\Coach\Resources\TrainingPrograms\Pages;

use App\Filament\Coach\Resources\TrainingPrograms\TrainingProgramResource;
use App\Models\TrainingProgram;
use App\Services\SubroleAccreditationService;
use App\Services\WeeklyTrackingService;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewTrainingProgram extends ViewRecord
{
    protected static string $resource = TrainingProgramResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()->label('Editar'),

            Action::make('cerrar_semana')
                ->label('Cerrar Semana')
                ->color('warning')
                ->requiresConfirmation()
                ->modalHeading('Cerrar semana actual')
                ->modalDescription('Esto calculará los KPIs y generará el snapshot semanal.')
                ->action(function () {
                    $record = $this->getRecord();
                    $semana = $record->weeklyTrackings()
                        ->where('status', 'in_progress')
                        ->first();

                    if (!$semana) {
                        Notification::make()
                            ->title('No hay semana activa')
                            ->warning()
                            ->send();
                        return;
                    }

                    app(WeeklyTrackingService::class)->closeWeek($semana);

                    Notification::make()
                        ->title('Semana cerrada')
                        ->body('KPI snapshot generado correctamente.')
                        ->success()
                        ->send();

                    $this->refreshFormData(['current_week', 'status']);
                }),

            Action::make('abrir_semana')
                ->label('Abrir Nueva Semana')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Abrir nueva semana')
                ->modalDescription('Esto creará el tracking de la semana siguiente.')
                ->action(function () {
                    $record = $this->getRecord();

                    $semanaActiva = $record->weeklyTrackings()
                        ->where('status', 'in_progress')
                        ->exists();

                    if ($semanaActiva) {
                        Notification::make()
                            ->title('Ya hay una semana activa')
                            ->warning()
                            ->send();
                        return;
                    }

                    app(WeeklyTrackingService::class)->openWeek($record);

                    Notification::make()
                        ->title('Nueva semana abierta')
                        ->success()
                        ->send();
                }),

            Action::make('acreditar_subrol')
                ->label('Acreditar Sub-Rol')
                ->color('primary')
                ->form([
                    Textarea::make('evidence_summary')
                        ->label('Resumen de evidencia para la acreditación')
                        ->required()
                        ->minLength(20)
                        ->rows(4),
                ])
                ->action(function (array $data) {
                    $record  = $this->getRecord();
                    $service = app(SubroleAccreditationService::class);
                    $check   = $service->canAccredit($record);

                    if (!$check['can_advance']) {
                        $reasons = [];
                        if (!($check['volume_ok'] ?? true))      $reasons[] = 'Volumen insuficiente';
                        if (!($check['consistency_ok'] ?? true)) $reasons[] = 'Rituales menor al 90%';
                        if (!($check['quality_ok'] ?? true))     $reasons[] = 'Rubrica menor a Nivel 2';

                        Notification::make()
                            ->title('No cumple condiciones')
                            ->body(implode(' | ', $reasons))
                            ->danger()
                            ->send();
                        return;
                    }

                    $service->accredit($record, auth()->user(), $data['evidence_summary']);

                    $nuevoSubrol = $record->fresh()->current_subrole;

                    app(\App\Services\NotificationService::class)->notify(
                        user: $record->trainee,
                        type: 'subrole_achieved',
                        title: 'Lograste un nuevo sub-rol: ' . ucfirst($nuevoSubrol),
                        body: 'Tu coach acredito tu avance. Sigue construyendo tu historial de desempeno.',
                        url: '/mi-programa',
                    );

                    Notification::make()
                        ->title('Sub-rol acreditado')
                        ->body('Nuevo sub-rol: ' . ucfirst($nuevoSubrol))
                        ->success()
                        ->send();

                    $this->refreshFormData(['current_subrole', 'current_stage']);
                }),

            Action::make('recomendar_ascenso')
                ->label('Recomendar ascenso')
                ->color('primary')
                ->icon('heroicon-o-arrow-up-circle')
                ->visible(fn() => $this->getRecord()->status === 'active' && ! $this->getRecord()->hasPromotionPending())
                ->form([
                    Textarea::make('promotion_recommendation_notes')
                        ->label('Justificacion del ascenso')
                        ->helperText('Describe por que el trainee esta listo para ser Asesor Comercial.')
                        ->required()
                        ->minLength(30)
                        ->rows(4),
                ])
                ->modalHeading('Recomendar ascenso a Gerencia')
                ->modalSubmitActionLabel('Enviar recomendacion')
                ->action(function (array $data) {
                    $this->getRecord()->update([
                        'promotion_recommended_at'       => now(),
                        'promotion_recommended_by'       => auth()->id(),
                        'promotion_recommendation_notes' => $data['promotion_recommendation_notes'],
                    ]);
                    Notification::make()
                        ->title('Recomendacion enviada a Gerencia')
                        ->success()
                        ->send();
                    $this->refreshFormData(['promotion_recommended_at']);
                }),
        ];
    }
}

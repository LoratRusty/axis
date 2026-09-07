<?php

namespace App\Filament\Manager\Resources\ProgramaResource\Pages;

use App\Filament\Manager\Resources\ProgramaResource;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use App\Services\NotificationService;

class ViewPrograma extends ViewRecord
{
    protected static string $resource = ProgramaResource::class;

    public function getTitle(): string|\Illuminate\Contracts\Support\Htmlable
    {
        return 'Programa de ' . $this->getRecord()->trainee->name;
    }

    protected function getHeaderActions(): array
    {
        return [

            Action::make('aprobar_ascenso')
                ->label('Aprobar ascenso')
                ->color('success')
                ->icon('heroicon-o-check-circle')
                ->visible(fn() => $this->getRecord()->hasPromotionPending())
                ->requiresConfirmation()
                ->modalHeading('Aprobar ascenso a Asesor Comercial')
                ->modalDescription('Esta accion cambiara el estado del programa a Graduado.')
                ->modalSubmitActionLabel('Si, aprobar ascenso')
                ->action(function () {
                    $record = $this->getRecord();
                    $record->update([
                        'status'                         => 'graduated',
                        'promotion_recommended_at'       => null,
                        'promotion_recommended_by'       => null,
                        'promotion_recommendation_notes' => null,
                    ]);

                    $notif = app(NotificationService::class);

                    $notif->notify(
                        user: $record->trainee,
                        type: 'subrole_achieved',
                        title: 'Felicitaciones - Has sido graduado como Asesor Comercial',
                        body: 'Gerencia aprobo tu ascenso. Has completado el programa de entrenamiento AXIS.',
                        url: '/mi-programa',
                    );

                    $notif->notify(
                        user: $record->coach,
                        type: 'kpi_alert',
                        title: 'Ascenso aprobado - ' . $record->trainee->name,
                        body: 'Gerencia aprobo el ascenso de ' . $record->trainee->name . ' a Asesor Comercial.',
                        url: '/coach/training-programs/' . $record->id,
                    );

                    Notification::make()
                        ->title('Ascenso aprobado')
                        ->body($record->trainee->name . ' ha sido graduado como Asesor Comercial.')
                        ->success()
                        ->send();

                    $this->refreshFormData(['status']);
                }),

            Action::make('solicitar_evidencia')
                ->label('Solicitar mas evidencia')
                ->color('warning')
                ->icon('heroicon-o-document-magnifying-glass')
                ->visible(fn() => $this->getRecord()->hasPromotionPending())
                ->form([
                    Textarea::make('nota')
                        ->label('Que evidencia adicional se requiere')
                        ->required()
                        ->minLength(20)
                        ->rows(4),
                ])
                ->modalHeading('Solicitar evidencia adicional')
                ->modalSubmitActionLabel('Enviar solicitud')
                ->action(function (array $data) {
                    $record = $this->getRecord();
                    $record->update([
                        'promotion_recommendation_notes' => $record->promotion_recommendation_notes . "\n\n[Gerencia solicita]: " . $data['nota'],
                    ]);
                    Notification::make()
                        ->title('Solicitud enviada al coach')
                        ->warning()
                        ->send();
                }),

            Action::make('rechazar_ascenso')
                ->label('Rechazar ascenso')
                ->color('danger')
                ->icon('heroicon-o-x-circle')
                ->visible(fn() => $this->getRecord()->hasPromotionPending())
                ->form([
                    Textarea::make('motivo')
                        ->label('Motivo del rechazo')
                        ->required()
                        ->minLength(20)
                        ->rows(4),
                ])
                ->modalHeading('Rechazar recomendacion de ascenso')
                ->modalSubmitActionLabel('Confirmar rechazo')
                ->action(function (array $data) {
                    $record = $this->getRecord();
                    $record->update([
                        'promotion_recommended_at'       => null,
                        'promotion_recommended_by'       => null,
                        'promotion_recommendation_notes' => 'RECHAZADO: ' . $data['motivo'],
                    ]);
                    Notification::make()
                        ->title('Ascenso rechazado')
                        ->danger()
                        ->send();
                    $this->refreshFormData(['status']);
                }),
        ];
    }
}

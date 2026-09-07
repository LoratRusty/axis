<?php

namespace App\Filament\Coach\Resources\Evidence\Pages;

use App\Filament\Coach\Resources\Evidence\EvidenceResource;
use App\Models\Evidence;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Pages\ViewRecord;
use Filament\Notifications\Notification;

class ViewEvidence extends ViewRecord
{
    protected static string $resource = EvidenceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('aprobar')
                ->label('Aprobar')
                ->color('success')
                ->icon('heroicon-o-check-circle')
                ->visible(fn() => $this->getRecord()->status !== 'approved')
                ->requiresConfirmation()
                ->modalHeading('Aprobar evidencia')
                ->modalDescription('Confirmas que esta evidencia cumple con los requisitos del programa.')
                ->modalSubmitActionLabel('Si, aprobar')
                ->action(function () {
                    $this->getRecord()->update(['status' => 'approved']);
                    Notification::make()
                        ->title('Evidencia aprobada')
                        ->success()
                        ->send();
                    $this->refreshFormData(['status']);
                }),

            Action::make('solicitar_revision')
                ->label('Solicitar revision')
                ->color('warning')
                ->icon('heroicon-o-arrow-path')
                ->visible(fn() => $this->getRecord()->status !== 'needs_revision')
                ->form([
                    Textarea::make('coach_notes')
                        ->label('Indicaciones para el trainee')
                        ->helperText('Explica que debe corregir o mejorar el trainee.')
                        ->required()
                        ->minLength(10)
                        ->rows(4),
                ])
                ->modalHeading('Solicitar revision')
                ->modalSubmitActionLabel('Enviar solicitud')
                ->action(function (array $data) {
                    $this->getRecord()->update([
                        'status'      => 'needs_revision',
                        'coach_notes' => $data['coach_notes'],
                    ]);
                    Notification::make()
                        ->title('Revision solicitada')
                        ->warning()
                        ->send();
                    $this->refreshFormData(['status', 'coach_notes']);
                }),

            Action::make('rechazar')
                ->label('Rechazar')
                ->color('danger')
                ->icon('heroicon-o-x-circle')
                ->visible(fn() => $this->getRecord()->status !== 'rejected')
                ->form([
                    Textarea::make('coach_notes')
                        ->label('Motivo del rechazo')
                        ->helperText('Explica al trainee por que se rechaza esta evidencia.')
                        ->required()
                        ->minLength(10)
                        ->rows(4),
                ])
                ->modalHeading('Rechazar evidencia')
                ->modalSubmitActionLabel('Confirmar rechazo')
                ->modalDescription('Esta accion marca la evidencia como rechazada. El trainee podra ver el motivo.')
                ->action(function (array $data) {
                    $this->getRecord()->update([
                        'status'      => 'rejected',
                        'coach_notes' => $data['coach_notes'],
                    ]);
                    Notification::make()
                        ->title('Evidencia rechazada')
                        ->danger()
                        ->send();
                    $this->refreshFormData(['status', 'coach_notes']);
                }),

            EditAction::make()->label('Editar'),
        ];
    }
}
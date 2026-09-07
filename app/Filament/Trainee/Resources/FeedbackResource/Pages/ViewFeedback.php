<?php

namespace App\Filament\Trainee\Resources\FeedbackResource\Pages;

use App\Filament\Trainee\Resources\FeedbackResource;
use App\Models\FeedbackSession;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewFeedback extends ViewRecord
{
    protected static string $resource = FeedbackResource::class;

    public function getTitle(): string|\Illuminate\Contracts\Support\Htmlable
    {
        return 'Detalle de feedback';
    }

    protected function getHeaderActions(): array
    {
        $record = $this->getRecord();

        return [
            Actions\Action::make('confirmar_lectura')
                ->label('Confirmar lectura')
                ->icon('heroicon-o-check')
                ->color('success')
                ->visible(fn() => ! $record->trainee_ack)
                ->requiresConfirmation()
                ->modalHeading('Confirmar lectura del feedback')
                ->modalDescription('Al confirmar, indicas que leiste y entendiste el feedback de tu coach. Esta accion no se puede deshacer.')
                ->modalSubmitActionLabel('Si, confirmo que lo lei')
                ->action(function () use ($record) {
                    $record->acknowledge();
                    $this->refreshFormData(['trainee_ack']);
                }),
        ];
    }
}

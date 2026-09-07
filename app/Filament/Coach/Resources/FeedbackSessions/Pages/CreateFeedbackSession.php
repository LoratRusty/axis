<?php

namespace App\Filament\Coach\Resources\FeedbackSessions\Pages;

use App\Filament\Coach\Resources\FeedbackSessions\FeedbackSessionResource;
use App\Services\NotificationService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateFeedbackSession extends CreateRecord
{
    protected static string $resource = FeedbackSessionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['coach_id']    = Auth::id();
        $data['trainee_ack'] = false;

        return $data;
    }

    protected function afterCreate(): void
    {
        $record  = $this->getRecord();
        $program = $record->trainingProgram()->with('trainee')->first();

        if (! $program) return;

        app(NotificationService::class)->notify(
            user:  $program->trainee,
            type:  'feedback_ready',
            title: 'Tu coach publico una sesion de feedback',
            body:  'Tienes una nueva sesion de feedback pendiente de confirmacion. Revisala y confirma tu lectura.',
            url:   '/mi-programa/feedback/' . $record->id,
        );
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
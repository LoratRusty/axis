<?php

namespace App\Filament\Coach\Resources\FeedbackSessions\Pages;

use App\Filament\Coach\Resources\FeedbackSessions\FeedbackSessionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewFeedbackSession extends ViewRecord
{
    protected static string $resource = FeedbackSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

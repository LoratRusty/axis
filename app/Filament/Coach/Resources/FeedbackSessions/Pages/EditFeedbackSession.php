<?php

namespace App\Filament\Coach\Resources\FeedbackSessions\Pages;

use App\Filament\Coach\Resources\FeedbackSessions\FeedbackSessionResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditFeedbackSession extends EditRecord
{
    protected static string $resource = FeedbackSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}

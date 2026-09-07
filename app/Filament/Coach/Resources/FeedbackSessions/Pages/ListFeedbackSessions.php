<?php

namespace App\Filament\Coach\Resources\FeedbackSessions\Pages;

use App\Filament\Coach\Resources\FeedbackSessions\FeedbackSessionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFeedbackSessions extends ListRecords
{
    protected static string $resource = FeedbackSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

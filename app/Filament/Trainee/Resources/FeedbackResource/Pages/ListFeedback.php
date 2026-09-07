<?php

namespace App\Filament\Trainee\Resources\FeedbackResource\Pages;

use App\Filament\Trainee\Resources\FeedbackResource;
use Filament\Resources\Pages\ListRecords;

class ListFeedback extends ListRecords
{
    protected static string $resource = FeedbackResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
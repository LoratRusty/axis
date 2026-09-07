<?php

namespace App\Filament\Coach\Resources\Evidence\Pages;

use App\Filament\Coach\Resources\Evidence\EvidenceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEvidence extends ListRecords
{
    protected static string $resource = EvidenceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

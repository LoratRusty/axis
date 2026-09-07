<?php

namespace App\Filament\Coach\Resources\FieldInteractions\Pages;

use App\Filament\Coach\Resources\FieldInteractions\FieldInteractionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFieldInteractions extends ListRecords
{
    protected static string $resource = FieldInteractionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

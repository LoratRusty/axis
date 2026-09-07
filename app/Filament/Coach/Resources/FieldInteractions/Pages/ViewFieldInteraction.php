<?php

namespace App\Filament\Coach\Resources\FieldInteractions\Pages;

use App\Filament\Coach\Resources\FieldInteractions\FieldInteractionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewFieldInteraction extends ViewRecord
{
    protected static string $resource = FieldInteractionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

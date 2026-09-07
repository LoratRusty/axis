<?php

namespace App\Filament\Coach\Resources\FieldInteractions\Pages;

use App\Filament\Coach\Resources\FieldInteractions\FieldInteractionResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditFieldInteraction extends EditRecord
{
    protected static string $resource = FieldInteractionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}

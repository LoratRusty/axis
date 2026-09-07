<?php

namespace App\Filament\Trainee\Resources\InteraccionResource\Pages;

use App\Filament\Trainee\Resources\InteraccionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInteracciones extends ListRecords
{
    protected static string $resource = InteraccionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Registrar interaccion'),
        ];
    }
}
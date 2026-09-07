<?php

namespace App\Filament\Trainee\Resources\EvidenciaResource\Pages;

use App\Filament\Trainee\Resources\EvidenciaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEvidencias extends ListRecords
{
    protected static string $resource = EvidenciaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Nueva evidencia'),
        ];
    }
}
<?php

namespace App\Filament\Manager\Resources\ProgramaResource\Pages;

use App\Filament\Manager\Resources\ProgramaResource;
use Filament\Resources\Pages\ListRecords;

class ListProgramas extends ListRecords
{
    protected static string $resource = ProgramaResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
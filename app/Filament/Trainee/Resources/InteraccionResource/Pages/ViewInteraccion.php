<?php

namespace App\Filament\Trainee\Resources\InteraccionResource\Pages;

use App\Filament\Trainee\Resources\InteraccionResource;
use Filament\Resources\Pages\ViewRecord;

class ViewInteraccion extends ViewRecord
{
    protected static string $resource = InteraccionResource::class;

    public function getTitle(): string|\Illuminate\Contracts\Support\Htmlable
    {
        return 'Detalle de interaccion';
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}

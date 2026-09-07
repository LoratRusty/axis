<?php

namespace App\Filament\Trainee\Resources\EvidenciaResource\Pages;

use App\Filament\Trainee\Resources\EvidenciaResource;
use Filament\Resources\Pages\ViewRecord;

class ViewEvidencia extends ViewRecord
{
    protected static string $resource = EvidenciaResource::class;

    public function getTitle(): string|\Illuminate\Contracts\Support\Htmlable
    {
        return 'Detalle de evidencia';
    }

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\EditAction::make()
                ->label('Corregir y reenviar')
                ->visible(fn() => $this->getRecord()->status === 'needs_revision'),
        ];
    }
}

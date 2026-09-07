<?php

namespace App\Filament\Trainee\Resources\EvidenciaResource\Pages;

use App\Filament\Trainee\Resources\EvidenciaResource;
use Filament\Resources\Pages\EditRecord;

class EditEvidencia extends EditRecord
{
    protected static string $resource = EvidenciaResource::class;

    public function getTitle(): string|\Illuminate\Contracts\Support\Htmlable
    {
        return 'Editar evidencia';
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Al resubmitir resetear a pending_review
        $data['status'] = 'pending_review';
        return $data;
    }
}
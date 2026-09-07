<?php

namespace App\Filament\Trainee\Resources\EvidenciaResource\Pages;

use App\Filament\Trainee\Resources\EvidenciaResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateEvidencia extends CreateRecord
{
    protected static string $resource = EvidenciaResource::class;

    public function getTitle(): string|\Illuminate\Contracts\Support\Htmlable
    {
        return 'Subir nueva evidencia';
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $program = Auth::user()->trainingProgram;

        $data['program_id']   = $program->id;
        $data['uploaded_by']  = Auth::id();
        $data['status'] = 'pending_review';

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

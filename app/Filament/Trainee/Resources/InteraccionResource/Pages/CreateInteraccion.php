<?php

namespace App\Filament\Trainee\Resources\InteraccionResource\Pages;

use App\Filament\Trainee\Resources\InteraccionResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateInteraccion extends CreateRecord
{
    protected static string $resource = InteraccionResource::class;

    public function getTitle(): string|\Illuminate\Contracts\Support\Htmlable
    {
        return 'Registrar interaccion de campo';
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['program_id'] = Auth::user()->trainingProgram->id;

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
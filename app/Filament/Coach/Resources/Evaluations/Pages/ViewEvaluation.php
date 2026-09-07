<?php

namespace App\Filament\Coach\Resources\Evaluations\Pages;

use App\Filament\Coach\Resources\Evaluations\EvaluationResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewEvaluation extends ViewRecord
{
    protected static string $resource = EvaluationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Coach\Resources\Evaluations;

use App\Filament\Coach\Resources\Evaluations\Pages\CreateEvaluation;
use App\Filament\Coach\Resources\Evaluations\Pages\EditEvaluation;
use App\Filament\Coach\Resources\Evaluations\Pages\ListEvaluations;
use App\Filament\Coach\Resources\Evaluations\Pages\ViewEvaluation;
use App\Filament\Coach\Resources\Evaluations\Schemas\EvaluationForm;
use App\Filament\Coach\Resources\Evaluations\Schemas\EvaluationInfolist;
use App\Filament\Coach\Resources\Evaluations\Tables\EvaluationsTable;
use App\Models\Evaluation;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EvaluationResource extends Resource
{
    protected static ?string $model = Evaluation::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'instrument';
    protected static ?string $navigationLabel = 'Evaluaciones';
    protected static ?string $modelLabel = 'Evaluación';
    protected static ?string $pluralModelLabel = 'Evaluaciones';

    public static function form(Schema $schema): Schema
    {
        return EvaluationForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return EvaluationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EvaluationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEvaluations::route('/'),
            'create' => CreateEvaluation::route('/create'),
            'view' => ViewEvaluation::route('/{record}'),
            'edit' => EditEvaluation::route('/{record}/edit'),
        ];
    }
}

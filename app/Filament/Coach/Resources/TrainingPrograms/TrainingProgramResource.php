<?php

namespace App\Filament\Coach\Resources\TrainingPrograms;

use App\Filament\Coach\Resources\TrainingPrograms\Pages\CreateTrainingProgram;
use App\Filament\Coach\Resources\TrainingPrograms\Pages\EditTrainingProgram;
use App\Filament\Coach\Resources\TrainingPrograms\Pages\ListTrainingPrograms;
use App\Filament\Coach\Resources\TrainingPrograms\Pages\ViewTrainingProgram;
use App\Filament\Coach\Resources\TrainingPrograms\Schemas\TrainingProgramForm;
use App\Filament\Coach\Resources\TrainingPrograms\Schemas\TrainingProgramInfolist;
use App\Filament\Coach\Resources\TrainingPrograms\Tables\TrainingProgramsTable;
use App\Models\TrainingProgram;
use App\Services\SubroleAccreditationService;
use App\Services\WeeklyTrackingService;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TrainingProgramResource extends Resource
{
    protected static ?string $model = TrainingProgram::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'current_subrole';
    protected static ?string $navigationLabel     = 'Programas';
    protected static ?string $modelLabel          = 'Programa';
    protected static ?string $pluralModelLabel    = 'Programas de Entrenamiento';

    public static function form(Schema $schema): Schema
    {
        return TrainingProgramForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TrainingProgramInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TrainingProgramsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListTrainingPrograms::route('/'),
            'create' => CreateTrainingProgram::route('/create'),
            'view'   => ViewTrainingProgram::route('/{record}'),
            'edit'   => EditTrainingProgram::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
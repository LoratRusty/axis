<?php

namespace App\Filament\Coach\Resources\Evidence;

use App\Filament\Coach\Resources\Evidence\Pages\CreateEvidence;
use App\Filament\Coach\Resources\Evidence\Pages\EditEvidence;
use App\Filament\Coach\Resources\Evidence\Pages\ListEvidence;
use App\Filament\Coach\Resources\Evidence\Pages\ViewEvidence;
use App\Filament\Coach\Resources\Evidence\Schemas\EvidenceForm;
use App\Filament\Coach\Resources\Evidence\Schemas\EvidenceInfolist;
use App\Filament\Coach\Resources\Evidence\Tables\EvidenceTable;
use App\Models\Evidence;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EvidenceResource extends Resource
{
    protected static ?string $model = Evidence::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $navigationLabel  = 'Evidencias';
    protected static ?string $modelLabel       = 'Evidencia';
    protected static ?string $pluralModelLabel = 'Evidencias';

    public static function form(Schema $schema): Schema
    {
        return EvidenceForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return EvidenceInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EvidenceTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListEvidence::route('/'),
            'create' => CreateEvidence::route('/create'),
            'view'   => ViewEvidence::route('/{record}'),
            'edit'   => EditEvidence::route('/{record}/edit'),
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
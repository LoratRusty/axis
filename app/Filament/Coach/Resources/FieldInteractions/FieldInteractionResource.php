<?php

namespace App\Filament\Coach\Resources\FieldInteractions;

use App\Filament\Coach\Resources\FieldInteractions\Pages\CreateFieldInteraction;
use App\Filament\Coach\Resources\FieldInteractions\Pages\EditFieldInteraction;
use App\Filament\Coach\Resources\FieldInteractions\Pages\ListFieldInteractions;
use App\Filament\Coach\Resources\FieldInteractions\Pages\ViewFieldInteraction;
use App\Filament\Coach\Resources\FieldInteractions\Schemas\FieldInteractionForm;
use App\Filament\Coach\Resources\FieldInteractions\Schemas\FieldInteractionInfolist;
use App\Filament\Coach\Resources\FieldInteractions\Tables\FieldInteractionsTable;
use App\Models\FieldInteraction;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FieldInteractionResource extends Resource
{
    protected static ?string $model = FieldInteraction::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'client_name';
    protected static ?string $navigationLabel = 'Interacciones';
    protected static ?string $modelLabel = 'Interacción';
    protected static ?string $pluralModelLabel = 'Interacciones de Campo';

    public static function form(Schema $schema): Schema
    {
        return FieldInteractionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return FieldInteractionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FieldInteractionsTable::configure($table);
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
            'index' => ListFieldInteractions::route('/'),
            'create' => CreateFieldInteraction::route('/create'),
            'view' => ViewFieldInteraction::route('/{record}'),
            'edit' => EditFieldInteraction::route('/{record}/edit'),
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

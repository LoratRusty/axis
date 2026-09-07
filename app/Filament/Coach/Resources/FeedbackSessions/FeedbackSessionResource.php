<?php

namespace App\Filament\Coach\Resources\FeedbackSessions;

use App\Filament\Coach\Resources\FeedbackSessions\Pages\CreateFeedbackSession;
use App\Filament\Coach\Resources\FeedbackSessions\Pages\EditFeedbackSession;
use App\Filament\Coach\Resources\FeedbackSessions\Pages\ListFeedbackSessions;
use App\Filament\Coach\Resources\FeedbackSessions\Pages\ViewFeedbackSession;
use App\Filament\Coach\Resources\FeedbackSessions\Schemas\FeedbackSessionForm;
use App\Filament\Coach\Resources\FeedbackSessions\Schemas\FeedbackSessionInfolist;
use App\Filament\Coach\Resources\FeedbackSessions\Tables\FeedbackSessionsTable;
use App\Models\FeedbackSession;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FeedbackSessionResource extends Resource
{
    protected static ?string $model = FeedbackSession::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'session_type';
    protected static ?string $navigationLabel = 'Feedback';
    protected static ?string $modelLabel = 'Sesión de Feedback';
    protected static ?string $pluralModelLabel = 'Sesiones de Feedback';

    public static function form(Schema $schema): Schema
    {
        return FeedbackSessionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return FeedbackSessionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FeedbackSessionsTable::configure($table);
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
            'index' => ListFeedbackSessions::route('/'),
            'create' => CreateFeedbackSession::route('/create'),
            'view' => ViewFeedbackSession::route('/{record}'),
            'edit' => EditFeedbackSession::route('/{record}/edit'),
        ];
    }
}

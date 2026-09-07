<?php

namespace App\Filament\Trainee\Resources;

use App\Filament\Trainee\Resources\FeedbackResource\Pages;
use App\Models\FeedbackSession;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Filament\Actions\ViewAction;
use Filament\Actions\Action;

class FeedbackResource extends Resource
{
    protected static ?string $model = FeedbackSession::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleLeftRight;

    protected static ?string $navigationLabel  = 'Mi Feedback';
    protected static ?string $modelLabel       = 'Sesion de feedback';
    protected static ?string $pluralModelLabel = 'Sesiones de feedback';
    protected static ?int    $navigationSort   = 4;

    public static function getEloquentQuery(): Builder
    {
        $user    = Auth::user();
        $program = $user->trainingProgram;

        if (! $program) {
            return parent::getEloquentQuery()->whereRaw('1 = 0');
        }

        return parent::getEloquentQuery()
            ->where('program_id', $program->id)
            ->orderByDesc('session_date');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([

            \Filament\Schemas\Components\Section::make('Informacion de la sesion')
                ->schema([
                    \Filament\Infolists\Components\TextEntry::make('session_type')
                        ->label('Tipo de sesion')
                        ->formatStateUsing(fn($state) => match ($state) {
                            'weekly_plan'      => 'Plan semanal',
                            'risk_management'  => 'Gestion de riesgo',
                            'wins_losses'      => 'Ganancias y perdidas',
                            'quarterly_growth' => 'Crecimiento trimestral',
                            'field_coaching'   => 'Coaching en campo',
                            default            => $state,
                        })
                        ->badge()
                        ->color('primary'),

                    \Filament\Infolists\Components\TextEntry::make('session_date')
                        ->label('Fecha de sesion')
                        ->dateTime('d/m/Y H:i'),

                    \Filament\Infolists\Components\TextEntry::make('coach.name')
                        ->label('Coach'),

                    \Filament\Infolists\Components\TextEntry::make('trainee_ack')
                        ->label('Estado')
                        ->formatStateUsing(fn($state) => $state ? 'Leido y confirmado' : 'Pendiente de confirmacion')
                        ->badge()
                        ->color(fn($state) => $state ? 'success' : 'warning'),
                ])->columns(2),

            \Filament\Schemas\Components\Section::make('Contenido del feedback')
                ->schema([
                    \Filament\Infolists\Components\TextEntry::make('strengths')
                        ->label('Fortalezas observadas')
                        ->prose()
                        ->columnSpanFull(),

                    \Filament\Infolists\Components\TextEntry::make('gaps')
                        ->label('Brechas identificadas')
                        ->prose()
                        ->columnSpanFull(),

                    \Filament\Infolists\Components\TextEntry::make('single_action')
                        ->label('Accion de mejora')
                        ->prose()
                        ->columnSpanFull(),

                    \Filament\Infolists\Components\TextEntry::make('ritual.name')
                        ->label('Ritual foco')
                        ->placeholder('-'),
                ])->columns(1),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('session_date')
                    ->label('Fecha')
                    ->dateTime('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('session_type')
                    ->label('Tipo')
                    ->badge()
                    ->formatStateUsing(fn($state) => match ($state) {
                        'weekly_plan'      => 'Plan semanal',
                        'risk_management'  => 'Gestion de riesgo',
                        'wins_losses'      => 'Ganancias y perdidas',
                        'quarterly_growth' => 'Crecimiento trimestral',
                        'field_coaching'   => 'Coaching en campo',
                        default            => $state,
                    })
                    ->color('primary'),

                Tables\Columns\TextColumn::make('coach.name')
                    ->label('Coach'),

                Tables\Columns\TextColumn::make('single_action')
                    ->label('Accion de mejora')
                    ->limit(50)
                    ->placeholder('-'),

                Tables\Columns\IconColumn::make('trainee_ack')
                    ->label('Confirmado')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-clock')
                    ->trueColor('success')
                    ->falseColor('warning'),
            ])
            ->recordActions([
                ViewAction::make()->label('Ver'),
                Action::make('confirmar_lectura')
                    ->label('Confirmar lectura')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->visible(fn(FeedbackSession $record) => ! $record->trainee_ack)
                    ->requiresConfirmation()
                    ->modalHeading('Confirmar lectura del feedback')
                    ->modalDescription('Al confirmar, indicas que leiste y entendiste el feedback de tu coach. Esta accion no se puede deshacer.')
                    ->modalSubmitActionLabel('Si, confirmo que lo lei')
                    ->action(fn(FeedbackSession $record) => $record->acknowledge()),
            ])
            ->toolbarActions([])
            ->emptyStateHeading('No tienes sesiones de feedback registradas')
            ->emptyStateDescription('Tu coach registrara las sesiones de feedback. Apareceran aqui cuando esten disponibles.')
            ->defaultSort('session_date', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFeedback::route('/'),
            'view'  => Pages\ViewFeedback::route('/{record}'),
        ];
    }
}

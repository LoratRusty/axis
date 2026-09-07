<?php

namespace App\Filament\Manager\Resources;

use App\Filament\Manager\Resources\ProgramaResource\Pages;
use App\Models\TrainingProgram;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ProgramaResource extends Resource
{
    protected static ?string $model = TrainingProgram::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?string $navigationLabel  = 'Programas';
    protected static ?string $modelLabel       = 'Programa';
    protected static ?string $pluralModelLabel = 'Programas de Entrenamiento';
    protected static ?int    $navigationSort   = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([

            \Filament\Schemas\Components\Section::make('Datos del programa')
                ->schema([
                    \Filament\Infolists\Components\TextEntry::make('trainee.name')
                        ->label('Trainee'),
                    \Filament\Infolists\Components\TextEntry::make('coach.name')
                        ->label('Coach'),
                    \Filament\Infolists\Components\TextEntry::make('start_date')
                        ->label('Inicio')
                        ->date('d/m/Y'),
                    \Filament\Infolists\Components\TextEntry::make('status')
                        ->label('Estado')
                        ->badge()
                        ->formatStateUsing(fn($state) => match ($state) {
                            'active'       => 'Activo',
                            'on_hold'      => 'En pausa',
                            'graduated'    => 'Graduado',
                            'discontinued' => 'Discontinuado',
                            default        => $state,
                        })
                        ->color(fn($state) => match ($state) {
                            'active'       => 'success',
                            'on_hold'      => 'warning',
                            'graduated'    => 'primary',
                            'discontinued' => 'danger',
                            default        => 'gray',
                        }),
                ])->columns(2),

            \Filament\Schemas\Components\Section::make('Progreso actual')
                ->schema([
                    \Filament\Infolists\Components\TextEntry::make('current_week')
                        ->label('Semana')
                        ->numeric(),
                    \Filament\Infolists\Components\TextEntry::make('current_stage')
                        ->label('Fase')
                        ->badge(),
                    \Filament\Infolists\Components\TextEntry::make('current_subrole')
                        ->label('Sub-Rol')
                        ->badge()
                        ->formatStateUsing(fn($state) => ucfirst($state)),
                    \Filament\Infolists\Components\TextEntry::make('currentWeekTracking.actual_interactions')
                        ->label('Interacciones esta semana')
                        ->placeholder('-'),
                    \Filament\Infolists\Components\TextEntry::make('currentWeekTracking.rituals_completed')
                        ->label('Rituales completados')
                        ->placeholder('-'),
                    \Filament\Infolists\Components\TextEntry::make('currentWeekTracking.target_interactions')
                        ->label('Meta interacciones')
                        ->placeholder('-'),
                ])->columns(3),

            \Filament\Schemas\Components\Section::make('Recomendacion de ascenso')
                ->visible(fn($record) => $record->hasPromotionPending())
                ->schema([
                    \Filament\Infolists\Components\TextEntry::make('promotionRecommendedBy.name')
                        ->label('Recomendado por'),
                    \Filament\Infolists\Components\TextEntry::make('promotion_recommended_at')
                        ->label('Fecha')
                        ->dateTime('d/m/Y H:i'),
                    \Filament\Infolists\Components\TextEntry::make('promotion_recommendation_notes')
                        ->label('Justificacion del coach')
                        ->placeholder('-')
                        ->columnSpanFull(),
                ])->columns(2),

            \Filament\Schemas\Components\Section::make('Notas')
                ->schema([
                    \Filament\Infolists\Components\TextEntry::make('notes')
                        ->label('Notas del programa')
                        ->placeholder('Sin notas')
                        ->columnSpanFull(),
                ]),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('trainee.name')
                    ->label('Trainee')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('coach.name')
                    ->label('Coach')
                    ->searchable(),

                Tables\Columns\TextColumn::make('current_week')
                    ->label('Semana')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('current_stage')
                    ->label('Fase')
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'A' => 'gray',
                        'B' => 'info',
                        'C' => 'warning',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('current_subrole')
                    ->label('Sub-Rol')
                    ->badge()
                    ->formatStateUsing(fn($state) => ucfirst($state)),

                Tables\Columns\TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->formatStateUsing(fn($state) => match ($state) {
                        'active'       => 'Activo',
                        'on_hold'      => 'En pausa',
                        'graduated'    => 'Graduado',
                        'discontinued' => 'Discontinuado',
                        default        => $state,
                    })
                    ->color(fn($state) => match ($state) {
                        'active'       => 'success',
                        'on_hold'      => 'warning',
                        'graduated'    => 'primary',
                        'discontinued' => 'danger',
                        default        => 'gray',
                    }),

                Tables\Columns\IconColumn::make('promotion_recommended_at')
                    ->label('Ascenso pendiente')
                    ->boolean()
                    ->trueIcon('heroicon-o-arrow-up-circle')
                    ->falseIcon('heroicon-o-minus')
                    ->trueColor('warning')
                    ->falseColor('gray')
                    ->getStateUsing(fn($record) => $record->hasPromotionPending()),

                Tables\Columns\TextColumn::make('promotion_recommended_at')
                    ->label('Recomendado el')
                    ->dateTime('d/m/Y')
                    ->placeholder('-')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Estado')
                    ->options([
                        'active'       => 'Activo',
                        'on_hold'      => 'En pausa',
                        'graduated'    => 'Graduado',
                        'discontinued' => 'Discontinuado',
                    ]),

                Tables\Filters\Filter::make('ascenso_pendiente')
                    ->label('Con ascenso pendiente')
                    ->query(
                        fn(Builder $query) => $query
                            ->whereNotNull('promotion_recommended_at')
                            ->where('status', 'active')
                    ),
            ])
            ->recordActions([
                \Filament\Actions\ViewAction::make()->label('Ver'),
            ])
            ->toolbarActions([])
            ->defaultSort('promotion_recommended_at', 'desc')
            ->emptyStateHeading('No hay programas registrados');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProgramas::route('/'),
            'view'  => Pages\ViewPrograma::route('/{record}'),
        ];
    }
}

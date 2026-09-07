<?php

namespace App\Filament\Coach\Resources\FeedbackSessions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FeedbackSessionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('trainingProgram.trainee.name')
                    ->label('Trainee')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('session_type')
                    ->label('Tipo de sesión')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match($state) {
                        'weekly_plan'      => 'Plan semanal',
                        'risk_management'  => 'Gestión de riesgo',
                        'wins_losses'      => 'Ganadas y perdidas',
                        'quarterly_growth' => 'Crecimiento trimestral',
                        'field_coaching'   => 'Coaching en campo',
                        default            => $state,
                    }),
                TextColumn::make('session_date')
                    ->label('Fecha')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('single_action')
                    ->label('Acción de mejora')
                    ->limit(50)
                    ->placeholder('Sin acción'),
                IconColumn::make('trainee_ack')
                    ->label('Leído')
                    ->boolean(),
            ])
            ->defaultSort('session_date', 'desc')
            ->recordActions([
                ViewAction::make()->label('Ver'),
                EditAction::make()->label('Editar'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->label('Eliminar'),
                ]),
            ]);
    }
}
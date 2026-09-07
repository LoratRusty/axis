<?php

namespace App\Filament\Coach\Resources\TrainingPrograms\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TrainingProgramsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('trainee.name')
                    ->label('Trainee')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('coach.name')
                    ->label('Coach')
                    ->searchable(),
                TextColumn::make('start_date')
                    ->label('Inicio')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('current_week')
                    ->label('Semana')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('current_stage')
                    ->label('Fase')
                    ->badge()
                    ->color(fn (string $state): string => match($state) {
                        'A' => 'gray',
                        'B' => 'info',
                        'C' => 'warning',
                        'D' => 'success',
                        'E' => 'primary',
                        default => 'gray',
                    }),
                TextColumn::make('current_subrole')
                    ->label('Sub-Rol')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->color(fn (string $state): string => match($state) {
                        'active'       => 'success',
                        'on_hold'      => 'warning',
                        'graduated'    => 'primary',
                        'discontinued' => 'danger',
                        default        => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match($state) {
                        'active'       => 'Activo',
                        'on_hold'      => 'En pausa',
                        'graduated'    => 'Graduado',
                        'discontinued' => 'Discontinuado',
                        default        => $state,
                    }),
            ])
            ->defaultSort('start_date', 'desc')
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
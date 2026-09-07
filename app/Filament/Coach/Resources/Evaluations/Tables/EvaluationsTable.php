<?php

namespace App\Filament\Coach\Resources\Evaluations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EvaluationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('trainingProgram.trainee.name')
                    ->label('Trainee')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('instrument')
                    ->label('Instrumento')
                    ->badge()
                    ->color(fn (string $state): string => match($state) {
                        'I1' => 'gray',
                        'I2' => 'info',
                        'I3' => 'warning',
                        'I4' => 'success',
                        'I5' => 'primary',
                        'I6' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('ritual.name')
                    ->label('Ritual')
                    ->placeholder('-'),
                TextColumn::make('quality_level')
                    ->label('Nivel')
                    ->formatStateUsing(fn ($state): string => match((string)$state) {
                        '1' => 'Mecánico',
                        '2' => 'Funcional',
                        '3' => 'Estratégico',
                        '4' => 'Experto',
                        default => '-',
                    })
                    ->placeholder('-'),
                TextColumn::make('dimension_focus')
                    ->label('Dimensión')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match($state) {
                        'volume'  => 'Volumen',
                        'time'    => 'Tiempo',
                        'quality' => 'Calidad',
                        'cost'    => 'Costo',
                        default   => '-',
                    }),
                IconColumn::make('advance_to_next')
                    ->label('Avanza')
                    ->boolean(),
                TextColumn::make('evaluated_at')
                    ->label('Fecha')
                    ->date('d/m/Y')
                    ->sortable(),
            ])
            ->defaultSort('evaluated_at', 'desc')
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
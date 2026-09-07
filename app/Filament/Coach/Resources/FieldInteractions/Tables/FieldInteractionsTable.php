<?php

namespace App\Filament\Coach\Resources\FieldInteractions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FieldInteractionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('trainingProgram.trainee.name')
                    ->label('Trainee')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('client_name')
                    ->label('Cliente')
                    ->searchable(),
                TextColumn::make('visit_date')
                    ->label('Fecha de visita')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('visit_type')
                    ->label('Tipo')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match($state) {
                        'prospecting' => 'Prospección',
                        'discovery'   => 'Descubrimiento',
                        'proposal'    => 'Propuesta',
                        'negotiation' => 'Negociación',
                        'closing'     => 'Cierre',
                        'follow_up'   => 'Seguimiento',
                        default       => $state,
                    }),
                IconColumn::make('is_valid')
                    ->label('Válida')
                    ->boolean(),
            ])
            ->defaultSort('visit_date', 'desc')
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
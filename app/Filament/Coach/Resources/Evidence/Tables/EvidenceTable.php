<?php

namespace App\Filament\Coach\Resources\Evidence\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EvidenceTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('trainingProgram.trainee.name')
                    ->label('Trainee')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('ritual.name')
                    ->label('Ritual')
                    ->searchable(),
                TextColumn::make('title')
                    ->label('Título')
                    ->searchable(),
                TextColumn::make('evidence_type')
                    ->label('Tipo')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match($state) {
                        'document' => 'Documento',
                        'image'    => 'Imagen',
                        'url'      => 'URL',
                        'audio'    => 'Audio',
                        'video'    => 'Video',
                        'form'     => 'Formulario',
                        default    => $state,
                    }),
                TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->color(fn (string $state): string => match($state) {
                        'approved'       => 'success',
                        'needs_revision' => 'warning',
                        'rejected'       => 'danger',
                        default          => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match($state) {
                        'pending_review' => 'Pendiente',
                        'approved'       => 'Aprobada',
                        'needs_revision' => 'Requiere revisión',
                        'rejected'       => 'Rechazada',
                        default          => $state,
                    }),
                TextColumn::make('created_at')
                    ->label('Fecha')
                    ->date('d/m/Y')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
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
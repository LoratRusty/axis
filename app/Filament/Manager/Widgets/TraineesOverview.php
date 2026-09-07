<?php

namespace App\Filament\Manager\Widgets;

use App\Models\TrainingProgram;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class TraineesOverview extends TableWidget
{
    protected static ?string $heading = 'Estado del Equipo Comercial';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                fn(): Builder => TrainingProgram::query()
                    ->where('status', 'active')
                    ->with(['trainee', 'coach', 'weeklyTrackings' => function ($q) {
                        $q->where('status', 'in_progress');
                    }])
            )
            ->columns([
                TextColumn::make('trainee.name')
                    ->label('Trainee')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('coach.name')
                    ->label('Coach')
                    ->searchable(),
                TextColumn::make('current_stage')
                    ->label('Fase')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
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
                    ->formatStateUsing(fn(string $state): string => ucfirst($state)),
                TextColumn::make('current_week')
                    ->label('Semana')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('interacciones')
                    ->label('Interacciones')
                    ->getStateUsing(function (TrainingProgram $record): string {
                        $semana = $record->weeklyTrackings->first();
                        if (!$semana) return '-';
                        return "{$semana->actual_interactions} / {$semana->target_interactions}";
                    }),
                TextColumn::make('rituales')
                    ->label('Rituales')
                    ->getStateUsing(function (TrainingProgram $record): string {
                        $semana = $record->weeklyTrackings->first();
                        if (!$semana) return '-';
                        return "{$semana->rituals_completed} / {$semana->rituals_target}";
                    }),
                TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'active'       => 'Activo',
                        'on_hold'      => 'En pausa',
                        'graduated'    => 'Graduado',
                        'discontinued' => 'Discontinuado',
                        default        => $state,
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'active'       => 'success',
                        'on_hold'      => 'warning',
                        'graduated'    => 'primary',
                        'discontinued' => 'danger',
                        default        => 'gray',
                    }),
                IconColumn::make('en_riesgo')
                    ->label('En riesgo')
                    ->boolean()
                    ->getStateUsing(function (TrainingProgram $record): bool {
                        $semana = $record->weeklyTrackings->first();
                        if (!$semana) return true;
                        $sinInteracciones = $semana->actual_interactions === 0;
                        $pocosRituales    = $semana->rituals_target > 0
                            && ($semana->rituals_completed / $semana->rituals_target) < 0.5;
                        return !($sinInteracciones || $pocosRituales);
                    })
                    ->trueColor('success')
                    ->falseColor('danger'),
            ])
            ->defaultSort('current_stage');
    }
}

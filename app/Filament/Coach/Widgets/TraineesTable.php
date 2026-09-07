<?php

namespace App\Filament\Coach\Widgets;

use App\Models\TrainingProgram;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class TraineesTable extends TableWidget
{
    protected static ?string $heading = 'Mis Trainees - Semana Actual';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                fn (): Builder => TrainingProgram::query()
                    ->where('coach_id', auth()->id())
                    ->where('status', 'active')
                    ->with(['trainee', 'weeklyTrackings' => function ($q) {
                        $q->where('status', 'in_progress');
                    }])
            )
            ->columns([
                TextColumn::make('trainee.name')
                    ->label('Trainee')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('current_subrole')
                    ->label('Sub-Rol')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
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
                TextColumn::make('current_week')
                    ->label('Semana')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('weeklyTrackings.actual_interactions')
                    ->label('Interacciones')
                    ->formatStateUsing(function ($state, TrainingProgram $record): string {
                        $semana = $record->weeklyTrackings->first();
                        if (!$semana) return '-';
                        return "{$semana->actual_interactions} / {$semana->target_interactions}";
                    }),
                TextColumn::make('weeklyTrackings.rituals_completed')
                    ->label('Rituales')
                    ->formatStateUsing(function ($state, TrainingProgram $record): string {
                        $semana = $record->weeklyTrackings->first();
                        if (!$semana) return '-';
                        return "{$semana->rituals_completed} / {$semana->rituals_target}";
                    }),
                IconColumn::make('en_riesgo')
                    ->label('En riesgo')
                    ->boolean()
                    ->getStateUsing(function (TrainingProgram $record): bool {
                        $semana = $record->weeklyTrackings->first();
                        if (!$semana) return false;
                        return $semana->actual_interactions === 0
                            || $semana->rituals_completed < ($semana->rituals_target * 0.5);
                    })
                    ->trueColor('success')
                    ->falseColor('danger'),
            ])
            ->defaultSort('trainee.name');
    }
}
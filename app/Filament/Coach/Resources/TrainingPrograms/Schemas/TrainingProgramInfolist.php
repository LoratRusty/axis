<?php

namespace App\Filament\Coach\Resources\TrainingPrograms\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TrainingProgramInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Section::make('Datos del programa')
                ->schema([
                    TextEntry::make('trainee.name')
                        ->label('Trainee'),
                    TextEntry::make('coach.name')
                        ->label('Coach'),
                    TextEntry::make('start_date')
                        ->label('Fecha de inicio')
                        ->date('d/m/Y'),
                    TextEntry::make('status')
                        ->label('Estado')
                        ->badge()
                        ->color(fn(string $state): string => match($state) {
                            'active'       => 'success',
                            'on_hold'      => 'warning',
                            'graduated'    => 'primary',
                            'discontinued' => 'danger',
                            default        => 'gray',
                        })
                        ->formatStateUsing(fn(string $state): string => match($state) {
                            'active'       => 'Activo',
                            'on_hold'      => 'En pausa',
                            'graduated'    => 'Graduado',
                            'discontinued' => 'Discontinuado',
                            default        => $state,
                        }),
                ])->columns(2),

            Section::make('Progreso actual')
                ->schema([
                    TextEntry::make('current_week')
                        ->label('Semana actual')
                        ->numeric(),
                    TextEntry::make('current_stage')
                        ->label('Fase')
                        ->badge()
                        ->color(fn(string $state): string => match($state) {
                            'A' => 'gray',
                            'B' => 'info',
                            'C' => 'warning',
                            default => 'gray',
                        }),
                    TextEntry::make('current_subrole')
                        ->label('Sub-Rol actual')
                        ->badge()
                        ->formatStateUsing(fn(string $state): string => ucfirst($state)),
                    TextEntry::make('currentWeekTracking.target_interactions')
                        ->label('Meta interacciones semana')
                        ->placeholder('-'),
                    TextEntry::make('currentWeekTracking.actual_interactions')
                        ->label('Interacciones realizadas')
                        ->placeholder('-'),
                    TextEntry::make('currentWeekTracking.rituals_completed')
                        ->label('Rituales completados')
                        ->placeholder('-'),
                    TextEntry::make('currentWeekTracking.rituals_target')
                        ->label('Meta rituales')
                        ->placeholder('-'),
                    TextEntry::make('currentWeekTracking.status')
                        ->label('Estado semana')
                        ->badge()
                        ->formatStateUsing(fn($state) => match($state) {
                            'in_progress' => 'En curso',
                            'closed'      => 'Cerrada',
                            'pending'     => 'Pendiente',
                            default       => $state ?? '-',
                        })
                        ->color(fn($state) => match($state) {
                            'in_progress' => 'success',
                            'closed'      => 'gray',
                            default       => 'warning',
                        }),
                ])->columns(4),

            Section::make('Notas')
                ->schema([
                    TextEntry::make('notes')
                        ->label('Notas del programa')
                        ->placeholder('Sin notas')
                        ->columnSpanFull(),
                ])->columns(1),

        ]);
    }
}
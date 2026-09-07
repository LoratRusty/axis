<?php

namespace App\Filament\Coach\Resources\FeedbackSessions\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FeedbackSessionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Section::make('Datos de la sesion')
                ->description('Informacion general de la sesion de feedback.')
                ->schema([
                    TextEntry::make('trainingProgram.trainee.name')
                        ->label('Trainee'),
                    TextEntry::make('coach.name')
                        ->label('Coach'),
                    TextEntry::make('session_type')
                        ->label('Tipo de sesion')
                        ->badge()
                        ->color('primary')
                        ->formatStateUsing(fn(string $state): string => match($state) {
                            'weekly_plan'      => 'Plan semanal',
                            'risk_management'  => 'Gestion de riesgo',
                            'wins_losses'      => 'Ganancias y perdidas',
                            'quarterly_growth' => 'Crecimiento trimestral',
                            'field_coaching'   => 'Coaching en campo',
                            default            => $state,
                        }),
                    TextEntry::make('session_date')
                        ->label('Fecha de sesion')
                        ->date('d/m/Y'),
                    TextEntry::make('ritual.name')
                        ->label('Ritual foco')
                        ->placeholder('-'),
                    IconEntry::make('trainee_ack')
                        ->label('Leido por el trainee')
                        ->boolean()
                        ->trueColor('success')
                        ->falseColor('warning'),
                ])->columns(2),

            Section::make('Contenido del feedback')
                ->description('Observaciones estructuradas del coach para esta sesion.')
                ->schema([
                    TextEntry::make('strengths')
                        ->label('Fortalezas observadas')
                        ->placeholder('Sin registrar')
                        ->columnSpanFull(),
                    TextEntry::make('gaps')
                        ->label('Brechas identificadas')
                        ->placeholder('Sin registrar')
                        ->columnSpanFull(),
                    TextEntry::make('single_action')
                        ->label('Accion de mejora prioritaria')
                        ->placeholder('Sin registrar')
                        ->columnSpanFull(),
                ])->columns(1),

        ]);
    }
}
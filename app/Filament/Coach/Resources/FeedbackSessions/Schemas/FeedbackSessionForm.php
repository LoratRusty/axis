<?php

namespace App\Filament\Coach\Resources\FeedbackSessions\Schemas;

use App\Models\Ritual;
use App\Models\TrainingProgram;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FeedbackSessionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Section::make('Sesion de feedback')
                ->schema([

                    Select::make('program_id')
                        ->label('Trainee')
                        ->options(function () {
                            return TrainingProgram::with('trainee')
                                ->active()
                                ->get()
                                ->mapWithKeys(fn($p) => [
                                    $p->id => $p->trainee->name . ' - Sem. ' . $p->current_week . ' (' . $p->current_subrole . ')',
                                ]);
                        })
                        ->required()
                        ->searchable()
                        ->live(),

                    Select::make('session_type')
                        ->label('Tipo de sesion')
                        ->options([
                            'weekly_plan'      => 'Plan semanal',
                            'risk_management'  => 'Gestion de riesgo',
                            'wins_losses'      => 'Ganancias y perdidas',
                            'quarterly_growth' => 'Crecimiento trimestral',
                            'field_coaching'   => 'Coaching en campo',
                        ])
                        ->required(),

                    DateTimePicker::make('session_date')
                        ->label('Fecha de la sesion')
                        ->required()
                        ->default(now()),

                    Select::make('ritual_focus')
                        ->label('Ritual foco')
                        ->options(function () {
                            return Ritual::active()
                                ->orderBy('number')
                                ->get()
                                ->mapWithKeys(fn($r) => [
                                    $r->id => $r->number . '. ' . $r->name,
                                ]);
                        })
                        ->searchable()
                        ->nullable(),

                ])->columns(2),

            Section::make('Contenido del feedback')
                ->description('Cada campo debe ser especifico y accionable. Minimo 30 palabras por campo.')
                ->schema([

                    Textarea::make('strengths')
                        ->label('Fortalezas observadas')
                        ->helperText('Describe comportamientos especificos que el trainee demostro correctamente.')
                        ->required()
                        ->rows(4)
                        ->minLength(30)
                        ->columnSpanFull(),

                    Textarea::make('gaps')
                        ->label('Brechas identificadas')
                        ->helperText('Describe de forma objetiva las areas donde el trainee debe mejorar.')
                        ->required()
                        ->rows(4)
                        ->minLength(30)
                        ->columnSpanFull(),

                    Textarea::make('single_action')
                        ->label('Accion de mejora prioritaria')
                        ->helperText('Una sola accion concreta y verificable. No uses listas.')
                        ->required()
                        ->rows(3)
                        ->columnSpanFull(),

                ])->columns(1),

        ]);
    }
}
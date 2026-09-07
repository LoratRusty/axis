<?php

namespace App\Filament\Coach\Resources\Evaluations\Schemas;

use App\Models\Ritual;
use App\Models\TrainingProgram;
use App\Models\WeeklyTracking;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EvaluationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Section::make('Identificacion')
                ->schema([
                    Select::make('program_id')
                        ->label('Trainee')
                        ->options(fn() => TrainingProgram::with('trainee')
                            ->active()
                            ->get()
                            ->mapWithKeys(fn($p) => [
                                $p->id => $p->trainee->name . ' - Sem. ' . $p->current_week,
                            ])
                        )
                        ->required()
                        ->searchable()
                        ->live(),

                    Select::make('ritual_id')
                        ->label('Ritual evaluado')
                        ->options(fn() => Ritual::active()
                            ->orderBy('number')
                            ->get()
                            ->mapWithKeys(fn($r) => [$r->id => $r->number . '. ' . $r->name])
                        )
                        ->searchable(),

                    Select::make('instrument')
                        ->label('Instrumento')
                        ->options([
                            'I1' => 'I1 - Matriz de Planificacion',
                            'I2' => 'I2 - Interaccion de Campo',
                            'I3' => 'I3 - Documento SPICED',
                            'I4' => 'I4 - Acuerdo Mutuo',
                            'I5' => 'I5 - Evidencia Fisica',
                            'I6' => 'I6 - Rubrica de Evaluacion',
                        ])
                        ->required(),

                    DateTimePicker::make('evaluated_at')
                        ->label('Fecha de evaluacion')
                        ->default(now()),

                ])->columns(2),

            Section::make('Resultados')
                ->schema([
                    Select::make('evidence_status')
                        ->label('Estado de la evidencia')
                        ->options([
                            'active'   => 'Activa',
                            'partial'  => 'Parcial',
                            'inactive' => 'Inactiva',
                        ]),

                    Select::make('frequency_level')
                        ->label('Nivel de frecuencia')
                        ->options([
                            'high'         => 'Alto',
                            'moderate'     => 'Moderado',
                            'low'          => 'Bajo',
                            'non_existent' => 'No existe',
                        ]),

                    TextInput::make('frequency_pct')
                        ->label('Frecuencia (%)')
                        ->numeric()
                        ->suffix('%'),

                    TextInput::make('quality_level')
                        ->label('Nivel de calidad (1-4)')
                        ->numeric()
                        ->minValue(1)
                        ->maxValue(4),

                    TextInput::make('overall_score')
                        ->label('Puntaje general')
                        ->numeric(),

                    Select::make('dimension_focus')
                        ->label('Dimension de optimizacion')
                        ->options([
                            'volume'  => 'Volumen',
                            'time'    => 'Tiempo',
                            'quality' => 'Calidad',
                            'cost'    => 'Costo',
                        ]),

                    Toggle::make('field_observed')
                        ->label('Observado en campo')
                        ->inline(false),

                    Toggle::make('advance_to_next')
                        ->label('Listo para avanzar al siguiente proceso')
                        ->inline(false),

                ])->columns(2),

            Section::make('Notas de evaluacion')
                ->schema([
                    Textarea::make('strengths')
                        ->label('Fortalezas observadas')
                        ->rows(3)
                        ->columnSpanFull(),

                    Textarea::make('gaps')
                        ->label('Brechas identificadas')
                        ->rows(3)
                        ->columnSpanFull(),

                    Textarea::make('improvement_action')
                        ->label('Accion de mejora')
                        ->rows(3)
                        ->columnSpanFull(),

                    Textarea::make('field_notes')
                        ->label('Notas de campo')
                        ->rows(3)
                        ->columnSpanFull(),

                    Textarea::make('next_cycle_focus')
                        ->label('Foco del proximo ciclo')
                        ->rows(3)
                        ->columnSpanFull(),

                    Textarea::make('notes')
                        ->label('Notas adicionales')
                        ->rows(3)
                        ->columnSpanFull(),

                ])->columns(1),

        ]);
    }
}
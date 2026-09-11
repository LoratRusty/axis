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
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EvaluationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Section::make('Identificación')
                ->schema([
                    Select::make('program_id')
                        ->label('Trainee')
                        ->options(
                            fn() => TrainingProgram::with('trainee')
                                ->active()
                                ->get()
                                ->mapWithKeys(fn($p) => [
                                    $p->id => $p->trainee->name . ' - Sem. ' . $p->current_week,
                                ])
                        )
                        ->required()
                        ->searchable()
                        ->live(),

                    Select::make('weekly_tracking_id')
                        ->label('Semana a evaluar')
                        ->options(function (callable $get) {
                            $programId = $get('program_id');
                            if (! $programId) return [];
                            return WeeklyTracking::where('program_id', $programId)
                                ->orderByDesc('week_number')
                                ->get()
                                ->mapWithKeys(fn($wt) => [
                                    $wt->id => 'Semana ' . $wt->week_number . ' (' . ($wt->week_start_date?->format('d/m/Y') ?? '-') . ')',
                                ]);
                        })
                        ->required()
                        ->searchable()
                        ->live(),

                    Select::make('instrument')
                        ->label('Instrumento')
                        ->options([
                            'I1' => 'I1 - Matriz de Planificación',
                            'I2' => 'I2 - Interacción de Campo',
                            'I6' => 'I6 - Rúbrica de Evaluación',
                        ])
                        ->required(),

                    DateTimePicker::make('evaluated_at')
                        ->label('Fecha de evaluación')
                        ->default(now()),

                ])->columns(2),

            Section::make('Calificación por Ritual')
                ->description('Selecciona la semana primero. Se mostrarán los rituales correspondientes para calificar del 1 al 10.')
                ->schema([
                    Repeater::make('ritualScores')
                        ->label('')
                        ->relationship('ritualScores')
                        ->schema([
                            Select::make('ritual_id')
                                ->label('Ritual')
                                ->options(function (callable $get) {
                                    $weeklyTrackingId = $get('../../weekly_tracking_id');
                                    $programId = $get('../../program_id');

                                    if (! $programId) return [];

                                    $program = TrainingProgram::find($programId);
                                    if (! $program) return [];

                                    return Ritual::active()
                                        ->whereHas('phase', fn($q) => $q->where('code', $program->current_stage))
                                        ->orderBy('number')
                                        ->get()
                                        ->mapWithKeys(fn($r) => [$r->id => $r->number . '. ' . $r->name]);
                                })
                                ->required()
                                ->searchable()
                                ->distinct()
                                ->disableOptionsWhenSelectedInSiblingRepeaterItems(),

                            Select::make('score')
                                ->label('Calificación (1-10)')
                                ->options(array_combine(range(1, 10), range(1, 10)))
                                ->required(),

                            Textarea::make('notes')
                                ->label('Notas a mejorar')
                                ->rows(2)
                                ->columnSpanFull(),
                        ])
                        ->columns(2)
                        ->addActionLabel('Agregar ritual')
                        ->defaultItems(0)
                        ->columnSpanFull(),

                ])->columns(1),

            Section::make('Notas generales de la evaluación')
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
                        ->label('Acción de mejora')
                        ->rows(3)
                        ->columnSpanFull(),

                    Textarea::make('notes')
                        ->label('Notas adicionales')
                        ->rows(3)
                        ->columnSpanFull(),

                    Toggle::make('advance_to_next')
                        ->label('Listo para avanzar al siguiente proceso')
                        ->inline(false),

                ])->columns(1),

        ]);
    }
}

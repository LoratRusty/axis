<?php

namespace App\Filament\Coach\Resources\Evaluations\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EvaluationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Section::make('Identificacion')
                ->description('Datos generales de la evaluacion.')
                ->schema([
                    TextEntry::make('trainingProgram.trainee.name')
                        ->label('Trainee'),
                    TextEntry::make('coach.name')
                        ->label('Coach'),
                    TextEntry::make('instrument')
                        ->label('Instrumento')
                        ->badge()
                        ->color('primary')
                        ->formatStateUsing(fn(string $state): string => match($state) {
                            'I1' => 'I1 - Matriz de Planificacion',
                            'I2' => 'I2 - Interaccion de Campo',
                            'I3' => 'I3 - Documento SPICED',
                            'I4' => 'I4 - Acuerdo Mutuo',
                            'I5' => 'I5 - Evidencia Fisica',
                            'I6' => 'I6 - Rubrica de Evaluacion',
                            default => $state,
                        }),
                    TextEntry::make('ritual.name')
                        ->label('Ritual evaluado')
                        ->placeholder('-'),
                    TextEntry::make('evaluated_at')
                        ->label('Fecha de evaluacion')
                        ->dateTime('d/m/Y H:i'),
                    TextEntry::make('dimension_focus')
                        ->label('Dimension de optimizacion')
                        ->badge()
                        ->formatStateUsing(fn(?string $state): string => match($state) {
                            'volume'  => 'Volumen',
                            'time'    => 'Tiempo',
                            'quality' => 'Calidad',
                            'cost'    => 'Costo',
                            default   => '-',
                        }),
                ])->columns(2),

            Section::make('Resultados')
                ->description('Indicadores cuantitativos de la evaluacion.')
                ->schema([
                    TextEntry::make('evidence_status')
                        ->label('Estado de evidencia')
                        ->badge()
                        ->formatStateUsing(fn(?string $state): string => match($state) {
                            'active'   => 'Activa',
                            'partial'  => 'Parcial',
                            'inactive' => 'Inactiva',
                            default    => '-',
                        })
                        ->color(fn(?string $state): string => match($state) {
                            'active'   => 'success',
                            'partial'  => 'warning',
                            'inactive' => 'danger',
                            default    => 'gray',
                        }),
                    TextEntry::make('frequency_level')
                        ->label('Nivel de frecuencia')
                        ->badge()
                        ->formatStateUsing(fn(?string $state): string => match($state) {
                            'high'         => 'Alto',
                            'moderate'     => 'Moderado',
                            'low'          => 'Bajo',
                            'non_existent' => 'No existe',
                            default        => '-',
                        }),
                    TextEntry::make('frequency_pct')
                        ->label('Frecuencia (%)')
                        ->suffix('%')
                        ->placeholder('-'),
                    TextEntry::make('quality_level')
                        ->label('Nivel de calidad')
                        ->formatStateUsing(fn($state): string => match((string)$state) {
                            '1' => '1 - Mecanico',
                            '2' => '2 - Funcional',
                            '3' => '3 - Estrategico',
                            '4' => '4 - Experto',
                            default => '-',
                        })
                        ->placeholder('-'),
                    TextEntry::make('overall_score')
                        ->label('Puntaje general')
                        ->placeholder('-'),
                    IconEntry::make('field_observed')
                        ->label('Observado en campo')
                        ->boolean()
                        ->trueColor('success')
                        ->falseColor('danger'),
                    IconEntry::make('advance_to_next')
                        ->label('Listo para avanzar')
                        ->boolean()
                        ->trueColor('success')
                        ->falseColor('warning'),
                ])->columns(3),

            Section::make('Notas de evaluacion')
                ->description('Observaciones cualitativas del coach.')
                ->schema([
                    TextEntry::make('strengths')
                        ->label('Fortalezas observadas')
                        ->placeholder('-')
                        ->columnSpanFull(),
                    TextEntry::make('gaps')
                        ->label('Brechas identificadas')
                        ->placeholder('-')
                        ->columnSpanFull(),
                    TextEntry::make('improvement_action')
                        ->label('Accion de mejora')
                        ->placeholder('-')
                        ->columnSpanFull(),
                    TextEntry::make('field_notes')
                        ->label('Notas de campo')
                        ->placeholder('-')
                        ->columnSpanFull(),
                    TextEntry::make('next_cycle_focus')
                        ->label('Foco del proximo ciclo')
                        ->placeholder('-')
                        ->columnSpanFull(),
                    TextEntry::make('notes')
                        ->label('Notas adicionales')
                        ->placeholder('-')
                        ->columnSpanFull(),
                ])->columns(1),

        ]);
    }
}
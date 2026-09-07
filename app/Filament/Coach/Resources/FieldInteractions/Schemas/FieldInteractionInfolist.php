<?php

namespace App\Filament\Coach\Resources\FieldInteractions\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FieldInteractionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Section::make('Datos de la visita')
                ->description('Informacion general de la interaccion de campo registrada.')
                ->schema([
                    TextEntry::make('trainingProgram.trainee.name')
                        ->label('Trainee'),
                    TextEntry::make('visit_date')
                        ->label('Fecha de visita')
                        ->date('d/m/Y'),
                    TextEntry::make('client_name')
                        ->label('Cliente'),
                    TextEntry::make('client_account')
                        ->label('Cuenta')
                        ->placeholder('-'),
                    TextEntry::make('visit_type')
                        ->label('Tipo de visita')
                        ->badge()
                        ->color('primary')
                        ->formatStateUsing(fn(string $state): string => match($state) {
                            'prospecting' => 'Prospeccion',
                            'discovery'   => 'Descubrimiento',
                            'proposal'    => 'Propuesta',
                            'negotiation' => 'Negociacion',
                            'closing'     => 'Cierre',
                            'follow_up'   => 'Seguimiento',
                            default       => $state,
                        }),
                    TextEntry::make('is_valid')
                        ->label('Resultado')
                        ->badge()
                        ->formatStateUsing(fn($state) => $state ? 'Interaccion valida' : 'Interaccion no valida')
                        ->color(fn($state) => $state ? 'success' : 'danger'),
                    TextEntry::make('spiced_doc_url')
                        ->label('Documento SPICED')
                        ->placeholder('-')
                        ->url(fn($state) => $state),
                    TextEntry::make('notes')
                        ->label('Notas')
                        ->placeholder('-')
                        ->columnSpanFull(),
                ])->columns(2),

            Section::make('Validacion - Las 5 Normas')
                ->description('Una interaccion es valida solo si cumple las 5 normas del programa.')
                ->schema([
                    IconEntry::make('is_in_matrix')
                        ->label('En Matriz de Planificacion')
                        ->boolean()
                        ->trueColor('success')
                        ->falseColor('danger'),
                    IconEntry::make('is_scheduled')
                        ->label('Agendada proactivamente')
                        ->boolean()
                        ->trueColor('success')
                        ->falseColor('danger'),
                    IconEntry::make('is_presential')
                        ->label('Presencial')
                        ->boolean()
                        ->trueColor('success')
                        ->falseColor('danger'),
                    IconEntry::make('crm_registered')
                        ->label('Registrada en CRM')
                        ->boolean()
                        ->trueColor('success')
                        ->falseColor('danger'),
                    IconEntry::make('has_artifacts')
                        ->label('Tiene evidencia tangible')
                        ->boolean()
                        ->trueColor('success')
                        ->falseColor('danger'),
                ])->columns(5),

        ]);
    }
}
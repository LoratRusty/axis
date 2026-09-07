<?php

namespace App\Filament\Coach\Resources\FieldInteractions\Schemas;

use App\Models\TrainingProgram;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FieldInteractionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Section::make('Datos de la visita')
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
                        ->label('Semana')
                        ->options(function (callable $get) {
                            $programId = $get('program_id');
                            if (! $programId) return [];
                            return \App\Models\WeeklyTracking::where('program_id', $programId)
                                ->orderByDesc('week_number')
                                ->get()
                                ->mapWithKeys(fn($wt) => [
                                    $wt->id => 'Semana ' . $wt->week_number . ' (' . ($wt->week_start_date?->format('d/m/Y') ?? '-') . ')',
                                ]);
                        })
                        ->required()
                        ->searchable(),
                    DatePicker::make('visit_date')
                        ->label('Fecha de la visita')
                        ->required()
                        ->maxDate(now()),

                    TextInput::make('client_name')
                        ->label('Nombre del cliente')
                        ->required()
                        ->maxLength(255),

                    TextInput::make('client_account')
                        ->label('Cuenta / Negocio')
                        ->maxLength(255),

                    Select::make('visit_type')
                        ->label('Tipo de visita')
                        ->options([
                            'prospecting'  => 'Prospectacion',
                            'discovery'    => 'Descubrimiento',
                            'proposal'     => 'Propuesta',
                            'negotiation'  => 'Negociacion',
                            'closing'      => 'Cierre',
                            'follow_up'    => 'Seguimiento',
                        ])
                        ->required(),

                    TextInput::make('spiced_doc_url')
                        ->label('URL documento SPICED')
                        ->url(),

                    Textarea::make('notes')
                        ->label('Notas')
                        ->rows(3)
                        ->columnSpanFull(),

                ])->columns(2),

            Section::make('Validacion - Las 5 Normas')
                ->schema([
                    Toggle::make('is_in_matrix')
                        ->label('Cliente en matriz de planificacion')
                        ->inline(false),
                    Toggle::make('is_scheduled')
                        ->label('Visita agendada proactivamente')
                        ->inline(false),
                    Toggle::make('is_presential')
                        ->label('Visita presencial')
                        ->inline(false),
                    Toggle::make('crm_registered')
                        ->label('Registrada en CRM')
                        ->inline(false),
                    Toggle::make('has_artifacts')
                        ->label('Cuenta con evidencias fisicas')
                        ->inline(false),
                ])->columns(2),

        ]);
    }
}

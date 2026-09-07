<?php

namespace App\Filament\Coach\Resources\TrainingPrograms\Schemas;

use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TrainingProgramForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Section::make('Datos del programa')
                ->description('Solo el administrador puede modificar trainee, coach o fecha de inicio. El coach gestiona el progreso desde las acciones del programa.')
                ->schema([

                    Select::make('trainee_id')
                        ->label('Trainee')
                        ->options(fn() => User::trainees()->get()->pluck('name', 'id'))
                        ->required()
                        ->searchable()
                        ->disabledOn('edit'),

                    Select::make('coach_id')
                        ->label('Coach')
                        ->options(fn() => User::coaches()->get()->pluck('name', 'id'))
                        ->required()
                        ->searchable()
                        ->disabledOn('edit'),

                    DatePicker::make('start_date')
                        ->label('Fecha de inicio')
                        ->required()
                        ->disabledOn('edit'),

                    Select::make('status')
                        ->label('Estado')
                        ->options([
                            'active'       => 'Activo',
                            'on_hold'      => 'En pausa',
                            'graduated'    => 'Graduado',
                            'discontinued' => 'Discontinuado',
                        ])
                        ->default('active')
                        ->required(),

                    Textarea::make('notes')
                        ->label('Notas del programa')
                        ->placeholder('Observaciones generales sobre el trainee o el programa')
                        ->rows(3)
                        ->columnSpanFull(),

                ])->columns(2),

        ]);
    }
}
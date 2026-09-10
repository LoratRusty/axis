<?php

namespace App\Filament\Trainee\Resources;

use App\Filament\Trainee\Resources\InteraccionResource\Pages;
use App\Models\FieldInteraction;
use App\Models\WeeklyTracking;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Filament\Actions\ViewAction;

class InteraccionResource extends Resource
{
    protected static ?string $model = FieldInteraction::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMapPin;

    protected static ?string $navigationLabel  = 'Mis Interacciones';
    protected static ?string $modelLabel       = 'Interaccion de campo';
    protected static ?string $pluralModelLabel = 'Interacciones de campo';
    protected static ?int    $navigationSort   = 3;

    public static function getEloquentQuery(): Builder
    {
        $user    = Auth::user();
        $program = $user->trainingProgram;

        if (! $program) {
            return parent::getEloquentQuery()->whereRaw('1 = 0');
        }

        return parent::getEloquentQuery()
            ->where('program_id', $program->id)
            ->orderByDesc('visit_date');
    }

    public static function form(Schema $schema): Schema
    {
        $user    = Auth::user();
        $program = $user->trainingProgram;

        return $schema->components([

            Section::make('Datos de la interaccion')
                ->description('Registra los datos de tu visita o interaccion de campo. Una interaccion es valida cuando cumple las 5 normas indicadas abajo.')
                ->schema([

                    Select::make('weekly_tracking_id')
                        ->label('Semana')
                        ->options(function () use ($program) {
                            if (! $program) return [];
                            return WeeklyTracking::where('program_id', $program->id)
                                ->orderByDesc('week_number')
                                ->get()
                                ->mapWithKeys(fn($wt) => [
                                    $wt->id => 'Semana ' . $wt->week_number . ' (' . $wt->week_start_date?->format('d/m/Y') . ')',
                                ]);
                        })
                        ->default(function () use ($program) {
                            if (! $program) return null;
                            return $program->currentWeekTracking?->id;
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
                        ->label('Contacto')
                        ->maxLength(255),

                    Select::make('visit_type')
                        ->label('Tipo de visita')
                        ->options([
                            'prospecting'  => 'Prospectación',
                            'discovery'    => 'Descubrimiento',
                            'proposal'     => 'Propuesta',
                            'negotiation'  => 'Negociación',
                            'closing'      => 'Cierre',
                        ])
                        ->required(),

                    TextInput::make('opportunity_name')
                        ->label('Oportunidad en CRM')
                        ->maxLength(255)
                        ->placeholder('Nombre de la oportunidad registrada en CRM'),

                    Textarea::make('notes')
                        ->label('Notas de la visita')
                        ->rows(3)
                        ->maxLength(600)
                        ->placeholder('Describe brevemente lo que ocurrio en esta visita')
                        ->columnSpanFull(),

                ])->columns(2),

            Section::make('Validacion - Las 5 Normas')
                ->description('Una interaccion solo cuenta como valida si cumple las 5 normas del programa. Marca unicamente las que realmente se cumplieron.')
                ->schema([

                    Toggle::make('is_in_matrix')
                        ->label('El cliente esta en la matriz de planificacion')
                        ->helperText('La visita fue a un cliente previamente identificado en tu matriz.')
                        ->inline(false),

                    Toggle::make('is_scheduled')
                        ->label('La interaccion fue agendada')
                        ->helperText('La visita se programo con anticipacion, no fue espontanea.')
                        ->inline(false),

                    Toggle::make('is_presential')
                        ->label('La interaccion fue presencial')
                        ->helperText('Visitaste fisicamente al cliente en su negocio o punto de venta.')
                        ->inline(false),

                    Toggle::make('crm_registered')
                        ->label('Registrada en CRM')
                        ->helperText('La interaccion quedo registrada en el sistema CRM antes del corte.')
                        ->inline(false),

                    Toggle::make('has_artifacts')
                        ->label('Cuenta con evidencias fisicas')
                        ->helperText('Tienes foto, reporte, cotizacion u otro artefacto que respalde esta visita.')
                        ->inline(false),

                ])->columns(2),

        ]);
    }

    public static function infolist(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return $schema->components([

            \Filament\Schemas\Components\Section::make('Datos de la visita')
                ->schema([
                    \Filament\Infolists\Components\TextEntry::make('visit_date')
                        ->label('Fecha de visita')
                        ->date('d/m/Y'),
                    \Filament\Infolists\Components\TextEntry::make('visit_type')
                        ->label('Tipo de visita')
                        ->badge()
                        ->color('primary')
                        ->formatStateUsing(fn($state) => match ($state) {
                            'prospecting' => 'Prospeccion',
                            'discovery'   => 'Descubrimiento',
                            'proposal'    => 'Propuesta',
                            'negotiation' => 'Negociacion',
                            'closing'     => 'Cierre',
                            default       => $state,
                        }),
                    \Filament\Infolists\Components\TextEntry::make('client_name')
                        ->label('Cliente'),
                    \Filament\Infolists\Components\TextEntry::make('client_account')
                        ->label('Contacto')
                        ->placeholder('—'),
                    \Filament\Infolists\Components\TextEntry::make('is_valid')
                        ->label('Resultado')
                        ->badge()
                        ->formatStateUsing(fn($state) => $state ? 'Interaccion valida' : 'Interaccion no valida')
                        ->color(fn($state) => $state ? 'success' : 'danger'),
                    \Filament\Infolists\Components\TextEntry::make('opportunity_name')
                        ->label('Oportunidad en CRM')
                        ->placeholder('—'),
                    \Filament\Infolists\Components\TextEntry::make('notes')
                        ->label('Notas')
                        ->placeholder('—')
                        ->columnSpanFull(),
                ])->columns(2),

            \Filament\Schemas\Components\Section::make('Validacion — Las 5 Normas')
                ->description('Una interaccion es valida solo cuando cumple las 5 normas del programa.')
                ->schema([
                    \Filament\Infolists\Components\IconEntry::make('is_in_matrix')
                        ->label('En matriz de planificacion')
                        ->boolean()
                        ->trueColor('success')
                        ->falseColor('danger'),
                    \Filament\Infolists\Components\IconEntry::make('is_scheduled')
                        ->label('Agendada proactivamente')
                        ->boolean()
                        ->trueColor('success')
                        ->falseColor('danger'),
                    \Filament\Infolists\Components\IconEntry::make('is_presential')
                        ->label('Presencial')
                        ->boolean()
                        ->trueColor('success')
                        ->falseColor('danger'),
                    \Filament\Infolists\Components\IconEntry::make('crm_registered')
                        ->label('Registrada en CRM')
                        ->boolean()
                        ->trueColor('success')
                        ->falseColor('danger'),
                    \Filament\Infolists\Components\IconEntry::make('has_artifacts')
                        ->label('Cuenta con evidencias fisicas')
                        ->boolean()
                        ->trueColor('success')
                        ->falseColor('danger'),
                ])->columns(5),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('visit_date')
                    ->label('Fecha')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('client_name')
                    ->label('Cliente')
                    ->searchable()
                    ->limit(30),

                Tables\Columns\TextColumn::make('client_account')
                    ->label('Contacto')
                    ->limit(30)
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make('opportunity_name')
                    ->label('Oportunidad')
                    ->limit(30)
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make('visit_type')
                    ->label('Tipo')
                    ->badge()
                    ->formatStateUsing(fn($state) => match ($state) {
                        'prospecting' => 'Prospección',
                        'discovery'   => 'Descubrimiento',
                        'proposal'    => 'Propuesta',
                        'negotiation' => 'Negociación',
                        'closing'     => 'Cierre',
                        default       => $state,
                    }),

                Tables\Columns\IconColumn::make('is_valid')
                    ->label('Valida')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\TextColumn::make('weeklyTracking.week_number')
                    ->label('Semana')
                    ->prefix('Sem. '),

                Tables\Columns\IconColumn::make('is_in_matrix')
                    ->label('Matriz')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\IconColumn::make('is_scheduled')
                    ->label('Agendada')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\IconColumn::make('is_presential')
                    ->label('Presencial')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\IconColumn::make('crm_registered')
                    ->label('CRM')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\IconColumn::make('has_artifacts')
                    ->label('Evidencia')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('danger'),
            ])
            ->recordActions([
                \Filament\Actions\ViewAction::make()->label('Ver'),
            ])
            ->toolbarActions([])
            ->emptyStateHeading('No tienes interacciones registradas')
            ->emptyStateDescription('Registra tu primera interaccion de campo usando el boton de arriba.')
            ->defaultSort('visit_date', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListInteracciones::route('/'),
            'create' => Pages\CreateInteraccion::route('/create'),
            'view'   => Pages\ViewInteraccion::route('/{record}'),
        ];
    }
}

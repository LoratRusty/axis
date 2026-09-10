<?php

namespace App\Filament\Trainee\Resources;

use App\Filament\Trainee\Resources\EvidenciaResource\Pages;
use App\Models\Evidence;
use App\Models\WeeklyTracking;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Models\Ritual;

class EvidenciaResource extends Resource
{
    protected static ?string $model = Evidence::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static ?string $navigationLabel  = 'Mis Evidencias';
    protected static ?string $modelLabel       = 'Evidencia';
    protected static ?string $pluralModelLabel = 'Evidencias';
    protected static ?int    $navigationSort   = 2;

    public static function getEloquentQuery(): Builder
    {
        $user    = Auth::user();
        $program = $user->trainingProgram;

        if (! $program) {
            return parent::getEloquentQuery()->whereRaw('1 = 0');
        }

        return parent::getEloquentQuery()
            ->where('program_id', $program->id)
            ->orderByDesc('created_at');
    }

    public static function form(Schema $schema): Schema
    {
        $user    = Auth::user();
        $program = $user->trainingProgram;

        return $schema->components([

            Section::make('Informacion de la evidencia')
                ->description('Registra una evidencia vinculada a tu semana actual. Solo puedes subir evidencias de tu propio programa.')
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

                    Select::make('evidence_type')
                        ->label('Tipo de evidencia')
                        ->options([
                            'document' => 'Documento',
                            'image'    => 'Imagen',
                            'url'      => 'URL / Enlace',
                            'audio'    => 'Audio',
                            'video'    => 'Video',
                            'form'     => 'Formulario',
                        ])
                        ->required(),

                    TextInput::make('title')
                        ->label('Titulo')
                        ->required()
                        ->maxLength(150)
                        ->placeholder('Ej: Visita cliente Ferreteria Lopez semana 7'),

                    Textarea::make('description')
                        ->label('Descripcion')
                        ->rows(3)
                        ->maxLength(500)
                        ->placeholder('Describe brevemente el contexto de esta evidencia'),

                    TextInput::make('file_url')
                        ->label('URL del archivo')
                        ->url()
                        ->required()
                        ->placeholder('https://drive.google.com/...')
                        ->helperText('Sube tu archivo a Google Drive o similar y pega el enlace aqui.'),
                    Select::make('ritual_id')
                        ->label('Ritual asociado')
                        ->options(function () {
                            return Ritual::active()
                                ->orderBy('number')
                                ->get()
                                ->mapWithKeys(fn($r) => [
                                    $r->id => $r->number . '. ' . $r->name,
                                ]);
                        })
                        ->required()
                        ->searchable()
                        ->helperText('Selecciona el ritual al que corresponde esta evidencia.'),
                    \Filament\Forms\Components\Select::make('self_assessment_score')
                        ->label('¿Cómo te sentiste ejecutando este ritual? (1-10)')
                        ->options(array_combine(range(1, 10), range(1, 10)))
                        ->required()
                        ->helperText('Esta calificación será usada en tus reuniones de seguimiento.'),
                ])->columns(1),

        ]);
    }

    public static function infolist(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return $schema->components([

            \Filament\Schemas\Components\Section::make('Datos de la evidencia')
                ->schema([
                    \Filament\Infolists\Components\TextEntry::make('ritual.name')
                        ->label('Ritual asociado')
                        ->placeholder('—'),
                    \Filament\Infolists\Components\TextEntry::make('evidence_type')
                        ->label('Tipo')
                        ->badge()
                        ->color('primary')
                        ->formatStateUsing(fn($state) => match ($state) {
                            'document' => 'Documento',
                            'image'    => 'Imagen',
                            'url'      => 'URL',
                            'audio'    => 'Audio',
                            'video'    => 'Video',
                            'form'     => 'Formulario',
                            default    => $state,
                        }),
                    \Filament\Infolists\Components\TextEntry::make('status')
                        ->label('Estado')
                        ->badge()
                        ->formatStateUsing(fn($state) => match ($state) {
                            'pending_review' => 'Pendiente de revision',
                            'approved'       => 'Aprobada',
                            'needs_revision' => 'Requiere correccion',
                            'rejected'       => 'Rechazada',
                            default          => $state,
                        })
                        ->color(fn($state) => match ($state) {
                            'approved'       => 'success',
                            'needs_revision' => 'warning',
                            'rejected'       => 'danger',
                            default          => 'gray',
                        }),
                    \Filament\Infolists\Components\TextEntry::make('created_at')
                        ->label('Subida el')
                        ->date('d/m/Y'),
                    \Filament\Infolists\Components\TextEntry::make('title')
                        ->label('Titulo')
                        ->columnSpanFull(),
                    \Filament\Infolists\Components\TextEntry::make('description')
                        ->label('Descripcion')
                        ->placeholder('—')
                        ->columnSpanFull(),
                    \Filament\Infolists\Components\TextEntry::make('file_url')
                        ->label('Enlace del archivo')
                        ->placeholder('—')
                        ->url(fn($state) => $state)
                        ->columnSpanFull(),
                    \Filament\Infolists\Components\TextEntry::make('self_assessment_score')
                        ->label('Auto-evaluación')
                        ->placeholder('—')
                        ->suffix('/10'),
                ])->columns(2),

            \Filament\Schemas\Components\Section::make('Revision del coach')
                ->schema([
                    \Filament\Infolists\Components\TextEntry::make('coach_notes')
                        ->label('Comentarios del coach')
                        ->placeholder('Tu coach aun no ha dejado comentarios sobre esta evidencia.')
                        ->columnSpanFull(),
                ])->columns(1),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Titulo')
                    ->searchable()
                    ->limit(40),

                Tables\Columns\TextColumn::make('evidence_type')
                    ->label('Tipo')
                    ->badge()
                    ->formatStateUsing(fn($state) => match ($state) {
                        'pending_review' => 'Pendiente de revision',
                        'approved'       => 'Aprobada',
                        'needs_revision' => 'Requiere correccion',
                        'rejected'       => 'Rechazada',
                        default          => $state,
                    })
                    ->color(fn($state) => match ($state) {
                        'foto'       => 'info',
                        'reporte'    => 'success',
                        'crm'        => 'warning',
                        'cotizacion' => 'primary',
                        default      => 'gray',
                    }),

                Tables\Columns\TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->formatStateUsing(fn($state) => match ($state) {
                        'pending'        => 'Pendiente de revision',
                        'approved'       => 'Aprobada',
                        'needs_revision' => 'Requiere correccion',
                        'rejected'       => 'Rechazada',
                        default          => $state,
                    })
                    ->color(fn($state) => match ($state) {
                        'approved'       => 'success',
                        'needs_revision' => 'warning',
                        'rejected'       => 'danger',
                        default          => 'gray',
                    }),

                Tables\Columns\TextColumn::make('weeklyTracking.week_number')
                    ->label('Semana')
                    ->prefix('Sem. '),

                Tables\Columns\TextColumn::make('coach_notes')
                    ->label('Comentario del coach')
                    ->limit(50)
                    ->placeholder('-'),
                Tables\Columns\TextColumn::make('self_assessment_score')
                    ->label('Auto-eval.')
                    ->suffix('/10')
                    ->placeholder('-'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Subida el')
                    ->date('d/m/Y'),
            ])
            ->recordActions([
                \Filament\Actions\ViewAction::make()->label('Ver'),
                \Filament\Actions\EditAction::make()
                    ->label('Corregir y reenviar')
                    ->visible(fn($record) => $record->status === 'needs_revision'),
            ])
            ->toolbarActions([])
            ->emptyStateHeading('No tienes evidencias registradas')
            ->emptyStateDescription('Usa el boton "Nueva evidencia" para subir tu primera evidencia de la semana.')
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListEvidencias::route('/'),
            'create' => Pages\CreateEvidencia::route('/create'),
            'view'   => Pages\ViewEvidencia::route('/{record}'),
            'edit'   => Pages\EditEvidencia::route('/{record}/edit'),
        ];
    }
}

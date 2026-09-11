<?php

namespace App\Filament\Trainee\Resources;

use App\Filament\Trainee\Resources\EvidenciaResource\Pages;
use App\Models\Ritual;
use App\Models\TraineeRitualScore;
use App\Models\WeeklyTracking;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class EvidenciaResource extends Resource
{
    protected static ?string $model = TraineeRitualScore::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $navigationLabel  = 'Mis Rituales';
    protected static ?string $modelLabel       = 'Calificación de rituales';
    protected static ?string $pluralModelLabel = 'Calificación de rituales';
    protected static ?int    $navigationSort   = 2;

    public static function getEloquentQuery(): Builder
    {
        $program = Auth::user()->trainingProgram;

        if (! $program) {
            return parent::getEloquentQuery()->whereRaw('1 = 0');
        }

        return parent::getEloquentQuery()
            ->where('program_id', $program->id)
            ->with('ritual', 'weeklyTracking')
            ->orderByDesc('created_at');
    }

    public static function form(Schema $schema): Schema
    {
        // El form no se usa directamente — el flujo es por la Page custom
        return $schema->components([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('weeklyTracking.week_number')
                    ->label('Semana')
                    ->formatStateUsing(fn($state) => 'Semana ' . $state)
                    ->sortable(),

                Tables\Columns\TextColumn::make('ritual.number')
                    ->label('Ritual #')
                    ->sortable(),

                Tables\Columns\TextColumn::make('ritual.name')
                    ->label('Ritual')
                    ->limit(50),

                Tables\Columns\TextColumn::make('score')
                    ->label('Calificación')
                    ->formatStateUsing(fn($state) => $state . ' / 10')
                    ->badge()
                    ->color(fn($state) => match(true) {
                        $state >= 8  => 'success',
                        $state >= 5  => 'warning',
                        default      => 'danger',
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Registrado')
                    ->date('d/m/Y')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('weekly_tracking_id')
                    ->label('Semana')
                    ->options(function () {
                        $program = Auth::user()->trainingProgram;
                        if (! $program) return [];
                        return WeeklyTracking::where('program_id', $program->id)
                            ->orderByDesc('week_number')
                            ->get()
                            ->mapWithKeys(fn($wt) => [
                                $wt->id => 'Semana ' . $wt->week_number,
                            ]);
                    }),
            ])
            ->paginated([10, 25, 50]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListEvidencias::route('/'),
            'create' => Pages\CreateEvidencia::route('/create'),
        ];
    }
}
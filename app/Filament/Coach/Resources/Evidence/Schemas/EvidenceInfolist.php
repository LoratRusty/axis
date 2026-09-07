<?php

namespace App\Filament\Coach\Resources\Evidence\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EvidenceInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Section::make('Datos de la evidencia')
                ->description('Informacion general de la evidencia cargada por el trainee.')
                ->schema([
                    TextEntry::make('trainingProgram.trainee.name')
                        ->label('Trainee'),
                    TextEntry::make('created_at')
                        ->label('Fecha de carga')
                        ->dateTime('d/m/Y H:i'),
                    TextEntry::make('ritual.name')
                        ->label('Ritual asociado')
                        ->placeholder('-'),
                    TextEntry::make('evidence_type')
                        ->label('Tipo')
                        ->badge()
                        ->color('primary')
                        ->formatStateUsing(fn(string $state): string => match($state) {
                            'document' => 'Documento',
                            'image'    => 'Imagen',
                            'url'      => 'URL',
                            'audio'    => 'Audio',
                            'video'    => 'Video',
                            'form'     => 'Formulario',
                            default    => $state,
                        }),
                    TextEntry::make('status')
                        ->label('Estado')
                        ->badge()
                        ->color(fn(string $state): string => match($state) {
                            'approved'       => 'success',
                            'needs_revision' => 'warning',
                            'rejected'       => 'danger',
                            default          => 'gray',
                        })
                        ->formatStateUsing(fn(string $state): string => match($state) {
                            'pending_review' => 'Pendiente de revision',
                            'approved'       => 'Aprobada',
                            'needs_revision' => 'Requiere correccion',
                            'rejected'       => 'Rechazada',
                            default          => $state,
                        }),
                    TextEntry::make('title')
                        ->label('Titulo')
                        ->columnSpanFull(),
                    TextEntry::make('description')
                        ->label('Descripcion')
                        ->placeholder('-')
                        ->columnSpanFull(),
                    TextEntry::make('file_url')
                        ->label('Enlace del archivo')
                        ->placeholder('-')
                        ->url(fn($state) => $state)
                        ->columnSpanFull(),
                ])->columns(2),

            Section::make('Revision del coach')
                ->description('Notas y comentarios del coach sobre esta evidencia.')
                ->schema([
                    TextEntry::make('coach_notes')
                        ->label('Comentarios del coach')
                        ->placeholder('Sin comentarios aun.')
                        ->columnSpanFull(),
                ])->columns(1),

        ]);
    }
}
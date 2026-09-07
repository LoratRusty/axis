<?php

namespace App\Filament\Coach\Resources\Evidence\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class EvidenceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('program_id')
                    ->required(),
                TextInput::make('weekly_tracking_id')
                    ->required(),
                TextInput::make('ritual_id')
                    ->required(),
                TextInput::make('uploaded_by')
                    ->required(),
                TextInput::make('title')
                    ->required(),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                Select::make('evidence_type')
                    ->options([
            'document' => 'Document',
            'image' => 'Image',
            'url' => 'Url',
            'audio' => 'Audio',
            'video' => 'Video',
            'form' => 'Form',
        ])
                    ->required(),
                TextInput::make('file_path')
                    ->default(null),
                TextInput::make('file_url')
                    ->url()
                    ->default(null),
                TextInput::make('external_url')
                    ->url()
                    ->default(null),
                TextInput::make('file_name')
                    ->default(null),
                TextInput::make('file_mime')
                    ->default(null),
                TextInput::make('file_size_kb')
                    ->numeric()
                    ->default(null),
                Select::make('status')
                    ->options([
            'pending_review' => 'Pending review',
            'approved' => 'Approved',
            'needs_revision' => 'Needs revision',
            'rejected' => 'Rejected',
        ])
                    ->default('pending_review')
                    ->required(),
                Textarea::make('coach_notes')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('reviewed_by')
                    ->default(null),
                DateTimePicker::make('reviewed_at'),
            ]);
    }
}

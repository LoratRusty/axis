<?php

namespace App\Filament\Trainee\Resources\EvidenciaResource\Pages;

use App\Filament\Trainee\Resources\EvidenciaResource;
use App\Models\Ritual;
use App\Models\TraineeRitualScore;
use App\Models\WeeklyTracking;
use Filament\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateEvidencia extends Page
{
    protected static string $resource = EvidenciaResource::class;

    public function getView(): string
    {
        return 'filament.trainee.resources.evidencia-resource.pages.create-evidencia';
    }

    public ?string $weekly_tracking_id = null;
    public array $scores = [];
    public ?string $general_notes = null;

    public function getTitle(): string|\Illuminate\Contracts\Support\Htmlable
    {
        return 'Calificar rituales de la semana';
    }

    public function updatedWeeklyTrackingId(): void
    {
        $this->loadRituals();
    }

    protected function loadRituals(): void
    {
        if (! $this->weekly_tracking_id) {
            $this->scores = [];
            return;
        }

        $program = Auth::user()->trainingProgram;

        $weeklyTracking = WeeklyTracking::find($this->weekly_tracking_id);
        $weekNumber = $weeklyTracking?->week_number ?? 1;

        // Rituales desbloqueados según la semana
        $ritualesDesbloqueados = match (true) {
            $weekNumber <= 2  => [1, 2, 3, 4, 5, 6, 7, 8],
            $weekNumber <= 4  => [1, 2, 3, 4, 5, 6, 7, 8, 9, 12, 13, 14, 15, 22],
            $weekNumber <= 6  => [1, 2, 3, 4, 5, 6, 7, 8, 9, 12, 13, 14, 15, 16, 17, 18, 19, 20, 22],
            $weekNumber <= 8  => [1, 2, 3, 4, 5, 6, 7, 8, 9, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28],
            default           => range(1, 28),
        };

        $rituales = Ritual::where('is_active', true)
            ->whereIn('number', $ritualesDesbloqueados)
            ->orderBy('number')
            ->get();

        $existing = TraineeRitualScore::where('weekly_tracking_id', $this->weekly_tracking_id)
            ->where('program_id', $program->id)
            ->pluck('score', 'ritual_id');

        $this->scores = $rituales->map(fn($r) => [
            'ritual_id'   => $r->id,
            'ritual_name' => $r->number . '. ' . $r->name,
            'score'       => $existing[$r->id] ?? null,
        ])->toArray();
    }

    public function getWeekOptions(): array
    {
        $program = Auth::user()->trainingProgram;
        if (! $program) return [];

        return WeeklyTracking::where('program_id', $program->id)
            ->orderByDesc('week_number')
            ->get()
            ->mapWithKeys(fn($wt) => [
                $wt->id => 'Semana ' . $wt->week_number .
                    ($wt->week_start_date ? ' (' . $wt->week_start_date->format('d/m/Y') . ')' : ''),
            ])
            ->toArray();
    }

    public function save(): void
    {
        $program = Auth::user()->trainingProgram;

        if (! $this->weekly_tracking_id) {
            Notification::make()
                ->title('Selecciona una semana primero')
                ->warning()
                ->send();
            return;
        }

        if (empty($this->scores)) {
            Notification::make()
                ->title('No hay rituales para calificar')
                ->warning()
                ->send();
            return;
        }

        $hasAnyScore = collect($this->scores)->some(fn($s) => $s['score'] !== null);
        if (! $hasAnyScore) {
            Notification::make()
                ->title('Debes calificar al menos un ritual')
                ->warning()
                ->send();
            return;
        }

        DB::transaction(function () use ($program) {
            foreach ($this->scores as $row) {
                if ($row['score'] === null) continue;

                TraineeRitualScore::updateOrCreate(
                    [
                        'weekly_tracking_id' => $this->weekly_tracking_id,
                        'ritual_id'          => $row['ritual_id'],
                        'program_id'         => $program->id,
                    ],
                    [
                        'score' => (int) $row['score'],
                        'notes' => $this->general_notes,
                    ]
                );
            }
        });

        Notification::make()
            ->title('Calificaciones guardadas')
            ->success()
            ->send();

        $this->redirect($this->getResource()::getUrl('index'));
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}

<?php

namespace App\Exports;

use App\Models\FieldInteraction;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FieldInteractionsExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    public function __construct(
        protected string $programId,
        protected ?string $weeklyTrackingId = null,
    ) {}

    public function query()
    {
        $query = FieldInteraction::with(['weeklyTracking', 'trainingProgram.trainee'])
            ->where('program_id', $this->programId);

        if ($this->weeklyTrackingId) {
            $query->where('weekly_tracking_id', $this->weeklyTrackingId);
        }

        return $query->orderBy('visit_date');
    }

    public function headings(): array
    {
        return [
            'Semana',
            'Fecha',
            'Cliente',
            'Contacto',
            'Tipo de Visita',
            'Oportunidad en CRM',
            'Válida',
        ];
    }

    public function map($row): array
    {
        return [
            'Semana ' . $row->weeklyTracking?->week_number,
            $row->visit_date?->format('d/m/Y'),
            $row->client_name,
            $row->client_account ?? '—',
            match ($row->visit_type) {
                'prospecting' => 'Prospección',
                'discovery'   => 'Descubrimiento',
                'proposal'    => 'Propuesta',
                'negotiation' => 'Negociación',
                'closing'     => 'Cierre',
                default       => $row->visit_type,
            },
            $row->opportunity_name ?? '—',
            $row->is_valid ? 'Sí' : 'No',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
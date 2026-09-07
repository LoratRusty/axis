<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProgramPhaseSeeder extends Seeder
{
    public function run(): void
    {
        $phases = [
            [
                'id'          => Str::uuid(),
                'code'        => 'A',
                'name'        => 'Concientización',
                'week_start'  => 1,
                'week_end'    => 4,
                'main_tool'   => 'Go-To-Market',
                'description' => 'El trainee construye su mapa de mercado y ejecuta sus primeras visitas. Foco en volumen y presencia. Herramientas activas: GTM y Matriz de Planificación.',
            ],
            [
                'id'          => Str::uuid(),
                'code'        => 'B',
                'name'        => 'Educación',
                'week_start'  => 5,
                'week_end'    => 9,
                'main_tool'   => 'SPICED',
                'description' => 'El trainee aprende a descubrir el problema del cliente con profundidad. Incorpora el framework SPICED en cada cita de descubrimiento.',
            ],
            [
                'id'          => Str::uuid(),
                'code'        => 'C',
                'name'        => 'Priorización y Selección',
                'week_start'  => 10,
                'week_end'    => 16,
                'main_tool'   => 'Presentación ATAR',
                'description' => 'El trainee articula la propuesta de valor de Advance en el lenguaje del cliente. Domina la presentación ATAR personalizada por cuenta.',
            ],
            [
                'id'          => Str::uuid(),
                'code'        => 'D',
                'name'        => 'Desarrollo',
                'week_start'  => 17,
                'week_end'    => 24,
                'main_tool'   => 'Cotizaciones',
                'description' => 'El trainee convierte oportunidades en ingresos. Cotiza, negocia y cierra con consistencia. Gestiona el embudo con disciplina.',
            ],
            [
                'id'          => Str::uuid(),
                'code'        => 'E',
                'name'        => 'Mejora Continua',
                'week_start'  => 25,
                'week_end'    => 51,
                'main_tool'   => 'PHVA Completo',
                'description' => 'El trainee opera como Asesor Comercial. Optimiza cobertura, tiempo, conversión y costo. Ciclo PHVA completo en cada trimestre.',
            ],
        ];

        foreach ($phases as $phase) {
            DB::table('program_phases')->insertOrIgnore(array_merge($phase, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
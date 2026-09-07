<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RitualSeeder extends Seeder
{
    public function run(): void
    {
        $phaseIds = DB::table('program_phases')->pluck('id', 'code');

        $rituals = [
            // H1: Go-To-Market - Fase A
            [
                'number'        => 1,
                'name'          => 'Activar el Go-To-Market',
                'description'   => 'Consultar el GTM al inicio de cada semana para identificar cuentas prioritarias y definir el foco de la semana.',
                'phase_code'    => 'A',
                'tool'          => 'Go-To-Market',
                'frequency'     => 'weekly',
                'evidence_type' => 'document',
            ],
            [
                'number'        => 2,
                'name'          => 'Revisar Tríadas de Acceso',
                'description'   => 'Identificar en el GTM las tríadas de acceso (Técnico, Económico, Usuario) para cada cuenta objetivo y documentar el estado de cada contacto.',
                'phase_code'    => 'A',
                'tool'          => 'Go-To-Market',
                'frequency'     => 'weekly',
                'evidence_type' => 'document',
            ],
            [
                'number'        => 3,
                'name'          => 'Clasificar Cuentas por Potencial',
                'description'   => 'Clasificar las cuentas del territorio en A, B y C según potencial de consumo, usando los criterios del GTM.',
                'phase_code'    => 'A',
                'tool'          => 'Go-To-Market',
                'frequency'     => 'monthly',
                'evidence_type' => 'document',
            ],
            // H2: Matriz de Planificación - Fase A
            [
                'number'        => 4,
                'name'          => 'Construir la Matriz Semanal',
                'description'   => 'Completar la Matriz de Planificación cada lunes con las citas agendadas para las próximas dos semanas. Incluir cliente, objetivo, tipo de visita y material necesario.',
                'phase_code'    => 'A',
                'tool'          => 'Matriz de Planificación',
                'frequency'     => 'weekly',
                'evidence_type' => 'document',
            ],
            [
                'number'        => 5,
                'name'          => 'Confirmar Citas 48 Horas Antes',
                'description'   => 'Confirmar por escrito cada cita de la Matriz con 48 horas de anticipación. Registrar confirmación como evidencia.',
                'phase_code'    => 'A',
                'tool'          => 'Matriz de Planificación',
                'frequency'     => 'per_visit',
                'evidence_type' => 'document',
            ],
            [
                'number'        => 6,
                'name'          => 'Plan de Batalla Semanal',
                'description'   => 'Cada viernes revisar la Matriz de la semana siguiente. Identificar cuentas sin cita agendada y definir acciones para cubrirlas.',
                'phase_code'    => 'A',
                'tool'          => 'Matriz de Planificación',
                'frequency'     => 'weekly',
                'evidence_type' => 'document',
            ],
            [
                'number'        => 7,
                'name'          => 'Registrar Resultado de Cada Visita',
                'description'   => 'Al terminar cada visita, actualizar la Matriz con el resultado obtenido y el siguiente paso acordado con el cliente.',
                'phase_code'    => 'A',
                'tool'          => 'Matriz de Planificación',
                'frequency'     => 'per_visit',
                'evidence_type' => 'form',
            ],
            [
                'number'        => 8,
                'name'          => 'Confirmación 48 Horas',
                'description'   => 'Enviar mensaje de confirmación de cita 48 horas antes. Incluir agenda propuesta y objetivos de la reunión.',
                'phase_code'    => 'A',
                'tool'          => 'Matriz de Planificación',
                'frequency'     => 'per_visit',
                'evidence_type' => 'document',
            ],
            // H3: SPICED - Fase B
            [
                'number'        => 9,
                'name'          => 'Preparar Pre-Cita SPICED',
                'description'   => 'Antes de cada cita de descubrimiento, completar las secciones S y P del SPICED con información conocida del cliente.',
                'phase_code'    => 'B',
                'tool'          => 'SPICED',
                'frequency'     => 'per_visit',
                'evidence_type' => 'document',
            ],
            [
                'number'        => 10,
                'name'          => 'Ejecutar Descubrimiento SPICED',
                'description'   => 'Conducir la cita siguiendo la estructura SPICED. Hacer preguntas de impacto y criticidad. No presentar soluciones hasta completar el descubrimiento.',
                'phase_code'    => 'B',
                'tool'          => 'SPICED',
                'frequency'     => 'per_visit',
                'evidence_type' => 'document',
            ],
            [
                'number'        => 11,
                'name'          => 'Documentar SPICED Post-Cita',
                'description'   => 'En las 2 horas siguientes a cada cita, completar y digitalizar el SPICED completo. Archivar en el CRM.',
                'phase_code'    => 'B',
                'tool'          => 'SPICED',
                'frequency'     => 'per_visit',
                'evidence_type' => 'document',
            ],
            [
                'number'        => 12,
                'name'          => 'Identificar Evento Decisivo',
                'description'   => 'En cada cita de descubrimiento, identificar el evento o fecha límite que hace urgente la decisión del cliente. Documentar en sección E del SPICED.',
                'phase_code'    => 'B',
                'tool'          => 'SPICED',
                'frequency'     => 'per_visit',
                'evidence_type' => 'document',
            ],
            [
                'number'        => 13,
                'name'          => 'Mapear Proceso de Decisión',
                'description'   => 'Identificar todos los roles en la decisión del cliente: decisor, influenciador, usuario, comprador, bloqueador. Documentar en sección D del SPICED.',
                'phase_code'    => 'B',
                'tool'          => 'SPICED',
                'frequency'     => 'per_visit',
                'evidence_type' => 'document',
            ],
            [
                'number'        => 14,
                'name'          => 'Entender Criterios de Decisión',
                'description'   => 'En cada cita de descubrimiento, identificar los criterios de evaluación del cliente (técnicos, económicos, políticos). Documentar prioridad de cada criterio.',
                'phase_code'    => 'B',
                'tool'          => 'SPICED',
                'frequency'     => 'per_visit',
                'evidence_type' => 'document',
            ],
            [
                'number'        => 15,
                'name'          => 'Tomar Notas y Parafrasear',
                'description'   => 'Durante cada cita, tomar notas directamente en el formato SPICED. Parafrasear al cliente al cierre de cada bloque para validar comprensión.',
                'phase_code'    => 'B',
                'tool'          => 'SPICED',
                'frequency'     => 'per_visit',
                'evidence_type' => 'audio',
            ],
            // H4: Presentación ATAR - Fase C
            [
                'number'        => 16,
                'name'          => 'Presentar la Empresa (ATAR a Medida)',
                'description'   => 'Antes de cada cita de presentación, adaptar la estructura ATAR al contexto del cliente usando el SPICED. Nunca usar la versión genérica sin adaptación.',
                'phase_code'    => 'C',
                'tool'          => 'Presentación ATAR',
                'frequency'     => 'per_visit',
                'evidence_type' => 'document',
            ],
            [
                'number'        => 17,
                'name'          => 'Presentar Productos',
                'description'   => 'Seleccionar máximo 2-3 soluciones vinculadas al SPICED. Preparar ficha de 3 minutos por producto: problema que resuelve, resultado que genera, por qué Advance.',
                'phase_code'    => 'C',
                'tool'          => 'Presentación ATAR',
                'frequency'     => 'per_visit',
                'evidence_type' => 'document',
            ],
            [
                'number'        => 18,
                'name'          => 'Construir Plan de Cuentas',
                'description'   => 'Para cada cuenta clave, construir un Plan de Cuentas con objetivo trimestral, oportunidades identificadas, estrategia y plan de acción.',
                'phase_code'    => 'C',
                'tool'          => 'Presentación ATAR',
                'frequency'     => 'monthly',
                'evidence_type' => 'document',
            ],
            [
                'number'        => 19,
                'name'          => 'Actualizar Plan de Cuentas',
                'description'   => 'Cada mes revisar y actualizar el Plan de Cuentas con el avance real vs objetivo, ajustar estrategia según cambios en el cliente.',
                'phase_code'    => 'C',
                'tool'          => 'Presentación ATAR',
                'frequency'     => 'monthly',
                'evidence_type' => 'document',
            ],
            [
                'number'        => 20,
                'name'          => 'Gestionar Objeciones con Aikido',
                'description'   => 'Ante cada objeción del cliente, aplicar la técnica de Aikido Comercial: escuchar, validar, redirigir. No confrontar ni ceder sin contrapartida.',
                'phase_code'    => 'C',
                'tool'          => 'Presentación ATAR',
                'frequency'     => 'per_visit',
                'evidence_type' => 'audio',
            ],
            // H5: Cotizaciones - Fase D
            [
                'number'        => 21,
                'name'          => 'Elaborar Cotización Estratégica',
                'description'   => 'Construir la cotización basada en el SPICED y el Plan de Cuentas. Incluir propuesta de valor cuantificada. Requiere aprobación del líder para cuentas A y B.',
                'phase_code'    => 'D',
                'tool'          => 'Cotizaciones',
                'frequency'     => 'per_visit',
                'evidence_type' => 'document',
            ],
            [
                'number'        => 22,
                'name'          => 'Radiografía del Embudo',
                'description'   => 'Cada viernes revisar el embudo completo: oportunidades activas, etapa de cada una, próximo paso, probabilidad de cierre. Actualizar en CRM.',
                'phase_code'    => 'D',
                'tool'          => 'Cotizaciones',
                'frequency'     => 'weekly',
                'evidence_type' => 'form',
            ],
            [
                'number'        => 23,
                'name'          => 'Seguimiento Post-Propuesta',
                'description'   => 'En las 48 horas siguientes a presentar una propuesta, ejecutar seguimiento estructurado: confirmar recepción, resolver dudas, proponer siguiente paso.',
                'phase_code'    => 'D',
                'tool'          => 'Cotizaciones',
                'frequency'     => 'per_visit',
                'evidence_type' => 'document',
            ],
            [
                'number'        => 24,
                'name'          => 'Cerrar con Mutuo Acuerdo',
                'description'   => 'Al cierre de cada oportunidad, documentar el Mutuo Acuerdo: qué se acordó, quién es responsable, fechas comprometidas. Registrar en CRM.',
                'phase_code'    => 'D',
                'tool'          => 'Cotizaciones',
                'frequency'     => 'per_visit',
                'evidence_type' => 'document',
            ],
            // Fase E: Mejora Continua
            [
                'number'        => 25,
                'name'          => 'Revisión de Ganadas y Perdidas',
                'description'   => 'Al cierre de cada oportunidad (ganada o perdida), documentar los factores determinantes. Analizar patrones para mejorar el proceso.',
                'phase_code'    => 'E',
                'tool'          => 'PHVA Completo',
                'frequency'     => 'per_visit',
                'evidence_type' => 'document',
            ],
            [
                'number'        => 26,
                'name'          => 'Autoevaluación Trimestral',
                'description'   => 'Al cierre de cada trimestre, completar la guía de autoevaluación: rituales consistentes, habilidades desarrolladas, brechas identificadas, plan para el siguiente trimestre.',
                'phase_code'    => 'E',
                'tool'          => 'PHVA Completo',
                'frequency'     => 'monthly',
                'evidence_type' => 'document',
            ],
            [
                'number'        => 27,
                'name'          => 'Optimizar Cobertura de Territorio',
                'description'   => 'Revisar mensualmente el GTM para identificar cuentas no visitadas, cuentas de alto potencial desatendidas y oportunidades de expansión.',
                'phase_code'    => 'E',
                'tool'          => 'PHVA Completo',
                'frequency'     => 'monthly',
                'evidence_type' => 'document',
            ],
            [
                'number'        => 28,
                'name'          => 'Revisión de ARR de Consumibles',
                'description'   => 'Cada mes calcular el ARR de consumibles generado por la Matriz de Planificación. Comparar contra meta y ajustar estrategia de cuentas.',
                'phase_code'    => 'E',
                'tool'          => 'PHVA Completo',
                'frequency'     => 'monthly',
                'evidence_type' => 'document',
            ],
        ];

        foreach ($rituals as $ritual) {
            $phaseCode = $ritual['phase_code'];
            unset($ritual['phase_code']);

            DB::table('rituals')->insertOrIgnore(array_merge($ritual, [
                'id'         => Str::uuid(),
                'phase_id'   => $phaseIds[$phaseCode],
                'is_active'  => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
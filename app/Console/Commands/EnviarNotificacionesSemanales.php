<?php

namespace App\Console\Commands;

use App\Models\TrainingProgram;
use App\Models\WeeklyTracking;
use App\Services\NotificationService;
use Illuminate\Console\Command;

class EnviarNotificacionesSemanales extends Command
{
    protected $signature   = 'axis:notificaciones-semanales';
    protected $description = 'Envia alertas de jueves a trainees y coaches sobre evidencias e interacciones faltantes';

    public function handle(NotificationService $notif): void
    {
        $this->info('Enviando notificaciones semanales...');

        $programas = TrainingProgram::with(['trainee', 'coach', 'currentWeekTracking'])
            ->active()
            ->get();

        $traineeCount = 0;
        $coachCount   = 0;

        foreach ($programas as $program) {
            $tracking = $program->currentWeekTracking;

            if (! $tracking) continue;

            // Notificar trainee si tiene evidencias faltantes
            $evidenciasFaltantes = $tracking->evidences_target - $tracking->evidences_uploaded;

            if ($evidenciasFaltantes > 0) {
                $notif->notify(
                    user:  $program->trainee,
                    type:  'evidence_due',
                    title: 'Te faltan evidencias esta semana',
                    body:  'Tienes ' . $evidenciasFaltantes . ' evidencia(s) pendiente(s) de subir antes del cierre de semana. No dejes tu historial incompleto.',
                    url:   '/mi-programa/evidencias/create',
                );
                $traineeCount++;
            }

            // Notificar coach si trainee no tiene interacciones validas
            $interaccionesValidas = $tracking->actual_interactions;
            $meta                 = $tracking->target_interactions;

            if ($interaccionesValidas < $meta) {
                $notif->notify(
                    user:  $program->coach,
                    type:  'ritual_alert',
                    title: $program->trainee->name . ' tiene interacciones insuficientes',
                    body:  'Lleva ' . $interaccionesValidas . ' de ' . $meta . ' interacciones validas requeridas esta semana. Considera contactarlo antes del cierre.',
                    url:   '/coach/field-interactions',
                );
                $coachCount++;
            }
        }

        $this->info("Notificaciones enviadas: {$traineeCount} trainees, {$coachCount} coaches.");
    }
}
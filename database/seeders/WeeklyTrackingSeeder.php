<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class WeeklyTrackingSeeder extends Seeder
{
    public function run(): void
    {
        $programs = DB::table('training_programs')->get();

        foreach ($programs as $program) {
            $startDate = Carbon::parse($program->start_date);

            for ($week = 1; $week <= $program->current_week; $week++) {
                $weekStart = $startDate->copy()->addWeeks($week - 1)->startOfWeek();
                $weekEnd   = $weekStart->copy()->endOfWeek();
                $isCurrent = ($week === $program->current_week);

                // Meta de interacciones según etapa (regla de negocio del programa)
                $target = match(true) {
                    $week <= 4  => 1,
                    $week <= 9  => 3,
                    $week <= 16 => 5,
                    $week <= 24 => 7,
                    default     => 8,
                };

                $actual = $isCurrent
                    ? rand(0, $target)
                    : rand(intval($target * 0.6), $target);

                DB::table('weekly_tracking')->insertOrIgnore([
                    'id'                  => Str::uuid(),
                    'program_id'          => $program->id,
                    'week_number'         => $week,
                    'week_start_date'     => $weekStart->toDateString(),
                    'week_end_date'       => $weekEnd->toDateString(),
                    'target_interactions' => $target,
                    'actual_interactions' => $actual,
                    'rituals_target'      => 14,
                    'rituals_completed'   => $isCurrent ? rand(6, 14) : rand(10, 14),
                    'status'              => $isCurrent ? 'in_progress' : 'completed',
                    'coach_reviewed'      => !$isCurrent,
                    'created_at'          => $weekStart,
                    'updated_at'          => now(),
                ]);
            }
        }
    }
}
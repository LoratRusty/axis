<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TrainingProgramSeeder extends Seeder
{
    public function run(): void
    {
        $coach    = DB::table('users')->where('email', 'coach@axis.test')->first();
        $trainee1 = DB::table('users')->where('email', 'trainee1@axis.test')->first();
        $trainee2 = DB::table('users')->where('email', 'trainee2@axis.test')->first();

        $programs = [
            [
                'id'              => Str::uuid(),
                'trainee_id'      => $trainee1->id,
                'coach_id'        => $coach->id,
                'start_date'      => now()->subWeeks(6)->toDateString(),
                'current_week'    => 7,
                'current_stage'   => 2,
                'current_subrole' => 'descubridor',
                'status'          => 'active',
            ],
            [
                'id'              => Str::uuid(),
                'trainee_id'      => $trainee2->id,
                'coach_id'        => $coach->id,
                'start_date'      => now()->subWeeks(11)->toDateString(),
                'current_week'    => 12,
                'current_stage'   => 3,
                'current_subrole' => 'articulador',
                'status'          => 'active',
            ],
        ];

        foreach ($programs as $program) {
            DB::table('training_programs')->insertOrIgnore(array_merge($program, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
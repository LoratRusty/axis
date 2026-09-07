<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ProgramPhaseSeeder::class,
            RitualSeeder::class,
            UserSeeder::class,
            TrainingProgramSeeder::class,
            WeeklyTrackingSeeder::class,
        ]);
    }
}
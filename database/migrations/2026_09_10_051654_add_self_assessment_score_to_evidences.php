<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('evidences', function (Blueprint $table) {
            $table->tinyInteger('self_assessment_score')
                  ->unsigned()
                  ->nullable()
                  ->after('coach_notes')
                  ->comment('Auto-evaluación del Trainee del 1 al 10');
        });
    }

    public function down(): void
    {
        Schema::table('evidences', function (Blueprint $table) {
            $table->dropColumn('self_assessment_score');
        });
    }
};
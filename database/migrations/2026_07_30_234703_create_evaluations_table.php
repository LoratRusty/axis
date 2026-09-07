<?php
// database/migrations/2024_01_01_000008_create_evaluations_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('program_id');
            $table->uuid('weekly_tracking_id')->nullable();
            $table->uuid('coach_id');
            $table->enum('instrument', ['I1', 'I2', 'I3', 'I4', 'I5', 'I6']);
            $table->uuid('ritual_id')->nullable();
            
            // I1: Panel de Evidencia
            $table->enum('evidence_status', [
                'active',
                'partial',
                'inactive'
            ])->nullable();
            
            // I2: Frecuencia de Rituales
            $table->enum('frequency_level', [
                'high',
                'moderate',
                'low',
                'non_existent'
            ])->nullable();
            $table->decimal('frequency_pct', 5, 2)->nullable();
            
            // I3: Rúbrica de Calidad
            $table->integer('quality_level')->nullable();
            
            // I4: Observación en Campo
            $table->boolean('field_observed')->default(false);
            $table->text('field_notes')->nullable();
            
            // I5: Sesión de Retroalimentación
            $table->text('strengths')->nullable();
            $table->text('gaps')->nullable();
            $table->text('improvement_action')->nullable();
            
            // I6: Tablero Resumen
            $table->decimal('overall_score', 5, 2)->nullable();
            $table->text('next_cycle_focus')->nullable();
            $table->boolean('advance_to_next')->default(false);
            
            $table->enum('dimension_focus', [
                'volume',
                'time',
                'quality',
                'cost'
            ])->nullable();
            
            $table->timestamp('evaluated_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('program_id')
                  ->references('id')
                  ->on('training_programs')
                  ->onDelete('cascade');

            $table->foreign('weekly_tracking_id')
                  ->references('id')
                  ->on('weekly_tracking')
                  ->onDelete('set null');

            $table->foreign('coach_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('restrict');

            $table->foreign('ritual_id')
                  ->references('id')
                  ->on('rituals')
                  ->onDelete('set null');

            $table->index(['program_id', 'instrument']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
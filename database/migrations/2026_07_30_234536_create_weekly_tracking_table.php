<?php
// database/migrations/2024_01_01_000005_create_weekly_tracking_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('weekly_tracking', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('program_id');
            $table->integer('week_number');
            $table->date('week_start_date');
            $table->date('week_end_date');
            
            $table->integer('target_interactions')->default(0);
            $table->integer('actual_interactions')->default(0);
            $table->integer('rituals_target')->default(0);
            $table->integer('rituals_completed')->default(0);
            $table->integer('evidences_target')->default(0);
            $table->integer('evidences_uploaded')->default(0);
            
            $table->enum('status', [
                'pending',
                'in_progress',
                'completed',
                'overdue'
            ])->default('pending');
            
            $table->boolean('coach_reviewed')->default(false);
            $table->timestamp('coach_reviewed_at')->nullable();
            $table->uuid('coach_reviewed_by')->nullable();
            
            $table->enum('stage_at_start', ['A', 'B', 'C', 'D', 'E']);
            $table->string('subrole_at_start');
            $table->enum('dimension_at_start', [
                'volume',
                'time',
                'quality',
                'cost'
            ])->default('volume');
            
            $table->timestamps();

            $table->foreign('program_id')
                  ->references('id')
                  ->on('training_programs')
                  ->onDelete('cascade');

            $table->foreign('coach_reviewed_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');

            $table->unique(['program_id', 'week_number']);
            $table->index('status');
            $table->index('week_start_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('weekly_tracking');
    }
};
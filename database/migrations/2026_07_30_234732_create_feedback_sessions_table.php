<?php
// database/migrations/2024_01_01_000009_create_feedback_sessions_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feedback_sessions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('program_id');
            $table->uuid('coach_id');
            $table->enum('session_type', [
                'weekly_plan',
                'risk_management',
                'wins_losses',
                'quarterly_growth',
                'field_coaching'
            ]);
            $table->timestamp('session_date');
            $table->text('strengths');
            $table->text('gaps');
            $table->text('single_action');
            $table->uuid('ritual_focus')->nullable();
            $table->json('next_steps')->nullable();
            $table->boolean('trainee_ack')->default(false);
            $table->timestamps();

            $table->foreign('program_id')
                  ->references('id')
                  ->on('training_programs')
                  ->onDelete('cascade');

            $table->foreign('coach_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('restrict');

            $table->foreign('ritual_focus')
                  ->references('id')
                  ->on('rituals')
                  ->onDelete('set null');

            $table->index(['program_id', 'trainee_ack']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedback_sessions');
    }
};
<?php
// database/migrations/2024_01_01_000004_create_training_programs_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('training_programs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('trainee_id');
            $table->uuid('coach_id');
            $table->date('start_date');
            $table->integer('current_week')->default(1);
            $table->enum('current_stage', ['A', 'B', 'C', 'D', 'E'])->default('A');
            $table->enum('current_subrole', [
                'visitador',
                'prospectador',
                'descubridor',
                'articulador',
                'negociador',
                'asesor_comercial'
            ])->default('visitador');
            $table->enum('status', [
                'active',
                'on_hold',
                'graduated',
                'discontinued'
            ])->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('trainee_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->foreign('coach_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('restrict');

            $table->index('coach_id');
            $table->index('status');
            $table->index('current_stage');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('training_programs');
    }
};
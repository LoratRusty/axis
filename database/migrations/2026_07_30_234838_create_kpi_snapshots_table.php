<?php
// database/migrations/2024_01_01_000011_create_kpi_snapshots_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kpi_snapshots', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('program_id');
            $table->date('snapshot_date');
            $table->integer('week_number');
            $table->integer('weekly_interactions');
            $table->integer('total_interactions');
            $table->integer('spiced_opportunities');
            $table->integer('mutual_agreements');
            $table->decimal('win_rate', 5, 2)->nullable();
            $table->decimal('arr_consumables', 12, 2)->nullable();
            $table->enum('current_dimension', [
                'volume',
                'time',
                'quality',
                'cost'
            ]);
            $table->enum('current_phase', ['A', 'B', 'C', 'D', 'E']);
            $table->enum('advancement_recommendation', [
                'continue',
                'reinforce',
                'review',
                'graduate'
            ])->nullable();
            $table->timestamps();

            $table->foreign('program_id')
                  ->references('id')
                  ->on('training_programs')
                  ->onDelete('cascade');

            $table->index(['program_id', 'snapshot_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kpi_snapshots');
    }
};
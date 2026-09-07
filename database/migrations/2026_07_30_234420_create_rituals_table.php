<?php
// database/migrations/2024_01_01_000003_create_rituals_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rituals', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('number')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->uuid('phase_id');
            $table->string('tool', 100)->nullable();
            $table->enum('frequency', [
                'daily',
                'weekly',
                'per_visit',
                'monthly'
            ]);
            $table->enum('evidence_type', [
                'document',
                'form',
                'url',
                'image',
                'audio',
                'video'
            ]);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('phase_id')
                  ->references('id')
                  ->on('program_phases')
                  ->onDelete('restrict');

            $table->index('phase_id');
            $table->index('is_active');
            $table->index('number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rituals');
    }
};
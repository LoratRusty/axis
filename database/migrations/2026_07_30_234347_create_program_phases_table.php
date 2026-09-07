<?php
// database/migrations/2024_01_01_000002_create_program_phases_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('program_phases', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('code', ['A', 'B', 'C', 'D', 'E'])->unique();
            $table->string('name', 100);
            $table->integer('week_start');
            $table->integer('week_end');
            $table->string('main_tool')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index('code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('program_phases');
    }
};
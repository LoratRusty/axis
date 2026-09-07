<?php
// database/migrations/2024_01_01_000010_create_subrole_achievements_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subrole_achievements', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('program_id');
            $table->enum('subrole', [
                'visitador',
                'prospectador',
                'descubridor',
                'articulador',
                'negociador',
                'asesor_comercial'
            ]);
            $table->date('accredited_date');
            $table->uuid('accredited_by');
            $table->text('evidence_summary')->nullable();
            $table->json('kpis_at_accreditation')->nullable();
            $table->timestamps();

            $table->foreign('program_id')
                  ->references('id')
                  ->on('training_programs')
                  ->onDelete('cascade');

            $table->foreign('accredited_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('restrict');

            $table->index('program_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subrole_achievements');
    }
};
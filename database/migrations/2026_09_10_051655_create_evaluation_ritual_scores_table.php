<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluation_ritual_scores', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('evaluation_id');
            $table->uuid('ritual_id');
            $table->tinyInteger('score')->unsigned()->comment('Calificación del 1 al 10');
            $table->text('notes')->nullable()->comment('Notas a mejorar por ritual');
            $table->timestamps();

            $table->foreign('evaluation_id')
                  ->references('id')->on('evaluations')
                  ->onDelete('cascade');

            $table->foreign('ritual_id')
                  ->references('id')->on('rituals')
                  ->onDelete('restrict');

            $table->unique(['evaluation_id', 'ritual_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluation_ritual_scores');
    }
};
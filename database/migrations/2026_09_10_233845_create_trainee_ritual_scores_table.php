<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trainee_ritual_scores', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('program_id')->constrained('training_programs')->cascadeOnDelete();
            $table->foreignUuid('weekly_tracking_id')->constrained('weekly_tracking')->cascadeOnDelete();
            $table->foreignUuid('ritual_id')->constrained('rituals')->cascadeOnDelete();
            $table->unsignedTinyInteger('score')->comment('1-10');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['weekly_tracking_id', 'ritual_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trainee_ritual_scores');
    }
};

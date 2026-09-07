<?php
// database/migrations/2024_01_01_000006_create_evidences_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evidences', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('program_id');
            $table->uuid('weekly_tracking_id');
            $table->uuid('ritual_id');
            $table->uuid('uploaded_by');
            
            $table->string('title');
            $table->text('description');
            $table->enum('evidence_type', [
                'document',
                'image',
                'url',
                'audio',
                'video',
                'form'
            ]);
            
            $table->string('file_path')->nullable();
            $table->string('file_url')->nullable();
            $table->string('external_url')->nullable();
            $table->string('file_name')->nullable();
            $table->string('file_mime')->nullable();
            $table->integer('file_size_kb')->nullable();
            
            $table->enum('status', [
                'pending_review',
                'approved',
                'needs_revision',
                'rejected'
            ])->default('pending_review');
            
            $table->text('coach_notes')->nullable();
            $table->uuid('reviewed_by')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('program_id')
                  ->references('id')
                  ->on('training_programs')
                  ->onDelete('cascade');

            $table->foreign('weekly_tracking_id')
                  ->references('id')
                  ->on('weekly_tracking')
                  ->onDelete('cascade');

            $table->foreign('ritual_id')
                  ->references('id')
                  ->on('rituals')
                  ->onDelete('restrict');

            $table->foreign('uploaded_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->foreign('reviewed_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');

            $table->index(['program_id', 'status']);
            $table->index('weekly_tracking_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evidences');
    }
};
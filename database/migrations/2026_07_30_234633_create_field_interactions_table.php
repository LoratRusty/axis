<?php
// database/migrations/2024_01_01_000007_create_field_interactions_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('field_interactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('program_id');
            $table->uuid('weekly_tracking_id');
            
            $table->string('client_name');
            $table->string('client_account')->nullable();
            $table->date('visit_date');
            $table->enum('visit_type', [
                'prospecting',
                'discovery',
                'proposal',
                'negotiation',
                'closing',
                'follow_up'
            ]);
            
            $table->boolean('is_in_matrix')->default(false);
            $table->boolean('is_scheduled')->default(false);
            $table->boolean('is_presential')->default(false);
            $table->boolean('crm_registered')->default(false);
            $table->boolean('has_artifacts')->default(false);
            $table->boolean('is_valid')->default(false);
            
            $table->string('spiced_doc_url')->nullable();
            $table->text('notes')->nullable();
            
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

            $table->index(['program_id', 'is_valid']);
            $table->index('visit_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('field_interactions');
    }
};
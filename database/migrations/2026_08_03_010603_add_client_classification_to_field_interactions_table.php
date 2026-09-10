<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('field_interactions', function (Blueprint $table) {
            $table->enum('client_classification', ['A', 'B', 'C'])
                  ->nullable()
                  ->after('client_account');
            $table->boolean('leader_approval')
                  ->default(false)
                  ->after('client_classification');
        });
    }

    public function down(): void
    {
        Schema::table('field_interactions', function (Blueprint $table) {
            $table->dropColumn(['client_classification', 'leader_approval']);
        });
    }
};

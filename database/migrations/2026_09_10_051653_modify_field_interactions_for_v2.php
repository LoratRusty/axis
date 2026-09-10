<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('field_interactions', function (Blueprint $table) {
            // Agregar opportunity_name en lugar de spiced_doc_url
            $table->string('opportunity_name')->nullable()->after('client_account');
        });

        // Modificar ENUM visit_type quitando follow_up
        DB::statement("ALTER TABLE field_interactions MODIFY COLUMN visit_type ENUM('prospecting','discovery','proposal','negotiation','closing') NOT NULL");

        // Quitar client_classification
        Schema::table('field_interactions', function (Blueprint $table) {
            $table->dropColumn('client_classification');
        });
    }

    public function down(): void
    {
        Schema::table('field_interactions', function (Blueprint $table) {
            $table->dropColumn('opportunity_name');
            $table->enum('client_classification', ['A', 'B', 'C'])->nullable()->after('client_account');
        });

        DB::statement("ALTER TABLE field_interactions MODIFY COLUMN visit_type ENUM('prospecting','discovery','proposal','negotiation','closing','follow_up') NOT NULL");
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('training_programs', function (Blueprint $table) {
            $table->timestamp('promotion_recommended_at')->nullable()->after('notes');
            $table->foreignUuid('promotion_recommended_by')->nullable()->after('promotion_recommended_at')->constrained('users')->nullOnDelete();
            $table->text('promotion_recommendation_notes')->nullable()->after('promotion_recommended_by');
        });
    }

    public function down(): void
    {
        Schema::table('training_programs', function (Blueprint $table) {
            $table->dropForeign(['promotion_recommended_by']);
            $table->dropColumn([
                'promotion_recommended_at',
                'promotion_recommended_by',
                'promotion_recommendation_notes',
            ]);
        });
    }
};
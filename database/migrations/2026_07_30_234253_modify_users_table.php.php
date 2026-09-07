<?php
// database/migrations/2024_01_01_000001_modify_users_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Cambiar id a UUID
            $table->dropColumn('id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->uuid('id')->primary()->first();
            $table->enum('role', [
                'trainee',
                'coach',
                'manager',
                'biz_dev',
                'admin'
            ])->default('trainee')->after('password');
            $table->string('region', 100)->nullable()->after('role');
            $table->string('phone', 20)->nullable()->after('region');
            $table->string('avatar_url')->nullable()->after('phone');
            $table->boolean('is_active')->default(true)->after('avatar_url');
            $table->softDeletes();

            $table->index('role');
            $table->index('region');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role']);
            $table->dropIndex(['region']);
            $table->dropIndex(['is_active']);
            $table->dropColumn([
                'role', 'region', 'phone', 'avatar_url', 'is_active'
            ]);
            $table->dropSoftDeletes();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->id()->first();
        });
    }
};
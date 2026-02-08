<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('modalities', function (Blueprint $table) {
            $table->string('slug')->unique()->nullable()->after('name');
            $table->string('color')->default('#3b82f6')->after('slug');
            $table->string('icon')->default('heroicon-o-academic-cap')->after('color');
            $table->boolean('is_active')->default(true)->after('icon');
            $table->integer('order')->default(0)->after('is_active');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('modalities', function (Blueprint $table) {
            $table->dropColumn(['slug', 'color', 'icon', 'is_active', 'order']);
            $table->dropSoftDeletes();
        });
    }
};

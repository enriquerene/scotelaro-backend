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
        Schema::table('pricing_tiers', function (Blueprint $table) {
            $table->text('description')->nullable()->after('name');
            $table->string('billing_period')->default('monthly')->after('price');
            $table->decimal('comparative_price', 10, 2)->nullable()->after('price');
            $table->string('frequency_type')->default('unlimited')->after('billing_period');
            $table->integer('class_cap')->nullable()->after('frequency_type');
            $table->boolean('is_active')->default(true)->after('class_cap');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pricing_tiers', function (Blueprint $table) {
            $table->dropColumn([
                'description',
                'billing_period',
                'comparative_price',
                'frequency_type',
                'class_cap',
                'is_active'
            ]);
            $table->dropSoftDeletes();
        });
    }
};

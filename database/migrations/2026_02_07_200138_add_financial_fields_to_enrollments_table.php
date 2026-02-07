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
        Schema::table('enrollments', function (Blueprint $table) {
            $table->foreignId('pricing_tier_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('amount', 10, 2)->default(0)->after('pricing_tier_id');
            $table->string('payment_method')->nullable()->after('amount');
            $table->timestamp('next_billing_date')->nullable()->after('payment_method');
            $table->text('notes')->nullable()->after('next_billing_date');
            $table->string('cancellation_reason')->nullable()->after('notes');
            $table->timestamp('cancelled_at')->nullable()->after('cancellation_reason');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete()->after('cancelled_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            $table->dropForeign(['pricing_tier_id']);
            $table->dropForeign(['created_by']);
            $table->dropColumn([
                'pricing_tier_id',
                'amount',
                'payment_method',
                'next_billing_date',
                'notes',
                'cancellation_reason',
                'cancelled_at',
                'created_by'
            ]);
        });
    }
};

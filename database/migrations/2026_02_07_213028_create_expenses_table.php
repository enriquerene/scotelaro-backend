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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->decimal('amount', 10, 2);
            $table->string('category')->default('other'); // staff_payment, maintenance, marketing, supplies, etc.
            $table->date('date');
            $table->string('payment_method')->default('cash'); // cash, bank_transfer, credit_card, pix
            $table->text('notes')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // who recorded the expense
            $table->foreignId('staff_id')->nullable()->constrained('users')->nullOnDelete(); // if it's a staff payment
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};

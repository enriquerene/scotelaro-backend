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
        Schema::create('resource_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category')->default('supplies'); // first_aid, maintenance, marketing, equipment, supplies
            $table->text('description')->nullable();
            $table->integer('quantity')->default(1);
            $table->decimal('unit_cost', 10, 2)->nullable();
            $table->decimal('total_cost', 10, 2)->nullable();
            $table->date('purchase_date')->nullable();
            $table->date('next_maintenance_date')->nullable();
            $table->string('status')->default('available'); // available, in_use, maintenance, depleted
            $table->foreignId('responsible_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resource_items');
    }
};

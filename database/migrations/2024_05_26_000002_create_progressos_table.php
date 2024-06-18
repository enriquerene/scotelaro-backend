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
        Schema::create('progressos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('modalidade_id');
            $table->string('graduacao');
            $table->timestamps();
            $table->string('presenca')->default('0/0');

            $table->foreign('modalidade_id')->references('id')->on('modalidades');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progressos');
    }
};

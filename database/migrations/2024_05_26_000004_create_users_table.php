<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->char('uuid', 36)->default(DB::raw('UUID()'))->unique();
            $table->string('whatsapp')->unique();
            $table->string('senha');
            $table->timestamp('whatsapp_verificado_em')->nullable();
            $table->string('email')->nullable();
            $table->rememberToken();
            $table->unsignedBigInteger('plano_id')->nullable();
            $table->date('data_inscricao_plano')->nullable();
            $table->string('turmas_experimentais_id')->nullable();
            $table->timestamps();

            $table->foreign('plano_id')->references('id')->on('planos')->onDelete('restrict');
        });

        Schema::create('tokens_redefinicoes_de_senha', function (Blueprint $table) {
            $table->string('uuid')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('tokens_redefinicoes_de_senha');
    }
};

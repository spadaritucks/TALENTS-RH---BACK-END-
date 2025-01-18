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
        Schema::create('candidatos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('ultimo_cargo');
            $table->decimal('ultimo_salario',8,2);
            $table->decimal('pretensao_salarial_clt',8,2);
            $table->decimal('pretensao_salarial_pj',8,2);
            $table->string('posicao_desejada');
            $table->string('escolaridade');
            $table->string('graduacao_principal');
            $table->string('como_conheceu');
            $table->string('consultor_talents');
            $table->string('nivel_ingles');
            $table->string('qualificacoes_tecnicas');
            $table->string('certificacoes');
            $table->string('cv');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidatos');
    }
};

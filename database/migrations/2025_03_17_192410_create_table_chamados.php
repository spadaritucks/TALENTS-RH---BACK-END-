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
        Schema::create('chamados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->onDelete('cascade');
            $table->foreignId('profissao_id')->constrained('profissoes')->onDelete('cascade');
            $table->foreignId('headhunter_id')->constrained('headhunters')->onDelete('cascade');
            $table->string('descricao');
            $table->string('numero_vagas');
            $table->string('status')->nullable();
            $table->timestamps();
        });

        Schema::create('chamado_atualizacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chamados_id')->constrained('chamados')->onDelete('cascade');
            $table->foreignId('headhunter_id')->constrained('headhunters')->onDelete('cascade');
            $table->string('titulo');
            $table->string('anexo');
            $table->text('atualizacoes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chamado_atualizacoes');
        Schema::dropIfExists('chamados');
    }
};
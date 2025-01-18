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
        Schema::create('headhunters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('como_conheceu');
            $table->string('situacao');
            $table->text('comportamento_description');
            $table->string('anos_trabalho');
            $table->string('quantia_vagas');
            $table->string('horas_diarias');
            $table->string('dias_semanais');
            $table->string('nivel_senioridade');
            $table->string('segmento');
            $table->string('cv');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('headhunters');
    }
};

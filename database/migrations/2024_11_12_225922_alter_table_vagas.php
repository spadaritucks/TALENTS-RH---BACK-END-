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
        Schema::table('vagas', function (Blueprint $table) {
            $table->dropColumn('salario');
            $table->string('competencias')->after('descricao');
            $table->string('salario_minimo')->after('nivel_senioridade');
            $table->string('salario_maximo')->after('salario_minimo');
            $table->string('status')->after('salario_maximo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vagas', function (Blueprint $table) {
            //
        });
    }
};

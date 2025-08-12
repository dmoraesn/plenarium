<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('partidos', function (Blueprint $table) {
            $table->id();
            $table->string('sigla', 20)->unique();     // ex.: PSDB, PT
            $table->string('nome', 100);               // ex.: Partido dos Trabalhadores
            $table->boolean('ativo')->default(true);   // padrão do sistema: inativação lógica
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('partidos');
    }
};

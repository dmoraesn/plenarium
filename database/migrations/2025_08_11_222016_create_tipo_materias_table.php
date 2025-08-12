<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tipo_materias', function (Blueprint $table) {
            $table->id();
            $table->string('sigla', 10)->unique();      // ex.: PL, REQ, MOC
            $table->string('nome', 100);                // ex.: Projeto de Lei
            $table->boolean('ativo')->default(true);    // inativação lógica (sem delete destrutivo)
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('tipo_materias');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('materia_numeracoes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('tipo_materia_id')->constrained('tipo_materias')->cascadeOnDelete();
            $table->smallInteger('ano');
            $table->integer('proximo_numero')->default(1);
            $table->timestamps();

            $table->unique(['tipo_materia_id', 'ano'], 'materia_numeracoes_unq');
        });
    }

    public function down(): void {
        Schema::dropIfExists('materia_numeracoes');
    }
};

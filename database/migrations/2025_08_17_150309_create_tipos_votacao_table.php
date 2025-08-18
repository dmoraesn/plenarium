<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tipos_votacao', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 150)->unique();
            $table->text('descricao')->nullable();

            // 🗳️ critérios de votação
            $table->enum('criterio', [
                'maioria_simples',
                'maioria_absoluta',
                'maioria_qualificada',
                'personalizado'
            ])->default('maioria_simples');

            // usados apenas se criterio = personalizado
            $table->unsignedInteger('percentual')->nullable(); // Ex.: 60 = 60%
            $table->unsignedInteger('min_votos')->nullable();  // Ex.: mínimo de votos
            $table->string('condicoes_adicionais')->nullable(); // Texto livre

            $table->boolean('ativo')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tipos_votacao');
    }
};

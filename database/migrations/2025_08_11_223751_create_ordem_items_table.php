<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ordem_itens', function (Blueprint $table) {
            $table->id();

            $table->foreignId('sessao_id')->constrained('sessoes')->cascadeOnDelete();
            $table->foreignId('materia_id')->constrained('materias')->cascadeOnDelete();

            $table->unsignedSmallInteger('posicao'); // começa em 1
            $table->enum('situacao', ['em_pauta','adiado','retirado'])->default('em_pauta');
            $table->string('justificativa')->nullable(); // usado para adiar/retirar

            $table->timestamps();

            // Regras de unicidade na sessão
            $table->unique(['sessao_id','materia_id'], 'ordem_item_unq_materia_por_sessao');
            $table->unique(['sessao_id','posicao'], 'ordem_item_unq_posicao_por_sessao');

            $table->index(['sessao_id','situacao']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ordem_itens');
    }
};

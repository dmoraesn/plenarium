<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sessoes', function (Blueprint $table) {
            $table->id();

            $table->unsignedSmallInteger('numero');     // nº da sessão no ano
            $table->unsignedSmallInteger('ano');        // facilita índices/relatórios
            $table->enum('tipo', ['ordinaria','extraordinaria','solene'])->default('ordinaria');

            // Máquina de estados (mínimo viável do manual): abrir / encerrar / publicar
            $table->enum('status', ['planejada','aberta','encerrada','publicada','cancelada'])
                  ->default('planejada');

            // Marcos operacionais
            $table->timestamp('aberta_em')->nullable();
            $table->timestamp('encerrada_em')->nullable();
            $table->timestamp('publicada_em')->nullable();

            // Data prevista/real
            $table->date('data')->index();              // listagem por data
            $table->text('observacoes')->nullable();

            $table->timestamps();

            // Unicidade: (ano, numero, tipo)
            $table->unique(['ano','numero','tipo'], 'sessoes_ano_numero_tipo_unq');

            // Índices úteis
            $table->index(['status','tipo']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessoes');
    }
};

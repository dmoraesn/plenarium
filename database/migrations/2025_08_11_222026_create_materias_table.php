<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::create('materias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_materia_id')->constrained('tipo_materias')->cascadeOnUpdate();
            $table->unsignedInteger('numero');       // número da matéria dentro do ano/tipo
            $table->unsignedSmallInteger('ano');
            $table->text('ementa');
            $table->enum('status', [                  // máquina de estados (versão 1 – string/enum do banco)
                'rascunho', 'protocolada', 'em_comissoes', 'pronta_pauta',
                'adiada', 'retirada', 'aprovada', 'rejeitada', 'arquivada'
            ])->default('rascunho');
            $table->boolean('ativo')->default(true);  // inativação lógica
            $table->timestamps();

            // Unicidade exigida: tipo + ano + número
            $table->unique(['tipo_materia_id', 'ano', 'numero'], 'materias_tipo_ano_numero_unique');

            // Índices auxiliares
            $table->index(['status', 'ativo']);
        });

        // Opcional: FULLTEXT para ementa (MySQL/MariaDB). Ignora drivers que não suportam.
        try {
            if (DB::getDriverName() === 'mysql') {
                DB::statement('ALTER TABLE materias ADD FULLTEXT idx_materias_ementa (ementa)');
            }
        } catch (\Throwable $e) {
            // TODO: se necessário, logar/avisar — em dev podemos ignorar
        }
    }

    public function down(): void {
        Schema::dropIfExists('materias');
    }
};

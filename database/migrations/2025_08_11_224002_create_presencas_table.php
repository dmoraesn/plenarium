<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('presencas', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->id();
            $table->foreignId('sessao_id')->constrained('sessoes')->cascadeOnDelete();
            $table->foreignId('vereador_id')->constrained('vereadores')->cascadeOnDelete();

            // presença/ausência com carimbo
            $table->enum('status', ['presente','ausente'])->default('ausente');
            $table->timestamp('marcado_em')->useCurrent();

            // alteração com justificativa (auditoria funcional)
            $table->timestamp('alterado_em')->nullable();
            $table->string('justificativa', 255)->nullable();

            // (opcional) quem marcou/alterou
            $table->foreignId('marcado_por_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('alterado_por_user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            // um registro por sessão+vereador
            $table->unique(['sessao_id','vereador_id'], 'presenca_unq_sessao_vereador');

            $table->index(['sessao_id','status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('presencas');
    }
};

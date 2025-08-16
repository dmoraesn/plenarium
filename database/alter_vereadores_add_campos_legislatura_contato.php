<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('vereadores', function (Blueprint $table) {
            // contato/identificação
            $table->string('cpf', 14)->nullable()->after('nome_completo');
            $table->string('email')->nullable()->after('cpf');
            $table->string('telefone')->nullable()->after('email');

            // vínculo legislatura (FK opcional)
            $table->foreignId('legislatura_id')->nullable()->after('partido_id')
                  ->constrained('legislaturas')->nullOnDelete();

            // índice/unique conforme disponibilidade de dados
            $table->unique('cpf', 'vereadores_unq_cpf');
        });
    }

    public function down(): void {
        Schema::table('vereadores', function (Blueprint $table) {
            $table->dropUnique('vereadores_unq_cpf');
            $table->dropConstrainedForeignId('legislatura_id');
            $table->dropColumn(['cpf','email','telefone']);
        });
    }
};

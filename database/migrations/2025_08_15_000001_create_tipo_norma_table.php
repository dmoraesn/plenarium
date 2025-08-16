<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tipo_norma', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('descricao', 150);
            $table->string('sigla', 20)->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();

            $table->unique('descricao', 'tipo_norma_unq_desc');
            $table->unique('sigla', 'tipo_norma_unq_sigla');
        });
    }

    public function down(): void {
        Schema::dropIfExists('tipo_norma');
    }
};

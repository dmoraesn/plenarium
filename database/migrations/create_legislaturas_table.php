<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('legislaturas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('numero')->nullable();        // número sequencial
            $table->date('data_eleicao')->nullable();
            $table->date('data_inicio');
            $table->date('data_fim');
            $table->text('observacao')->nullable();
            $table->boolean('ativo')->default(false);
            $table->timestamps();

            $table->unique(['data_inicio','data_fim'], 'legislaturas_unq_periodo');
        });
    }

    public function down(): void {
        Schema::dropIfExists('legislaturas');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('cargo_mesa', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('descricao', 100);
            $table->integer('posicao_ordenacao')->nullable();
            $table->boolean('cargo_unico')->default(true);
            $table->text('observacao')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();

            $table->unique('descricao', 'cargo_mesa_unq_descricao');
        });
    }

    public function down(): void {
        Schema::dropIfExists('cargo_mesa');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('cargo_mesa', function (Blueprint $table) {
            $table->id();
            $table->string('descricao');
            $table->unsignedInteger('posicao_ordenacao')->nullable();
            $table->boolean('cargo_unico')->default(false);
            $table->text('observacao')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('cargo_mesa');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('group', 60)->index();         // ex.: casa, votacao, materias, sessao, integracoes
            $table->string('key', 150)->unique();         // ex.: votacao.quorum_abertura
            $table->json('value')->nullable();            // valor tipado
            $table->string('description', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('settings');
    }
};

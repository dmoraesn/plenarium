<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vereadores', function (Blueprint $table) {
            $table->id();
            $table->string('nome_parlamentar', 120)->index();
            $table->string('nome_completo', 150);
            $table->foreignId('partido_id')->nullable()->constrained('partidos')->nullOnDelete();
            $table->string('foto')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vereadores');
    }
};

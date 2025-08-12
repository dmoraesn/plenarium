<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('materia_anexos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('materia_id')->constrained('materias')->cascadeOnDelete();
            $table->string('arquivo');                 // path relativo em storage/app/public
            $table->string('nome_original')->nullable();
            $table->string('mime', 100)->nullable();
            $table->unsignedBigInteger('tamanho_bytes')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('materia_anexos');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('materia_vereador')) {
            Schema::create('materia_vereador', function (Blueprint $table) {
                $table->unsignedBigInteger('materia_id');
                $table->unsignedBigInteger('vereador_id');
                $table->timestamps();

                $table->primary(['materia_id', 'vereador_id']);
                $table->foreign('materia_id')->references('id')->on('materias')->cascadeOnDelete();
                $table->foreign('vereador_id')->references('id')->on('vereadores')->cascadeOnDelete();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('materia_vereador');
    }
};

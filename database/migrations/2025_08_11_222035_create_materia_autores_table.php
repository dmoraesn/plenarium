<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('materia_autores', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->id();
            $table->unsignedBigInteger('materia_id');
            $table->unsignedBigInteger('vereador_id');
            $table->enum('papel', ['autor','coautor'])->default('autor');
            $table->timestamps();

            $table->unique(['materia_id','vereador_id','papel'], 'materia_autor_unq');

            $table->foreign('materia_id')
                  ->references('id')->on('materias')
                  ->onDelete('cascade');

            $table->foreign('vereador_id')
                  ->references('id')->on('vereadores')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materia_autores');
    }
};

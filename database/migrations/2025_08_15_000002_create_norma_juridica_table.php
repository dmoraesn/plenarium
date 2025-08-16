<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('norma_juridica', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('tipo')->constrained('tipo_norma'); // campo “tipo” como FK (seguir SAPL)
            $table->integer('numero');
            $table->integer('ano');
            $table->text('ementa')->nullable();
            $table->longText('texto_integral')->nullable();  // pode guardar o texto ou um link
            $table->date('data_publicacao')->nullable();
            $table->timestamps();

            $table->unique(['tipo','numero','ano'], 'norma_juridica_unq_composta');
        });
    }

    public function down(): void {
        Schema::dropIfExists('norma_juridica');
    }
};

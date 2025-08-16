<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tipo_expediente', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('descricao', 150);
            $table->integer('ordenacao')->nullable();
            $table->text('observacao')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();

            $table->unique('descricao', 'tipo_expediente_unq_desc');
        });
    }

    public function down(): void {
        Schema::dropIfExists('tipo_expediente');
    }
};

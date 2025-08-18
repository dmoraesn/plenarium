<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// O nome da classe deve corresponder ao nome do arquivo
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // O nome da tabela, conforme a especificação, é 'tipos_tramitacao' (no plural)
        Schema::create('tipos_tramitacao', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 150)->unique();
            $table->text('descricao')->nullable();
            $table->unsignedInteger('prazo_dias')->default(0);
            $table->boolean('ativo')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipos_tramitacao');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
public function up()
{
    Schema::create('legislaturas', function (Blueprint $table) {
        $table->id();
        $table->unsignedSmallInteger('numero');
        $table->date('data_eleicao');
        $table->date('data_inicio');
        $table->date('data_fim');
        $table->text('observacao')->nullable();
        $table->boolean('ativo')->default(true);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('legislaturas');
    }
};

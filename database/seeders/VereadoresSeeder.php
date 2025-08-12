<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vereador;
use App\Models\Partido;

class VereadoresSeeder extends Seeder
{
    public function run(): void
    {
        $abc = Partido::where('sigla','ABC')->first();
        $xyz = Partido::where('sigla','XYZ')->first();

        Vereador::updateOrCreate(
            ['nome_parlamentar' => 'João da Silva'],
            ['nome_completo' => 'João da Silva', 'partido_id' => optional($abc)->id, 'ativo' => true]
        );

        Vereador::updateOrCreate(
            ['nome_parlamentar' => 'Maria Souza'],
            ['nome_completo' => 'Maria de Souza', 'partido_id' => optional($xyz)->id, 'ativo' => true]
        );
    }
}

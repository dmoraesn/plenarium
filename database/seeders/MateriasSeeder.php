<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Materia;
use App\Models\TipoMateria;
use App\Models\Vereador;

class MateriasSeeder extends Seeder
{
    public function run(): void
    {
        $pl  = TipoMateria::where('sigla','PL')->first();
        $req = TipoMateria::where('sigla','REQ')->first();

        $joao  = Vereador::where('nome_parlamentar','João da Silva')->first();
        $maria = Vereador::where('nome_parlamentar','Maria Souza')->first();

        $m1 = Materia::updateOrCreate(
            ['tipo_materia_id' => $pl->id, 'ano' => 2025, 'numero' => 1],
            ['ementa' => 'Cria o Programa Municipal de Áreas Verdes', 'status' => 'pronta_pauta', 'ativo' => true]
        );
        $m1->autores()->syncWithoutDetaching([$joao->id => ['papel' => 'autor']]);

        $m2 = Materia::updateOrCreate(
            ['tipo_materia_id' => $req->id, 'ano' => 2025, 'numero' => 2],
            ['ementa' => 'Requer informações sobre obras em andamento', 'status' => 'pronta_pauta', 'ativo' => true]
        );
        $m2->autores()->syncWithoutDetaching([$maria->id => ['papel' => 'autor']]);
    }
}

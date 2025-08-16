<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CargoMesaSeeder extends Seeder
{
    public function run(): void
    {
        $itens = [
            ['descricao' => 'Presidente',      'posicao_ordenacao' => 1, 'cargo_unico' => true, 'ativo' => true],
            ['descricao' => 'Vice-Presidente', 'posicao_ordenacao' => 2, 'cargo_unico' => true, 'ativo' => true],
            ['descricao' => '1º Secretário',   'posicao_ordenacao' => 3, 'cargo_unico' => true, 'ativo' => true],
            ['descricao' => '2º Secretário',   'posicao_ordenacao' => 4, 'cargo_unico' => true, 'ativo' => true],
        ];

        foreach ($itens as $i) {
            DB::table('cargo_mesa')->updateOrInsert(['descricao' => $i['descricao']], $i);
        }
    }
}

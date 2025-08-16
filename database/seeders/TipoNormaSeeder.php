<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoNormaSeeder extends Seeder
{
    public function run(): void
    {
        $itens = [
            ['descricao' => 'Lei',        'sigla' => 'LEI',  'ativo' => true],
            ['descricao' => 'Decreto',    'sigla' => 'DEC',  'ativo' => true],
            ['descricao' => 'Resolução',  'sigla' => 'RES',  'ativo' => true],
        ];

        foreach ($itens as $i) {
            DB::table('tipo_norma')->updateOrInsert(['descricao' => $i['descricao']], $i);
        }
    }
}

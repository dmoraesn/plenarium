<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoExpedienteSeeder extends Seeder
{
    public function run(): void
    {
        $itens = [
            ['descricao' => 'Leitura e aprovação da ata', 'ordenacao' => 1, 'ativo' => true],
            ['descricao' => 'Expediente do Executivo',    'ordenacao' => 2, 'ativo' => true],
            ['descricao' => 'Expediente dos Vereadores',  'ordenacao' => 3, 'ativo' => true],
            ['descricao' => 'Comunicações',               'ordenacao' => 4, 'ativo' => true],
        ];

        foreach ($itens as $i) {
            DB::table('tipo_expediente')->updateOrInsert(['descricao' => $i['descricao']], $i);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoMateria;

class TipoMateriaSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = [
            ['sigla' => 'PL',  'nome' => 'Projeto de Lei'],
            ['sigla' => 'REQ', 'nome' => 'Requerimento'],
            ['sigla' => 'MOC', 'nome' => 'Moção'],
            ['sigla' => 'IND', 'nome' => 'Indicação'],
        ];

        foreach ($tipos as $t) {
            TipoMateria::updateOrCreate(['sigla' => $t['sigla']], $t + ['ativo' => true]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Partido;

class PartidosSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['sigla' => 'ABC', 'nome' => 'Partido ABC'],
            ['sigla' => 'XYZ', 'nome' => 'Partido XYZ'],
        ];

        foreach ($data as $p) {
            Partido::updateOrCreate(['sigla' => $p['sigla']], $p + ['ativo' => true]);
        }
    }
}

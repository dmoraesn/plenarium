<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sessao;
use App\Models\Materia;
use App\Models\OrdemItem;

class OrdemDoDiaSeeder extends Seeder
{
    public function run(): void
    {
        $sessao = Sessao::where(['ano' => 2025, 'numero' => 1, 'tipo' => 'ordinaria'])->first();
        if (!$sessao) return;

        $materias = Materia::whereIn('numero', [1,2])->where('ano', 2025)->orderBy('numero')->get();

        $pos = 1;
        foreach ($materias as $m) {
            OrdemItem::updateOrCreate(
                ['sessao_id' => $sessao->id, 'materia_id' => $m->id],
                ['posicao' => $pos++, 'situacao' => 'em_pauta']
            );
        }
    }
}

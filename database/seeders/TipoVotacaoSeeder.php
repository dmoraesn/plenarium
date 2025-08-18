<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoVotacao;

class TipoVotacaoSeeder extends Seeder
{
    public function run(): void
    {
        // Registros padrão
        $tipos = [
            [
                'nome' => 'Maioria Simples',
                'descricao' => 'Aprovação por maioria dos votos dos presentes, desde que haja quórum mínimo.',
                'criterio' => 'maioria_simples',
                'percentual' => null,
                'min_votos' => null,
                'condicoes_adicionais' => null,
                'ativo' => true,
            ],
            [
                'nome' => 'Maioria Absoluta',
                'descricao' => 'Aprovação pelo primeiro número inteiro superior à metade do total de membros do colegiado.',
                'criterio' => 'maioria_absoluta',
                'percentual' => null,
                'min_votos' => null,
                'condicoes_adicionais' => null,
                'ativo' => true,
            ],
            [
                'nome' => 'Maioria Qualificada',
                'descricao' => 'Aprovação por fração superior (ex.: 2/3 ou 3/5) do total de membros do colegiado.',
                'criterio' => 'maioria_qualificada',
                'percentual' => 66, // exemplo: 2/3
                'min_votos' => null,
                'condicoes_adicionais' => null,
                'ativo' => true,
            ],
        ];

        foreach ($tipos as $tipo) {
            TipoVotacao::firstOrCreate(['nome' => $tipo['nome']], $tipo);
        }

        // Registros fakes adicionais para testes
        TipoVotacao::factory()->count(5)->create();
    }
}

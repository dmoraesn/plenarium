<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sessao;
use Illuminate\Support\Carbon;

class SessoesSeeder extends Seeder
{
    public function run(): void
    {
        Sessao::updateOrCreate(
            ['ano' => 2025, 'numero' => 1, 'tipo' => 'ordinaria'],
            ['status' => 'planejada', 'data' => Carbon::now()->toDateString()]
        );
    }
}

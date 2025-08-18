<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Aqui você chama os seeders que quiser
        $this->call([
            TipoVotacaoSeeder::class,
        ]);
    }
}

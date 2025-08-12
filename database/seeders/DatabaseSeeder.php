<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
{
    $this->call([
        PartidosSeeder::class,
        VereadoresSeeder::class,
        TipoMateriasSeeder::class,
        MateriasSeeder::class,
        SessoesSeeder::class,
        OrdemDoDiaSeeder::class,
    ]);
}

}
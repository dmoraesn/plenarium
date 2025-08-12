<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@sisplenarium.local'],
            [
                'name' => 'Admin SisPlenarium',
                'password' => Hash::make('senha123'), // TODO: trocar em produção
            ]
        );
    }
}

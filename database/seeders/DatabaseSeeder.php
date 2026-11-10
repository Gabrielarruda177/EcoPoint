<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Popula a base com os dados essenciais para o desenvolvimento inicial.
     */
    public function run(): void
    {
        // 1. Cadastra o Administrador inicial para testes e acesso
        User::firstOrCreate(
            ['email' => 'admin@ecopoint.com'],
            [
                'name' => 'Administrador EcoPoint',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // 2. Popula a lista inicial de materiais acadêmicos aceitos
        $this->call([
            MaterialAceitoSeeder::class,
        ]);
    }
}

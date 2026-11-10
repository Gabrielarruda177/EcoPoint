<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Popula a base com os dados essenciais para o desenvolvimento inicial.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            MaterialAceitoSeeder::class,
            OngSeeder::class,
        ]);
    }
}

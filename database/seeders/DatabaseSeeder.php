<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            HorariosSeeder::class,
            ModalidadesSeeder::class,
            TurmasSeeder::class,
            TurmaHorariosSeeder::class,
            PlanosSeeder::class,
            PlanoTurmasSeeder::class,
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlanosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $table = DB::table('planos');
        if ($table->count() === 0) {
            $table->insert([
                ['nome' => 'Plano Boxe Noite', 'valor' => 100],
                ['nome' => 'Plano Muay Thai Manhã', 'valor' => 110],
                ['nome' => 'Plano Muay Thai Noite', 'valor' => 110],
                ['nome' => 'Plano Muay Thai Manhã e Noite', 'valor' => 180],
                ['nome' => 'Plano MMA Noite', 'valor' => 120],
                ['nome' => 'Plano Muay Thai Manhã e Boxe Noite', 'valor' => 180],
                ['nome' => 'Plano Muay Thai Noite e Boxe Noite', 'valor' => 180],
                ['nome' => 'Plano Muay Thai Manhã e Luta Livre Manhã', 'valor' => 180],
                ['nome' => 'Plano Muay Thai Manhã e Luta Livre Noite', 'valor' => 180],
                ['nome' => 'Plano Muay Thai Noite e Luta Livre Manhã', 'valor' => 180],
                ['nome' => 'Plano Muay Thai Noite e Luta Livre Noite', 'valor' => 180],
                ['nome' => 'Plano Muay Thai Manhã e MMA Noite', 'valor' => 200],
                ['nome' => 'Plano Muay Thai Noite e MMA Noite', 'valor' => 200],
                ['nome' => 'Plano Todas as Modalidades', 'valor' => 230],
            ]);
        }
    }
}

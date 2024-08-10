<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TurmasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $table = DB::table('turmas');
        if ($table->count() === 0) {
            $table->insert([
                ['nome' => 'Luta Livre Manhã', 'modalidade_id' => 1, 'valor' => 110],
                ['nome' => 'Luta Livre Noite', 'modalidade_id' => 1, 'valor' => 110],
                ['nome' => 'Muay Thai Manhã', 'modalidade_id' => 2, 'valor' => 110],
                ['nome' => 'Muay Thai Noite', 'modalidade_id' => 2, 'valor' => 110],
                ['nome' => 'Boxe Noite', 'modalidade_id' => 3, 'valor' => 100],
                ['nome' => 'MMA Noite', 'modalidade_id' => 4, 'valor' => 120],
            ]);
        }
    }
}

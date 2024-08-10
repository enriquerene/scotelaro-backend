<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlanoTurmasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $table = DB::table('plano_turmas');
        if ($table->count() === 0) {
            $table->insert([
                ['plano_id' => 1, 'turma_id' => 5],
                ['plano_id' => 2, 'turma_id' => 3],
                ['plano_id' => 3, 'turma_id' => 4],
                ['plano_id' => 4, 'turma_id' => 3],
                ['plano_id' => 4, 'turma_id' => 4],
                ['plano_id' => 5, 'turma_id' => 6],
                ['plano_id' => 6, 'turma_id' => 3],
                ['plano_id' => 6, 'turma_id' => 5],
                ['plano_id' => 7, 'turma_id' => 4],
                ['plano_id' => 7, 'turma_id' => 5],
                ['plano_id' => 8, 'turma_id' => 1],
                ['plano_id' => 8, 'turma_id' => 3],
                ['plano_id' => 9, 'turma_id' => 2],
                ['plano_id' => 9, 'turma_id' => 3],
                ['plano_id' => 10, 'turma_id' => 1],
                ['plano_id' => 10, 'turma_id' => 4],
                ['plano_id' => 11, 'turma_id' => 2],
                ['plano_id' => 11, 'turma_id' => 4],
                ['plano_id' => 12, 'turma_id' => 3],
                ['plano_id' => 12, 'turma_id' => 6],
                ['plano_id' => 13, 'turma_id' => 4],
                ['plano_id' => 13, 'turma_id' => 6],
                ['plano_id' => 14, 'turma_id' => 1],
                ['plano_id' => 14, 'turma_id' => 2],
                ['plano_id' => 14, 'turma_id' => 3],
                ['plano_id' => 14, 'turma_id' => 4],
                ['plano_id' => 14, 'turma_id' => 5],
                ['plano_id' => 14, 'turma_id' => 6],
            ]);
        }
    }
}

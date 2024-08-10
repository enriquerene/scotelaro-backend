<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TurmaHorariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $table = DB::table('turma_horarios');
        if ($table->count() === 0) {
            $table->insert([
                ['turma_id' => 3, 'horario_id' => 1],
                ['turma_id' => 3, 'horario_id' => 2],
                ['turma_id' => 3, 'horario_id' => 3],
                ['turma_id' => 1, 'horario_id' => 4],
                ['turma_id' => 1, 'horario_id' => 5],
                ['turma_id' => 1, 'horario_id' => 6],
                ['turma_id' => 2, 'horario_id' => 7],
                ['turma_id' => 2, 'horario_id' => 8],
                ['turma_id' => 2, 'horario_id' => 9],
                ['turma_id' => 4, 'horario_id' => 10],
                ['turma_id' => 4, 'horario_id' => 11],
                ['turma_id' => 4, 'horario_id' => 12],
                ['turma_id' => 6, 'horario_id' => 13],
                ['turma_id' => 6, 'horario_id' => 14],
                ['turma_id' => 6, 'horario_id' => 15],
                ['turma_id' => 5, 'horario_id' => 16],
                ['turma_id' => 5, 'horario_id' => 17],
                ['turma_id' => 5, 'horario_id' => 12],
            ]);
        }
    }
}

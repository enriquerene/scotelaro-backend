<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class HorariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $table = DB::table('horarios');
        if ($table->count() === 0) {
            $table->insert([
                ['dia_semana' => 1, 'hora_inicio' => '07:00', 'hora_fim' => '8:00'],
                ['dia_semana' => 3, 'hora_inicio' => '07:00', 'hora_fim' => '8:00'],
                ['dia_semana' => 5, 'hora_inicio' => '07:00', 'hora_fim' => '8:00'],
                ['dia_semana' => 1, 'hora_inicio' => '08:00', 'hora_fim' => '9:00'],
                ['dia_semana' => 3, 'hora_inicio' => '08:00', 'hora_fim' => '9:00'],
                ['dia_semana' => 5, 'hora_inicio' => '08:00', 'hora_fim' => '9:00'],
                ['dia_semana' => 1, 'hora_inicio' => '17:00', 'hora_fim' => '19:00'],
                ['dia_semana' => 3, 'hora_inicio' => '17:00', 'hora_fim' => '19:00'],
                ['dia_semana' => 5, 'hora_inicio' => '17:00', 'hora_fim' => '19:00'],
                ['dia_semana' => 1, 'hora_inicio' => '19:00', 'hora_fim' => '20:00'],
                ['dia_semana' => 3, 'hora_inicio' => '19:00', 'hora_fim' => '20:00'],
                ['dia_semana' => 5, 'hora_inicio' => '19:00', 'hora_fim' => '20:00'],
                ['dia_semana' => 1, 'hora_inicio' => '20:00', 'hora_fim' => '21:00'],
                ['dia_semana' => 3, 'hora_inicio' => '20:00', 'hora_fim' => '21:00'],
                ['dia_semana' => 5, 'hora_inicio' => '20:00', 'hora_fim' => '21:00'],
                ['dia_semana' => 2, 'hora_inicio' => '19:00', 'hora_fim' => '20:00'],
                ['dia_semana' => 4, 'hora_inicio' => '19:00', 'hora_fim' => '20:00'],
            ]);
        }
    }
}

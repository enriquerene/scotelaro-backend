<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModalidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $table = DB::table('modalidades');
        if ($table->count() === 0) {
            $table->insert([
                ['nome' => 'Luta Livre', 'descricao' => 'Enfatiza o combate corpo a corpo, sem o uso de kimono, com o objetivo de imobilizar ou finalizar o oponente através de chaves e estrangulamentos.'],
                ['nome' => 'Muay Thai', 'descricao' => 'Conhecido como "a arte das oito armas," é uma arte marcial tailandesa que utiliza socos, chutes, cotoveladas e joelhadas.'],
                ['nome' => 'Boxe', 'descricao' => 'Esporte de combate focado em socos, onde os atletas utilizam luvas para golpear o oponente.'],
                ['nome' => 'MMA', 'descricao' => 'Esporte de combate que combina técnicas de diversas artes marciais, incluindo jiu-jitsu, wrestling, boxe e muay thai.'],
            ]);
        }
    }
}

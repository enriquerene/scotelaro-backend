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
                ['nome' => 'Luta Livre', 'descricao' => 'Arte marcial brasileira focada em grappling, combinando técnicas de wrestling e submissões no solo. Enfatiza o combate corpo a corpo, sem o uso de kimono, com o objetivo de imobilizar ou finalizar o oponente através de chaves e estrangulamentos.'],
                ['nome' => 'Muay Thai', 'descricao' => 'Conhecido como "a arte das oito armas," é uma arte marcial tailandesa que utiliza socos, chutes, cotoveladas e joelhadas. Com ênfase no combate em pé e na resistência física, o Muay Thai desenvolve força, agilidade e técnicas de ataque e defesa.'],
                ['nome' => 'Boxe', 'descricao' => 'Esporte de combate focado em socos, onde os atletas utilizam luvas para golpear o oponente. Trabalha habilidades como agilidade, estratégia, precisão e defesa, enquanto aprimora o condicionamento físico e mental.'],
                ['nome' => 'MMA', 'descricao' => 'Esporte de combate que combina técnicas de diversas artes marciais, incluindo jiu-jitsu, wrestling, boxe e muay thai. Conhecido por sua versatilidade, o MMA permite lutas tanto em pé quanto no solo, proporcionando um estilo completo e dinâmico de combate.'],
            ]);
        }
    }
}

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
                ['nome' => 'Plano Boxe Noite', 'valor' => 100, 'descricao' => 'Este plano permite participar da turma de Boxe Noite.'],
                ['nome' => 'Plano Muay Thai Manhã', 'valor' => 110, 'descricao' => 'Este plano permite participar da turma de Muay Thai Manhã.'],
                ['nome' => 'Plano Muay Thai Noite', 'valor' => 110, 'descricao' => 'Este plano permite participar da turma de Muay Thai Noite.'],
                ['nome' => 'Plano Muay Thai Manhã e Noite', 'valor' => 180, 'descricao' => 'Este plano permite participar das turmas de Muay Thai Manhã e Noite.'],
                ['nome' => 'Plano MMA Noite', 'valor' => 120, 'descricao' => 'Este plano permite participar da turma de MMA Noite.'],
                ['nome' => 'Plano Muay e Thai Boxe', 'valor' => 180, 'descricao' => 'Este plano permite participar das turmas de Muay Thai e Boxe.'],
                ['nome' => 'Plano Muay e Luta Livre', 'valor' => 180, 'descricao' => 'Este plano permite participar das turmas de Muay Thai e Luta Livre.'],
                ['nome' => 'Plano Muay Thai e MMA', 'valor' => 200, 'descricao' => 'Este plano permite participar das turmas de Muay Thai e MMA.'],
                ['nome' => 'Plano Todas as Modalidades', 'valor' => 230, 'descricao' => 'Este plano permite participar de todas as turmas.'],
            ]);
        }
    }
}

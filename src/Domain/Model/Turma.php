<?php

namespace FightGym\Domain\Model;

class Turma
{
    public function __construct(
        private readonly string $id,
        private string $nome,
        private Modalidade $modalidade,
        private Usuario $professor,
        /* @var HorarioTurma[] $horarios */
        private array $horarios,
        private PosicaoTurma $posicaoTurma,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getModalidade(): Modalidade
    {
        return $this->modalidade;
    }

    public function getProfessor(): Usuario
    {
        return $this->professor;
    }

    public function getHorarios(): array
    {
        return $this->horarios;
    }

    public function getPosicaoTurma(): PosicaoTurma
    {
        return $this->posicaoTurma;
    }
}
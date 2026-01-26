<?php

namespace FightGym\Domain\Model;

class Professor
{
    public function __construct(
        private readonly string $id,
        private readonly string $usuarioId,
        private array $modalidades,
        private ?array $turmas = null,
    ) {}

    public function getModalidades(): array
    {
        return $this->modalidades;
    }

    public function addModalidade(Modalidade $modalidade): void
    {
        $this->modalidades[] = $modalidade;
    }

    public function getTurmas(): array
    {
        return $this->turmas;
    }

    public function addTurma(Turma $turma): void
    {
        $this->turmas[] = $turma;
    }
}
<?php

namespace FightGym\Domain\Model;

class Aluno
{
    public function __construct(
        private readonly string $id,
        private ?Plano $plano = null,
    ) {
    }

    public function getPlano(): ?Plano
    {
        return $this->plano;
    }

    public function setPlano(?Plano $plano): void
    {
        $this->plano = $plano;
    }
}

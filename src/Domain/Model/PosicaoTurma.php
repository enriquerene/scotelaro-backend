<?php

namespace FightGym\Domain\Model;

class PosicaoTurma {
    public function __construct(
        private readonly string $id,
        private PosicaoTurmaTipo $tipo,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTipo(): PosicaoTurmaTipo
    {
        return $this->tipo->value;
    }

    public function getNome(): string
    {
        return $this->tipo->label();
    }

    public function setTipo(PosicaoTurmaTipo $tipo): void
    {
        $this->tipo = $tipo;
    }
}
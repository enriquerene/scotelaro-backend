<?php

namespace FightGym\Domain\Model;

class Plano
{
    public function __construct(
        private readonly string $id,
        private string $nome,
        private int $valor,
        private string $descricao = '',
        private int $quantidadeDeTurmas,
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

    public function getValor(): int
    {
        return $this->valor;
    }

    public function getDescricao(): string
    {
        return $this->descricao;
    }

    public function getQuantidadeDeTurmas(): int
    {
        return $this->quantidadeDeTurmas;
    }
}

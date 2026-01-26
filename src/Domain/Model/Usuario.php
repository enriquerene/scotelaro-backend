<?php

namespace FightGym\Domain\Model;

class Usuario
{

    public function __construct(
        private readonly string $id,
        private string $nomeCompleto,
        private string $whatsapp,
        private string $email,
        private string $senha,
        private array $funcoes = [],
    ) {
    }

    public function getFuncoes(): array
    {
        return $this->funcoes;
    }

    public function addFuncao(object $funcao): void
    {
        $this->funcoes[get_class($funcao)] = $funcao;
    }

    public function getFuncao(string $funcaoClass): ?object
    {
        return $this->funcoes[$funcaoClass] ?? null;
    }
}
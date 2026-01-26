<?php

namespace FightGym\Domain\Model;

class Modalidade {
    public function __construct(
        private readonly string $id,
        private string $nome,
        private string $descricao,
        private string $imagemUrl,
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
    
    public function getDescricao(): string
    {
        return $this->descricao;
    }

    public function getImagemUrl(): string
    {
        return $this->imagemUrl;
    }
}
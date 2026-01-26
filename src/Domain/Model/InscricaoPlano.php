<?php

namespace FightGym\Domain\Model;

class InscricaoPlano
{
    public function __construct(
        private readonly string $id,
        private Usuario $responsavel,
        private Plano $plano,
        private DateTime $dataInscricao,
        private ?DateTime $dataCancelamento = null,
        /* @var Turma[] $turmas */
        private ?array $turmas = null,
        /* @var Usuario[] $dependentes */
        private ?array $dependentes = null,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getResponsavel(): Usuario
    {
        return $this->responsavel;
    }

    public function getPlano(): Plano
    {
        return $this->plano;
    }

    public function getDataInscricao(): DateTime
    {
        return $this->dataInscricao;
    }

    public function getDataCancelamento(): ?DateTime
    {
        return $this->dataCancelamento;
    }
}
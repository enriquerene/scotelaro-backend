<?php

namespace FightGym\Domain\Model;

class HorarioTurma {
    public function __construct(
        private readonly string $id,
        private string $diaSemana,
        private string $horaInicio,
        private ?string $horaFim = null,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getDiaSemana(): string
    {
        return $this->diaSemana;
    }

    public function getHoraInicio(): string
    {
        return $this->horaInicio;
    }

    public function getHoraFim(): string
    {
        return $this->horaFim;
    }

    public function getDuracao(): string
    {
        return Carbon::parse($this->horaFim)->diffInMinutes(Carbon::parse($this->horaInicio));
    }
}
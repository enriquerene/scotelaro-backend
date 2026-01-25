<?php

namespace Core\Domain\Training\Entities;

class Schedule
{
    private ?int $id;
    private string $dayOfWeek;
    private string $startTime;
    private string $endTime;

    public function __construct(
        string $dayOfWeek,
        string $startTime,
        string $endTime,
        ?int $id = null
    ) {
        $this->id = $id;
        $this->dayOfWeek = $dayOfWeek;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDayOfWeek(): string
    {
        return $this->dayOfWeek;
    }

    public function getStartTime(): string
    {
        return $this->startTime;
    }

    public function getEndTime(): string
    {
        return $this->endTime;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'dia_semana' => $this->dayOfWeek,
            'hora_inicio' => $this->startTime,
            'hora_fim' => $this->endTime,
        ];
    }
}

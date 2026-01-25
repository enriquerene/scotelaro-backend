<?php

namespace Core\Domain\Training\Entities;

class TrainingClass
{
    private ?int $id;
    private string $name;
    private int $trainingTypeId;
    private float $price;

    public function __construct(
        string $name,
        int $trainingTypeId,
        float $price,
        ?int $id = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->trainingTypeId = $trainingTypeId;
        $this->price = $price;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTrainingTypeId(): int
    {
        return $this->trainingTypeId;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->name,
            'modalidade_id' => $this->trainingTypeId,
            'valor' => $this->price,
        ];
    }
}

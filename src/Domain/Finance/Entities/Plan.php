<?php

namespace Core\Domain\Finance\Entities;

class Plan
{
    private ?int $id;
    private string $name;
    private float $price;
    private ?string $description;

    public function __construct(
        string $name,
        float $price,
        ?string $description = null,
        ?int $id = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->name,
            'valor' => $this->price,
            'descricao' => $this->description,
        ];
    }
}

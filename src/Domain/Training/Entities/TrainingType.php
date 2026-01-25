<?php

namespace Core\Domain\Training\Entities;

class TrainingType
{
    private ?int $id;
    private string $name;
    private ?string $description;
    private ?string $featuredImage;

    public function __construct(
        string $name,
        ?string $description = null,
        ?string $featuredImage = null,
        ?int $id = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->featuredImage = $featuredImage;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getFeaturedImage(): ?string
    {
        return $this->featuredImage;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->name,
            'descricao' => $this->description,
            'imagem_destacada' => $this->featuredImage,
        ];
    }
}

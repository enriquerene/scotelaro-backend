<?php

namespace Core\Domain\Identity\Entities;

class User
{
    private ?int $id;
    private string $uuid;
    private string $name;
    private string $whatsapp;
    private ?string $email;
    private ?string $password;
    private ?string $planInscriptionDate;
    private ?int $planId;

    public function __construct(
        string $uuid,
        string $name,
        string $whatsapp,
        ?string $email = null,
        ?string $password = null,
        ?string $planInscriptionDate = null,
        ?int $planId = null,
        ?int $id = null
    ) {
        $this->id = $id;
        $this->uuid = $uuid;
        $this->name = $name;
        $this->whatsapp = $whatsapp;
        $this->email = $email;
        $this->password = $password;
        $this->planInscriptionDate = $planInscriptionDate;
        $this->planId = $planId;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getWhatsapp(): string
    {
        return $this->whatsapp;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getPlanInscriptionDate(): ?string
    {
        return $this->planInscriptionDate;
    }

    public function getPlanId(): ?int
    {
        return $this->planId;
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'nome' => $this->name,
            'whatsapp' => $this->whatsapp,
            'email' => $this->email,
            'data_inscricao_plano' => $this->planInscriptionDate,
            'plano_id' => $this->planId,
        ];
    }
}

<?php

namespace Core\Application\Identity\Ports;

use Core\Domain\Identity\Entities\User;

interface UserRepositoryInterface
{
    public function findByWhatsapp(string $whatsapp): ?User;
    public function findByUuid(string $uuid): ?User;
    public function save(User $user): void;
}

<?php

namespace Core\Application\Identity\Ports;

interface AuthenticationServiceInterface
{
    public function authenticate(string $userUuid): string;
    public function logout(string $userUuid): void;
    public function checkPassword(string $password, string $hashedPassword): bool;
}

<?php

namespace Core\Application\Identity\UseCases;

use Core\Application\Identity\Ports\AuthenticationServiceInterface;
use Core\Application\Identity\Ports\UserRepositoryInterface;
use Core\Domain\Identity\Entities\User;

class LoginUser
{
    private UserRepositoryInterface $userRepository;
    private AuthenticationServiceInterface $authService;

    public function __construct(
        UserRepositoryInterface $userRepository,
        AuthenticationServiceInterface $authService
    ) {
        $this->userRepository = $userRepository;
        $this->authService = $authService;
    }

    public function execute(string $whatsapp, string $password): array
    {
        $user = $this->userRepository->findByWhatsapp($whatsapp);

        if (!$user || !$this->authService->checkPassword($password, $user->getPassword())) {
            throw new \Exception('Credenciais inválidas', 401);
        }

        $token = $this->authService->authenticate($user->getUuid());

        return [
            'user' => $user,
            'token' => $token
        ];
    }
}

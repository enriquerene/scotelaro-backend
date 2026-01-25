<?php

namespace Core\Application\Identity\UseCases;

use Core\Application\Identity\Ports\UserRepositoryInterface;
use Core\Domain\Identity\Entities\User;
use Illuminate\Support\Str;

class RegisterUser
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(array $data): User
    {
        $existingUser = $this->userRepository->findByWhatsapp($data['whatsapp']);
        if ($existingUser) {
            throw new \Exception('Usuário já registrado', 400);
        }

        $user = new User(
            Str::uuid()->toString(),
            $data['nome'],
            $data['whatsapp'],
            null,
            $data['senha']
        );

        $this->userRepository->save($user);

        return $user;
    }
}

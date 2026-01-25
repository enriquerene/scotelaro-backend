<?php

namespace Core\Application\Finance\UseCases;

use Core\Application\Identity\Ports\UserRepositoryInterface;
use Core\Domain\Identity\Entities\User;

class CancelPlan
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(string $userUuid): User
    {
        $user = $this->userRepository->findByUuid($userUuid);
        if (!$user) {
            throw new \Exception('Usuário não encontrado', 404);
        }

        if (!$user->getPlanId()) {
            throw new \Exception('Usuário não está inscrito em nenhum plano.', 400);
        }

        $updatedUser = new User(
            $user->getUuid(),
            $user->getName(),
            $user->getWhatsapp(),
            $user->getEmail(),
            $user->getPassword(),
            null,
            null,
            $user->getId()
        );

        $this->userRepository->save($updatedUser);

        return $updatedUser;
    }
}

<?php

namespace Core\Application\Finance\UseCases;

use Core\Application\Finance\Ports\PlanRepositoryInterface;
use Core\Application\Identity\Ports\UserRepositoryInterface;
use Core\Domain\Identity\Entities\User;
use Carbon\Carbon;

class SubscribeToPlan
{
    private UserRepositoryInterface $userRepository;
    private PlanRepositoryInterface $planRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        PlanRepositoryInterface $planRepository
    ) {
        $this->userRepository = $userRepository;
        $this->planRepository = $planRepository;
    }

    public function execute(string $userUuid, int $planId): User
    {
        $user = $this->userRepository->findByUuid($userUuid);
        if (!$user) {
            throw new \Exception('Usuário não encontrado', 404);
        }

        $plan = $this->planRepository->findById($planId);
        if (!$plan) {
            throw new \Exception('O plano requisitado não existe.', 404);
        }

        $updatedUser = new User(
            $user->getUuid(),
            $user->getName(),
            $user->getWhatsapp(),
            $user->getEmail(),
            $user->getPassword(),
            Carbon::now()->toDateString(),
            $planId,
            $user->getId()
        );

        $this->userRepository->save($updatedUser);

        return $updatedUser;
    }
}

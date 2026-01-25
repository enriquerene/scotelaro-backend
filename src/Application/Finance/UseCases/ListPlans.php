<?php

namespace Core\Application\Finance\UseCases;

use Core\Application\Finance\Ports\PlanRepositoryInterface;

class ListPlans
{
    private PlanRepositoryInterface $repository;

    public function __construct(PlanRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(): array
    {
        return $this->repository->all();
    }
}

<?php

namespace Core\Application\Training\UseCases;

use Core\Application\Training\Ports\TrainingClassRepositoryInterface;

class ListTrainingClasses
{
    private TrainingClassRepositoryInterface $repository;

    public function __construct(TrainingClassRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(): array
    {
        return $this->repository->all();
    }
}

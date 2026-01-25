<?php

namespace Core\Application\Training\UseCases;

use Core\Application\Training\Ports\TrainingTypeRepositoryInterface;

class ListTrainingTypes
{
    private TrainingTypeRepositoryInterface $repository;

    public function __construct(TrainingTypeRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(): array
    {
        return $this->repository->all();
    }
}

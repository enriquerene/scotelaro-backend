<?php

namespace Core\Application\Training\UseCases;

use Core\Application\Training\Ports\TrainingTypeRepositoryInterface;
use Core\Domain\Training\Entities\TrainingType;

class CreateTrainingType
{
    private TrainingTypeRepositoryInterface $repository;

    public function __construct(TrainingTypeRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(array $data): TrainingType
    {
        $trainingType = new TrainingType(
            $data['nome'],
            $data['descricao']
        );

        $this->repository->save($trainingType);

        return $trainingType;
    }
}

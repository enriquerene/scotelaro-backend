<?php

namespace Core\Application\Training\Ports;

use Core\Domain\Training\Entities\TrainingType;

interface TrainingTypeRepositoryInterface
{
    public function all(): array;
    public function findById(int $id): ?TrainingType;
    public function save(TrainingType $trainingType): void;
}

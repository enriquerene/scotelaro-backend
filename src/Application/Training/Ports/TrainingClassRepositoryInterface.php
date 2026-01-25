<?php

namespace Core\Application\Training\Ports;

use Core\Domain\Training\Entities\TrainingClass;

interface TrainingClassRepositoryInterface
{
    public function all(): array;
    public function save(TrainingClass $trainingClass): void;
}

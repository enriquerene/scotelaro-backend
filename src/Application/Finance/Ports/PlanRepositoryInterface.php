<?php

namespace Core\Application\Finance\Ports;

use Core\Domain\Finance\Entities\Plan;

interface PlanRepositoryInterface
{
    public function all(): array;
    public function findById(int $id): ?Plan;
    public function save(Plan $plan): void;
}

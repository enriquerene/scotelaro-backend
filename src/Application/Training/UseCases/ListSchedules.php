<?php

namespace Core\Application\Training\UseCases;

use Core\Application\Training\Ports\ScheduleRepositoryInterface;

class ListSchedules
{
    private ScheduleRepositoryInterface $repository;

    public function __construct(ScheduleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(): array
    {
        return $this->repository->all();
    }
}

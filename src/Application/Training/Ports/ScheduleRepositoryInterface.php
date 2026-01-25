<?php

namespace Core\Application\Training\Ports;

use Core\Domain\Training\Entities\Schedule;

interface ScheduleRepositoryInterface
{
    public function all(): array;
    public function save(Schedule $schedule): void;
}

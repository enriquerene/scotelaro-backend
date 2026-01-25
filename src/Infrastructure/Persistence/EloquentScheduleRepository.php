<?php

namespace Core\Infrastructure\Persistence;

use App\Models\Horario as EloquentHorario;
use Core\Application\Training\Ports\ScheduleRepositoryInterface;
use Core\Domain\Training\Entities\Schedule;

class EloquentScheduleRepository implements ScheduleRepositoryInterface
{
    public function all(): array
    {
        return EloquentHorario::all()->map(fn($h) => $this->toDomain($h)->toArray())->toArray();
    }

    public function save(Schedule $schedule): void
    {
        $eloquent = EloquentHorario::find($schedule->getId()) ?? new EloquentHorario();
        $eloquent->dia_semana = $schedule->getDayOfWeek();
        $eloquent->hora_inicio = $schedule->getStartTime();
        $eloquent->hora_fim = $schedule->getEndTime();
        $eloquent->save();
    }

    private function toDomain(EloquentHorario $eloquent): Schedule
    {
        return new Schedule(
            $eloquent->dia_semana,
            $eloquent->hora_inicio,
            $eloquent->hora_fim,
            $eloquent->id
        );
    }
}

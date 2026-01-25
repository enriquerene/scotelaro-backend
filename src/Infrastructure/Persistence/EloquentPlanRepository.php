<?php

namespace Core\Infrastructure\Persistence;

use App\Models\Plano as EloquentPlano;
use Core\Application\Finance\Ports\PlanRepositoryInterface;
use Core\Domain\Finance\Entities\Plan;

class EloquentPlanRepository implements PlanRepositoryInterface
{
    public function all(): array
    {
        return EloquentPlano::all()->map(fn($p) => $this->toDomain($p)->toArray())->toArray();
    }

    public function findById(int $id): ?Plan
    {
        $eloquent = EloquentPlano::find($id);
        return $eloquent ? $this->toDomain($eloquent) : null;
    }

    public function save(Plan $plan): void
    {
        $eloquent = EloquentPlano::find($plan->getId()) ?? new EloquentPlano();
        $eloquent->nome = $plan->getName();
        $eloquent->valor = $plan->getPrice();
        $eloquent->descricao = $plan->getDescription();
        $eloquent->save();
    }

    private function toDomain(EloquentPlano $eloquent): Plan
    {
        return new Plan(
            $eloquent->nome,
            (float) $eloquent->valor,
            $eloquent->descricao,
            $eloquent->id
        );
    }
}

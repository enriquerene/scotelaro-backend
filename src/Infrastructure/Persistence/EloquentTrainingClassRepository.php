<?php

namespace Core\Infrastructure\Persistence;

use App\Models\Turma as EloquentTurma;
use Core\Application\Training\Ports\TrainingClassRepositoryInterface;
use Core\Domain\Training\Entities\TrainingClass;

class EloquentTrainingClassRepository implements TrainingClassRepositoryInterface
{
    public function all(): array
    {
        return EloquentTurma::with(['modalidade', 'horarios'])->get()->map(function($t) {
            // Mapping complex relations to array for now as Domain Entity is simple
            // In a full implementation, Domain Entity would have collections of other Domain Entities
            $data = $this->toDomain($t)->toArray();
            $data['modalidade'] = $t->modalidade ? $t->modalidade->toArray() : null;
            $data['horarios'] = $t->horarios->toArray();
            return $data;
        })->toArray();
    }

    public function save(TrainingClass $trainingClass): void
    {
        $eloquent = EloquentTurma::find($trainingClass->getId()) ?? new EloquentTurma();
        $eloquent->nome = $trainingClass->getName();
        $eloquent->modalidade_id = $trainingClass->getTrainingTypeId();
        $eloquent->valor = $trainingClass->getPrice();
        $eloquent->save();
    }

    private function toDomain(EloquentTurma $eloquent): TrainingClass
    {
        return new TrainingClass(
            $eloquent->nome,
            $eloquent->modalidade_id,
            (float) $eloquent->valor,
            $eloquent->id
        );
    }
}

<?php

namespace Core\Infrastructure\Persistence;

use App\Models\Modalidade as EloquentModalidade;
use Core\Application\Training\Ports\TrainingTypeRepositoryInterface;
use Core\Domain\Training\Entities\TrainingType;

class EloquentTrainingTypeRepository implements TrainingTypeRepositoryInterface
{
    public function all(): array
    {
        return EloquentModalidade::all()->map(fn($m) => $this->toDomain($m))->toArray();
    }

    public function findById(int $id): ?TrainingType
    {
        $eloquent = EloquentModalidade::find($id);
        return $eloquent ? $this->toDomain($eloquent) : null;
    }

    public function save(TrainingType $trainingType): void
    {
        $eloquent = EloquentModalidade::find($trainingType->getId()) ?? new EloquentModalidade();
        $eloquent->nome = $trainingType->getName();
        $eloquent->descricao = $trainingType->getDescription();
        $eloquent->imagem_destacada = $trainingType->getFeaturedImage();
        $eloquent->save();
    }

    private function toDomain(EloquentModalidade $eloquent): TrainingType
    {
        return new TrainingType(
            $eloquent->nome,
            $eloquent->descricao,
            $eloquent->imagem_destacada,
            $eloquent->id
        );
    }
}

<?php

namespace Core\Infrastructure\Persistence;

use App\Models\Usuario as EloquentUser;
use Core\Application\Identity\Ports\UserRepositoryInterface;
use Core\Domain\Identity\Entities\User;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function findByWhatsapp(string $whatsapp): ?User
    {
        $eloquentUser = EloquentUser::where('whatsapp', $whatsapp)->first();
        if (!$eloquentUser) {
            return null;
        }

        return $this->toDomain($eloquentUser);
    }

    public function findByUuid(string $uuid): ?User
    {
        $eloquentUser = EloquentUser::where('uuid', $uuid)->first();
        if (!$eloquentUser) {
            return null;
        }

        return $this->toDomain($eloquentUser);
    }

    public function save(User $user): void
    {
        $eloquentUser = EloquentUser::where('uuid', $user->getUuid())->first() ?? new EloquentUser();

        $eloquentUser->uuid = $user->getUuid();
        $eloquentUser->nome = $user->getName();
        $eloquentUser->whatsapp = $user->getWhatsapp();
        $eloquentUser->email = $user->getEmail();
        $eloquentUser->senha = $user->getPassword();
        $eloquentUser->data_inscricao_plano = $user->getPlanInscriptionDate();
        $eloquentUser->plano_id = $user->getPlanId();

        $eloquentUser->save();
    }

    private function toDomain(EloquentUser $eloquentUser): User
    {
        return new User(
            $eloquentUser->uuid,
            $eloquentUser->nome,
            $eloquentUser->whatsapp,
            $eloquentUser->email,
            $eloquentUser->senha, // Note: Eloquent might have hashed this already or it's coming from DB
            $eloquentUser->data_inscricao_plano,
            $eloquentUser->plano_id,
            $eloquentUser->id
        );
    }
}

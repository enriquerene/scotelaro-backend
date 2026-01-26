<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Identity
        $this->app->bind(
            \FightGym\Application\Identity\Ports\UserRepositoryInterface::class,
            \FightGym\Infrastructure\Persistence\EloquentUserRepository::class
        );
        $this->app->bind(
            \FightGym\Application\Identity\Ports\AuthenticationServiceInterface::class,
            \FightGym\Infrastructure\Services\LaravelAuthenticationService::class
        );
        $this->app->bind(
            \FightGym\Application\Identity\Ports\PasswordHasherInterface::class,
            \FightGym\Infrastructure\Services\LaravelPasswordHasher::class
        );
        // Training
        $this->app->bind(
            \FightGym\Application\Training\Ports\TrainingTypeRepositoryInterface::class,
            \FightGym\Infrastructure\Persistence\EloquentTrainingTypeRepository::class
        );
        $this->app->bind(
            \FightGym\Application\Training\Ports\TrainingClassRepositoryInterface::class,
            \FightGym\Infrastructure\Persistence\EloquentTrainingClassRepository::class
        );
        $this->app->bind(
            \FightGym\Application\Training\Ports\ScheduleRepositoryInterface::class,
            \FightGym\Infrastructure\Persistence\EloquentScheduleRepository::class
        );
        // Finance
        $this->app->bind(
            \FightGym\Application\Finance\Ports\PlanRepositoryInterface::class,
            \FightGym\Infrastructure\Persistence\EloquentPlanRepository::class
        );
    }
}

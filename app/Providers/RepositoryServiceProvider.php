<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Identity
        $this->app->bind(
            \Core\Application\Identity\Ports\UserRepositoryInterface::class,
            \Core\Infrastructure\Persistence\EloquentUserRepository::class
        );
        $this->app->bind(
            \Core\Application\Identity\Ports\AuthenticationServiceInterface::class,
            \Core\Infrastructure\Services\LaravelAuthenticationService::class
        );
        // Training
        $this->app->bind(
            \Core\Application\Training\Ports\TrainingTypeRepositoryInterface::class,
            \Core\Infrastructure\Persistence\EloquentTrainingTypeRepository::class
        );
        $this->app->bind(
            \Core\Application\Training\Ports\TrainingClassRepositoryInterface::class,
            \Core\Infrastructure\Persistence\EloquentTrainingClassRepository::class
        );
        $this->app->bind(
            \Core\Application\Training\Ports\ScheduleRepositoryInterface::class,
            \Core\Infrastructure\Persistence\EloquentScheduleRepository::class
        );
        // Finance
        $this->app->bind(
            \Core\Application\Finance\Ports\PlanRepositoryInterface::class,
            \Core\Infrastructure\Persistence\EloquentPlanRepository::class
        );
    }
}

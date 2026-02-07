<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();
        $this->registerLivewireMacro();
        $this->registerBladeComponents();
    }

    protected function registerBladeComponents(): void
    {
        \Illuminate\Support\Facades\Blade::componentNamespace('App\\View\\Components\\Layouts', 'layouts');
    }

    protected function registerLivewireMacro(): void
    {
        \Illuminate\Support\Facades\Route::macro('livewire', function ($uri, $component) {
            return \Illuminate\Support\Facades\Route::get($uri, $component);
        });
    }

    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null
        );
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use RunTracker\Identity\Domain\Ports\UserFactoryInterface;
use RunTracker\Identity\Domain\Ports\UserRepositoryInterface;
use RunTracker\Identity\Infrastructure\Factories\UserFactory;
use RunTracker\Identity\Infrastructure\Persistence\EloquentUserRepository;

class IdentityServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(
            UserFactoryInterface::class,
            UserFactory::class
        );
        $this->app->singleton(
            UserRepositoryInterface::class,
            EloquentUserRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

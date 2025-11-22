<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use RunTracker\Shared\Application\Command\CommandBus as CommandBusInterface;
use RunTracker\Shared\Application\Query\QueryBus as QueryBusInterface;
use RunTracker\Shared\Infrastructure\Bus\CommandBus;
use RunTracker\Shared\Infrastructure\Bus\QueryBus;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CommandBusInterface::class, CommandBus::class);
        $this->app->singleton(QueryBusInterface::class, QueryBus::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

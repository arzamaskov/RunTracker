<?php

declare(strict_types=1);

namespace App\Providers;

use Database\Factories\UserFactory;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\ServiceProvider;
use RunTracker\Identity\Application\Command\CreateUser\CreateUserCommand;
use RunTracker\Identity\Application\Command\CreateUser\CreateUserCommandHandler;
use RunTracker\Identity\Application\Port\PasswordHasher;
use RunTracker\Identity\Domain\Port\UserFactory as UserFactoryInterface;
use RunTracker\Identity\Domain\Port\UserRepository;
use RunTracker\Identity\Infrastructure\Repositories\Identity\EloquentUserRepository;
use RunTracker\Identity\Infrastructure\Service\LaravelPasswordHaser;
use RunTracker\Shared\Application\Command\CommandBus;

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
            UserRepository::class,
            EloquentUserRepository::class
        );
        $this->app->singleton(
            PasswordHasher::class,
            LaravelPasswordHaser::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @throws BindingResolutionException
     */
    public function boot(): void
    {
        $commandBus = $this->app->make(CommandBus::class);
        $commandBus->register(CreateUserCommand::class, CreateUserCommandHandler::class);
    }
}

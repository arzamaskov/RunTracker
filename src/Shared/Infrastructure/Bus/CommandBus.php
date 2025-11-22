<?php

declare(strict_types=1);

namespace RunTracker\Shared\Infrastructure\Bus;

use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;
use RunTracker\Shared\Application\Command\Command;
use RunTracker\Shared\Application\Command\CommandBus as CommandBusInterface;
use RunTracker\Shared\Domain\Exceptions\HandlerNotFoundException;

final class CommandBus implements CommandBusInterface
{
    /** @var array<class-string, class-string> */
    private array $handlers = [];

    public function __construct(private readonly Container $container) {}

    public function register(string $commandClass, string $handlerClass): void
    {
        $this->handlers[$commandClass] = $handlerClass;
    }

    /**
     * @throws BindingResolutionException
     */
    public function execute(Command $command): mixed
    {
        $handler = $this->resolveHandler($command);

        return $handler->handle($command);
    }

    /**
     * @throws BindingResolutionException
     */
    private function resolveHandler(Command $command): object
    {
        $commandClass = get_class($command);
        if (! array_key_exists($commandClass, $this->handlers)) {
            throw HandlerNotFoundException::forCommand($commandClass);
        }

        $handlerClass = $this->handlers[$commandClass];

        return $this->container->make($handlerClass);
    }
}

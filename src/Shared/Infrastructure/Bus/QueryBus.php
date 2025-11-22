<?php

declare(strict_types=1);

namespace RunTracker\Shared\Infrastructure\Bus;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Container\Container;
use RunTracker\Shared\Application\Query\Query;
use RunTracker\Shared\Application\Query\QueryBus as QueryBusInterface;
use RunTracker\Shared\Domain\Exceptions\HandlerNotFoundException;

final class QueryBus implements QueryBusInterface
{
    /** @var array<class-string, class-string> */
    private array $handlers = [];

    public function __construct(private readonly Container $container) {}

    public function register(string $queryClass, string $handlerClass): void
    {
        $this->handlers[$queryClass] = $handlerClass;
    }

    /**
     * @throws BindingResolutionException
     */
    public function execute(Query $query): mixed
    {
        $handler = $this->resolveHandler($query);

        return $handler->handle($query);
    }

    /**
     * @throws BindingResolutionException
     */
    private function resolveHandler(Query $query): object
    {
        $queryClass = get_class($query);
        if (! array_key_exists($queryClass, $this->handlers)) {
            throw HandlerNotFoundException::forQuery($queryClass);
        }

        $handlerClass = $this->handlers[$queryClass];

        return $this->container->make($handlerClass);
    }
}

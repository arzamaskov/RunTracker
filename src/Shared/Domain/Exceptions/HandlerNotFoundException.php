<?php

declare(strict_types=1);

namespace RunTracker\Shared\Domain\Exceptions;

final class HandlerNotFoundException extends DomainException
{
    public static function forCommand(string $commandClass): self
    {
        return new self("No handler registered for command {$commandClass}");
    }

    public static function forQuery(string $queryClass): self
    {
        return new self("No handler registered for query {$queryClass}");
    }
}

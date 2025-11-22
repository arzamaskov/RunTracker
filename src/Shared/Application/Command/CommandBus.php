<?php

declare(strict_types=1);

namespace RunTracker\Shared\Application\Command;

interface CommandBus
{
    public function register(string $commandClass, string $handlerClass): void;

    public function execute(Command $command): mixed;
}

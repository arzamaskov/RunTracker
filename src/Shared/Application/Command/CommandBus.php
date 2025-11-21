<?php

declare(strict_types=1);

namespace RunTracker\Shared\Application\Command;

interface CommandBus
{
    public function execute(Command $command): void;
}

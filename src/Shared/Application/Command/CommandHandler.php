<?php

declare(strict_types=1);

namespace RunTracker\Shared\Application\Command;

interface CommandHandler
{
    public function handle(Command $command): mixed;
}

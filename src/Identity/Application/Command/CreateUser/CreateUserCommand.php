<?php

declare(strict_types=1);

namespace RunTracker\Identity\Application\Command\CreateUser;

use RunTracker\Shared\Application\Command\Command as CommandInterface;

readonly class CreateUserCommand implements CommandInterface
{
    public function __construct(public string $email, public string $password) {}
}

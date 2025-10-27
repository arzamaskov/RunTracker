<?php

declare(strict_types=1);

namespace RunTracker\Identity\Application\Commands;

final readonly class RegisterUserCommand
{
    public function __construct(
        public string $email,
        public string $plainPassword
    ) {}
}

<?php

declare(strict_types=1);

namespace RunTracker\Identity\Application\Port;

interface PasswordHasher
{
    public function hash(string $plainPassword): string;
}

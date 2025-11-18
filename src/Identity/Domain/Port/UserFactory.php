<?php

declare(strict_types=1);

namespace RunTracker\Identity\Domain\Port;

use RunTracker\Identity\Domain\Entity\User;

interface UserFactory
{
    public function create(string $email, string $hashedPassword): User;
}

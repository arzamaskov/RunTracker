<?php

declare(strict_types=1);

namespace RunTracker\Identity\Domain\Port;

use RunTracker\Identity\Domain\Entity\User;

interface UserRepository
{
    public function add(User $user): void;
}

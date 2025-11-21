<?php

declare(strict_types=1);

namespace RunTracker\Identity\Domain\Port;

use RunTracker\Identity\Domain\Entity\User;
use RunTracker\Identity\Domain\ValueObject\UserId;

interface UserRepository
{
    public function add(User $user): void;

    public function find(UserId $id): ?User;
}

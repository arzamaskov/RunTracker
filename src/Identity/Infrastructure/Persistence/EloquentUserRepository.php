<?php

declare(strict_types=1);

namespace RunTracker\Identity\Infrastructure\Persistence;

use RunTracker\Identity\Domain\Model\User;
use RunTracker\Identity\Domain\Ports\UserRepositoryInterface;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function add(User $user): void
    {
        // TODO: Implement add() method.
    }
}

<?php

declare(strict_types=1);

namespace RunTracker\Identity\Domain\Ports;

use RunTracker\Identity\Domain\Model\User;

interface UserRepositoryInterface
{
    public function add(User $user): void;
}

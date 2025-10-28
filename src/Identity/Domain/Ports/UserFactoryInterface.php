<?php

declare(strict_types=1);

namespace RunTracker\Identity\Domain\Ports;

use RunTracker\Identity\Domain\Model\User;
use RunTracker\Identity\Domain\Model\UserEmail;

interface UserFactoryInterface
{
    public function create(UserEmail $email, string $name, string $plainPassword): User;
}

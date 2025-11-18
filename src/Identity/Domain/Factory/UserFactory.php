<?php

declare(strict_types=1);

namespace RunTracker\Identity\Domain\Factory;

use RunTracker\Identity\Domain\Entity\User;
use RunTracker\Identity\Domain\Port\UserFactory as UserFactoryInterface;
use RunTracker\Identity\Domain\ValueObject\UserId;

class UserFactory implements UserFactoryInterface
{
    public function create(string $email, string $hashedPassword): User
    {
        $id = UserId::new();

        return new User($id, $email, $hashedPassword);
    }
}

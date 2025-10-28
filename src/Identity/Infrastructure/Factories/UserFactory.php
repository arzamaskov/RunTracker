<?php

declare(strict_types=1);

namespace RunTracker\Identity\Infrastructure\Factories;

use Illuminate\Support\Facades\Hash;
use RunTracker\Identity\Domain\Model\User;
use RunTracker\Identity\Domain\Model\UserEmail;
use RunTracker\Identity\Domain\Model\UserId;
use RunTracker\Identity\Domain\Ports\UserFactoryInterface;

class UserFactory implements UserFactoryInterface
{
    public function create(UserEmail $email, string $name, string $plainPassword): User
    {
        return new User(new UserId, $email, $name, Hash::make($plainPassword));
    }
}

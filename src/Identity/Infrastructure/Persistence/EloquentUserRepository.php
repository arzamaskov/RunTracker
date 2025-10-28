<?php

declare(strict_types=1);

namespace RunTracker\Identity\Infrastructure\Persistence;

use App\Models\User as EloquentUser;
use RunTracker\Identity\Domain\Model\User;
use RunTracker\Identity\Domain\Ports\UserRepositoryInterface;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function add(User $user): void
    {
        $eloquentUser = new EloquentUser;

        $eloquentUser->id = $user->id()->toString();
        $eloquentUser->name = $user->name();
        $eloquentUser->email = $user->email()->userEmail;
        $eloquentUser->password = $user->password();

        $eloquentUser->save();
    }
}

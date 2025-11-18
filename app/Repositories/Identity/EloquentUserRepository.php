<?php

declare(strict_types=1);

namespace App\Repositories\Identity;

use App\Models\User as EloquentUser;
use RunTracker\Identity\Domain\Entity\User;
use RunTracker\Identity\Domain\Port\UserRepository;

final readonly class EloquentUserRepository implements UserRepository
{
    public function add(User $user): void
    {
        $eloquentUser = new EloquentUser;
        $eloquentUser->id = $user->id()->value();
        $eloquentUser->email = $user->email();
        $eloquentUser->password = $user->password();

        $eloquentUser->save();
    }
}

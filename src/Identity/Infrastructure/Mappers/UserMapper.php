<?php

declare(strict_types=1);

namespace RunTracker\Identity\Infrastructure\Mappers;

use App\Models\User as EloquentUser;
use RunTracker\Identity\Domain\Entity\User;
use RunTracker\Identity\Domain\ValueObject\UserId;

final class UserMapper
{
    public function toDomain(EloquentUser $eloquentUser): User
    {
        return new User(
            UserId::new($eloquentUser->id),
            $eloquentUser->email,
            $eloquentUser->password,
        );
    }
}

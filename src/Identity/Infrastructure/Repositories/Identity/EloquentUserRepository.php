<?php

declare(strict_types=1);

namespace RunTracker\Identity\Infrastructure\Repositories\Identity;

use App\Models\User as EloquentUser;
use RunTracker\Identity\Domain\Entity\User;
use RunTracker\Identity\Domain\Port\UserRepository;
use RunTracker\Identity\Domain\ValueObject\UserId;
use RunTracker\Identity\Infrastructure\Mappers\UserMapper;

final readonly class EloquentUserRepository implements UserRepository
{
    public function __construct(private UserMapper $userMapper) {}

    public function add(User $user): void
    {
        $eloquentUser = new EloquentUser;
        $eloquentUser->id = $user->id()->value();
        $eloquentUser->email = $user->email();
        $eloquentUser->password = $user->password();

        $eloquentUser->save();
    }

    public function find(UserId $id): ?User
    {
        $eloquentUser = EloquentUser::query()->find($id->value());
        if ($eloquentUser === null) {
            return null;
        }

        return $this->userMapper->toDomain($eloquentUser);
    }
}

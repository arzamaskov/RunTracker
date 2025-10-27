<?php

declare(strict_types=1);

namespace RunTracker\Identity\Domain\Model;

use RunTracker\Identity\Domain\Events\UserWasCreated;
use RunTracker\Shared\Domain\Model\AggregateRoot;

final class User extends AggregateRoot
{
    public function __construct(
        private readonly UserId $id,
        private UserEmail $email,
        private string $password
    ) {
        $this->record(new UserWasCreated($this->id, $this->email));
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function email(): UserEmail
    {
        return $this->email;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function changePassword(string $newPassword): void
    {
        $this->password = $newPassword;
    }

    public function changeEmail(UserEmail $newEmail): void
    {
        $this->email = $newEmail;
    }
}

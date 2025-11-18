<?php

declare(strict_types=1);

namespace RunTracker\Identity\Domain\Entity;

use RunTracker\Identity\Domain\ValueObject\UserId;

final class User
{
    public function __construct(
        private readonly UserId $id,
        private string $email,
        private ?string $password,
    ) {}

    public function id(): UserId
    {
        return $this->id;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function password(): ?string
    {
        return $this->password;
    }

    public function changeEmail(string $newEmail): void
    {
        $this->email = $newEmail;
    }

    public function changePassword(string $newPassword): void
    {
        $this->password = $newPassword;
    }
}

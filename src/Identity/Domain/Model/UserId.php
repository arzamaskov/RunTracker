<?php

declare(strict_types=1);

namespace RunTracker\Identity\Domain\Model;

use Symfony\Component\Uid\Ulid;

final readonly class UserId
{
    private string $userId;

    public function __construct(?string $userId = null)
    {
        $this->userId = $userId ?? (new Ulid()->toRfc4122());
    }

    public function toString(): string
    {
        return $this->userId;
    }
}

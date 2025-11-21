<?php

declare(strict_types=1);

namespace RunTracker\Identity\Domain\ValueObject;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final readonly class UserId
{
    private function __construct(private UuidInterface $id) {}

    public static function new(?UuidInterface $id = null): UserId
    {
        return $id === null ? new self(Uuid::uuid7()) : new self($id);
    }

    public static function fromString(string $id): self
    {
        if (! Uuid::isValid($id)) {
            throw new \InvalidArgumentException('Invalid UUID format');
        }

        return new self(Uuid::fromString($id));
    }

    public function value(): UuidInterface
    {
        return $this->id;
    }

    public function equals(UserId $other): bool
    {
        return $this->id === $other->id;
    }
}

<?php

declare(strict_types=1);

namespace RunTracker\Identity\Domain\ValueObject;

use Symfony\Component\Uid\Uuid;

final readonly class UserId
{
    private function __construct(private Uuid $id) {}

    public static function new(): UserId
    {
        return new self(Uuid::v7());
    }

    public function value(): Uuid
    {
        return $this->id;
    }
}

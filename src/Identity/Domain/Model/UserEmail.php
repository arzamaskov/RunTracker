<?php

declare(strict_types=1);

namespace RunTracker\Identity\Domain\Model;

use Webmozart\Assert\Assert;

final readonly class UserEmail
{
    public function __construct(public string $userEmail)
    {
        Assert::email($userEmail);
    }
}

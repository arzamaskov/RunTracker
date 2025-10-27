<?php

declare(strict_types=1);

namespace RunTracker\Identity\Domain\Events;

use RunTracker\Identity\Domain\Model\UserEmail;
use RunTracker\Identity\Domain\Model\UserId;

final class UserWasCreated
{
    public function __construct(
        public UserId $userId,
        public UserEmail $email
    ) {}
}

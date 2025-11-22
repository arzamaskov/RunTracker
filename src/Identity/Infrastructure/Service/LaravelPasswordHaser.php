<?php

declare(strict_types=1);

namespace RunTracker\Identity\Infrastructure\Service;

use Illuminate\Support\Facades\Hash;
use RunTracker\Identity\Application\Port\PasswordHasher;

final class LaravelPasswordHaser implements PasswordHasher
{
    public function hash(string $plainPassword): string
    {
        return Hash::make($plainPassword);
    }
}

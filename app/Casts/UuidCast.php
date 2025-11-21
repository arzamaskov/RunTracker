<?php

declare(strict_types=1);

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @implements CastsAttributes<UuidInterface, mixed>
 */
final class UuidCast implements CastsAttributes
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): ?UuidInterface
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof UuidInterface) {
            return $value;
        }

        return Uuid::fromString($value);
    }

    /**
     * @param  array<string, mixed>  $attributes
     * @param  UuidInterface|string|null  $value
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof UuidInterface) {
            return $value->toString();
        }

        return (string) $value;
    }
}

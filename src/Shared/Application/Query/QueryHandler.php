<?php

declare(strict_types=1);

namespace RunTracker\Shared\Application\Query;

interface QueryHandler
{
    public function handle(Query $query): mixed;
}

<?php

declare(strict_types=1);

namespace RunTracker\Shared\Application\Query;

interface QueryBus
{
    public function execute(Query $query): mixed;
}

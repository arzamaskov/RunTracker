<?php

declare(strict_types=1);

namespace RunTracker\Shared\Domain\Model;

abstract class AggregateRoot
{
    /**
     * @var object[]
     */
    private array $domainEvents = [];

    final public function pullDomainEvents(): array
    {
        $domainEvents = $this->domainEvents;
        $this->domainEvents = [];

        return $domainEvents;
    }

    final protected function record(object $domainEvent): void
    {
        $this->domainEvents[] = $domainEvent;
    }
}

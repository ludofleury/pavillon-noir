<?php

namespace App\Util\EventSourcing;

use Ramsey\Uuid\UuidInterface;

interface EventStore
{
    public function append(Stream $stream): void;

    public function load(UuidInterface $aggregateRootId): Stream;
}